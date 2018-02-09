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

/**
 * -------------------------------------------
 *
 * Class ContentManagerController  内容管理类
 * @package backend\controllers
 *
 * -------------------------------------------
 */
class ContentManagerController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actions()
    {
        return [
            'ueditor' => \yii::$app->Gather->ueditorCfg()
        ];
    }

    /**
     *-------------------------------------------
     * actionUpload 上传图片
     * @return mixed
     * -------------------------------------------
     */
    public function actionUpload()
    {
        $model = null;
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
                $savePath = Url::base(true) . '/backend/blog_cover/' . $today . '/' . $filename;
                $dir = dirname(dirname(__FILE__)) . '/web/backend/blog_cover/' . $today . '/';
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
     *-------------------------------------------
     * actionUpload 渲染文章列表页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     *-------------------------------------------
     * actionAddArticle 渲染添加文章页面
     * @return mixed
     * -------------------------------------------
     */
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
        return $this->render('article-add', [
            'model' => $model,
            'categoryList' => Category::getAllCategory(),
            'error' => $model->getErrors()
        ]);
    }

    /**
     *-------------------------------------------
     * actionEditArticle 渲染编辑文章页面
     * @return mixed
     * @throws \Exception
     * -------------------------------------------
     */
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
        return $this->render('article-edit', ['model' => $article, 'categoryList' => Category::getAllCategory(),]);
    }

    /**
     *-------------------------------------------
     * actionDeleteArticle 渲染文章删除页面
     * @return mixed
     * @throws \Exception
     * -------------------------------------------
     */
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

    /**
     *-------------------------------------------
     * actionCategory 渲染文章分类页面
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     *-------------------------------------------
     * actionDeleteCategory 删除文章分类页面
     * @return mixed
     * @throws \Exception
     * -------------------------------------------
     */
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

    /**
     *-------------------------------------------
     * actionShare 渲染工具分享页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionShare()
    {
        $gridData = new ActiveDataProvider([
            'query' => Share::find(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('share', ['gridData' => $gridData]);
    }

    /**
     *-------------------------------------------
     * actionEditShare 渲染编辑工具分享页面
     * @return mixed
     * @throws \Exception
     * -------------------------------------------
     */
    public function actionEditShare()
    {
        $category = (new Category)->getAllCategory('true', ['type' => 'share']);
        $model = new Share;
        $sid = (int)\yii::$app->request->get('sid');
        if (empty($sid)) {
            throw new \Exception('参数错误');
        }
        $post = \yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            unset($post['Share']['file']);
            if ($model->updateAll($post['Share'], ['id' => $sid])) {
                \yii::$app->session->setFlash('info', '编辑成功');
                return $this->redirect('share');
            }
        }
        return $this->render('share-edit', ['model' => $model->findOne($sid), 'category' => $category]);
    }

    /**
     *-------------------------------------------
     * actionDelShare 渲染工具分享页面
     * @return mixed
     * @throws \Exception
     * -------------------------------------------
     */
    public function actionDelShare()
    {
        $sid = (int)\yii::$app->request->get('sid');
        $ifrid = (int)yii::$app->request->get('ifrid');
        if (empty($sid)) {
            throw new \Exception('参数错误');
        }
        if (Share::deleteAll(['id' => $sid])) {
            \yii::$app->session->setFlash('info', '删除成功');
        } else {
            \yii::$app->session->setFlash('error', '删除失败,请重新尝试下');
        }
        return $this->redirect(['share?iframe-id=' . $ifrid]);
    }


    /**
     *-------------------------------------------
     * actionShare 渲染工具添加页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionShareAdd()
    {
        $model = new Share;
        $category = (new Category)->getAllCategory('true', ['type' => 'share']);
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
            'category' => $category
        ]);
    }

    /**
     *-------------------------------------------
     * actionTimeline 渲染时光轴页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionTimeline()
    {
        echo '时光轴';
    }

    /**
     *-------------------------------------------
     * actionTimeline 渲染文章回收站页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionRecycle()
    {

        echo '回收站';
    }


}