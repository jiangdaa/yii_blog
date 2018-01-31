<?php

namespace backend\controllers;

use backend\models\Admin;
use yii\data\ActiveDataProvider;
use yii;

class AdminController extends BaseController
{



    public function actionMain()
    {
        if (yii::$app->user->isGuest) {
            $this->redirect(['login']);
        }
        return $this->renderPartial('main', []);
    }



    public function actionMemberManager()
    {

        $dataGridView = new ActiveDataProvider([
            'query' => Admin::find(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('member-manager', ['dataGridView' => $dataGridView]);
    }


}