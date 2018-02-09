<?php

namespace frontend\assets;

use yii\web\AssetBundle;


/**
 * -------------------------------------------
 *
 * Class EmptyAsset 空模版资源管理
 * @package common\components
 *
 * -------------------------------------------
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
