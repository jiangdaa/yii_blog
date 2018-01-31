<?php

namespace common\components;

use yii\base\Component;


class Gather extends Component
{


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

    public function subtext($text, $length)
    {
        if (mb_strlen($text, 'utf8') > $length)
            return mb_substr($text, 0, $length, 'utf8') . '...';
        return $text;
    }


}