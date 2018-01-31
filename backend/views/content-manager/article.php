<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$gather = yii::$app->Gather;
?>
<blockquote class="layui-elem-quote layui-quote-nm">
    <a class="layui-btn" href="<?= Url::to(['add-article']) ?>">添加文章</a>
</blockquote>
<?php
echo GridView::widget([
    'dataProvider' => $gridData,
    'options' => [
        'class' => 'layui-table',
        'style' => 'width:100%;'
    ],
    'tableOptions' => [
        'style' => 'width:100%;'
    ],
    'columns' => [

        'id',
        [
            'label' => '文章标题',
            'attribute' => 'title',
            'contentOptions' => [
                'width' => '30%'
            ],
        ],
        [
            'label' => '文章置顶',
            'attribute' => 'stick',
            'value' => function ($model) {
                return $model['stick'] == 0 ? '不置顶' : '置顶';
            }
        ],
        [
            'label' => '文章推荐',
            'attribute' => 'recommend',
            'value' => function ($model) {
                return $model['recommend'] == 0 ? '不推荐' : '推荐';
            }
        ],
        'count:text:浏览量',
        'praise:text:点赞数',
        'author:text:文章作者',
        'name:text:文章分类',
        'issuetime:text:发布时间',
        'updatetime:text:修改时间',
        [
            'label' => '文章审核',
            'attribute' => 'state',
            'value' => function ($model) {
                return $model['state'] == 0 ? '未审核' : '已审核';
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{update}  {delete} {preview}',
            'buttons' => [
                'update' => function ($url, $model, $key) {
                    return Html::a('修改', ['edit-article', 'aid' => $model['id']]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('删除', null, ['class' => 'delete', 'aid' => $model['id']]);
                },
                'preview' => function () {
                    return Html::a('预览', ['preview']);
                }
            ]
        ]
    ],
    'layout' => "{items}" . $gather->pager('pagerLayout'),
    'pager' => $gather->pager('pagerConfig')

]);

$this->registerCss($gather->pager('css'));
$delurl = Url::to(['delete-article']);
$ifid = yii::$app->request->get('iframe-id');
$js = yii::$app->Prompt->jsString([
    'appendJs' => "
        var iframe = $('iframe',window.parent.document);
        $('.delete').on('click',function(){
            var aid = $(this).attr('aid');
            layer.confirm('确定删除该文章？', {
              btn: ['确定','取消']
            }, function(){
                $.each(iframe,function(i){
                    if(iframe.eq(i).attr('iframe-id')=='{$ifid}'){
                       iframe.eq(i).attr('src','{$delurl}?ifrid={$ifid}&aid='+aid);
                    }
                });
            });
        });
      "
]);

$this->registerJs($js);

?>

