<?php

namespace app\helpers\api;

use app\models\Message;
use Yii;
use yii\console\controllers\HelpController;
use yii\web\Response;

class ApiHelper extends HelpController
{

    /**
     * Метод ответа
     * @param $message
     * @param $code
     */
    public static function createResponse($message, $code)
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        $response->data = [
            'message' => $message,
            'statusCode'=> $code
        ];
        $response->send();
    }

    /**
     * Метод создания новой модели
     * @return array
     */
    public static function checkAttribute()
    {
        $model = new Message();
        $params = $params = \Yii::$app->request->bodyParams;
        $model->load($params);
        return static::saveModel($model);
    }

    /**
     * Метод сохранения модели в БД
     * @param $model
     * @return array
     */
    protected static function saveModel($model)
    {
        if ($model->save()) {
            $message = 'Данные успешно добавленны';
            $statusCode = 200;
            static::createResponse($message, $statusCode);
        } else {
            $message = 'Не удалось добавить данные в таблицу';
            $statusCode = 400;
            static::createResponse($message, $statusCode);
        }
    }

    /**
     * Метод проверки POST тела запроса на лишние поля
     * @return array
     */
    public static function validatePostRequest()
    {
        $post = Yii::$app->request->post();
        if (empty($post['comment']) || (count($post) > 1)) {
            $message = 'Ошибка в теле запроса';
            $statusCode = 400;
            static::createResponse($message, $statusCode);
        } else {
            return static::checkAttribute();
        }
    }

    public static function validatePutRequest()
    {

    }

}