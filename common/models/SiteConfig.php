<?php

namespace common\models;

use yii\db\ActiveRecord;

class SiteConfig extends ActiveRecord
{

    public $file;

    public static function tableName()
    {
        return "{{%site_config}}";
    }

    public function rules()
    {
        return [
            ['site_name', 'required', 'message' => '网站标题不能为空', 'on' => 'edit'],
            ['keyword', 'required', 'message' => '网站seo关键字不能为空', 'on' => 'edit'],
            ['logo', 'required', 'message' => 'logo不能为空', 'on' => 'edit'],
            ['copyright', 'required', 'message' => '请输入网站版权', 'on' => 'edit'],
            ['icp', 'required', 'message' => '请输入网站备案信息', 'on' => 'edit'],
            ['title_suffix', 'required', 'message' => '请输入网站标题后缀', 'on' => 'edit'],
            ['site_intro', 'safe'],
            [['file'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false, 'on' => 'upload'],
        ];
    }

    public function editSiteConfig($data)
    {
        $this->scenario = 'edit';
        if ($this->load($data) && $this->validate()) {
            unset($data['SiteConfig']['file']);
            return (bool)$this->updateAll($data['SiteConfig'], ['id' => '1']);
        }
        return false;
    }


}
