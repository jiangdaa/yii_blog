<?php

namespace backend\controllers;

use backend\models\Admin;
use common\models\LeaveMsg;
use yii\data\ActiveDataProvider;
use yii;
use common\models\User;
use common\models\Article;
use common\models\Share;

class AdminController extends BaseController
{


    public function actionMain()
    {
        if (yii::$app->user->isGuest) {
            $this->redirect(['login']);
        }
        $userCount = User::find()->count();
        $todayRegCount = User::find()
            ->where('created_time >= :today', [':today' => date('Y-m-d', time()) . '00:00:00'])
            ->count();
        $todayLoginCount = User::find()
            ->where('login_time >= :today', [':today' => date('Y-m-d', time()) . '00:00:00'])
            ->count();
        $articleCount = Article::find()->count();
        $shareCount = Share::find()->count();
        $todayLeaveMsgCount = LeaveMsg::find()
            ->where('leave_msg_time >= :today', [':today' => date('Y-m-d', time()) . '00:00:00'])
            ->count();
        return $this->renderPartial('main', [
            'total' => [
                'userCount' => $userCount,
                'todayRegCount' => $todayRegCount,
                'todayLoginCount' => $todayLoginCount,
                'articleCount' => $articleCount,
                'shareCount' => $shareCount,
                'todayLeaveMsgCount'=>$todayLeaveMsgCount
            ]
        ]);
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