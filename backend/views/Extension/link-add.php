<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to(['link']) ?>">返回</a>
    </blockquote>
<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">链接名称</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'link_name', [
                'placeholder' => '友情链接名称',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'link_name', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">链接地址</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'link_url', [
                'placeholder' => '链接地址',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'link_url', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">链接logo</label>
        <div class="layui-input-block">
            <?= Html::activeInput('hidden', $model, 'link_logo', [
                'placeholder' => '网站Logo',
                'class' => 'layui-input',
                'id' => 'coverPath'
            ]) ?>
            <button type="button" class="layui-btn" id="uploadLinkLogo" style="vertical-align:top;">
                <i class="layui-icon">&#xe67c;</i>上传logo
            </button>
            <img width="200" id="logo" src="<?= $model->link_logo ?>" height="80"
                 style="border:1px solid #ccc;margin-bottom:10px;margin-left:30px;vertical-align: middle;" alt="logo">

            <?= Html::error($model, 'link_logo', ['class' => 'error']) ?>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('添加友情链接', [
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();
$url = Url::to(['upload','cName'=>'Link']);
$this->registerJs(\yii::$app->Prompt->jsString([
    'upload' => [
        'uploadBtn' => '#uploadLinkLogo',
        'url' => "{$url}",
        'field' => 'Link[file]',
        'coverPath' => '#coverPath',
        'cover' => '#logo',
        'successMsg' => '上传成功'
    ]
]));


?>