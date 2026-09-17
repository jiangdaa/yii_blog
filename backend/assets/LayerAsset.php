<?php

namespace yii\web;

/**
 * LayerAsset 加载后台 layui 前端框架资源
 * 通过 common/config/bootstrap.php 中的 Yii::$classMap 注册，
 * 保持与 backend/assets/AppAsset.php 中 'yii\web\LayerAsset' 的引用一致。
 */
class LayerAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/backend/plugins/layui/css/layui.css',
        '/backend/plugins/font-awesome/css/font-awesome.min.css',
        '/backend/css/main.css',
    ];
    public $js = [
        '/backend/plugins/layui/layui.js',
    ];
    public $depends = [];
}
