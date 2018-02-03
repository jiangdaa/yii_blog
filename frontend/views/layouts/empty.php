<?php


use frontend\assets\EmptyAsset;

EmptyAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; Charset=gb2312">
        <meta http-equiv="Content-Language" content="zh-CN">
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div style="padding:15px">
        <?= $content ?>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>