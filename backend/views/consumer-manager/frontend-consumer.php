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
        'user_name:text:账号名称',
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
        'ip:text:最后一次登陆',
        'login_time:text:最后一次登陆时间',
        'created_time:text:注册时间',
        [
            'label' => '状态',
            'attribute' => 'state',
            'value' => function ($model) {
                return $model['state'] === '0' ? '正常' : '黑名单';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => "{delete}{edit}",
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除用户 ', null, ['class' => 'delete', 'uid' => $model['id']]);
                },
                'edit' => function ($url, $model, $key) {
                    return Html::a($model['state'] === '0' ? ' 拉黑用户' : ' 取消拉黑', ['blacklist', 'uid' => $model['id']]);
                }
            ]
        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')

]);
$delurl = Url::to(['consumer-manager/user-delete']);
$this->registerJs(\yii::$app->Prompt->jsString(['confirmDel' => [
    'url' => $delurl,
    'msg' => '资源',
    'attrId' => 'uid'
]]));