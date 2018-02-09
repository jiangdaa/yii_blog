<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\Url;

/**
 * -------------------------------------------
 *
 * @class Component 封装layer常用的js代码
 *
 * -------------------------------------------
 */
class Prompt extends Component
{

    /**
     * -------------------------------------------
     * pager  jsString  layer JS 代码
     * @param array $config 配置
     * @return string
     * -------------------------------------------
     */
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
        $confirmDel = '';
        if (!empty($config['upload'])) {
            $config['upload']['use'] = 'upload';
            $use = $config['upload']['use'];
            $upload = "
              var uploadInst = upload.render({
                elem: '{$config['upload']['uploadBtn']}', //绑定元素
                url: '{$config['upload']['url']}',
                field:'{$config['upload']['field']}',
                done: function(res){
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

        if (!empty($config['confirmDel'])) {
            $config['confirmDel']['msg'] = empty($config['confirmDel']['msg']) ? '选项' : $config['confirmDel']['msg'];
            $frameId = \yii::$app->request->get('iframe-id');
            $delUrl = $config['confirmDel']['url'];
            $idtype = empty($config['confirmDel']['attrId']) ? 'sid' : $config['confirmDel']['attrId'];
            $confirmDel = " 
                var iframe = $('iframe',window.parent.document);
                $('.delete').on('click',function(){
                    var id = $(this).attr('{$idtype}');
                    layer.confirm('确定删除该{$config['confirmDel']['msg']}？', {
                      btn: ['确定','取消']
                    }, function(){
                        $.each(iframe,function(i){
                            if(iframe.eq(i).attr('iframe-id')=='{$frameId}'){
                       
                               iframe.eq(i).attr('src','{$delUrl}?ifrid={$frameId}&{$idtype}='+id);
                            }
                        });
                    });
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
              //--确认删除--
              {$confirmDel}
              
        })";
        return $jsTemplate;
    }


}