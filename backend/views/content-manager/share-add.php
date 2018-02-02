<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to(['share']) ?>">返回</a>
    </blockquote>
<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">资源名称</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'share_name', [
                'placeholder' => '资源名称',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'share_name', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">资源描述</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'share_describe', [
                'placeholder' => '资源描述',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'share_describe', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item" style="line-height:40px;">
        <label class="layui-form-label">分类</label>
        <div class="layui-input-block">
            <?= Html::activeRadioList($model, 'cid', $category) ?>

            <?= Html::error($model, 'category', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">作者</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'author', [
                'placeholder' => '作者',
                'class' => 'layui-input',
                'value' => 'admin'
            ]) ?>
            <?= Html::error($model, 'author', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">封面</label>
        <div class="layui-input-block">
            <?= Html::activeInput('hidden', $model, 'cover', [
                'placeholder' => '封面',
                'class' => 'layui-input',
                'id' => 'coverPath'
            ]) ?>
            <button type="button" class="layui-btn" id="uploadCover" style="vertical-align:top;">
                <i class="layui-icon">&#xe67c;</i>上传封面
            </button>
            <img width="200" id="cover" src="<? //= $model->link_logo ?>" height="80"
                 style="border:1px solid #ccc;margin-bottom:10px;margin-left:30px;vertical-align: middle;">

            <?= Html::error($model, 'cover', ['class' => 'error']) ?>
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('添加资源', [
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();
$url = Url::to(['upload', 'cName' => 'Share']);
$this->registerJs(\yii::$app->Prompt->jsString([
    'upload' => [
        'uploadBtn' => '#uploadCover',
        'url' => "{$url}",
        'field' => 'Share[file]',
        'coverPath' => '#coverPath',
        'cover' => '#cover',
        'successMsg' => '上传成功'
    ]
]));


?>