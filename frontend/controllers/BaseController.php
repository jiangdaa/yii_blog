<?php

namespace frontend\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;
use \common\models\BloggerInfo;
use \common\models\SiteConfig;
use \common\models\Link;

class BaseController extends Controller
{
    // -不用登录能执行的方法
    public $noMustCheck = [];
    // -需要登录才能执行的方法
    public $mustCheck = [];

    /**
     * -------------------------------------------
     * behaviors 行为
     * @return array
     * -------------------------------------------
     */
    public function behaviors()
    {
        $app = \yii::$app;
        $app->params['bloggerInfo'] = BloggerInfo::find()->limit(1)->asArray()->one();
        $app->params['siteConfig'] = SiteConfig::find()->where(['id' => '1'])->asArray()->one();
        $app->params['link'] = Link::find()->asArray()->all();
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