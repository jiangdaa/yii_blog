<?php

use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['login/captcha', 'refresh' => '']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <title>不落阁后台管理系统</title>
    <link rel="shortcut icon" href="/backend/images/Logo_40.png" type="image/x-icon">
    <!-- layui.css -->
    <link href="/backend/plugins/layui/css/layui.css" rel="stylesheet"/>
    <!-- 本页样式 -->
    <link href="/backend/css/index.css" rel="stylesheet"/>
</head>
<body>
<div class="mask"></div>
<div class="main">
    <h1><span style="font-size: 84px;">B</span><span style="font-size:30px;">log</span></h1>
    <p id="time"></p>
    <div id="login-box">
        <?= Html::beginForm('', 'post', [
            'class' => 'layui-form'
        ]) ?>
        <div class="layui-form-item">
            <label class="layui-form-label">账号</label>
            <div class="layui-input-inline pm-login-input">
                <?= Html::activeInput('text', $model, 'loginuser', [
                    'placeholder' => '请输入账号',
                    'autocomplete' => 'off',
                    'class' => 'layui-input'
                ]) ?>
                <?= Html::error($model,'loginuser')?>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">密码</label>
            <div class="layui-input-inline pm-login-input">
                <?= Html::activeInput('password', $model, 'adminpassword', [
                    'placeholder' => '请输入密码',
                    'autocomplete' => 'off',
                    'class' => 'layui-input'
                ]) ?>
                <?= Html::error($model,'adminpassword')?>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">验证码</label>
            <div class="layui-input-inline pm-login-input">
                <?= \yii\captcha\Captcha::widget([
                    'model' => $model, //Model
                    'attribute' => 'verifyCode', //字段
                    'captchaAction' => 'login/captcha', //验证码的 action 与 Model 是对应的
                    'template' => '{input}{image}', //模板 , 可以自定义
                    'options' => [
                        'class' => 'layui-input',
                        'id' => 'verifyCode',
                        "placeholder" => "请输入验证码",
                        'style' => 'width:60%'
                    ],
                    'imageOptions' => [
                        'id' => 'imagecode',
                        'alt' => '点击图片刷新',
                        'style' => 'float:right;margin-top:-39px;cursor:pointer',
                    ]
                ]);
                ?>
                <?= Html::error($model,'verifyCode')?>

            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">记住密码</label>
            <div class="layui-input-inline" style="text-align:left">
                <?= Html::activeInput('checkbox', $model, 'remember', [
                    'lay-skin' => 'switch',
                    'style' => 'float:left;margin-left:-0px',
                    'lay-text'=>'ON|OFF'
                ]) ?>
            </div>
        </div>
        <div class="layui-form-item" style="margin-top:25px;margin-bottom:0;">
            <div class="layui-input-block">
                <?= Html::submitButton('立即登录', [
                    'class' => 'layui-btn',
                    'style' => 'width:230px;'
                ]) ?>

            </div>
        </div>
        <?= Html::endForm() ?>
    </div>

</div>
<!-- layui.js -->
<script src="/backend/plugins/layui/layui.js"></script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    var url = '<?=$url?>';
    layui.config({
        base: '/backend/js/'
    }).use('index');
</script>
</body>
</html>