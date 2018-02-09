<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\ueditor\Ueditor;
use kartik\file\FileInput;

?>
    <blockquote class="layui-elem-quote layui-quote-nm">
        <a class="layui-btn" href="<?= Url::to('article') ?>">返回</a>
    </blockquote>
<?= Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
]); ?>
    <div class="layui-form-item">
        <label class="layui-form-label"> 文章标题</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'title', [
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'title', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 文章分类</label>
        <div class="layui-input-block">
            <?= Html::activeDropDownList($model, 'category', $categoryList, [
                'style' => 'height: 28px;margin-top: 4px;'
            ]) ?>
            <?= Html::error($model, 'category', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 文章置顶</label>
        <div class="layui-input-block">
            <?= Html::activeRadioList($model, 'stick', ['0' => '不置顶', '1' => '置顶'], ['style' => 'line-height:38px']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 是否推荐</label>
        <div class="layui-input-block">
            <?= Html::activeRadioList($model, 'recommend', ['0' => '不推荐', '1' => '推荐'], ['style' => 'line-height:38px']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 是否审核</label>
        <div class="layui-input-block">
            <?= Html::activeRadioList($model, 'state', ['0' => '未审核', '1' => '已审核'], ['style' => 'line-height:38px']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 浏览量</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'count', [
                'class' => 'layui-input',
                'value' => 0
            ]) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 点赞量</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'praise', [
                'class' => 'layui-input',
                'value' => 0
            ]) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 文章封面</label>
        <div class="layui-input-block">
            <button type="button" class="layui-btn" id="uploadCover" style="vertical-align:top;">
                <i class="layui-icon">&#xe67c;</i>上传封面
            </button>
            <img width="200" id="previewImg"
                 src="<?= $model->cover ? $model->cover : yii::$app->params['defaultCover'] ?>" height="200"
                 style="border:1px solid #ccc;margin-bottom:10px;margin-left:30px;" alt="文章封面">
            <?= Html::activeInput('hidden', $model, 'cover', [
                'id' => 'coverPath'
            ]) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 文章内容</label>
        <div class="layui-input-block">
            <?= Ueditor::widget(['model' => $model, 'attribute' => 'content', 'options' => ['initialFrameWidth' => '100%',]]) ?>
        </div>

    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> </label>
        <div class="layui-input-block">
            <?= Html::submitButton($submitBtnVal, [
                'class' => 'layui-btn'
            ]) ?>

        </div>
    </div>
<?= Html::endForm(); ?>

<?php
$url = Url::to(['content-manager/upload', 'cName' => 'Article']);
$info = yii::$app->session->hasFlash('info');

$prompt = \yii::$app->Prompt->jsString([
    'upload' => [
        'uploadBtn' => '#uploadCover',
        'url' => "{$url}",
        'field' => 'Article[file]',
        'coverPath' => '#coverPath',
        'cover' => '#previewImg',
        'successMsg' => '上传成功'
    ]
]);


$this->registerJs($prompt);

?>