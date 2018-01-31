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
        '/frontend/font-awesome/css/font-awesome.min.css'
    ];
    public $js = [
        '/frontend/js/global.js',

    ];
    public $depends = [
        'yii\web\LayerfAsset'
    ];
}
