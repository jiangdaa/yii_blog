<?php

namespace backend\controllers;

use common\models\Link;
use common\models\Announcement;
use common\models\BloggerInfo;
use common\models\SiteConfig;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use yii\helpers\Url;

class ExtensionController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionUpload()
    {
        $cName = \yii::$app->request->get('cName');
        switch ($cName) {
            case 'Link':
                $model = new Link;
                break;
            case 'SiteConfig':
                $model = new SiteConfig;
                break;
        }
        if (\Yii::$app->request->isPost) {
            $model->scenario = 'upload';
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $today = date('Y-m-d');
                $filename = $model->file->baseName . '.' . $model->file->extension;
                $savePath = Url::base(true) . '/site_img/' . $today . '/' . $filename;
                $dir = dirname(dirname(__FILE__)) . '/web/site_img/' . $today . '/';
                if (!file_exists($dir)) {
                    mkdir($dir);
                }
                if ($model->file->saveAs($dir . $filename)) {
                    echo json_encode([
                        'success' => 1,
                        'savePath' => $savePath
                    ]);
                } else {
                    echo json_encode([
                        'error' => 0,
                        'msg' => '上传失败请重新尝试'
                    ]);
                }
            }
        }
    }

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

    public function actionSiteConfig()
    {
        $model = new SiteConfig;
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            if ($model->editSiteConfig($post)) {
                \yii::$app->session->setFlash('info', '网站信息修改成功');
            } else {
                \yii::$app->session->setFlash('error', '网站信息修改失败');
            }
        }
        return $this->render('site-config', [
            'model' => $model->findOne(['id' => 1])
        ]);
    }

    public function actionLink()
    {
        $model = new Link;
        $gridViewData = new ActiveDataProvider([
            'query' => $model->find(),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);

        return $this->render('link', [
            'gridViewData' => $gridViewData
        ]);
    }

    public function actionLinkDelete()
    {
        $id = (int)\yii::$app->request->get('id');
        if (empty($id)) {
            \yii::$app->session->setFlash('error', '参数错误');
        } else {
            if (Link::deleteAll(['id' => $id])) {
                \yii::$app->session->setFlash('info', '删除成功');
            } else {
                \yii::$app->session->setFlash('error', '删除失败,请重新尝试');
            }
        }
        return $this->redirect('link');
    }

    public function actionLinkAdd()
    {
        $model = new Link;

        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            if ($model->addLink($post)) {
                \yii::$app->session->setFlash('info', '友情链接添加成功');
                return $this->redirect(['link']);
            } else {
                \yii::$app->session->setFlash('error', '友情链接添加失败,请重新尝试');
            }
        }

        return $this->render('link-add', [
            'model' => $model
        ]);
    }

    public function actionLinkEdit()
    {
        $model = new Link;
        $id = (int)\yii::$app->request->get('id');
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();

          unset($post['Link']['file']);
            if (!empty($id) && $model->updateAll($post['Link'], ['id' => $id])) {
                \yii::$app->session->setFlash('info', '友情链接修改成功');
                return $this->redirect(['link']);
            } else {
                \yii::$app->session->setFlash('error', '友情链接修改失败,请重新尝试');
            }
        }

        return $this->render('link-edit', [
            'model' => $model->findOne($id)
        ]);
    }


}