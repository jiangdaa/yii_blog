/**
 * 后台管理页 layui 主模块（原 backend/web/backend/js/main.js 未提交到仓库，此为兼容实现）
 * 约定：左侧菜单 <a data-url="..." data-id="...">，点击后在 lay-filter="tab" 的
 * layui-tab 中以 iframe 形式打开标签页。
 */
layui.define(['element', 'layer', 'jquery', 'form'], function (exports) {
    var element = layui.element,
        layer = layui.layer,
        form = layui.form,
        $ = layui.jquery;

    var TAB_FILTER = 'tab';

    function openTab(url, title, id) {
        if (!url || url === 'javascript:;' || url === '#') {
            return;
        }
        id = id || url;
        var $title = $('.layui-tab-title li[lay-id="' + id + '"]');
        if ($title.length === 0) {
            element.tabAdd(TAB_FILTER, {
                title: title || url,
                content: '<iframe src="' + url + '" frameborder="0" style="width:100%;height:100%;"></iframe>',
                id: id
            });
        }
        element.tabChange(TAB_FILTER, id);
    }

    // 左侧导航点击 -> 打开/切换 iframe 标签页
    element.on('nav(leftnav)', function (elem) {
        var url = elem.attr('data-url'),
            id = elem.attr('data-id'),
            title = $.trim(elem.text());
        openTab(url, title, id);
    });

    // 首页快捷菜单瓦片
    $(document).on('click', '.windows-tile span[data-url]', function () {
        var $span = $(this);
        openTab($span.attr('data-url'), $.trim($span.text()), $span.attr('data-id'));
    });

    // 收起/展开侧边导航
    $(document).on('click', '.layui-side-hide', function () {
        var $layout = $('.layui-layout-admin');
        $layout.toggleClass('pm-side-collapsed');
        if ($layout.hasClass('pm-side-collapsed')) {
            $('.layui-side').hide();
            $('.layui-body').css('left', '0');
            $(this).find('i').removeClass('fa-long-arrow-left').addClass('fa-long-arrow-right');
            $(this).contents().last().replaceWith('展开导航');
        } else {
            $('.layui-side').show();
            $('.layui-body').css('left', '200px');
            $(this).find('i').removeClass('fa-long-arrow-right').addClass('fa-long-arrow-left');
            $(this).contents().last().replaceWith('收起导航');
        }
    });

    // 个性化面板
    $(document).on('click', '#individuation', function () {
        $('.individuation').toggleClass('layui-hide').removeClass('flipOutY').addClass('flipInY');
    });

    // 主题切换
    $(document).on('click', '.setting-item.skin', function () {
        $('body').removeClass(function (i, cls) {
            return (cls.match(/(^|\s)skin-\S+/g) || []).join(' ');
        }).addClass($(this).attr('data-skin'));
    });

    // 侧边导航开关
    form.on('switch(sidenav)', function (data) {
        if (data.elem.checked) {
            $('.layui-side').show();
            $('.layui-body').css('left', '200px');
        } else {
            $('.layui-side').hide();
            $('.layui-body').css('left', '0');
        }
    });

    exports('main', {});
});
