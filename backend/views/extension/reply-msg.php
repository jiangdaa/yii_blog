<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to(['leave-msg']) ?>">返回</a>
    </blockquote>
<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">留言时间</label>
        <div class="layui-input-block">
            <p style="line-height:36px;"><?= $model->leave_msg_time ?></p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">留言内容</label>
        <div class="layui-input-block">
            <p style="line-height:36px;"><?= $model->leave_msg ?></p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">留言人</label>
        <div class="layui-input-block">
            <p style="line-height:36px;"><?= \yii::$app->request->get('nick_name') ?></p>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">头像</label>
        <div class="layui-input-block">
            <img width="50" height="50" style="border:1px solid #ccc;border-radius:50%"
                 src="<?= \yii::$app->request->get('portrait') ?>" alt="">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">pid</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'pid', [
                'placeholder' => '回复内容',
                'class' => 'layui-input',
                'value' => \yii::$app->request->get('rid')
            ]) ?>
            <?= Html::error($model, 'link_name', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">回复内容</label>
        <div class="layui-input-block">
            <?= Html::activeTextarea($model, 'leave_msg', [
                'placeholder' => '回复内容',
                'class' => 'layui-textarea',
                'value'=>''
            ]) ?>
            <?= Html::error($model, 'link_name', ['class' => 'error']) ?>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('回复留言', [
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();


?>