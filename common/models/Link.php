<?php

namespace common\models;

use yii\db\ActiveRecord;

class Link extends ActiveRecord
{

    public $file;

    public static function tableName()
    {
        return '{{%link}}';
    }

    public function rules()
    {

        return [
            ['link_name', 'required', 'message' => '友情链接名称不能为空', 'on' => ['add']],
            ['link_url', 'required', 'message' => '友情链接地址不能为空', 'on' => ['add']],
            ['link_logo', 'required', 'message' => '友情链接logo不能为空', 'on' => ['add']],
            [['file'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false, 'on' => 'upload'],
        ];
    }

    public function addLink($data)
    {
        $this->scenario = 'add';
        if ($this->load($data) && $this->save($data)) {
            return true;
        }
        return false;
    }

    public function editLink()
    {


    }

}