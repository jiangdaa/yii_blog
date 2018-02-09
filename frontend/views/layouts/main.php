<?php

use yii\helpers\Url;
use frontend\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; Charset=gb2312">
    <meta http-equiv="Content-Language" content="zh-CN">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <title><?= $this->title ?><?= \yii::$app->params['siteConfig']['title_suffix'] ?></title>
    <?php $this->registerMetaTag(['name' => 'keyword', 'content' => \yii::$app->params['siteConfig']['keyword']]) ?>
    <?php $this->head() ?>
    <link href="/frontend/css/home.css" rel="stylesheet"/>
</head>
<body>
<?php $this->beginBody() ?>
<!-- canvas动态背景 -->
<canvas id="canvas">当前浏览器不支持canvas</canvas>
<!-- 头部菜单部分 -->
<nav class="blog-nav layui-header">
    <div class="blog-container">
        <?php
        if (!\yii::$app->user->isGuest): ?>
            <div id="userInfo">
                <div class="blog-user">
                    <a style="color:red;vertical-align:top;" href="<?= Url::to(['index/user-info']) ?>"
                       class="user-name">
                        <?= empty(\yii::$app->user->identity->nick_name) ? \yii::$app->user->identity->user_name : \yii::$app->user->identity->nick_name ?>
                    </a>
                    <img class="user-head-img" style="margin-top:10px;"
                         src="<?= \yii::$app->user->identity->portrait ?>"
                         alt="<?= empty(\yii::$app->user->identity->nick_name) ? \yii::$app->user->identity->user_name : \yii::$app->user->identity->nick_name ?>">
                    <script>
                        window.localStorage.setItem('uid',<?= \yii::$app->user->id ?>);
                    </script>
                </div>
                <div class="user-nav">
                    <ol>
                        <li><a href="<?= Url::to(['index/user']) ?>"> <i class="layui-icon">&#xe612;</i>用户信息</a>
                        </li>
                        <li><a href="<?= Url::to(['index/logout']) ?>"> <i class="layui-icon">&#xe65c;</i>退出</a></li>
                    </ol>
                </div>
            </div>
        <?php else : ?>
            <div id="unLogin">
                <a href="javascript:;" class="blog-user" style="color:#ccc;font-size:20px;">
                    <i class="fa fa-envelope-o fa-fw"></i>
                </a>
                <script>
                    window.localStorage.clear();
                </script>
            </div>
        <?php endif ?>
        <a href="<?= Url::home() ?>" class="blog-user layui-hide">
            <img src="<?= \yii::$app->params['siteConfig']['logo'] ?>"/>
        </a>
        <!-- 不落阁 -->
        <a class="blog-logo" href="<?= Url::to(['index/index']) ?>">
            <?php if (empty(\yii::$app->params['siteConfig']['logo'])): ?>
                <?= \yii::$app->params['siteConfig']['site_name'] ?>
            <?php else: ?>
                <img width="200" height="60" style="line-height:60px;vertical-align:middle;"
                     src="<?= \yii::$app->params['siteConfig']['logo'] ?>"/>
            <?php endif ?>
        </a>
        <!-- 导航菜单 -->
        <ul class="layui-nav" lay-filter="nav">
            <li class="layui-nav-item <?= Url::current() == Url::to(['index/index']) ? 'layui-this' : '' ?>">
                <a href="<?= Url::to(['index/index']) ?>"><i class="fa fa-home fa-fw"></i>&nbsp;博客首页</a>
            </li>
            <li class="layui-nav-item <?= strstr(Url::current(), 'articles') || strstr(Url::current(), 'category') || strstr(Url::current(), 'post') ? 'layui-this' : '' ?>">
                <a href="<?= Url::to(['index/articles']) ?>"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
            </li>
            <li class="layui-nav-item <?= Url::current() == Url::to(['index/share']) ? 'layui-this' : '' ?>">
                <a href="<?= Url::to(['index/share']) ?>"><i class="fa fa-tags fa-fw"></i>&nbsp;工具分享</a>
            </li>

            <li class="layui-nav-item <?= Url::current() == Url::to(['index/about']) ? 'layui-this' : '' ?>">
                <a href="<?= Url::to(['index/about']) ?>"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
            </li>
        </ul>
        <!-- 手机和平板的导航开关 -->
        <a class="blog-navicon" href="javascript:;">
            <i class="fa fa-navicon"></i>
        </a>
    </div>
</nav>
<!-- 主体（一般只改变这里的内容） -->
<div class="blog-body" style="padding-top:20px;">
    <?= $content ?>
</div>
<!-- 底部 -->
<footer class="blog-footer">
    <p><span><?= \yii::$app->params['siteConfig']['copyright'] ?></span>
    </p>
    <p><a href="http://www.miibeian.gov.cn/" target="_blank"><?= \yii::$app->params['siteConfig']['icp'] ?></a></p>
</footer>
<!--侧边导航-->
<ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
    <li class="layui-nav-item <?= Url::current() == Url::to(['index/index']) ? 'layui-this' : '' ?>">
        <a href="<?= Url::to(['index/index']) ?>"><i class="fa fa-home fa-fw"></i>&nbsp;博客首页</a>
    </li>
    <li class="layui-nav-item <?= Url::current() == Url::to(['index/articles']) ? 'layui-this' : '' ?>">
        <a href="<?= Url::to(['category/articles']) ?>"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
    </li>
    <li class="layui-nav-item <?= Url::current() == Url::to(['index/share']) ? 'layui-this' : '' ?>">
        <a href="<?= Url::to(['tool/share']) ?>"><i class="fa fa-tags fa-fw"></i>&nbsp;工具分享</a>
    </li>

    <li class="layui-nav-item <?= Url::current() == Url::to(['index/about']) ? 'layui-this' : '' ?>">
        <a href="<?= Url::to(['about/site']) ?>"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
    </li>
</ul>
<!--分享窗体-->
<div class="blog-share layui-hide">
    <div class="blog-share-body">
        <div style="width: 200px;height:100%;">
            <div class="bdsharebuttonbox">
                <a class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                <a class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                <a class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                <a class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a>
            </div>
        </div>
    </div>
</div>
<!--遮罩-->
<div class="blog-mask animated layui-hide"></div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

