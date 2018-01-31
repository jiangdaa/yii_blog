<?php

use yii\helpers\Url;

?>
<div class="blog-container" style="margin-top:90px;">
    <div class="blog-main">
        <!-- 网站公告提示 -->
        <div class="home-tips shadow">
            <i style="float:left;line-height:17px;" class="fa fa-volume-up"></i>
            <div class="home-tips-container">
                <span style="color: #009688">偷偷告诉大家，本博客的后台管理也正在制作，为大家准备了游客专用账号！</span>
                <span style="color: red">网站新增留言回复啦！使用QQ登陆即可回复，人人都可以回复！</span>
                <span style="color: red">如果你觉得网站做得还不错，来Fly社区点个赞吧！<a href="http://fly.layui.com/case/2017/"
                                                                    target="_blank"
                                                                    style="color:#01AAED">点我前往</a></span>
                <span style="color: #009688">不落阁 &nbsp;—— &nbsp;一个.NET程序员的个人博客，新版网站采用Layui为前端框架，目前正在建设中！</span>
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
                        <span class="article-author"><i
                                    class="fa fa-user"></i>&nbsp;&nbsp;<?= $article['author'] ?></span>
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
                <p class="blogerinfo-nickname">JD</p>
                <p class="blogerinfo-introduce">一枚90后程序员,不断努力学习ing...</p>
                <p class="blogerinfo-location"><i class="fa fa-location-arrow"></i>&nbsp;吉林 - 长春</p>
                <hr/>
                <div class="blogerinfo-contact">
                    <a target="_blank" title="QQ交流" href="javascript:layer.msg('启动QQ会话窗口')"><i
                                class="fa fa-qq fa-2x"></i></a>
                    <a target="_blank" title="给我写信" href="javascript:layer.msg('启动邮我窗口')"><i
                                class="fa fa-envelope fa-2x"></i></a>
                    <a target="_blank" title="新浪微博" href="javascript:layer.msg('转到你的微博主页')"><i
                                class="fa fa-weibo fa-2x"></i></a>
                    <a target="_blank" title="码云" href="javascript:layer.msg('转到你的github主页')"><i
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