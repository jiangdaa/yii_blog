layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;
    var timing = 60;

    //发送邮箱验证码
    $('#sendCheckCode').on('click', function () {
        var emial = $('input[name=email]').val();
        if (!checkEmail(emial)) {
            layer.msg('请输入正确格式的邮箱', {'icon': 2});
            return false;
        }
        var _this = $(this);
        var index = layer.load(1);
        $.post('/request/send-check-code.html', {
            emial: emial
        }, function (res) {
            if (JSON.parse(res).error === '0') {
                var timer = setInterval(function () {
                    if (timing === 0) {
                        timing = 60;
                        _this.text('发送验证码');
                        _this.removeAttr('disabled').removeClass('layui-btn-disabled');
                        clearInterval(timer);
                    } else {
                        _this.text(timing-- + '重新发送');
                        _this.attr('disabled', 'true').addClass('layui-btn-disabled');
                    }
                }, 1000);
                layer.msg(JSON.parse(res).msg, {icon: 6});

            } else {
                layer.msg(JSON.parse(res).msg, {time: 5000, icon: 2});
            }
            layer.close(index);
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

function checkEmail(str) {
    var re = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
    if (re.test(str)) {
        return true;
    }
    return false;
}