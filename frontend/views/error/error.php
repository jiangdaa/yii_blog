<?php

use yii\helpers\Url;
use yii\helpers\Html;
$this->title = $name;
?>

<!DOCTYPE html>

<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312"/>
    <meta name="viewport" content="width=device-width"/>
    <title>嗨呀…您访问的页面不存在</title>
    <link href="/frontend/plugins/layui/css/layui.css" rel="stylesheet"/>
    <link href="/frontend/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <style>
        body {
            text-align: center;
        }

        .statuscode {
            margin-top: 18vh;
            font-size: 100px;
            color: #009688;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 20px;
            color: #393D49;
        }

        h3, h4 {
            margin: 20px 0;
        }

        h3 {
            font-size: 16px;
        }

        h3 a {
            padding: 10px 20px;
        }

    </style>
</head>
<body>
<div class="statuscode">
    404
</div>
<h1><?= Html::encode($this->title) ?></h1>

<div class="alert alert-danger">
    <?= nl2br(Html::encode($message)) ?>
</div>
<h2>嗨呀…您访问的页面不存在</h2>
<h3>
    <a href="javascript:history.back(-1);"><i class="fa fa-arrow-circle-left fa-fw"></i>返回</a>
    <a href="<?= Url::home() ?>"><i class="fa fa-home fa-fw"></i>博客首页</a>
</h3>

<h4><a href="#" style="color: #009688; font-weight: bold;">系统</a>&nbsp;提醒您 - 您可能输入了错误的网址，或者该网页已删除或移动</h4>
</body>
</html>
