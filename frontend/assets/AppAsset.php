<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * -------------------------------------------
 *
 * Class AppAsset 前端资源管理
 * @package common\components
 *
 * -------------------------------------------
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/frontend/css/global.css',
        '/frontend/plugins/font-awesome/css/font-awesome.min.css',
        '/frontend/css/animate.min.css',
        '/frontend/plugins/rain/css/reset.min.css',
        '/frontend/plugins/rain/css/style.css',

    ];
    public $js = [
        '/frontend/js/global.js',
        '/frontend/plugins/rain/js/dat.gui.min.js',
        '/frontend/plugins/rain/js/index.js'

    ];
    public $depends = [
        'yii\web\LayerfAsset'
    ];
}
