<?php

use yii\helpers\Url;

?>
<!--右边小栏目-->
<div class="blog-main-right">
    <div class="blogerinfo shadow animated fadeInRight">
        <div class="blogerinfo-figure">
            <img src="<?= \yii::$app->params['defaultHeadImg'] ?>" alt="JD" width="30%"/>
        </div>
        <p class="blogerinfo-nickname"><?= yii::$app->params['bloggerInfo']['blogger_name'] ?></p>
        <p class="blogerinfo-introduce"><?= yii::$app->params['bloggerInfo']['blogger_signature'] ?></p>
        <p class="blogerinfo-location"><i
                    class="fa fa-location-arrow"></i>&nbsp;<?= yii::$app->params['bloggerInfo']['blogger_address'] ?>
        </p>
        <hr/>
        <div class="blogerinfo-contact">
            <a target="_blank" title="QQ交流" href="<?= yii::$app->params['bloggerInfo']['qq'] ?>"><i
                        class="fa fa-qq fa-2x"></i></a>
            <a target="_blank" title="给我写信" href="<?= yii::$app->params['bloggerInfo']['email'] ?>"><i
                        class="fa fa-envelope fa-2x"></i></a>
            <a target="_blank" title="新浪微博" href="<?= yii::$app->params['bloggerInfo']['weibo'] ?>"><i
                        class="fa fa-weibo fa-2x"></i></a>
            <a target="_blank" title="码云" href="<?= yii::$app->params['bloggerInfo']['github'] ?>"><i
                        class="fa fa-git fa-2x"></i></a>
        </div>
    </div>
    <div></div><!--占位-->
    <div class="blog-module shadow animated fadeInUp">
        <div class="blog-module-title">文章分类</div>

        <ul class="fa-ul blog-module-ul">
            <?php foreach ($categorys as $key => $category): ?>
                <li><i class="fa-li fa fa-tag"></i><a
                            href="<?= Url::to(['category/articles', 'cid' => $key]) ?>"><?= $category ?></a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
    <div class="blog-module shadow animated fadeInUp">
        <div class="blog-module-title">推荐文章</div>
        <ul class="fa-ul blog-module-ul">
            <?php if (!empty($recommends)): ?>
                <?php foreach ($recommends as $recommends): ?>
                    <li><i class="fa-li fa fa-hand-o-right"></i>
                        <a href="<?= Url::to(['article/detail', 'aid' => $recommends['id']]) ?>">
                            <?= $recommends['title'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            <?php else: ?>
                <li style="text-align:center;">
                    暂时还没有推荐的文章哟
                </li>
            <?php endif ?>
        </ul>
    </div>
    <div class="blog-module shadow animated fadeInUp">
        <div class="blog-module-title">友情链接</div>
        <ul class="blogroll">
            <?php foreach (\yii::$app->params['link'] as $link) : ?>
                <li><a target="_blank" href="<?= $link['link_url'] ?>" title="Layui"><?= $link['link_name'] ?></a></li>
            <?php endforeach ?>
        </ul>
    </div>
</div>
<div class="clear"></div>