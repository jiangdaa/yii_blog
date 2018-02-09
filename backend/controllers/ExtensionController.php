<?php

namespace backend\controllers;

use common\models\LeaveMsg;
use common\models\Link;
use common\models\Announcement;
use common\models\BloggerInfo;
use common\models\SiteConfig;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * -------------------------------------------
 *
 * Class ExtensionController  扩展设置
 * @package backend\controllers
 *
 * -------------------------------------------
 */
class ExtensionController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'ueditor' => \yii::$app->Gather->ueditorCfg(),
        ];
    }

    /**
     * -------------------------------------------
     * actionUpload 图片上传
     * @return mixed
     * -------------------------------------------
     */
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
                $savePath = Url::base(true) . '/backend/link_logo/' . $today . '/' . $filename;
                $dir = dirname(dirname(__FILE__)) . '/web/backend/link_logo/' . $today . '/';
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

    /**
     * -------------------------------------------
     * actionAnnouncement 渲染网站公告页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionDisDisable 渲染网站公告 禁止/激活 页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionAdd 渲染添加网站公告页面
     * @return mixed
     * -------------------------------------------
     */
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
        return $this->render('announcement-add', [
            'model' => $model
        ]);
    }

    /**
     * -------------------------------------------
     * actionBloggerInfo 渲染博主信息页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionSiteConfig 渲染网站配置页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionLink 渲染网站友情链接配置页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionLinkDelete 删除友情链接
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionLinkAdd 渲染添加友情链接页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionLinkAdd()
    {
        $model = new Link;
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            if ($model->addLink($post)) {
                \yii::$app->session->setFlash('info', '友情链接添加成功');
            } else {
                \yii::$app->session->setFlash('error', '友情链接添加失败,请重新尝试');
            }

            return $this->redirect('link');
        }
        return $this->render('link-add', [
            'model' => $model
        ]);
    }

    /**
     * -------------------------------------------
     * actionLinkAdd 渲染修改友情链接页面
     * @return mixed
     * -------------------------------------------
     */
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


    /**
     * -------------------------------------------
     * actionLeaveMsg 渲染留言管理页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionLeaveMsg()
    {
        $gridViewData = new ActiveDataProvider([
            'query' => (new Query)->from('{{%leave_msg}}')->select('{{%user}}.nick_name,{{%user}}.email,{{%user}}.login_time,{{%user}}.ip,{{%user}}.portrait,{{%leave_msg}}.*')->leftJoin('{{%user}}', '{{%user}}.id={{%leave_msg}}.uid'),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('leave-msg', ['gridViewData' => $gridViewData]);
    }

    /**
     * -------------------------------------------
     * actionMsgDelete 删除留言
     * @return mixed
     * -------------------------------------------
     */
    public function actionMsgDelete()
    {
        $id = (int)\yii::$app->request->get('lid');
        $ifrid = (int)\yii::$app->request->get('ifrid');
        if (empty($id)) {
            \yii::$app->session->setFlash('error', '参数错误');
        } else {
            if (LeaveMsg::deleteAll(['id' => $id])) {
                \yii::$app->session->setFlash('info', '删除成功');
            } else {
                \yii::$app->session->setFlash('error', '删除失败,请重新尝试');
            }
        }
        return $this->redirect(['leave-msg?iframe-id=' . $ifrid]);
    }

    /**
     * -------------------------------------------
     * actionMsgReply 回复留言
     * @return mixed
     * @throws \Exception
     */
    public function actionReplyMsg()
    {
        $rid = (int)\yii::$app->request->get('rid');
        if (empty($rid)) {
            throw new \Exception('参数错误');
        }
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            $model = new LeaveMsg;
            if ($model->load($post) && $model->validate()) {
                $model->uid = 1;
                if ($model->save()) {
                    \yii::$app->session->setFlash('info', '回复留言成功');
                    \common\models\AdminLog::saveLog('Extension', 'ReplyMsg', 'leave_msg', '回复了留言', '添加', '', $rid);
                    return $this->redirect('leave-msg');
                }
            } else {
                \yii::$app->session->setFlash('error', '回复留言失败,请重新尝试');
            }
        }
        return $this->render('reply-msg', [
            'model' => LeaveMsg::findOne($rid)
        ]);
    }


    public function actionLog()
    {


        return $this->render('log', ['dataProvider' => $dataProvider]);
    }

}