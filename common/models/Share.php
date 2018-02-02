<?php

namespace common\models;

use yii\db\ActiveRecord;

class Share extends ActiveRecord
{

    public $file;

    public static function tableName()
    {

        return "{{%share}}";
    }

    public function rules()
    {
        return [
            ['share_name', 'required', 'message' => '要分享的资源名称不能为空', 'on' => ['add']],
            ['share_name', 'unique', 'message' => '要分享的资源名称已存在', 'on' => ['add']],
            ['share_describe', 'required', 'message' => '描述不能为空', 'on' => ['add']],
            ['cid', 'required', 'message' => '分类不能为空', 'on' => ['add']],
            ['author', 'required', 'message' => '作者不能为空', 'on' => ['add']],
            ['cover', 'required', 'message' => '封面不能为空', 'on' => ['add']],
            [['file'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false, 'on' => 'upload'],
        ];
    }

    public function beforeSave($inset)
    {
        if (parent::beforeSave($inset)) {
            $cname = Category::find()->where(['id' => $this->cid])->one()['name'];
            $this->category = $cname;
            return true;
        }
        return false;
    }

    public function addShare($data)
    {
        $this->scenario = 'add';
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }


}