<?php

use yii\widgets\DetailView;

?>
<div class="handle-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'log_title',
            'log_info',
            'admin_id',
            'admin_name',
            'admin_ip',
            'admin_agent',
            'model',
            'controller',
            'action',
            'type',
            'handle_id',
            [
                'attribute' => 'add_time',
                'value' => date('Y-m-d H:i:s', $model->add_time),
            ],
        ],
        'options' => [
            'class' => 'layui-table',
            'style' => 'width:100%;'
        ],
    ]); ?>

</div>
