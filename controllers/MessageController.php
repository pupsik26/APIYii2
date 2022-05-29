<?php

namespace app\controllers;

use app\helpers\api\ApiException;
use app\models\Message;
use app\helpers\api\ApiHelper;
use app\models\User;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\Response;

class MessageController extends \yii\rest\Controller
{

    const SORT = [
        'ASC',
        'DESC'
    ];

    public $modelClass = 'app\models\Message';

    /**
     * Метод получения всех заявок + сортировка по дате создания
     * @param int $sort
     * @return ApiException|array|ActiveRecord[]
     */
    public function actionAll($sort = self::SORT[0])
    {
        return Message::find()->orderBy('created_at ' . $sort)->all();
    }

    /**
     * Метод получения заявок по статусам + сортировка по дате создания
     * @param int $status
     * @param int $sort
     * @param null $id
     * @param null $name
     * @return array|string|ActiveQuery|ActiveRecord[]
     */
    public function actionGet($status = 0, $sort = self::SORT[0], $id = null, $name = null)
    {
        if ($id == null && $name == null) {
            return Message::find()
                ->where(['status' => $status])
                ->orderBy('created_at ' . $sort)
                ->all();
        } else {
            $messageId = User::find()->where(['or', ['id' => $id], ['name' => $name]])->one();
            if (!empty($messageId) && isset($messageId)) {
                return $messageId->messages;
            } else {
                return 'Нет данных по пользователю с ID: ' . $id;
            }

        }

    }

    /**
     * Метод отправки заявки
     * @return array|Response
     */
    public function actionPost()
    {
        $body = Yii::$app->request->bodyParams;
        $params = ApiHelper::checkPOSTBodyParams($body);
        return $params;
    }

    public function actionPut()
    {

    }

}
