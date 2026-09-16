<?php

namespace yii\web;

/**
 * LayerfAsset 加载 layui 前端框架资源
 * 通过 common/config/bootstrap.php 中的 Yii::$classMap 注册，
 * 保持与视图里 'yii\web\LayerfAsset' 的引用一致。
 */
class LayerfAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/frontend/plugins/layui/css/layui.css',
    ];
    public $js = [
        '/frontend/plugins/layui/layui.all.js',
    ];
    public $depends = [];
}
