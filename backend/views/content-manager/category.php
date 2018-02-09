<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->registerJs(\yii::$app->Prompt->jsString());
?>

<blockquote class="layui-elem-quote layui-quote-nm">
    <?= Html::beginForm('', '', [
        'class' => 'layer-form',
    ]) ?>

    <div class="layui-form-item">
        <label class="layui-form-label"> 分类名称</label>
        <div class="layui-input-inline" style="width: 300px;">
            <?= Html::activeInput('text', $model, 'name', [
                'class' => 'layui-input'
            ]) ?>
            <?= Html::error($model, 'name', ['class' => 'error']) ?>
        </div>
        <div class="layui-input-inline" style="width: 300px; line-height:40px;">

            <?= Html::activeRadioList($model, 'type', ['category' => '文章分类', 'share' => '资源分类']) ?>

        </div>
        <div class="layui-input-inline" style="width: 100px;">
            <?= Html::submitButton('添加分类', [
                'class' => 'layui-btn'
            ]) ?>
        </div>

    </div>
    <?= Html::endForm() ?>

</blockquote>
<table class="layui-table">
    <thead>
    <tr>
        <th>id</th>
        <th>分类名称</th>
        <th>分类类型</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($categorys as $category) : ?>
        <tr>
            <td><?= $category->id ?></td>
            <td><?= $category->name ?></td>
            <td><?= $category->type === 'category' ? '文章分类' : '资源分类' ?></td>
            <td><a href="<?= Url::to(['delete-category', 'cid' => $category->id]) ?>">删除</a></td>
        </tr>

    <?php endforeach ?>

    </tbody>

</table>



