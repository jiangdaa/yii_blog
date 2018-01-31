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
            <label class="layui-form-label"> 管理员</label>
            <div class="layui-input-block">
                <?php
                echo Html::Input('text', 'description', Html::decode($admin->adminname), [
                    'class' => 'layui-input'
                ]);
                ?>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">角色</label>
            <div class="layui-input-block">
                <?php
                echo Html::checkboxList('children', $children['roles'], $roles, [
                    'lay-skin' => 'primary'
                ]);
                ?>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">权限</label>
            <div class="layui-input-block">
                <?php
                echo Html::checkboxList('children', $children['permissions'], $permissions, [
                    'class' => 'aaa'
                ]);
                ?>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label"></label>
            <div class="layui-input-block">
                <?php
                echo Html::submitButton('分配权限', [
                    'class' => 'layui-btn',
                ]);
                ?>
            </div>
        </div>
        <?php
        echo Html::endForm();
        ?>
    </div>
<?php
$js = "



";
$css = "
    .layui-form input[type=checkbox]{
        display:inline-block;
    }
";
$this->registerJs($js);
$this->registerCss($css);

?>