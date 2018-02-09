<?php
namespace frontend\controllers;

use yii\web\Controller;

/**
 * -------------------------------------------
 *
 * Class ErrorController 定义error模板
 * @package frontend\controllers
 *
 * -------------------------------------------
 */
class ErrorController extends Controller{


    public function actionError(){

        return $this->renderPartial('error');
    }


}