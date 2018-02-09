<?php

use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;

$gather = yii::$app->Gather;
?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to(['share-add']) ?>">添加资源分享</a>
    </blockquote>
<?php
echo GridView::widget([
    'dataProvider' => $gridData,
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
            'label' => '分享标题',
            'attribute' => 'share_name',
            'contentOptions' => [
                'width' => '30%'
            ],
        ],
        [
            'label' => '描述',
            'attribute' => 'share_describe',
            'contentOptions' => [
                'width' => '30%'
            ],
        ],
        'category:text:分类',
        'author:text:作者',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{update}  {delete} {preview}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('修改', ['edit-share', 'sid' => $model['id']]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除', null, ['class' => 'delete', 'sid' => $model['id']]);
                }
            ]
        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')

]);

$this->registerCss($gather->pager('css'));
$delurl = Url::to(['del-share']);
$ifid = yii::$app->request->get('iframe-id');

$this->registerJs(yii::$app->Prompt->jsString([
    'confirmDel' => [
        'url' => $delurl,
        'msg' => '资源'
    ]
]));

?>