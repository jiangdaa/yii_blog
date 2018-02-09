<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to('announcement') ?>">返回</a>
    </blockquote>
<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">公告信息</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'content', [
                'placeholder' => '公告信息',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'content', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">状态</label>
        <div class="layui-input-inline">
            <?= Html::activeRadioList($model, 'is_disable', ['0' => '禁用', '1' => '启用'], ['style' => 'line-height:38px']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('添加公告', [
                'placeholder' => '请输入标题',
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();

?>