<?php

namespace frontend\controllers;

use common\components\ArticleQry;
use common\models\Category;
use yii;

class CategoryController extends BaseController
{
    public $noMustCheck = ['articles'];

    public function actionArticles()
    {
        $articles = ArticleQry::getInstance();
        $category = Category::getAllCategory();
        $cid = abs((int)yii::$app->request->get('cid'));
        if (empty($cid)) {
            $this->goHome();
        }
        return $this->render('articles', [
            'articles' => $articles->getArticles(['category' => $cid])['data'],
            'pager' => $articles->getArticles()['pager'],
            'categorys' => $category,
            'recommends' => $articles->getArticles(['recommend' => '1'])['data']
        ]);
    }


}
