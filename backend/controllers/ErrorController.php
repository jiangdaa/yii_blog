<?php
namespace backend\controllers;

use yii\web\Controller;

/*
 *  ErrorController  定义error模板
 */
class ErrorController extends Controller{


    public function actionError(){

        return $this->renderPartial('error');
    }


}