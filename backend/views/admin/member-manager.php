<?php

use yii\helpers\Html;
use yii\grid\GridView;

?>


<?php
echo GridView::widget([
    'dataProvider' => $dataGridView,
    'summary' => "当前 {begin}-{end} ,共{totalCount} 条数据,{pageCount}页",
    'options' => [
        'id' => 'member-table',
        'class' => 'layui-table',
        'lay-size' => ''
    ],
    'columns' => [
        'id',
        'adminname:text:用户名'
        ,
        'adminemail:text:邮箱',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{assign}{update}{delete}',
            'buttons' => [
                'assign' => function ($url, $model, $key) {
                    return ' ['.Html::a('分配权限', ['permissions-manager/assign-auth', 'adminid' => $model['id']]).'] ';
                },
                'update' => function ($url, $model, $key) {
                    return ' ['.Html::a('修改', ['permissions-manager/assign-auth', 'adminid' => $model['id']]).'] ';
                },
                'delete' => function ($url, $model, $key) {
                    return ' ['.Html::a('删除', ['permissions-manager/assign-auth', 'adminid' => $model['id']]).'] ';
                }
            ]
        ]
    ],
    'layout' => "\n{items}\n{summary}<div>{pager}</div>"
]);
$this->registerCss("
    #member-table a{
        color:blue;
    }
");

?>
