<?php

namespace backend\controllers;

use common\models\Announcement;
use common\models\BloggerInfo;
use yii\data\ActiveDataProvider;

class ExtensionController extends BaseController
{


    public function actionAnnouncement()
    {

        $model = new Announcement;
        $gridViewData = new ActiveDataProvider([
            'query' => $model->find()->orderBy('created_time'),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);

        return $this->render('announcement', [
            'gridViewData' => $gridViewData
        ]);
    }

    public function actionDisDisable()
    {
        $anid = \yii::$app->request->get('anid');
        if (empty($anid)) {
            \yii::$app->session->setFlash('error', '参数错误');
        }
        $val = Announcement::find()->where(['id' => $anid])->asArray()->one()['is_disable'];
        if (Announcement::updateAll(['is_disable' => $val === '0' ? '1' : '0'], ['id' => $anid])) {
            \yii::$app->session->setFlash('info', '设置成功');
        }
        return $this->redirect(['announcement']);
    }

    public function actionAdd()
    {
        $model = new Announcement;
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            if ($model->addAnnouncement($post)) {
                \yii::$app->session->setFlash('info', '公告添加成功');
                return $this->redirect(['announcement']);
            }
        }
        $model->is_disable = '1';
        return $this->render('add', [
            'model' => $model
        ]);
    }


    public function actionBloggerInfo()
    {

        $model = new BloggerInfo;

        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            $model->id = 1;
            if ($model->editBlogger($post)) {
                \yii::$app->session->setFlash('info', '修改成功');
            } else {
                \yii::$app->session->setFlash('error', '修改失败');
            }
        }


        return $this->render('blogger-info', [
            'model' => $model->find()->limit(1)->one()
        ]);
    }


}