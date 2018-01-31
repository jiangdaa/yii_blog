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
        $jsTemplate = " 
            layui.use(['form','element','jquery'],function(){
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
        })";
        return $jsTemplate;
    }


}