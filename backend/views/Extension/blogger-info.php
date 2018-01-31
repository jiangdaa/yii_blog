<?php

use yii\helpers\Html;

$gather = \yii::$app->Gather;
?>

<?php
echo Html::beginForm('', 'post', [
    'class' => 'layer-form',
    'style' => 'width:70%;margin:0 auto;'
])
?>
    <div class="layui-form-item">
        <label class="layui-form-label">博主名称</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'blogger_name', [
                'placeholder' => '博主名称',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'blogger_name', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">博主签名</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'blogger_signature', [
                'placeholder' => '博主签名',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'blogger_signature', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">博主地址</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'blogger_address', [
                'placeholder' => '博主签名',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'blogger_address', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'email', [
                'placeholder' => '博主邮箱',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'email', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'qq', [
                'placeholder' => 'QQ',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'email', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">微博</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'weibo', [
                'placeholder' => '微博',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'email', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">github</label>
        <div class="layui-input-block">
            <?= Html::activeInput('text', $model, 'github', [
                'placeholder' => 'github',
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'github', ['class' => 'error']) ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?= Html::submitButton('编辑信息', [
                'class' => 'layui-btn'
            ]) ?>
        </div>
    </div>
<?php
echo Html::endForm();
$this->registerCss($gather->pager('css'));
$this->registerCss("
    .error{
        color:red;
    }
");
$this->registerJs(yii::$app->Prompt->jsString());

?>