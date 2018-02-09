layui.use(['element', 'jquery', 'form', 'layedit'], function () {
    var element = layui.element;
    var form = layui.form;
    var $ = layui.jquery;
    var layedit = layui.layedit;
    //评论和留言的编辑器
    var editIndex = layedit.build('remarkEditor', {
        height: 150,
        tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
    });

    //评论和留言的编辑器的验证
    layui.form.verify({
        content: function (value) {
            value = $.trim(layedit.getText(editIndex));
            if (value == "") return "自少得有一个字吧";
            layedit.sync(editIndex);
        }
    });

    //Hash地址的定位
    var layid = location.hash.replace(/^#tabIndex=/, '');
    if (layid == "") {
        element.tabChange('tabAbout', 1);
    }
    element.tabChange('tabAbout', layid);
    element.on('tab(tabAbout)', function (elem) {
        location.hash = 'tabIndex=' + $(this).attr('lay-id');
    });

    //监听留言提交
    form.on('submit(formLeaveMessage)', function (data) {
        var index = layer.load(1);
        data.field.uid = window.localStorage.getItem('uid');
        $.post('/request/leave-msg.html', data.field, function (res) {
            var res = JSON.parse(res);
            if (res.error === '0') {
                setTimeout(function () {
                    var content = res.data.leave_msg;
                    var replyTime = res.data.leave_msg_time;
                    var nickName = res.data.nick_name;
                    var portrait = res.data.portrait;
                    var pid = res.data.id;
                    var html = ` <li>
                                    <div class="comment-parent">
                                        <img src="${portrait}"/>
                                        <div class="info" style="padding-top:20px;">
                                            <span class="username">${nickName}</span>
                                        </div>
                                        <div class="content"><br>${content}</div>
                                        <p class="info info-footer">
                                            <span class="time">${replyTime}</span>
                                            <a class="btn-reply"href="javascript:;" onclick="btnReplyClick(this)">回复</a>
                                        </p>
                                    </div>
                                    <hr>
                                    <div class="replycontainer layui-hide">
                                        <form class="layui-form"action="">
                                            <div class="layui-form-item">
                                                <input type="text" class="layui-input" name="pid" value="${pid}">
                                                <textarea name="leave_msg" lay-verify="replyContent" placeholder="请输入回复内容" class="layui-textarea" style="min-height:80px;"></textarea>
                                            </div>
                                            <div class="layui-form-item">
                                                <button class="layui-btn layui-btn-mini"lay-submit="formReply"lay-filter="formReply">提交</button>
                                            </div>
                                        </form>
                                    </div>
                                </li>`;
                    $('.blog-comment').append(html);
                    $('#remarkEditor').val('');
                    editIndex = layui.layedit.build('remarkEditor', {
                        height: 150,
                        tool: ['face', '|', 'left', 'center', 'right', '|', 'link'],
                    });
                    layer.msg("留言成功", {icon: 1});
                }, 500);
            } else {
                layer.msg(res.msg, {icon: 2});

            }
            layer.close(index);
        });
        return false;
    });

    //监听留言回复提交
    form.on('submit(formReply)', function (data) {
        data.field.uid = window.localStorage.getItem('uid');
        $.post('/request/reply.html', data.field, function (res) {
            var index = layer.load(1);
            var res = JSON.parse(res);
            setTimeout(function () {
                layer.close(index);
                var content = res.data.leave_msg;
                var replyTime = res.data.leave_msg_time;
                var nickName = res.data.nick_name;
                var portrait = res.data.portrait || 'http://yii.bgadmin.cn/backend/images/default-head.jpg';
                var html = `
                    <div class="comment-child">
                        <img src="${portrait}" />
                        <div class="info">
                            <span class="username">${nickName}</span>
                            <span>${content}</span>
                        </div>
                        <p class="info">
                            <span class="time">${replyTime}</span>
                        </p>
                    </div>
                    <hr>
                `;

                $(data.form).find('textarea').val('');
                $(data.form).parent('.replycontainer').before(html).siblings('.comment-parent').children('p').children('a').click();
                layer.msg("回复成功", {icon: 1});
            }, 500);
        });


        return false;
    });
});

function btnReplyClick(elem) {
    var $ = layui.jquery;
    $(elem).parent('p').parent('.comment-parent').siblings('.replycontainer').toggleClass('layui-hide');
    if ($(elem).text() == '回复') {
        $(elem).text('收起')
    } else {
        $(elem).text('回复')
    }
}

systemTime();

function systemTime() {
    //获取系统时间。
    var dateTime = new Date();
    var year = dateTime.getFullYear();
    var month = dateTime.getMonth() + 1;
    var day = dateTime.getDate();
    var hh = dateTime.getHours();
    var mm = dateTime.getMinutes();
    var ss = dateTime.getSeconds();
    mm = extra(mm);
    ss = extra(ss);
    document.getElementById("time").innerHTML = year + "-" + month + "-" + day + " " + hh + ":" + mm + ":" + ss;
    setTimeout("systemTime()", 1000);
}

//补位函数。
function extra(x) {
    //如果传入数字小于10，数字前补一位0。
    if (x < 10) {
        return "0" + x;
    }
    else {
        return x;
    }
}