<?php

namespace frontend\controllers;

use common\components\ArticleQry;
use common\models\Category;
use common\models\Announcement;
use yii;

class IndexController extends BaseController
{
    public $mustCheck = [];
    public $noMustCheck = ['index', 'detail'];

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

    public function actionDetail()
    {
        $aid = abs((int)yii::$app->request->get('aid'));
        if (empty($aid)) {
            $this->goHome();
        }
        return $this->render('detail', [
            'detail' => ArticleQry::getInstance()->getArticles(['a.id' => $aid])['data'][0],
            'categorys' => Category::getAllCategory(),
            'randArticles' => ArticleQry::getInstance()->getRandArticles(),
            'comments' => ArticleQry::getInstance()->getArticleComments($aid)
        ]);

    }

}

?>