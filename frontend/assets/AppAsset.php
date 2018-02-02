<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/frontend/css/global.css',
        '/frontend/font-awesome/css/font-awesome.min.css',
        '/frontend/css/animate.min.css',
        '/frontend/background/rain/css/reset.min.css',
        '/frontend/background/rain/css/style.css',

    ];
    public $js = [
        '/frontend/js/global.js',
        '/frontend/background/rain/js/dat.gui.min.js',
        '/frontend/background/rain/js/index.js'

    ];
    public $depends = [
        'yii\web\LayerfAsset'
    ];
}
