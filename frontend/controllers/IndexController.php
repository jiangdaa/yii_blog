<?php

namespace frontend\controllers;

use common\components\ArticleQry;
use common\models\Category;
use common\models\Announcement;
use common\models\Comment;
use common\models\LeaveMsg;
use common\models\Share;
use yii;
use yii\web\UploadedFile;
use common\models\User;
use yii\helpers\Url;

class IndexController extends BaseController
{
    public $mustCheck = ['logout', 'index', 'detail', 'share', 'about', 'login', 'register', 'user', 'upload', 'articles', 'category'];
    public $noMustCheck = ['index', 'detail', 'share', 'about', 'login', 'register', 'upload', 'articles', 'category'];
    public $enableCsrfValidation = false;


    /**
     * -------------------------------------------
     * actionUpload  文件上传
     * @return array
     * -------------------------------------------
     */
    public function actionUpload()
    {

        if (Yii::$app->request->isPost) {
            $model = new User();
            $model->scenario = 'upload';
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $today = date('Y-m-d');
                $filename = $model->file->baseName . '.' . $model->file->extension;
                $savePath = Url::base(true) . '/frontend/user_portrait/' . $today . '/' . $filename;
                $dir = dirname(dirname(__FILE__)) . '/web/frontend/user_portrait/' . $today . '/';
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
     * actionIndex  渲染博客首页
     * @return mixed
     * -------------------------------------------
     */
    public function actionIndex()
    {
        $articles = ArticleQry::getInstance();
        $category = Category::getAllCategory();
        $announcements = (new Announcement)->getAnnouncement(['is_disable' => '1']);
        return $this->render('index', [
            'articles' => $articles->getArticles()['data'],
            'pager' => $articles->getArticles()['pager'],
            'categorys' => $category,
            'recommends' => $articles->getArticles(['recommend' => '1'])['data'],
            'announcements' => $announcements
        ]);
    }

    /**
     * -------------------------------------------
     * actionDetail  渲染文章详情
     * @return mixed
     * -------------------------------------------
     */
    public function actionDetail()
    {
        $aid = abs((int)yii::$app->request->get('aid'));
        if (empty($aid)) {
            $this->goHome();
        }

        ArticleQry::getInstance()->increasingPageView($aid);
        return $this->render('detail', [
            'detail' => ArticleQry::getInstance()->getArticles(['a.id' => $aid])['data'][0],
            'categorys' => Category::getAllCategory(),
            'randArticles' => ArticleQry::getInstance()->getRandArticles(),
            'comments' => (new Comment)->disFormat($aid)
        ]);

    }

    /**
     * -------------------------------------------
     * actionArticles  文章专栏
     * @return mixed
     * -------------------------------------------
     */
    public function actionArticles()
    {
        $articles = ArticleQry::getInstance();
        $category = Category::getAllCategory();
        $cid = abs((int)yii::$app->request->get('cid'));
        $condition = ['category' => $cid];
        if (empty($cid)) {
            $condition = [];
        }
        return $this->render('articles', [
            'articles' => $articles->getArticles($condition)['data'],
            'pager' => $articles->getArticles()['pager'],
            'categorys' => $category,
            'recommends' => $articles->getArticles(['recommend' => '1'])['data']
        ]);
    }

    /**
     * -------------------------------------------
     * actionCategory  分类
     * @return mixed
     * -------------------------------------------
     */
    public function actionCategory()
    {
        $articles = ArticleQry::getInstance();
        $category = Category::getAllCategory();
        $cid = abs((int)yii::$app->request->get('cid'));
        $condition = ['category' => $cid];
        return $this->render('articles', [
            'articles' => $articles->getArticles($condition)['data'],
            'pager' => $articles->getArticles()['pager'],
            'categorys' => $category,
            'recommends' => $articles->getArticles(['recommend' => '1'])['data']
        ]);

    }


    /**
     * -------------------------------------------
     * actionShare  渲染分享
     * @return mixed
     * -------------------------------------------
     */
    public function actionShare()
    {
        $category_shares = (new Category)->getAllCategory(true, ['type' => 'share']);
        $shares = (new Share)->find()->asArray()->all();
        $new = [];
        foreach ($category_shares as $ckey => $category_share) {
            foreach ($shares as $skey => $share) {
                if ($ckey == $share['cid']) {
                    $new[$share['cid']][] = $share;
                }
            }
        }
        return $this->render('share', [
            'category_shares' => $category_shares,
            'shares' => $new
        ]);
    }

    /**
     * -------------------------------------------
     * actionAbout  渲染关于我们
     * @return mixed
     * -------------------------------------------
     */
    public function actionAbout()
    {
        $leave_msgs = (new LeaveMsg)->disFormat();

        return $this->render('about', [
            'leave_msgs' => $leave_msgs
        ]);
    }

    /**
     * -------------------------------------------
     * actionAbout  渲染登录页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionLogin()
    {
        $this->layout = 'empty';

        return $this->render('login');
    }


    /**
     * -------------------------------------------
     * actionRegister  渲染注册页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionRegister()
    {
        $this->layout = 'empty';
        return $this->render('register');
    }

    public function actionLogout()
    {

        if (\yii::$app->user->logout(true)) {
            return $this->redirect(['index']);
        }

    }

    /**
     * -------------------------------------------
     * actionUser  渲染个人中心页面
     * @return mixed
     * -------------------------------------------
     */
    public function actionUser()
    {
        $model = new User;
        $post = \yii::$app->request->post();
        if (\yii::$app->request->isPost && !empty($post)) {
            $model->scenario = 'edit';
            if ($model->load($post) && $model->validate()) {
                unset($post['User']['file']);
                if ($model->updateAll($post['User'], ['id' => \yii::$app->user->id])) {
                    \yii::$app->session->setFlash('info', '个人信息修改成功');
                }
            } else {
                \yii::$app->session->setFlash('error', '修改失败,昵称已存在');
            }
            return $this->redirect(['user']);
        }

        return $this->render('user', ['model' => $model->findOne(\yii::$app->user->id)]);
    }

}

?>