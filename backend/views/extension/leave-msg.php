<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$gather = yii::$app->Gather;


echo GridView::widget([
    'dataProvider' => $gridViewData,
    'options' => [
        'class' => 'layui-table',
        'style' => 'width:100%;'
    ],
    'tableOptions' => [
        'style' => 'width:100%;'
    ],
    'columns' => [
        'id',
        [
            'label' => '留言级别',
            'attribute' => 'pid',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model['pid'] == 0) {
                    return '1级留言';
                }
                return '回复id为' . Html::a($model['pid'], null, ['style' => 'color:red']) . '的留言';
            }
        ],

        'email:text:邮箱地址',
        'nick_name:text:昵称',
        [
            'label' => '头像',
            'attribute' => 'portrait',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model['portrait'], ['width' => 30, 'height' => 30, 'style' => 'border-radius:50%; border:1px solid #ccc;']);
            }
        ],
        'ip:text:ip地址',
        'login_time:text:最后一次登陆时间',
        'leave_msg_time:text:留言时间',
        [
            'label' => '留言内容',
            'attribute' => 'leave_msg',
            'format' => 'raw'
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => "{delete}{edit}",
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除留言 ', null, ['class' => 'delete', 'lid' => $model['id']]);
                },
                'edit' => function ($url, $model, $key) {
                    return Html::a(' 回复留言', ['reply-msg', 'rid' => $model['id'],'portrait'=>$model['portrait'],'nick_name'=>$model['nick_name']]);
                }
            ]
        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')

]);
$delurl = Url::to(['extension/msg-delete']);
$this->registerJs(\yii::$app->Prompt->jsString(['confirmDel' => [
    'url' => $delurl,
    'msg' => '留言',
    'attrId' => 'lid'
]]));