<?php

use yii\helpers\Url;

?>

    <fieldset class="layui-elem-field layui-field-title">
        <legend>账号注册</legend>
        <div class="layui-field-box" style="padding-top:30px;">
            <div class=" layui-tab-item layui-show" style="width:100%;text-align:center;">
                <div class="layui-form layui-form-pane">
                    <div>
                        <div class="layui-form-item">
                            <label for="L_email" class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input placeholder="请输入注册邮箱"
                                       name="email"
                                       required=""
                                       lay-verify="email"
                                       autocomplete="off"
                                       class="layui-input"
                                       type="text">
                            </div>
                            <div class="layui-inline">
                                <label class="layui-form-label" style="display:none;"></label>
                                <div class="layui-input-inline" style="width:auto;">
                                    <button class="layui-btn" id="sendCheckCode">发送验证码</button>
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_username" class="layui-form-label">昵称</label>
                            <div class="layui-input-block">
                                <input placeholder="请输入昵称"
                                       name="nick_name"
                                       lay-verify="required"
                                       autocomplete="off"
                                       class="layui-input"
                                       type="text">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_pass" class="layui-form-label">密码</label>
                            <div class="layui-input-block">
                                <input value=""
                                       placeholder="请输入密码"
                                       name="password"
                                       lay-verify="password"
                                       autocomplete="off"
                                       class="layui-input"
                                       type="password">
                            </div>

                        </div>
                        <div class="layui-form-item">
                            <label for="L_repass" class="layui-form-label">确认密码</label>
                            <div class="layui-input-block">
                                <input value=""
                                       placeholder="请输入确认密码"
                                       name="repassword"
                                       lay-verify="repassword"
                                       autocomplete="off"
                                       class="layui-input"
                                       type="password">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_vercode" class="layui-form-label">邮箱验证</label>
                            <div class="layui-input-block">
                                <input name="check_code"
                                       lay-verify="emialcode"
                                       placeholder="邮箱验证"
                                       autocomplete="off"
                                       class="layui-input"
                                       type="text">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn" id="fastRegister" lay-filter="register" lay-submit="">立即注册</button>
                        </div>
                        <div class="layui-form-item fly-form-app"><span>或者直接使用社交账号快捷注册</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

<?php
$check_code_url = Url::to(['request/send-check-code']);
$this->registerJs("
var url = {checkCodeUrl:'{$check_code_url}'};
");
$this->registerJsFile('/frontend/js/register.js', ['depends' => 'yii\web\LayerfAsset']);
?>