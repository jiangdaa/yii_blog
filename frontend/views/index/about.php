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
                    'label' => '关于本站',
                    'url' => ['index/about'],
                    'template' => "{link}\n", //只用引用该类的模板,
                ]
            ],
            'options' => [ //设置 html 属性
                'class' => 'layui-elem-quote sitemap layui-breadcrumb shadow animated fadeInDown',
                'style' => 'margin-top:-70px;'
            ]
        ]) ?>
        <div class="blog-main">
            <div class="layui-tab layui-tab-brief shadow" lay-filter="tabAbout">
                <ul class="layui-tab-title">
                    <li lay-id="1">关于博客</li>
                    <li lay-id="2">关于作者</li>
                    <li lay-id="3" id="frinedlink">友情链接</li>
                    <li lay-id="4">留言墙</li>
                </ul>
                <div class="layui-tab-content">
                    <div class="layui-tab-item">
                        <div class="aboutinfo">
                            <div class="aboutinfo-figure">
                                <?php if (!empty(\yii::$app->params['siteConfig']['logo'])): ?>
                                    <img src="<?= \yii::$app->params['siteConfig']['logo'] ?>"
                                         alt="<?= \yii::$app->params['siteConfig']['site_name'] ?>"/>
                                <?php endif ?>
                            </div>
                            <p class="aboutinfo-nickname"><?= \yii::$app->params['siteConfig']['site_name'] ?></p>
                            <p class="aboutinfo-location">
                                <i class="fa fa-link"></i>&nbsp;&nbsp;
                                <a target="_blank" href="<?= Url::base(true) ?>">
                                    <?= Url::base(true) ?>
                                </a>
                            </p>
                            <fieldset class="layui-elem-field layui-field-title">
                                <legend>简介</legend>
                                <div class="layui-field-box aboutinfo-abstract">
                                    <p style="text-align:center;">
                                    <div>
                                        <?= empty(\yii::$app->params['siteConfig']['site_intro']) ? '暂无简介' : \yii::$app->params['siteConfig']['site_intro'] ?>
                                    </div>
                                    <h1 style="text-align:center;">The End</h1>
                                </div>
                            </fieldset>
                        </div>
                    </div><!--关于网站End-->

                    <div class="layui-tab-item">
                        <div class="aboutinfo">
                            <div class="blogerinfo-figure">
                                <img src="<?= \yii::$app->params['defaultHeadImg'] ?>" alt="JD" width="30%"/>
                            </div>
                            <p class="blogerinfo-nickname"><?= yii::$app->params['bloggerInfo']['blogger_name'] ?></p>
                            <p class="blogerinfo-introduce"><?= yii::$app->params['bloggerInfo']['blogger_signature'] ?></p>
                            <p class="blogerinfo-location">
                                <i class="fa fa-location-arrow"></i>&nbsp;
                                <?= yii::$app->params['bloggerInfo']['blogger_address'] ?>
                            </p>
                            <hr/>
                            <div class="blogerinfo-contact">
                                <a target="_blank" title="QQ交流" href="<?= yii::$app->params['bloggerInfo']['qq'] ?>">
                                    <i class="fa fa-qq fa-2x"></i>
                                </a>
                                <a target="_blank" title="给我写信" href="<?= yii::$app->params['bloggerInfo']['email'] ?>">
                                    <i class="fa fa-envelope fa-2x"></i></a>
                                <a target="_blank" title="新浪微博" href="<?= yii::$app->params['bloggerInfo']['weibo'] ?>">
                                    <i class="fa fa-weibo fa-2x"></i></a>
                                <a target="_blank" title="码云"
                                   href="<?= yii::$app->params['bloggerInfo']['github'] ?>">
                                    <i class="fa fa-git fa-2x"></i>
                                </a>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title">
                                <legend>简介</legend>
                                <div class="layui-field-box aboutinfo-abstract abstract-bloger">
                                    <h1>个人信息</h1>
                                    <div>
                                        <?= \yii::$app->params['bloggerInfo']['blogger_info'] ?>
                                    </div>
                                    <h1>个人介绍</h1>
                                    <div>
                                        <?= \yii::$app->params['bloggerInfo']['blogger_describe'] ?>
                                    </div>
                                    <h1 style="text-align:center;">The End</h1>
                                </div>
                            </fieldset>
                        </div>
                    </div><!--关于作者End-->
                    <div class="layui-tab-item">
                        <div class="aboutinfo">
                            <div class="aboutinfo-figure">
                                <img src="/frontend/images/handshake.png" alt="友情链接"/>
                            </div>
                            <p class="aboutinfo-nickname">友情链接</p>

                            <p class="aboutinfo-location">
                                <span style="color:red;"><i class="fa fa-close"></i>经常宕机&nbsp;</span>
                                <span style="color:red;"><i class="fa fa-close"></i>不合法规&nbsp;</span>
                                <span style="color:red;"><i class="fa fa-close"></i>插边球站&nbsp;</span>
                                <span style="color:red;"><i class="fa fa-close"></i>红标报毒&nbsp;</span>
                                <span style="color:green;"><i class="fa fa-check"></i>原创优先&nbsp;</span>
                                <span style="color:green;"><i class="fa fa-check"></i>技术优先</span>
                            </p>
                            <hr/>
                            <div class="aboutinfo-contact">
                                <p style="font-size:2em;">互换友链，携手并进！</p>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title">
                                <legend>Friend Link</legend>
                                <div class="layui-field-box">
                                    <ul class="friendlink">
                                        <?php foreach (\yii::$app->params['link'] as $link) : ?>
                                            <li>
                                                <a target="_blank" href="<?= $link['link_url'] ?>" title="Layui"
                                                   class="friendlink-item">
                                                    <p class="friendlink-item-pic">
                                                        <img src="<?= $link['link_logo'] ?>"
                                                             alt="<?= $link['link_name'] ?>"/>
                                                    </p>
                                                    <p class="friendlink-item-title"><?= $link['link_name'] ?></p>
                                                    <p class="friendlink-item-domain"><?= $link['link_url'] ?></p>
                                                </a>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </div>
                            </fieldset>
                        </div>
                    </div><!--友情链接End-->
                    <div class="layui-tab-item">
                        <div class="aboutinfo">
                            <div class="aboutinfo-figure">
                                <img src="/frontend/images/messagewall.png" alt="留言墙"/>
                            </div>
                            <p class="aboutinfo-nickname">留言墙</p>
                            <p class="aboutinfo-introduce">本页面可留言、吐槽、提问。欢迎灌水，杜绝广告！</p>
                            <p class="aboutinfo-location">
                                <i class="fa fa-clock-o"></i>&nbsp;<span id="time"></span>
                            </p>
                            <hr/>
                            <div class="aboutinfo-contact">
                                <p style="font-size:2em;">沟通交流，拉近你我！</p>
                            </div>
                            <fieldset class="layui-elem-field layui-field-title">
                                <legend>Leave a message</legend>
                                <div class="layui-field-box">
                                    <div class="leavemessage" style="text-align:initial">
                                        <form class="layui-form blog-editor" action="">
                                            <div class="layui-form-item">
                                            <textarea name="editorContent" lay-verify="content" id="remarkEditor"
                                                      placeholder="请输入内容" class="layui-textarea layui-hide"></textarea>
                                            </div>
                                            <div class="layui-form-item">
                                                <button class="layui-btn" lay-submit="formLeaveMessage"
                                                        lay-filter="formLeaveMessage">提交留言
                                                </button>
                                            </div>
                                        </form>
                                        <ul class="blog-comment">
                                            <li>
                                                <div class="comment-parent">
                                                    <img src="../images/Logo_40.png" alt="不落阁"/>
                                                    <div class="info">
                                                        <span class="username">不落阁</span>
                                                    </div>
                                                    <div class="content">
                                                        我为大家做了模拟留言与回复！试试吧！
                                                    </div>
                                                    <p class="info info-footer"><span
                                                                class="time">2017-03-18 18:09</span><a
                                                                class="btn-reply" href="javascript:;"
                                                                onclick="btnReplyClick(this)">回复</a></p>
                                                </div>
                                                <hr/>
                                                <div class="comment-child">
                                                    <img src="../images/Absolutely.jpg" alt="Absolutely"/>
                                                    <div class="info">
                                                        <span class="username">Absolutely</span><span>这是用户回复内容</span>
                                                    </div>
                                                    <p class="info"><span class="time">2017-03-18 18:26</span></p>
                                                </div>
                                                <div class="comment-child">
                                                    <img src="../images/Absolutely.jpg" alt="Absolutely"/>
                                                    <div class="info">
                                                        <span class="username">Absolutely</span><span>这是第二个用户回复内容</span>
                                                    </div>
                                                    <p class="info"><span class="time">2017-03-18 18:26</span></p>
                                                </div>
                                                <!-- 回复表单默认隐藏 -->
                                                <div class="replycontainer layui-hide">
                                                    <form class="layui-form" action="">
                                                        <div class="layui-form-item">
                                                        <textarea name="replyContent" lay-verify="replyContent"
                                                                  placeholder="请输入回复内容" class="layui-textarea"
                                                                  style="min-height:80px;"></textarea>
                                                        </div>
                                                        <div class="layui-form-item">
                                                            <button class="layui-btn layui-btn-mini"
                                                                    lay-submit="formReply"
                                                                    lay-filter="formReply">提交
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div><!--留言墙End-->
                </div>
            </div>
        </div>
    </div>

<?php $this->registerCssFile('/frontend/css/about.css');
$this->registerJsFile('/frontend/js/about.js', ['depends' => 'yii\web\LayerfAsset']);

?>