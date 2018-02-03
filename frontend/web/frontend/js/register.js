layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    var timing = 2;
    $('#sendCheckCode').on('click', function () {
        var _this = $(this);
        $.post('/request/send-check-code.html', {
            emial: $('input[name=email]').val()
        }, function (res) {
            if (JSON.parse(res).error !== '-1') {
                var timer = setInterval(function () {
                    if (timing === 0) {
                        timing = 2;
                        _this.text('发送验证码');
                        _this.removeAttr('disabled').removeClass('layui-btn-disabled');
                        clearInterval(timer);
                    } else {
                        _this.text(timing-- + '重新发送');
                    }
                }, 1000);
                layer.msg(JSON.parse(res).msg);
                _this.attr('disabled', 'true').addClass('layui-btn-disabled');
            } else {


                layer.msg(JSON.parse(res).msg, {time: 5000, icon: 6});
            }
        });

    });

    //自定义验证规则
    form.verify({
        nickname: function (value) {
            if (value.length < 2 && value.length > 6) {
                return '昵称错误';
            }
        },
        password: [/(.+){6,12}$/, '密码必须6到12位'],
        repassword: function (value) {
            if ($('input[name=password]').val() !== value) {
                return '两次密码不一致';
            }
        },
        emialcode: function (value) {
            if (value.length !== 6) {
                return '邮箱验证码不正确';
            }
        }
    });

    //监听提交
    form.on('submit(register)', function (data) {
        $.post('/request/register.html', data.field, function (res) {
            if (JSON.parse(res).error === '0') {
                layer.msg(JSON.parse(res).msg, {
                    time: 3000, icon: 6, end: function () {
                        window.location.href = 'login.html';
                    }
                });
            }
            layer.msg(JSON.parse(res).msg, {time: 3000, icon: 6});
        });
        return false;
    });


});