<?php

namespace backend\controllers;

use common\models\Share;
use yii;
use common\models\Article;
use common\models\Category;
use yii\web\UploadedFile;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/*
 * 内容管理类
 */

class ContentManagerController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'ueditor' => [
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config' => [
                    'imageUrlPrefix' => "",
                    'imagePathFormat' => "/image/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }

    public function actionUpload()
    {
        $model = '';
        switch (yii::$app->request->get('cName')) {
            case 'Article':
                $model = new Article();
                break;
            case 'Share':
                $model = new Share();

                break;
        }
        if (Yii::$app->request->isPost) {

            $model->scenario = 'upload';
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {

                $today = date('Y-m-d');
                $filename = $model->file->baseName . '.' . $model->file->extension;
                $savePath = Url::base(true) . '/blog_cover/' . $today . '/' . $filename;
                $dir = dirname(dirname(__FILE__)) . '/web/blog_cover/' . $today . '/';
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

    public function actionArticle()
    {

        $gridData = new ActiveDataProvider([
            'query' => (new Query)
                ->select('a.id,a.title,a.stick,a.recommend,a.count,a.praise,a.author,c.name,a.issuetime,a.updatetime,a.state')
                ->from('{{%article}} as a')
                ->where('a.existdel = 1')
                ->leftjoin('{{%category}} as c', 'a.category = c.id')
                ->orderBy('issuetime desc'),
            'pagination' => [
                'pageSize' => 15
            ]
        ]);


        return $this->render('article', ['gridData' => $gridData]);
    }

    public function actionAddArticle()
    {

        $model = new Article;
        $request = yii::$app->request;
        $post = $request->post();
        if (!empty($post)) {
            if ($model->addArticle($post)) {
                yii::$app->session->setFlash('info', '文章添加成功');
                return $this->redirect(['article']);
            }
        }
        $model->recommend = 0;
        $model->state = 0;
        $model->stick = 0;

        return $this->render('add-article.php', [
            'model' => $model,
            'categoryList' => Category::getAllCategory(),
            'error' => $model->getErrors()
        ]);
    }


    public function actionEditArticle()
    {
        $aid = (int)yii::$app->request->get('aid');
        if (empty($aid) && !is_integer($aid) && $aid <= 0) {
            throw new \Exception('参数错误');
        }
        $article = Article::findOne((int)$aid);
        $article->scenario = 'addArticle';
        $request = yii::$app->request;
        $post = $request->post();
        if (!empty($post)) {
            if ($article->load($post) && $article->validate()) {
                if ($article->save(true)) {
                    yii::$app->session->setFlash('info', '文章修改成功');
                    return $this->redirect(['article']);
                }
            }
        }
        return $this->render('edit-article', ['model' => $article, 'categoryList' => Category::getAllCategory(),]);
    }

    public function actionDeleteArticle()
    {
        $aid = (int)yii::$app->request->get('aid');
        $ifrid = (int)yii::$app->request->get('ifrid');
        if (empty($aid) && !is_integer($aid) && $aid <= 0) {
            throw new \Exception('参数错误');
        }
        $article = Article::findOne((int)$aid);
        $article->existdel = 1;
        if ($article->save(false)) {
            yii::$app->session->setFlash('info', '文章已移到回收站');
            $this->redirect(['article?iframe-id=' . $ifrid]);
        }
    }

    public function actionCategory()
    {

        $model = new Category;
        $categorys = $model->find()->all();
        $post = yii::$app->request->post();
        if (!empty($post)) {
            if ($model->load($post) && $model->save()) {
                yii::$app->session->setFlash('info', '分类添加成功');
                $categorys = $model->find()->all();
            }

        }

        return $this->render('category', ['model' => $model, 'categorys' => $categorys]);
    }

    public function actionDeleteCategory()
    {
        $model = new Category;
        if ($cid = (int)yii::$app->request->get('cid')) {
            if (empty($cid) && $cid <= 0) {
                throw new \Exception('参数错误');
            }
            if (Article::find()->where(['category' => $cid])->count() == 0) {
                if ($model->deleteAll(['id' => $cid])) {
                    yii::$app->session->setFlash('info', '分类删除成功');
                }
            } else {
                yii::$app->session->setFlash('error', '删除失败,该分类下还有文章');
            }
        }
        return $this->redirect(['category']);

    }


    public function actionShare()
    {

        return $this->render('share', []);
    }

    public function actionShareAdd()
    {
        $model = new Share;
        $category = (new Category)->getAllCategory('true',['type'=>'share']);
        if (yii::$app->request->isPost) {
            $post = yii::$app->request->post();
            if ($model->addShare($post)) {
                yii::$app->session->setFlash('info', '添加资源成功');
            } else {
                yii::$app->session->setFlash('info', '添加资源失败');
            }
        }

        return $this->render('share-add', [
            'model' => $model,
            'category'=>$category
        ]);
    }


    public function actionTimeline()
    {
        echo '时光轴';
    }

    public function actionRecycle()
    {

        echo '回收站';
    }


}