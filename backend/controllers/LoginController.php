<?php
/**
 * Created by IntelliJ IDEA.
 * User: JiangDa
 * Date: 2018/1/23
 * Time: 19:30
 */

namespace backend\controllers;
use yii\web\Controller;
use backend\models\Admin;
use yii;
class LoginController extends Controller
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'maxLength' => 4,
                'minLength' => 4,
                'width' => 80,
                'height' => 40
            ]
        ];
    }


    public function actionLogin()
    {
        $model = new Admin;
        if (yii::$app->request->isPost) {
            $post = yii::$app->request->post();
            if ($model->login($post)) {
                $this->redirect(['admin/main']);
            }
        }
        return $this->renderPartial('login', ['model' => $model]);
    }
    public function actionLogout()
    {
        if (\yii::$app->user->logout()) {
            $this->redirect(['login']);
        }
    }

}