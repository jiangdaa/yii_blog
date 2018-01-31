<?php
$this->title = '首页';

use yii\helpers\Url;

?>
    <canvas id="canvas-banner" style="background: #393D49;"></canvas>
    <!--为了及时效果需要立即设置canvas宽高，否则就在home.js中设置-->
    <script type="text/javascript">
        var canvas = document.getElementById('canvas-banner');
        canvas.width = window.document.body.clientWidth - 10;//减去滚动条的宽度
        if (screen.width >= 992) {
            canvas.height = window.innerHeight * 1 / 3;
        } else {
            canvas.height = window.innerHeight * 2 / 7;
        }
    </script>
    <!-- 这个一般才是真正的主体内容 -->
    <div class="blog-container">
        <div class="blog-main">
            <!-- 网站公告提示 -->
            <div class="home-tips shadow">
                <i style="float:left;line-height:17px;" class="fa fa-volume-up"></i>
                <div class="home-tips-container">
                    <?php foreach ($announcements as $announcement): ?>
                        <span style="color: #009688"><?= $announcement['content'] ?></span>
                    <?php endforeach ?>
                </div>
            </div>
            <!--左边文章列表-->
            <div class="blog-main-left">
                <?php foreach ($articles as $article): ?>
                    <div class="article shadow">
                        <div class="article-left">
                            <img src="<?= empty($article['cover']) ? \yii::$app->params['defaultCover'] : $article['cover'] ?>"
                                 alt="<?= $article['title'] ?>"/>
                        </div>
                        <div class="article-right">
                            <div class="article-title">
                                <a href="<?= Url::to(['detail', 'aid' => $article['id']]) ?>"><?= $article['title'] ?></a>
                            </div>
                            <div class="article-abstract">
                                <?php echo \yii::$app->Gather->subText(strip_tags($article['content']), 10) ?>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="article-footer">
                            <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?= $article['updatetime'] ?></span>
                            <span class="article-author"><i class="fa fa-user"></i>&nbsp;&nbsp;<?= $article['author'] ?></span>
                            <span><i class="fa fa-tag"></i>&nbsp;&nbsp;<a
                                        href="<?= Url::to(['category/articles', 'cid' => $article['cid']]) ?>"><?= $article['name'] ?></a></span>
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
            <!--右边小栏目-->
            <div class="blog-main-right">
                <div class="blogerinfo shadow">
                    <div class="blogerinfo-figure">
                        <img src="<?= \yii::$app->params['defaultHeadImg'] ?>" alt="JD" width="30%"/>
                    </div>
                    <p class="blogerinfo-nickname"><?=yii::$app->params['bloggerInfo']['blogger_name']?></p>
                    <p class="blogerinfo-introduce"><?=yii::$app->params['bloggerInfo']['blogger_signature']?></p>
                    <p class="blogerinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;<?=yii::$app->params['bloggerInfo']['blogger_address']?></p>
                    <hr/>
                    <div class="blogerinfo-contact">
                        <a target="_blank" title="QQ交流" href="<?=yii::$app->params['bloggerInfo']['qq']?>"><i
                                    class="fa fa-qq fa-2x"></i></a>
                        <a target="_blank" title="给我写信" href="<?=yii::$app->params['bloggerInfo']['email']?>"><i
                                    class="fa fa-envelope fa-2x"></i></a>
                        <a target="_blank" title="新浪微博" href="<?=yii::$app->params['bloggerInfo']['weibo']?>"><i
                                    class="fa fa-weibo fa-2x"></i></a>
                        <a target="_blank" title="码云" href="<?=yii::$app->params['bloggerInfo']['github']?>"><i
                                    class="fa fa-git fa-2x"></i></a>
                    </div>
                </div>
                <div></div><!--占位-->
                <div class="blog-module shadow">
                    <div class="blog-module-title">文章分类</div>

                    <ul class="fa-ul blog-module-ul">
                        <?php foreach ($categorys as $key => $category): ?>
                            <li><i class="fa-li fa fa-tag"></i><a
                                        href="<?= Url::to(['category/articles', 'cid' => $key]) ?>"><?= $category ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </div>
                <div class="blog-module shadow">
                    <div class="blog-module-title">推荐文章</div>
                    <ul class="fa-ul blog-module-ul">
                        <?php if (!empty($recommends)): ?>
                            <?php foreach ($recommends as $recommends): ?>
                                <li><i class="fa-li fa fa-hand-o-right"></i>
                                    <a href="<?= Url::to(['detail', 'aid' => $recommends['id']]) ?>">
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
                <div class="blog-module shadow">
                    <div class="blog-module-title">友情链接</div>
                    <ul class="blogroll">
                        <li><a target="_blank" href="http://www.layui.com/" title="Layui">Layui</a></li>
                        <li><a target="_blank" href="http://www.pagemark.cn/" title="页签">页签</a></li>
                    </ul>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
<?php
$this->registerJsFile('/frontend/js/home.js', ['depends' => 'yii\web\LayerfAsset']);
$css = "
.disabled span{
    color:#ccc;
}
.layui-laypage-curr a{
color:#fff;

background-color: #009688;}";
$this->registerCss($css);
?>