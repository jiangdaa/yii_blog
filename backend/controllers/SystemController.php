<?php

namespace backend\controllers;

use common\models\AdminLog;
use yii\data\ActiveDataProvider;

class SystemController extends BaseController
{

    public function actionLog()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => AdminLog::find(),
            'sort' => [
                'defaultOrder' => [
                    'add_time' => SORT_DESC
                ]
            ],
        ]);
        return $this->render('log', [
            'dataProvider' => $dataProvider
        ]);
    }

}