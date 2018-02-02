<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

?>

    <div class="blog-container" style="margin-top:90px;">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => '博客首页', 'url' => Url::to(['index/index'])],
            'tag' => 'blockquote',
            'itemTemplate' => "{link}",
            'links' => [
                [
                    'label' => '工具分享',
                    'url' => ['index/share'],
                    'template' => "{link}\n", //只用引用该类的模板,
                ]
            ],
            'options' => [ //设置 html 属性
                'class' => 'layui-elem-quote sitemap layui-breadcrumb shadow animated fadeInDown',
                'style' => 'margin-top:-70px;'
            ]
        ]) ?>

        <div class="blog-main">

            <div class="child-nav shadow  animated fadeInRight">
                <?php $k = 0;
                foreach ($category_shares as $category_share): ?>
                    <span class="child-nav-btn <?= $k == 0 ? 'child-nav-btn-this' : '' ?>"><?= $category_share ?></span>
                    <?php $k++ ?>
                <?php endforeach ?>

            </div>
            <div class="resource-main  animated fadeInUp">
                <?php $k = 0; ?>
                <?php foreach ($shares

                               as $share): ?>
                    <div class="<?= $k == 0 ? '' : 'layui-hide' ?>">
                        <?php foreach ($share as $share_v): ?>
                            <div class="resource shadow">
                                <div class="resource-cover">
                                    <a href="javascript:layer.msg(&#39;暂未开发&#39;)" target="_blank">
                                        <img src="<?= $share_v['cover'] ?>" alt="时光轴"/>
                                    </a>
                                </div>
                                <h1 class="resource-title">
                                    <a href="javascript:layer.msg(&#39;暂未开发&#39;)" target="_blank">
                                        <?= $share_v['share_name'] ?>
                                    </a>
                                </h1>
                                <p class="resource-abstract"><?= $share_v['share_describe'] ?></p>
                                <div class="resource-info">
                                    <span class="category">
                                        <a href="javascript:;">
                                            <i class="fa fa-tags fa-fw"></i>&nbsp;
                                            <?= $share_v['category'] ?>
                                        </a>
                                    </span>
                                    <span class="author">
                                        <i class="fa fa-user fa-fw"></i><?= $share_v['author'] ?>
                                    </span>
                                    <div class="clear"></div>
                                </div>
                                <div class="resource-footer">
                                    <a class="layui-btn layui-btn-small layui-btn-primary"
                                       href="javascript:layer.msg(&#39;暂未开发&#39;)" target="_blank">
                                        <i class="fa fa-eye fa-fw"></i>
                                        演示
                                    </a>
                                    <a class="layui-btn layui-btn-small layui-btn-primary"
                                       href="javascript:layer.msg(&#39;暂未开发&#39;)" target="_blank">
                                        <i class="fa fa-download fa-fw"></i>
                                        下载
                                    </a>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <?php $k++ ?>
                <?php endforeach ?>

                <!-- 清除浮动 -->
                <div class="clear"></div>
            </div>
        </div>

    </div>

<?php
$this->registerCssFile('/frontend/css/resource.css');
?>