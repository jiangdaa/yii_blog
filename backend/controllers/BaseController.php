<?php

namespace backend\controllers;

use yii\web\Controller;

class BaseController extends Controller
{

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            return true;
            $controller = $action->controller->id;
            $actionName = $action->id;
            if ($actionName == 'login') {
                return true;
            }
            if (\yii::$app->user->identity->id == 1) {
                return true;
            }

            echo $controller . '/' . $actionName;
            if (\yii::$app->user->can($controller . '/' . $actionName)) {
                return true;
            }
            // print_r($_SESSION);
            echo '你没有权限访问' . $controller . '/' . $actionName;
            //return true;
        }

    }


}

?>