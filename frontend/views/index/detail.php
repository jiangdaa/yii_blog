<?php

use yii\helpers\Url;

?>
    <div class="blog-body">
        <div class="blog-container">
            <blockquote class="layui-elem-quote sitemap layui-breadcrumb shadow">
                <a href="home.html" title="网站首页">网站首页</a>
                <a href="article.html" title="文章专栏">文章专栏</a>
                <a><cite>基于layui的laypage扩展模块！</cite></a>
            </blockquote>
            <div class="blog-main">
                <div class="blog-main-left">
                    <!-- 文章内容（使用Kingeditor富文本编辑器发表的） -->
                    <div class="article-detail shadow">
                        <div class="article-detail-title">
                            <?php
                            if ($detail['recommend']) {
                                echo '<b style="color:orange;">【推荐】</b>';
                            }
                            ?>
                            <?= $detail['title'] ?>
                        </div>
                        <div class="article-detail-info">
                            <span>编辑时间：<?= $detail['updatetime'] ?></span>
                            <span>作者：<?= $detail['author'] ?></span>
                            <span>浏览量：<?= $detail['count'] ?></span>
                            <span>点赞：<?= $detail['praise'] ?></span>
                        </div>
                        <div class="article-detail-content">
                            <?= $detail['content'] ?>
                        </div>
                    </div>
                    <!-- 评论区域 -->
                    <div class="blog-module shadow" style="box-shadow: 0 1px 8px #a6a6a6;">
                        <fieldset class="layui-elem-field layui-field-title" style="margin-bottom:0">
                            <legend>来说两句吧</legend>
                            <div class="layui-field-box">
                                <form class="layui-form blog-editor" action="">
                                    <div class="layui-form-item">
                                    <textarea name="editorContent" lay-verify="content" id="remarkEditor"
                                              placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                    </div>
                                    <div class="layui-form-item">
                                        <button class="layui-btn" lay-submit="formRemark" lay-filter="formRemark">提交评论
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </fieldset>
                        <div class="blog-module-title">最新评论</div>
                        <ul class="blog-comment">
                            <?php foreach ($comments as $comment): ?>
                                <li>
                                    <div class="comment-parent">
                                        <img src="<?= yii::$app->params['defaultHeadImg'] ?>" />
                                        <div class="info">
                                            <span class="username"><?= $comment['adminname'] ?></span>
                                            <span class="time"><?= $comment['comment_time'] ?></span>
                                        </div>
                                        <div class="content">
                                            <?= $comment['comment_content'] ?>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                </div>
                <div class="blog-main-right">
                    <!--右边悬浮 平板或手机设备显示-->
                    <div class="category-toggle"><i class="fa fa-chevron-left"></i></div>
                    <!--这个div位置不能改，否则需要添加一个div来代替它或者修改样式表-->
                    <div class="article-category shadow">
                        <div class="article-category-title">分类导航</div>
                        <?php foreach ($categorys as $key => $category): ?>
                            <a href="<?= Url::to(['category/articles', 'cid' => $key]) ?>"><?= $category ?></a>
                        <?php endforeach ?>
                        <div class="clear"></div>
                    </div>

                    <div class="blog-module shadow">
                        <div class="blog-module-title">随便看看</div>
                        <ul class="fa-ul blog-module-ul">
                            <?php foreach ($randArticles as $randArticle): ?>
                                <li>
                                    <i class="fa-li fa fa-hand-o-right"></i>
                                    <a href="<?= Url::to(['detail', 'aid' => $randArticle['id']]) ?>">
                                        <?= $randArticle['title'] ?>
                                    </a>
                                </li>
                            <?php endforeach ?>

                        </ul>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>

<?php
$this->registerCssFile('/frontend/css/prettify.css');
$this->registerCssFile('/frontend/css/detail.css');
$this->registerJsFile('/frontend/js/detail.js', ['depends' => 'yii\web\LayerfAsset']);

?>