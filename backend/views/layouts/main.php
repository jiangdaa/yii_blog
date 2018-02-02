<?php

use backend\assets\AppAsset;
use yii\helpers\Html;
$gather = \yii::$app->Gather;

AppAsset::register($this);
$this->registerCss($gather->pager('css'));
$this->registerCss("
    .error{
        color:red;
    }
");
$this->registerJs(yii::$app->Prompt->jsString());
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div style="padding:5px">
    <?= $content ?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
