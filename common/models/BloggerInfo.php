<?php

namespace common\models;

use yii;
use yii\db\ActiveRecord;

class BloggerInfo extends ActiveRecord
{


    public static function tableName()
    {
        return "{{%blogger_info}}";
    }

    public function rules()
    {
        return [
            ['blogger_name', 'required', 'message' => '博主名称不能为空'],
            ['blogger_signature', 'required', 'message' => '博主个性签名不能为空'],
            ['blogger_address', 'required', 'message' => '博主地址不能为空'],
            [['qq', 'email', 'github', 'weibo'], 'safe']
        ];
    }


    public function editBlogger($data)
    {
        if ($this->load($data) && $this->validate()) {
            return $this->updateAll($data['BloggerInfo'],['id' => 1]);

        }
        return false;


    }


}