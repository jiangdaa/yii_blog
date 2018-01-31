<?php

namespace common\models;

use yii\db\ActiveRecord;

class Article extends ActiveRecord
{

    public $file;

    public static function tableName()
    {

        return '{{%article}}';
    }

    public function rules()
    {
        return [
            ['title', 'required', 'message' => '标题不能为空', 'on' => 'addArticle'],
            ['content', 'required', 'message' => '内容不能为空', 'on' => 'addArticle'],
            [['stick', 'count', 'praise'], 'integer', 'message' => '只能是数字', 'on' => 'addArticle'],
            [['recommend', 'state', 'existdel'], 'in', 'range' => ['0', '1'], 'message' => '非法操作', 'on' => 'addArticle'],
            ['category', 'required', 'message' => '文章分类不能为空', 'on' => 'addArticle'],
            [['issuetime', 'updatetime', 'author', 'cover'], 'safe'],
            [['file'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false, 'on' => 'upload'],
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $date = date('Y-m-d H:i:s', time());

            if ($this->isNewRecord) {
                $this->issuetime = $date;
                $this->updatetime = $date;
                $this->author = \yii::$app->user->identity->adminname;
                return true;
            } else {
                $this->updatetime = $date;
                $this->author = \yii::$app->user->identity->adminname;
                return true;
            }
        }
        return false;

    }


    public function addArticle($data)
    {
        $this->scenario = 'addArticle';
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }




}