<?php

namespace common\components;

use yii\db\Query;
use yii\data\Pagination;
use yii;
use common\models\Article;
use common\models\Comment;

class ArticleQry extends DB
{

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
            'pager' => $pagination];

    }

    public function getArticleCommentCount($aid)
    {

        return Comment::find()->where(['id' => $aid])->count();
    }

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

    public function getArticleComments($aid){
        $condition = ['c.id'=>$aid];
        return (new Query)->from('{{%comment}} as c')
            ->select('c.*,a.adminname')
            ->leftJoin('{{%admin}} as a','a.id=c.comment_uid')
            ->where($condition)
            ->orderBy('comment_time desc')
            ->all();

    }


}