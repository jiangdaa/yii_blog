<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\gridView;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to(['link-add']) ?>">添加友情链接</a>
    </blockquote>
<?php
$gather = yii::$app->Gather;

echo gridView::widget([

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
        'link_name:text:链接名称',
        'link_url:text:链接地址',
        [
            'label' => '链接logo',
            'attribute' => 'link_logo',
            'format' => 'raw',
            'value' => function ($model) {
                return Html::img($model['link_logo'], ['width' => 200, 'height' => 60]);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => "{delete}{edit}",
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除', ['link-delete', 'id' => $model['id']]);
                },
                'edit' => function ($url, $model, $key) {
                    return Html::a('修改', ['link-edit', 'id' => $model['id']]);
                }
            ]
        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')

]);


?>