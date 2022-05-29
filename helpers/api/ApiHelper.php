<?php

namespace app\helpers\api;

use app\models\Message;
use app\models\User;
use yii\console\controllers\HelpController;
use yii\web\Response;

class ApiHelper extends HelpController
{

    public static $postAttribute = [
        'comment' => false,
        'email' => false,
        'name' => false,
    ];

    /**
     * @int $value
     * @string $text
     * @string $data
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
            if ($modelMessage->hasAttribute($key) && array_key_exists($key, static::$postAttribute)) {
                $modelMessage->$key = $param;
                static::$postAttribute[$key] = true;
            } else if ($modelUser->hasAttribute($key) && array_key_exists($key, static::$postAttribute)) {
                $modelUser->$key = $param;
                static::$postAttribute[$key] = true;
            } else {
                $e = new ApiException('Не верный параметр запроса: ' . $key, 400, 'POST');
                $data = $e->getAllInfoRequest();
                return $data;
            }
        }
        return static::saveModel($modelMessage, $modelUser);
    }

    public static function checkEmailForUser()
    {

    }

}