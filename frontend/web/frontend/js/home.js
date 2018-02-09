layui.use('jquery', function () {
    var $ = layui.jquery;
     $(function () {
         //播放公告
         playAnnouncement(3000);
     });
    function playAnnouncement(interval) {
        var index = 0;
        var $announcement = $('.home-tips-container>span');
        //自动轮换
        setInterval(function () {
            index++;    //下标更新
            if (index >= $announcement.length) {
                index = 0;
            }
            $announcement.eq(index).stop(true, true).fadeIn(300).siblings('span').fadeOut(300);  //下标对应的图片显示，同辈元素隐藏
        }, interval);
    }

});



//监听窗口大小改变
//window.addEventListener("resize", resizeCanvas, false);

/*
//窗口大小改变时改变canvas宽度
function resizeCanvas() {
    var canvas = document.getElementById('canvas-banner');
    canvas.width = window.document.body.clientWidth;
    canvas.height = window.innerHeight * 1 / 3;
}*/
