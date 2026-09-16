<?php
Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');

// yii\web\LayerfAsset 在视图中被引用，但仓库里缺少该类定义
Yii::$classMap['yii\web\LayerfAsset'] = dirname(dirname(__DIR__)) . '/frontend/assets/LayerfAsset.php';
