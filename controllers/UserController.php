<?php

namespace app\controllers;

use app\models\User;
use yii\rest\Controller;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $modelClass = 'app\models\User';

//    public function actions()
//    {
//        $actions = parent::actions();
//
//        // отключить действия "delete" и "create"
//        unset($actions['delete'], $actions['create']);
//
//        // настроить подготовку провайдера данных с помощью метода "prepareDataProvider()"
//        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
//
//        return $actions;
//    }

    public function actionGet(array $params)
    {
        var_dump($params);
//        $body = Yii::$app->getRequest()->getBodyParams();
//        var_dump($body);
        return; //User::find()->where(['like', 'email', $filter])->all();
    }

}
