<?php

use yii\grid\GridView;

$gather = yii::$app->Gather;

?>
<div class="handle-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'log_title',
            'add_time',
            'admin_name',
            'admin_ip',

            'model',
            'controller',
            'action',
            'log_info',
            'type',
            'handle_id',
            [
                'attribute' => 'add_time',
                'value' => function ($model) {
                    return date('Y-m-d H:i:s', $model->add_time);
                },
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view}']
        ],
        'options' => [
            'class' => 'layui-table',
            'style' => 'width:100%;'
        ],
        'tableOptions' => [
            'style' => 'width:100%;'
        ],
        'layout' => "{items}" . $gather->pager('pagerLayout'),
        'pager' => $gather->pager('pagerConfig')
    ]); ?>

</div>