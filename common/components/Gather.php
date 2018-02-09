<?php

namespace common\components;

use yii\base\Component;
use yii\helpers\Url;

/**
 * -------------------------------------------
 *
 * Class Gather 封装一些常用的
 * @package common\components
 *
 * -------------------------------------------
 */
class Gather extends Component
{

    /**
     * -------------------------------------------
     * pager  gridView 分页配置
     * @param string $type 类型
     * @return array|null|string
     * -------------------------------------------
     */
    public function pager($type = 'css')
    {
        $css = ".pager-box{text-align:right;margin-top:30px;}.layui-laypage-curr a{color:#fff;background:#009688;}";
        $pagerConfig = [
            'disabledPageCssClass' => 'layui-laypage-prev layui-disabled',
            'nextPageLabel' => '下一页',
            'prevPageLabel' => '上一页',
            'options' => [

            ],
            'linkContainerOptions' => [
                'style' => 'float:left;'
            ],
            'activePageCssClass' => 'layui-laypage-curr'
        ];
        $pagerLayout = "<div class='pager-box'><div class='layui-box layui-laypage layui-laypage-default'>{pager}</div></div>";
        switch ($type) {
            case 'css':
                return $css;
                break;
            case 'pagerConfig':
                return $pagerConfig;
                break;
            case 'pagerLayout':
                return $pagerLayout;
                break;
        }
        return null;
    }

    /**
     * -------------------------------------------
     * subtext  截取中文并家省略号
     * @param  string $text 字符串文本
     * @param int $length 要截取的长度
     * @return string
     * -------------------------------------------
     */
    public function subtext($text, $length)
    {
        if (mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8') . '...';
        return $text;
    }

    /**
     * -------------------------------------------
     * ueditorCfg  百度富文本上传图片配置
     * @return array
     * -------------------------------------------
     */
    public function ueditorCfg()
    {

        return [
            'class' => 'common\widgets\ueditor\UeditorAction',
            'config' => [
                'imageUrlPrefix' => Url::base(true),
                'imagePathFormat' => "/editor/{yyyy}{mm}{dd}/{time}{rand:6}",
            ]
        ];
    }


}