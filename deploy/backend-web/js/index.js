/**
 * 后台登录页 layui 模块（原 backend/web/backend/js/index.js 未提交到仓库，此为兼容实现）
 * 页面约定：全局 url 为验证码刷新地址，#imagecode 为验证码图片，#time 为时间展示。
 */
layui.define(['form', 'jquery', 'element'], function (exports) {
    var form = layui.form,
        element = layui.element,
        $ = layui.jquery;

    form.render();

    // 登录页时钟
    function tick() {
        var week = ['日', '一', '二', '三', '四', '五', '六'];
        var d = new Date();
        var pad = function (n) { return n < 10 ? '0' + n : '' + n; };
        $('#time').text(
            d.getFullYear() + '-' + pad(d.getMonth() + 1) + '-' + pad(d.getDate()) +
            ' 星期' + week[d.getDay()] + ' ' +
            pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds())
        );
    }
    if ($('#time').length) {
        tick();
        setInterval(tick, 1000);
    }

    // 点击验证码图片刷新（login/captcha 的 refresh 接口返回 {url, hash1, hash2, id}）
    $(document).on('click', '#imagecode', function () {
        var img = this;
        $.getJSON(url || '/login/captcha?refresh=', {refresh: 1}, function (data) {
            if (data && data.url) {
                $(img).attr('src', data.url);
            }
        }).fail(function () {
            location.reload();
        });
    });

    exports('index', {});
});
