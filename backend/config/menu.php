<?php
use yii;
return [
    'options' => [
        'class' => 'layui-nav layui-nav-tree',
        'lay-filter' => 'leftnav'
    ],
    'itemOptions' => [
        'class' => 'layui-nav-item'
    ],
    'encodeLabels' => false,
    'linkTemplate' => '<a href="#" data-url="{url}" data-id="{id}">{label}</a>',
    'submenuTemplate' => '<ul class="layui-nav-child">{items}</ul>',
    'labelTemplate' => '<a href="javascript:;">{label}</a>',
    'items' => [
        ['label' => '<i class="fa fa-file-text"></i>首页', 'url' => ['javascript:;']],
        ['label' => '<i class="fa fa-file-text"></i>内容管理', 'url' => ['javascript:;'], 'items' => [
            ['label' => '文章管理', 'url' => ['content-manager/article'], 'visible' => yii::$app->user->can('content-manager/article')],
            ['label' => '资源管理', 'url' => ['content-manager/share'], 'visible' => yii::$app->user->can('content-manager/share')],
            ['label' => '时光轴管理', 'url' => ['content-manager/timeline'], 'visible' => yii::$app->user->can('content-manager/timeline')],
            ['label' => '文章回收站', 'url' => ['content-manager/recycle'], 'visible' => yii::$app->user->can('content-manager/recycle')],
        ]],
        ['label' => '<i class="fa fa-file-text"></i>用户管理', 'url' => ['javascript:;'], 'items' => [
            ['label' => '后台用户管理', 'url' => ['admin/member-manager'], 'visible' => yii::$app->user->can('admin/member-manager')],
        ]],
        ['label' => '<i class="fa fa-file-text"></i>权限管理', 'url' => ['javascript:;'], 'items' => [
            ['label' => '添加角色', 'url' => ['permissions-manager/add-role'], 'visible' => yii::$app->user->can('permissions-manager/add-role')],
            ['label' => '角色列表', 'url' => ['permissions-manager/role-list'], 'visible' => yii::$app->user->can('permissions-manager/role-list')],
            ['label' => '添加规则', 'url' => ['permissions-manager/add-rule'], 'visible' => yii::$app->user->can('permissions-manager/add-rule')],
            ['label' => '菜单配置', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
        ]],
        ['label' => '<i class="fa fa-file-text"></i>扩展管理', 'url' => ['javascript:;'], 'items' => [
            ['label' => '友情链接', 'url' => ['permissions-manager/add-role'], 'visible' => yii::$app->user->can('permissions-manager/add-role')],
            ['label' => '博主信息', 'url' => ['permissions-manager/role-list'], 'visible' => yii::$app->user->can('permissions-manager/role-list')],
            ['label' => '网站信息', 'url' => ['permissions-manager/add-rule'], 'visible' => yii::$app->user->can('permissions-manager/add-rule')],
            ['label' => '留言管理', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
            ['label' => '网站公告', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
            ['label' => '更新日志', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
        ]],
        ['label' => '<i class="fa fa-file-text"></i>系统配置', 'url' => ['javascript:;'], 'items' => [
            ['label' => 'SEO配置', 'url' => ['permissions-manager/add-role'], 'visible' => yii::$app->user->can('permissions-manager/add-role')],
            ['label' => 'QQ互联', 'url' => ['permissions-manager/role-list'], 'visible' => yii::$app->user->can('permissions-manager/role-list')],
            ['label' => '数据库配置', 'url' => ['permissions-manager/add-rule'], 'visible' => yii::$app->user->can('permissions-manager/add-rule')],
            ['label' => '站点地图', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
            ['label' => '操作日志', 'url' => ['permissions-manager/menu'], 'visible' => yii::$app->user->can('permissions-manager/menu')],
        ]],
        ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
    ],
];
