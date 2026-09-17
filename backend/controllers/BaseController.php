<?php

namespace backend\controllers;

use yii\web\Controller;

class BaseController extends Controller
{

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        $controller = $action->controller->id;
        $actionName = $action->id;
        if ($actionName == 'login' || $actionName == 'captcha') {
            return true;
        }
        if (\yii::$app->user->isGuest) {
            \yii::$app->user->loginRequired();
            return false;
        }
        if (\yii::$app->user->identity->id == 1) {
            return true;
        }
        if (\yii::$app->user->can($controller . '/' . $actionName)) {
            return true;
        }
        throw new \yii\web\ForbiddenHttpException('你没有权限访问' . $controller . '/' . $actionName);
    }



}

?>