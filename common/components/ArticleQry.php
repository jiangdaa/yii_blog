<?php

namespace common\components;

use yii\db\Query;
use yii\data\Pagination;
use yii;
use common\models\Article;
use common\models\Comment;

/**
 * -------------------------------------------
 *
 * @Class ArticleQry    文章的一些操作
 * @package common\components
 *
 * -------------------------------------------
 */
class ArticleQry extends DB
{
    /**
     * -------------------------------------------
     * getArticles 获取文章
     * @param array $additional 赛选条件
     * @return array
     * -------------------------------------------
     */
    public function getArticles($additional = [])
    {
        $condition = ['a.existdel' => '0', 'a.state' => '1'];
        $query = (new Query)->from('{{%article}} as a');
        $pagination = new Pagination([
            'pageSize' => yii::$app->params['pageSize'],
            'totalCount' => $query->where($condition)->count(),
        ]);
        return [
            'data' => $query->select('a.*,c.name,c.id as cid')
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->join('left join', '{{%category}} as c on c.id = a.category')
                ->where(array_merge($condition, $additional))
                ->orderBy('issuetime desc')
                ->all(),
            'pager' => $pagination
        ];

    }

    /**
     * -------------------------------------------
     * getArticleCommentCount 获取文章访问量
     * @param int $aid 文章id
     * @return int|string
     * -------------------------------------------
     */
    public function getArticleCommentCount($aid)
    {
        return Comment::find()->where(['id' => $aid])->count();
    }

    /**
     * -------------------------------------------
     * getRandArticles 获取随机的五篇文章
     * @return array
     * -------------------------------------------
     */
    public function getRandArticles()
    {
        return Article::find()
            ->select('id,title')
            ->where(['existdel' => '0', 'state' => '1'])
            ->orderBy('rand()')
            ->limit(5)
            ->asArray()
            ->all();
    }

    /**
     * -------------------------------------------
     * increasingPageView 增加访问量
     * @return bool
     * -------------------------------------------
     */
    public function increasingPageView($aid)
    {
        $count = (int)Article::find()->where(['id' => $aid])->one()['count'];
        return Article::updateAll(['count' => $count + 1], ['id' => $aid]);
    }

    /**
     * -------------------------------------------
     * giveALike 文章点赞
     * @param int $aid 文章id
     * @return bool
     * -------------------------------------------
     */
    public function giveALike($aid)
    {
        $count = (int)Article::find()->where(['id' => $aid])->one()['praise'];
        return Article::updateAll(['praise' => $count + 1], ['id' => $aid]);
    }


}