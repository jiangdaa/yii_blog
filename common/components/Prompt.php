<?php

namespace common\components;

use yii\base\Component;

// js 提示
class Prompt extends Component
{


    public function jsString($config = [])
    {

        $flash = \yii::$app->session;
        $info = $flash->hasFlash('info');
        $error = $flash->hasFlash('error');

        $successMsg = empty($config['successMsg']) ? $flash->getFlash('info') : $config['successMsg'];
        $errorMsg = empty($config['errorMsg']) ? $flash->getFlash('error') : $config['errorMsg'];
        $time = empty($config['time']) ? '2000' : $config['time'];
        $appendJs = empty($config['appendJs']) ? '' : $config['appendJs'];
        $upload = '';
        $use = '';
        if (!empty($config['upload'])) {
            $config['upload']['use'] = 'upload';
            $use = $config['upload']['use'];
            $upload = "
              var uploadInst = upload.render({
                elem: '{$config['upload']['uploadBtn']}', //绑定元素
                url: '{$config['upload']['url']}',
                field:'{$config['upload']['field']}',
                done: function(res){
                   console.log(res);
                   if(res.success){
                        $('{$config['upload']['cover']}').attr('src',res.savePath);
                        $('{$config['upload']['coverPath']}').val(res.savePath);
                        layer.msg('{$config['upload']['successMsg']}', {time: 3000, icon:6});
                   }else{
                        layer.msg('上传失败请重新尝试');
                   }
                },
                error: function(){
                    layer.msg('上传失败请重新尝试');
                }
              });";
        }
        $jsTemplate = " 
            var useArr = ['form','element','jquery'];
            var condition = '{$use}';
            if(condition=='upload'){
                useArr.push('upload');
            }
            layui.use(useArr,function(){
              var upload = layui.upload;
              var $ = layui.jquery;
              var info = '{$info}';
              var error = '{$error}';
              if(info){
                layer.msg('{$successMsg}', {time: {$time}, icon:6});
              }
              if(error){
                 layer.msg('{$errorMsg}', {time: {$time}, icon:2});
              }
              // --代码追加--
              {$appendJs}
              //--上传部分--
              {$upload}
              
        })";
        return $jsTemplate;
    }


}