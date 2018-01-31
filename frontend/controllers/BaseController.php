<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class BaseController extends Controller
{

    public $noMustCheck = [];
    public $mustCheck = [];

    public function behaviors()
    {
        \yii::$app->params['bloggerInfo'] = \common\models\BloggerInfo::find()->limit(1)->asArray()->one();
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => $this->noMustCheck,
                        'roles' => ['?']
                    ],
                    [
                        'allow' => true,
                        'actions' => $this->mustCheck,
                        'roles' => ['@']
                    ],

                ]
            ]
        ];
    }




}

?>