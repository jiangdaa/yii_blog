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
        <title><?= $this->title ?>-Yii2_Blog</title>
        <link rel="shortcut icon" href="../images/Logo_40.png" type="image/x-icon">
        <?php $this->head() ?>
        <link href="/frontend/css/home.css" rel="stylesheet"/>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <!-- 导航 -->
    <nav class="blog-nav layui-header">
        <div class="blog-container">
            <!-- QQ互联登陆 -->
            <a href="javascript:;" class="blog-user">
                <i class="fa fa-qq"></i>
            </a>
            <div class="" style=" width:20%;float:right;margin-right:5%;margin-top:15px;z-index:9999;">

                    <input type="password" style="width:70%; height:30px;float:left;" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">

                    <button class="layui-btn" style="width:30%;height:30px;">搜索</button>


            </div>
            <a href="<?= Url::home() ?>" class="blog-user layui-hide">
                <img src="#" alt="Absolutely" title="Absolutely"/>
            </a>
            <!-- 不落阁 -->
            <a class="blog-logo" href="<?= Url::to(['aaa']) ?>">Yii2_Blog</a>
            <!-- 导航菜单 -->
            <ul class="layui-nav" lay-filter="nav">
                <li class="layui-nav-item layui-this">
                    <a href="<?= Url::home() ?>"><i class="fa fa-home fa-fw"></i>&nbsp;博客首页</a>
                </li>
                <li class="layui-nav-item">
                    <a href="resource.html"><i class="fa fa-tags fa-fw"></i>&nbsp;工具分享</a>
                </li>

                <li class="layui-nav-item">
                    <a href="about.html"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
                </li>
            </ul>

            <!-- 手机和平板的导航开关 -->
            <a class="blog-navicon" href="javascript:;">
                <i class="fa fa-navicon"></i>
            </a>
        </div>
    </nav>
    <!-- 主体（一般只改变这里的内容） -->
    <div class="blog-body">
        <?= $content ?>
    </div>
    <!-- 底部 -->
    <footer class="blog-footer">
        <p><span>Copyright</span><span>&copy;</span><span>2017</span><a href="#">Yii2_Blog</a><span>Design By JD</span>
        </p>
        <p><a href="http://www.miibeian.gov.cn/" target="_blank">蜀ICP备16029915号-1</a></p>
    </footer>
    <!--侧边导航-->
    <ul class="layui-nav layui-nav-tree layui-nav-side blog-nav-left layui-hide" lay-filter="nav">
        <li class="layui-nav-item layui-this">
            <a href="home.html"><i class="fa fa-home fa-fw"></i>&nbsp;网站首页</a>
        </li>
        <li class="layui-nav-item">
            <a href="article.html"><i class="fa fa-file-text fa-fw"></i>&nbsp;文章专栏</a>
        </li>
        <li class="layui-nav-item">
            <a href="resource.html"><i class="fa fa-tags fa-fw"></i>&nbsp;资源分享</a>
        </li>
        <li class="layui-nav-item">
            <a href="timeline.html"><i class="fa fa-road fa-fw"></i>&nbsp;点点滴滴</a>
        </li>
        <li class="layui-nav-item">
            <a href="about.html"><i class="fa fa-info fa-fw"></i>&nbsp;关于本站</a>
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