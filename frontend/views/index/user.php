<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\helpers\Html;

$this->title = '个人信息';
?>
    <div class="blog-container" style="margin-top:90px;">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => '博客首页', 'url' => Url::to(['index/index'])],
            'tag' => 'blockquote',
            'itemTemplate' => "{link}",
            'links' => [
                [
                    'label' => '个人信息',
                    'url' => ['index/user'],
                    'template' => "{link}\n", //只用引用该类的模板,
                ]
            ],
            'options' => [ //设置 html 属性
                'class' => 'layui-elem-quote sitemap layui-breadcrumb shadow animated fadeInDown',
                'style' => 'margin-top:-70px;'
            ]
        ]) ?>
        <div class="blog-main" style="background:#fff;border-radius:5px;">
            <fieldset class="layui-elem-field layui-field-title">
                <legend>设置个人信息</legend>
                <div class="layui-field-box" style="padding:10px;">
                    <?= Html::beginForm('', 'post', [
                        'class' => 'layui-form',
                        'style' => 'margin-top:30px;'
                    ]) ?>

                    <div class="layui-form-item">
                        <label class="layui-form-label">昵称</label>
                        <div class="layui-input-block">
                            <?= Html::activeInput('text', $model, 'nick_name', [
                                'class' => 'layui-input',
                                'lay-verify' => 'required',
                                'placeholder' => '请输入昵称',
                                'autocomplete' => 'off',
                            ]) ?>

                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"> 头像</label>
                        <div class="layui-input-block">
                            <button type="button" class="layui-btn" id="userPortrait" style="vertical-align:top;">
                                <i class="layui-icon">&#xe67c;</i>上传头像
                            </button>
                            <img width="200" id="previewImg" src="<?= $model->portrait ?>" height="200"
                                 style="border:1px solid #ccc;margin-bottom:10px;margin-left:30px;" alt="头像">
                            <?= Html::activeInput('hidden', $model, 'portrait', [
                                'id' => 'portrait'
                            ]) ?>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <?= Html::submitButton('修改个人信息', [
                                'class' => 'layui-btn'
                            ]) ?>
                        </div>
                    </div>
                    <?= Html::endForm() ?>
                </div>
            </fieldset>

        </div>
    </div>
<?php
$url = Url::to(['upload', 'cName' => 'User']);
$this->registerJs(\yii::$app->Prompt->jsString([
    'upload' => [
        'uploadBtn' => '#userPortrait',
        'url' => "{$url}",
        'field' => 'User[file]',
        'coverPath' => '#portrait',
        'cover' => '#previewImg',
        'successMsg' => '上传成功'
    ]
]));
?>