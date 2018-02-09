<?php

namespace backend\controllers;


use common\models\AdminLog;
use yii;
use yii\data\ActiveDataProvider;

class AdminLogController extends BaseController
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => AdminLog::find()

        ]);
        return $this->render('index',[
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionView($id){
        return $this->render('view',[
            'model'=>AdminLog::findOne($id),
        ]);
    }

}