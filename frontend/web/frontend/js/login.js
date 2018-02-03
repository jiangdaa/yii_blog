layui.use(['form', 'layedit', 'laydate'], function () {
    var form = layui.form,
        layer = layui.layer,
        $ = layui.jquery;


    //自定义验证规则
    form.verify({
        password: [/(.+){6,12}$/, '密码格式错误'],

    });

    //监听提交
    form.on('submit(login)', function (data) {
        alert(123);
        $.post('/request/login.html', data.field, function (res) {
            if (JSON.parse(res).error === '0') {
                window.parent.location.href = 'index.html';
            }
            layer.msg(JSON.parse(res).msg, {time: 3000, icon: 6});
        });
        return false;
    });


});