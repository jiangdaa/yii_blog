<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\widgets\ueditor\Ueditor;

?>

<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">网站标题</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'site_name', [
                'placeholder' => '网站标题',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'site_name', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">关键字</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'keyword', [
                'placeholder' => '关键字',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'keyword', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">网站logo</label>
        <div class="layui-input-block">
            <?= Html::activeInput('hidden', $model, 'logo', [
                'placeholder' => '网站Logo',
                'class' => 'layui-input',
                'id' => 'coverPath'
            ]) ?>
            <button type="button" class="layui-btn" id="uploadLogo" style="vertical-align:top;">
                <i class="layui-icon">&#xe67c;</i>上传logo
            </button>
            <img width="200" id="logo" src="<?= $model->logo ?>" height="80"
                 style="border:1px solid #ccc;margin-bottom:10px;margin-left:30px;vertical-align: middle;" alt="logo">

            <?= Html::error($model, 'logo', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">网站版权</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'copyright', [
                'placeholder' => 'copyright',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'copyright', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">网站备案</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'icp', [
                'placeholder' => '网站备案',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'icp', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">标题后缀</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'title_suffix', [
                'placeholder' => '标题后缀',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'title_suffix', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">网站描述</label>
        <div class="layui-input-block">
            <?= Ueditor::widget(['model' => $model, 'attribute' => 'site_intro', 'options' => ['initialFrameWidth' => '100%',]]) ?>


            <?= Html::error($model, 'site_intro', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('修改网站信息', [
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();
$url = Url::to(['upload','cName'=>'SiteConfig']);
$this->registerJs(\yii::$app->Prompt->jsString([
    'upload' => [
        'uploadBtn' => '#uploadLogo',
        'url' => "{$url}",
        'field' => 'SiteConfig[file]',
        'coverPath' => '#coverPath',
        'cover' => '#logo',
        'successMsg' => '上传成功'
    ]
]));


?>