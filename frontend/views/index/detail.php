<?php

use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
$this->title = $detail['title'];
?>
    <div class="blog-body">
        <div class="blog-container">
            <?= Breadcrumbs::widget([
                'homeLink' => ['label' => '博客首页', 'url' => Url::to(['index/index'])],
                'tag' => 'blockquote',
                'itemTemplate' => "{link}",
                'activeItemTemplate' => '<cate><a>{link}</a></cate>',
                'links' => [
                    [
                        'label' => '文章专栏',
                        'url' => ['category/articles'],
                        'template' => "{link}\n", //只用引用该类的模板,
                    ],
                    $detail['title']
                ],
                'options' => [ //设置 html 属性
                    'class' => 'layui-elem-quote sitemap layui-breadcrumb shadow animated fadeInDown',
                    'style' => 'margin-top:-50px;'
                ]
            ]) ?>
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
                                <div class="layui-form blog-editor">
                                    <div class="layui-form-item">
                                        <input type="hidden" name="aid" value="<?= $detail['id'] ?>">
                                        <textarea name="comment_content" lay-verify="content" id="remarkEditor"
                                                  placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                    </div>
                                    <div class="layui-form-item">
                                        <button class="layui-btn" lay-submit="formRemark" lay-filter="formRemark">提交评论
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="blog-module-title">最新评论</div>
                        <ul class="blog-comment">
                            <?php foreach ($comments as $comment): ?>
                                <li>
                                    <div class="comment-parent">
                                        <img src="<?= yii::$app->params['defaultHeadImg'] ?>"/>
                                        <div class="info">
                                            <span class="username"><?= $comment['nick_name'] ?></span>
                                        </div>
                                        <div class="content">
                                            <br>
                                            <?= $comment['comment_content'] ?>
                                        </div>
                                        <p class="info info-footer">
                                            <span class="time"><?= $comment['comment_time'] ?></span>
                                            <a class="btn-reply"
                                               href="javascript:;"
                                               onclick="btnReplyClick(this)">回复</a>
                                        </p>
                                    </div>
                                    <hr>
                                    <?php if (!empty($comment['child'])): ?>
                                        <?php foreach ($comment['child'] as $child): ?>
                                            <div class="comment-child">
                                                <img src="<?= empty($child['portrait']) ? \yii::$app->params['defaultHeadImg'] : $child['portrait']; ?>"/>
                                                <div class="info">
                                                    <span class="username">
                                                        <?= $child['nick_name'] ?>
                                                    </span>
                                                    <span>
                                                        <?= $child['comment_content'] ?>
                                                    </span>
                                                </div>
                                                <p class="info">
                                                    <span class="time"><?= $child['comment_time'] ?></span>
                                                </p>
                                            </div>
                                            <hr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    <!-- 回复表单默认隐藏 -->
                                    <div class="replycontainer layui-hide">
                                        <form class="layui-form" action="">
                                            <div class="layui-form-item">
                                                <input type="hidden" class="layui-input" name="pid"
                                                       value="<?= $comment['id'] ?>">
                                                <input type="hidden" class="layui-input" name="uid"
                                                       value="<?= $comment['uid'] ?>">
                                                <textarea name="comment_content" lay-verify="replyContent"
                                                          placeholder="请输入回复内容" class="layui-textarea"
                                                          style="min-height:80px;"></textarea>
                                            </div>
                                            <div class="layui-form-item">
                                                <button class="layui-btn layui-btn-mini"
                                                        lay-submit="formReply"
                                                        lay-filter="formReply">
                                                    提交
                                                </button>
                                            </div>
                                        </form>
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
                            <a href="<?= Url::to(['index/category', 'cid' => $key]) ?>"><?= $category ?></a>
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