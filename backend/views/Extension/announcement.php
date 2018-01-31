<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$gather = \yii::$app->Gather;
?>

<blockquote class="layui-elem-quote layui-quote-nm">
    <a class="layui-btn" href="<?= Url::to(['add']) ?>">添加公告</a>
</blockquote>
<?php
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
        'content:text:公告内容',
        'created_time:text:发布时间',
        'uname:text:发布人',
        [
            'label' => '是否启用',
            'value' => function ($model) {
                return $model['is_disable'] == 0 ? '禁用' : '启用';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{disDisable}',
            'buttons' => [
                'disDisable' => function ($url, $model, $key) {
                    $con = $model['is_disable'] === '0' ? '启用' : '禁用';
                    return Html::a($con, ['dis-disable', 'anid' => $model['id']]);
                }
            ]

        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')
]);
$this->registerCss($gather->pager('css'));
$this->registerJs(yii::$app->Prompt->jsString());
?>


