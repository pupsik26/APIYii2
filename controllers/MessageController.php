<?php

namespace app\controllers;

use app\models\Message;
use app\helpers\api\ApiHelper;
use yii\web\MethodNotAllowedHttpException;

class MessageController extends \yii\rest\Controller
{

    public $modelClass = 'app\models\Message';
    const SORT = [
        'ASC',
        'DESC'
    ];
    /**
     * @param $request
     * @return array|void|MethodNotAllowedHttpException
     */
    private function checkError($request)
    {
        switch ($request) {
            case 'post':
                return ApiHelper::validatePostRequest();
            case 'put':
                return ApiHelper::validatePutRequest();
            default:
                return new MethodNotAllowedHttpException();
        }
    }

    /**
     * Метод получения всех заявок + сортировка по дате создания
     * @param int $sort
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionAll($sort = self::SORT[0])
    {
        return Message::find()->orderBy('created_at ' . $sort)->all();
    }

    /**
     * Метод получения заявок по статусам + сортировка по дате создания
     * @param $status
     * @param int $sort
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionGet($status, $sort = self::SORT[0])
    {
        return Message::find()->where(['status' => $status])->orderBy(['created_at' => $sort])->all();
    }

    public function actionPost()
    {
        return $this->checkError('post');
    }

}
