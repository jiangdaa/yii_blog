<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class EmptyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [


    ];
    public $js = [


    ];
    public $depends = [
        'yii\web\LayerfAsset'
    ];
}
