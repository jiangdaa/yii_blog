<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

// yii\web\LayerfAsset 与 yii\web\LayerAsset 在视图/AssetBundle 中被引用，但仓库里缺少类定义
Yii::$classMap['yii\web\LayerfAsset'] = dirname(dirname(__DIR__)) . '/frontend/assets/LayerfAsset.php';
Yii::$classMap['yii\web\LayerAsset'] = dirname(dirname(__DIR__)) . '/backend/assets/LayerAsset.php';
