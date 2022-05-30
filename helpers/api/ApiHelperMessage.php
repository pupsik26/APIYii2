<?php

namespace app\helpers\api;

use app\models\Message;
use app\models\User;
use Yii;
use yii\console\controllers\HelpController;
use yii\web\Response;

class ApiHelperMessage extends HelpController
{

    const POST_ATTRIBUTE = [
        'comment',
        'email',
        'name',
    ];

    const PUT_ATTRIBUTE = [
        'id',
        'comment',
    ];

    /**
     * Установка ответа
     * @int $value Статус код
     * @string $text Текст ответа
     * @string $data Текст тела ответа
     * @return Response
     */
    public static function sendResponse($value, $text, $data)
    {
        $response = new Response();
        $response->setStatusCode($value, $text);
        $response->data = $data;
        return $response;
    }

    /**
     * Сохранения моделей
     * @param $modelMessage
     * @param $modelUser
     * @return array|Response
     */
    public static function saveModel($modelMessage, $modelUser)
    {
        $idUser = User::findOne(['name' => $modelUser->name]);
        if (!($modelUser->checkEmail($modelUser->name) == $modelUser->email)) {
            $e = new ApiException('Email: ' . $modelUser->email . ' не соответсвует пользователю: ' . $modelUser->name, 400, 'POST');
            $data = $e->getAllInfoRequest();
            return $data;
        }
        if ($modelUser->save() && $modelMessage->save()) {
            $modelMessage->link('users', $modelUser);
            return static::sendResponse(200, 'OK', 'Заявка успешно отправлена, ждите ответа на почту');
        } else if (!empty($idUser) && $modelMessage->save()) {
            $modelMessage->link('users', $idUser);
            return static::sendResponse(200, 'OK', 'Заявка успешно отправлена, ждите ответа на почту');
        } else {
            $e = new ApiException('Ошибка при сохранении, проверьте правильность и полноту параметров', 400, 'POST');
            $data = $e->getAllInfoRequest();
            return $data;
        }
    }

    /**
     * Проверка на существование атрибутов
     * @param $params
     * @return array|Response
     */
    public static function checkPOSTBodyParams($params)
    {
        $modelMessage = new Message();
        $modelUser = new User();
        foreach ($params as $key => $param) {
            if ($modelMessage->hasAttribute($key) && in_array($key, self::POST_ATTRIBUTE)) {
                $modelMessage->$key = $param;
            } else if ($modelUser->hasAttribute($key) && in_array($key, self::POST_ATTRIBUTE)) {
                $modelUser->$key = $param;
            } else {
                $e = new ApiException('Не верный параметр запроса: ' . $key, 400, 'POST');
                $data = $e->getAllInfoRequest();
                return $data;
            }
        }
        return static::saveModel($modelMessage, $modelUser);
    }

    /**
     * Ответ на заявку
     * @param $modelMessage
     * @param $message
     * @return array|Response
     */
    public static function updateModel($modelMessage, $message)
    {
        try {
            $modelMessage->status = true;
            if ($modelMessage->save()) {
                $emailUser = $modelMessage->users->email;
                static::sendEmail($emailUser, $message);
                return static::sendResponse(200, 'OK', 'Заявка успешно решена, пользователю отправлено письмо.');
            } else {
                $e = new ApiException('Ошибка при обновлении данных', 400, 'PUT');
                $data = $e->getAllInfoRequest();
                return $data;
            }
        } catch (\Exception $e) {
            $data = [
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ];
            return $data;
        }

    }

    /**
     * Проверка на существование атрибутов
     * @param $params
     * @return array|Response
     */
    public static function checkPUTBodyParams($params)
    {
        $modelMessage = Message::find()->where(['id' => $params['id']])->one();
        if (empty($modelMessage)) {
            $e = new ApiException('Заявка не найдена', 404, 'PUT');
            $data = $e->getAllInfoRequest();
            return $data;
        }
        foreach ($params as $key => $param) {
            if (!$modelMessage->hasAttribute($key) || !in_array($key, self::PUT_ATTRIBUTE)) {
                $e = new ApiException('Не верный параметр запроса: ' . $key, 400, 'PUT');
                $data = $e->getAllInfoRequest();
                return $data;
            }
        }
        return static::updateModel($modelMessage, $params['comment']);
    }

    /**
     * Отправка письма на почту
     * @param $recipient
     * @param $message
     */
    public static function sendEmail($recipient, $message)
    {
        Yii::$app->mailer->compose()
            ->setFrom('supersite@mail.ru')
            ->setTo($recipient)
            ->setSubject('Ваша заявка решена')
            ->setTextBody('Комментарий к заявке: ' . $message)
            ->setHtmlBody("
                <b>Ваша заявка решена</b><br>
                Комментарий к заявке: {$message}
                ")
            ->send();
    }

    /**
     * Удаление заявки по id
     * @param $id
     * @return array|Response
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteMessage($id)
    {
        $modelMessage = Message::findOne($id);
        if (empty($modelMessage)) {
            $e = new ApiException('Заявка не найдена', 404, 'DELETE');
            $data = $e->getAllInfoRequest();
            return $data;
        } else {
            if ($modelMessage->delete()) {
                return static::sendResponse(200, 'DELETE', 'Заявка успешно удалена');
            } else {
                $e = new ApiException('Ошибка при удалении заявки', 418, 'DELETE');
                $data = $e->getAllInfoRequest();
                return $data;
            }
        }
    }

}