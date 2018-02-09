<?php

use yii\helpers\Url;
use \yii\widgets\Menu;

function can($permission)
{
    if (\yii::$app->user->identity->id == 1) {
        return true;
    }
    return \yii::$app->user->can($permission);
}

?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"/>
    <title>yii2_blog后台管理系统 - Design By Jd</title>
    <!-- layui.css -->
    <link href="/backend/plugins/layui/css/layui.css" rel="stylesheet"/>
    <!-- font-awesome.css -->
    <link href="/backend/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- animate.css -->
    <link href="/backend/plugins/animate.min.css" rel="stylesheet"/>
    <!-- 本页样式 -->
    <link href="/backend/css/main.css" rel="stylesheet"/>
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--顶部-->
    <div class="layui-header">
        <div class="ht-console">
            <div class="ht-user">
                <img src="<?= yii::$app->params['defaultHeadImg'] ?>"/>
                <a class="ht-user-name">超级管理员</a>
            </div>
        </div>
        <span class="sys-title">yii2_blog后台管理系统 - Design By Jd</span>
        <ul class="ht-nav">
            <li class="ht-nav-item">
                <a href="<?= \yii::$app->params['frontendUrl'] ?>">前台入口</a>
            </li>
            <li class="ht-nav-item">
                <a href="javascript:;" id="individuation"><i class="fa fa-tasks fa-fw" style="padding-right:5px;"></i>个性化</a>
            </li>
            <li class="ht-nav-item">
                <a href="<?= Url::to(['logout']) ?>"><i class="fa fa-power-off fa-fw"></i>注销</a>
            </li>
        </ul>
    </div>
    <!--侧边导航-->
    <div class="layui-side">
        <div class="layui-side-scroll">
            <?php
            echo Menu::widget([
                'options' => [
                    'class' => 'layui-nav layui-nav-tree',
                    'lay-filter' => 'leftnav'
                ],
                'itemOptions' => [
                    'class' => 'layui-nav-item'
                ],
                'encodeLabels' => false,
                'linkTemplate' => '<a href="#" data-url="{url}" data-id="{id}" >{label}</a>',
                'submenuTemplate' => '<ul class="layui-nav-child">{items}</ul>',
                'labelTemplate' => '<a href="javascript:;">{label}</a>',
                'items' => [
                    ['label' => '<i class="fa fa-file-text"></i>首页', 'url' => ['javascript:;']],
                    ['label' => '<i class="fa fa-file-text"></i>内容管理', 'url' => ['javascript:;'], 'items' => [
                        ['label' => '文章管理', 'url' => ['content-manager/article'], 'visible' => can('content-manager/article')],
                        ['label' => '分类管理', 'url' => ['content-manager/category'], 'visible' => can('content-manager/category')],
                        ['label' => '资源管理', 'url' => ['content-manager/share'], 'visible' => can('content-manager/share')],
                        ['label' => '时光轴管理', 'url' => ['content-manager/timeline'], 'visible' => can('content-manager/timeline')],
                        ['label' => '文章回收站', 'url' => ['content-manager/recycle'], 'visible' => can('content-manager/recycle')],
                    ]],
                    ['label' => '<i class="fa fa-file-text"></i>用户管理', 'url' => ['javascript:;'], 'items' => [
                        ['label' => '前台用户管理', 'url' => ['consumer-manager/frontend-consumer'], 'visible' => can('consumer-manager/frontend-consumer')],
                    ]],
                    ['label' => '<i class="fa fa-file-text"></i>权限管理', 'url' => ['javascript:;'], 'items' => [
                        ['label' => '添加角色', 'url' => ['permissions-manager/add-role'], 'visible' => can('permissions-manager/add-role')],
                        ['label' => '角色列表', 'url' => ['permissions-manager/role-list'], 'visible' => can('permissions-manager/role-list')],
                        ['label' => '添加规则', 'url' => ['permissions-manager/add-rule'], 'visible' => can('permissions-manager/add-rule')],
                        ['label' => '菜单配置', 'url' => ['permissions-manager/menu'], 'visible' => can('permissions-manager/menu')],
                    ]],
                    ['label' => '<i class="fa fa-file-text"></i>扩展管理', 'url' => ['javascript:;'], 'items' => [
                        ['label' => '友情链接', 'url' => ['extension/link'], 'visible' => can('extension/link')],
                        ['label' => '博主信息', 'url' => ['extension/blogger-info'], 'visible' => can('extension/blogger-info')],
                        ['label' => '网站信息', 'url' => ['extension/site-config'], 'visible' => can('extension/site-config')],
                        ['label' => '留言管理', 'url' => ['extension/leave-msg'], 'visible' => can('extension/leave-msg')],
                        ['label' => '网站公告', 'url' => ['extension/announcement'], 'visible' => can('extension/announcement')]
                    ]],
                    ['label' => '<i class="fa fa-file-text"></i>系统配置', 'url' => ['javascript:;'], 'items' => [
                        ['label' => 'QQ互联', 'url' => ['permissions-manager/role-list'], 'visible' => can('permissions-manager/role-list')],
                        ['label' => '数据库配置', 'url' => ['permissions-manager/add-rule'], 'visible' => can('permissions-manager/add-rule')],
                        ['label' => '操作日志', 'url' => ['system/log'], 'visible' => can('system/log')],
                    ]],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]);
            ?>
        </div>
    </div>
    <!--收起导航-->
    <div class="layui-side-hide layui-bg-cyan">
        <i class="fa fa-long-arrow-left fa-fw"></i>收起导航
    </div>
    <!--主体内容-->
    <div class="layui-body">
        <div style="margin:0;position:absolute;top:4px;bottom:0px;width:100%;" class="layui-tab layui-tab-brief"
             lay-filter="tab" lay-allowclose="true">
            <ul class="layui-tab-title">
                <li lay-id="0" class="layui-this">首页</li>
            </ul>
            <div class="layui-tab-content">
                <div class="layui-tab-item layui-show">
                    <p style="padding: 10px 15px; margin-bottom: 20px; margin-top: 10px; border:1px solid #ddd;display:inline-block;">
                        上次登陆
                        <span style="padding-left:1em;">IP：192.168.1.101</span>
                        <span style="padding-left:1em;">地点：四川成都</span>
                        <span style="padding-left:1em;">时间：2017-3-26 14：12</span>
                    </p>
                    <fieldset class="layui-elem-field layui-field-title">
                        <legend>统计信息</legend>
                        <div class="layui-field-box">
                            <div style="display: inline-block; width: 100%;">
                                <div class="ht-box layui-bg-blue">
                                    <p><?= $total['userCount'] ?></p>
                                    <p>用户总数</p>
                                </div>
                                <div class="ht-box layui-bg-red">
                                    <p><?= $total['todayRegCount'] ?></p>
                                    <p>今日注册</p>
                                </div>
                                <div class="ht-box layui-bg-green">
                                    <p><?= $total['todayLoginCount'] ?></p>
                                    <p>今日登陆</p>
                                </div>
                                <div class="ht-box layui-bg-orange">
                                    <p><?= $total['articleCount'] ?></p>
                                    <p>文章总数</p>
                                </div>
                                <div class="ht-box layui-bg-cyan">
                                    <p><?= $total['shareCount'] ?></p>
                                    <p>资源总数</p>
                                </div>
                                <div class="ht-box layui-bg-black">
                                    <p><?= $total['todayLeaveMsgCount'] ?></p>
                                    <p>今日留言</p>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <!--底部信息-->
    <div class="layui-footer">
        <p style="line-height:44px;text-align:center;">yii2_blog后台管理系统 - Design By Jd</p>
    </div>
    <!--快捷菜单-->
    <div class="short-menu" style="display:none">
        <fieldset class="layui-elem-field layui-field-title">
            <legend style="color:#fff;padding-top:10px;padding-bottom:10px;">快捷菜单</legend>
            <div class="layui-field-box">
                <div style="width:832px;margin:0 auto;">
                    <div class="windows-tile windows-two">
                        <i class="fa fa-file-text"></i>
                        <span data-url="datalist.html" data-id="1">文章管理</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-volume-up"></i>
                        <span data-url="datalist.html" data-id="2">网站公告</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-comments-o"></i>
                        <span data-url="datalist.html" data-id="3">留言管理</span>
                    </div>
                    <div class="windows-tile windows-two">
                        <i class="fa fa-handshake-o"></i>
                        <span data-url="datalist.html" data-id="4">友情链接</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-arrow-circle-right"></i>
                        <span data-url="datalist.html" data-id="5">更新日志</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-wrench"></i>
                        <span data-url="datalist.html" data-id="6">操作日志</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-tags"></i>
                        <span data-url="datalist.html" data-id="7">资源管理</span>
                    </div>
                    <div class="windows-tile windows-one">
                        <i class="fa fa-pencil-square-o"></i>
                        <span data-url="datalist.html" data-id="8">笔记管理</span>
                    </div>
                    <div class="windows-tile windows-two">
                        <i class="fa fa-hourglass-half"></i>
                        <span data-url="datalist.html" data-id="9">时光轴管理</span>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </div>
        </fieldset>

    </div>
    <!--个性化设置-->
    <div class="individuation animated flipOutY layui-hide">
        <ul>
            <li><i class="fa fa-cog" style="padding-right:5px"></i>个性化</li>
        </ul>
        <div class="explain">
            <small>从这里进行系统设置和主题预览</small>
        </div>
        <div class="setting-title">设置</div>
        <div class="setting-item layui-form">
            <span>侧边导航</span>
            <input type="checkbox" lay-skin="switch" lay-filter="sidenav" lay-text="ON|OFF" checked>
        </div>
        <div class="setting-item layui-form">
            <span>管家提醒</span>
            <input type="checkbox" lay-skin="switch" lay-filter="steward" lay-text="ON|OFF" checked>
        </div>
        <div class="setting-title">主题</div>
        <div class="setting-item skin skin-default" data-skin="skin-default">
            <span>低调优雅</span>
        </div>
        <div class="setting-item skin skin-deepblue" data-skin="skin-deepblue">
            <span>蓝色梦幻</span>
        </div>
        <div class="setting-item skin skin-pink" data-skin="skin-pink">
            <span>姹紫嫣红</span>
        </div>
        <div class="setting-item skin skin-green" data-skin="skin-green">
            <span>一碧千里</span>
        </div>
    </div>
</div>
<!-- layui.js -->
<script src="/backend/plugins/layui/layui.js"></script>
<!-- layui规范化用法 -->
<script type="text/javascript">
    layui.config({
        base: '/backend/js/'
    }).use('main');
</script>
</body>
</html>