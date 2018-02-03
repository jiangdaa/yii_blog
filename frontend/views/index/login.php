<fieldset class="layui-elem-field layui-field-title">
    <legend>登陆</legend>
    <div class="layui-field-box" style="padding-top:30px;">
        <div class="layui-tab-item layui-show" style="width:100%;text-align:center;">
            <div class="layui-form layui-form-pane">
                <div>
                    <div class="layui-form-item">
                        <label for="L_email" class="layui-form-label">邮箱</label>
                        <div class="layui-input-block">
                            <input placeholder="请输入邮箱"
                                   name="email"
                                   lay-verify="email"
                                   autocomplete="off"
                                   class="layui-input"
                                   type="text">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label for="L_pass" class="layui-form-label">密码</label>
                        <div class="layui-input-block">
                            <input placeholder="请输入密码"
                                   name="password"
                                   lay-verify="password"
                                   autocomplete="off"
                                   class="layui-input"
                                   type="password">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" lay-filter="login" lay-submit="">立即登陆</button>
                    </div>
                    <div class="layui-form-item fly-form-app"><span>没有账号点击
                    <a style="color:blue; " href="<?= \yii\helpers\Url::to(['index/register']) ?>"><u>注册</u></a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</fieldset>

<?php
$this->registerJsFile('/frontend/js/login.js', ['depends' => 'yii\web\LayerfAsset']);
?>