<?php

namespace frontend\controllers;

use common\components\ArticleQry;
use common\models\Category;
use common\models\Announcement;
use common\models\Share;
use yii;

class IndexController extends BaseController
{
    public $mustCheck = [];
    public $noMustCheck = ['index', 'detail', 'share', 'about'];

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

    public function actionAbout()
    {

        return $this->render('about');
    }

}

?>