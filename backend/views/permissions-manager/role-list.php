<?php

use yii\grid\GridView;
use yii\helpers\Html;

?>
<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => [
        'id'=>'role-table',
        'class' => 'layui-table',
        'lay-size' => ''
    ],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
        ],
        'description:text:名称',
        'name:text:标识',
        'rule_name:text:规则名称',
        'created_at:datetime:创建时间',
        'updated_at:datetime:更新时间',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{assign}{update}{delete}',
            'buttons' => [
                'assign' => function ($url, $model) {
                    return ' [' . Html::a('分配权限', ['assign-permission', 'name' => $model['name']]) . '] ';
                },
                'update' => function ($url, $model) {
                    return ' [' . Html::a('修改', ['update', 'name' => $model['name']]) . '] ';
                },
                'delete' => function ($url, $model) {
                    return ' [' . Html::a('删除', ['del', 'name' => $model['name']]) . '] ';
                }
            ]
        ]
    ],
    'layout' => "\n{items}\n{summary}<div class=''>{pager}</div>"
]);
$this->registerCss("
    #role-table a{
        color:blue;
    }
");
?>


