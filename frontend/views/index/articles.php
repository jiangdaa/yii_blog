<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
$this->title = '文章分类';
?>


<div class="blog-container" style="margin-top:90px;">
    <div class="blog-main">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => '博客首页', 'url' => Url::to(['index/index'])],
            'tag' => 'blockquote',
            'itemTemplate' => "{link}",
            'links' => [
                [
                    'label' => '文章专栏',
                    'url' => ['category/articles'],
                    'template' => "{link}\n", //只用引用该类的模板,
                ]
            ],
            'options' => [ //设置 html 属性
                'class' => 'layui-elem-quote sitemap layui-breadcrumb shadow animated fadeInDown',
                'style' => 'margin-top:-70px;'
            ]
        ]) ?>

        <!--左边文章列表-->
        <div class="blog-main-left">
            <?php if(empty($articles)) :?>
                <h3 style="text-align:center;color:white;" class="animated fadeInUp">暂时还没有文章哟</h3>
            <?php endif?>
            <?php foreach ($articles as $k => $article): ?>
                <div class="article shadow animated fadeIn<?= $k % 2 ? 'Right' : 'Left'; ?>">
                    <div class="article-left">
                        <img src="<?= empty($article['cover']) ? \yii::$app->params['defaultCover'] : $article['cover'] ?>"
                             alt="<?= $article['title'] ?>"/>
                    </div>
                    <div class="article-right">
                        <div class="article-title">
                            <a href="<?= Url::to(['index/detail', 'aid' => $article['id']]) ?>"><?= $article['title'] ?></a>
                        </div>
                        <div class="article-abstract">
                            <?php echo \yii::$app->Gather->subText(strip_tags($article['content']), 10) ?>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="article-footer">
                        <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?= $article['updatetime'] ?></span>
                        <span class="article-author"><i
                                    class="fa fa-user"></i>&nbsp;&nbsp;<?= $article['author'] ?></span>
                        <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a
                                    href="<?= Url::to(['index/category', 'cid' => $article['cid']]) ?>"><?= $article['name'] ?></a></span>
                        <span class="article-viewinfo"><i
                                    class="fa fa-eye"></i>&nbsp;<?= $article['count'] ?></span>
                        <span class="article-viewinfo"><i class="fa fa-commenting"></i>
                                &nbsp;<?= common\components\ArticleQry::getInstance()->getArticleCommentCount($article['id']) ?>
                            </span>
                    </div>
                </div>
            <?php endforeach ?>
            <?= \yii\widgets\LinkPager::widget([
                'pagination' => $pager,
                'options' => [
                    'class' => 'layui-box layui-laypage layui-laypage-default'
                ],
                'activePageCssClass' => 'layui-laypage-curr',
                'linkContainerOptions' => [
                    'style' => 'float:left;'
                ],
                'prevPageLabel' => '上一页',
                'nextPageLabel' => '下一页'

            ]) ?>
        </div>
        <?php echo $this->render('//common/right.php', ['categorys' => $categorys, 'recommends' => $recommends]) ?>
    </div>
