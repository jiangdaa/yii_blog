<?php
$this->title = '首页';

use yii\helpers\Url;

?>

    <!-- 这个一般才是真正的主体内容 -->
    <div class="blog-container">
        <div class="blog-main">
            <!-- 网站公告提示 -->
            <div class="home-tips shadow animated fadeInDown">
                <i style="float:left; line-height:15px;font-size:19px" class="fa fa-volume-up"></i>
                <div class="home-tips-container">
                    <?php foreach ($announcements as $announcement): ?>
                        <span style="color: #009688"><?= $announcement['content'] ?></span>
                    <?php endforeach ?>
                </div>
            </div>
            <!--左边文章列表-->
            <div class="blog-main-left ">
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
            <?php echo $this->render('//common/right.php', ['categorys' => $categorys, 'recommends' => $recommends]) ?>

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