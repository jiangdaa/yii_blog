<?php
    use yii\helpers\Html;
?>
<div style="width=80%;">
    <?php
    echo Html::beginForm('', 'post', [
        'class' => 'layui-form'
    ]);
    ?>
    <div class="layui-form-item">
        <label class="layui-form-label"> 角色名称</label>
        <div class="layui-input-block">
            <?php
            echo Html::Input('text', 'description', '', [
                'class' => 'layui-input'
            ]);
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-block">
            <?php
            echo Html::Input('text', 'name', '', [
                'class' => 'layui-input'
            ]);
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">规则名称</label>
        <div class="layui-input-block">
            <?php
            echo Html::Input('text', 'rule_name', '', [
                'class' => 'layui-input'
            ]);
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">角色名称</label>
        <div class="layui-input-block">
            <?php
            echo Html::Input('text', 'data', '', [
                'class' => 'layui-input'
            ]);
            ?>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <?php
            echo Html::submitButton('添加角色', [
                'class' => 'layui-btn'
            ]);
            ?>
        </div>
    </div>
    <?php
    echo Html::endForm();
    ?>
</div>
