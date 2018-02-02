<?php

namespace common\models;

use yii\db\ActiveRecord;

class Category extends ActiveRecord
{

    public static function tableName()
    {

        return '{{%category}}';
    }

    public function rules()
    {
        return [
            ['name', 'required', 'message' => '分类名称不能为空'],
            ['name', 'unique', 'message' => '分类已存在'],
            ['type', 'required', 'message' => '类型不能为空']
        ];
    }

    public static function getAllCategory($conversion = true,$condition = ['type'=>'category'])
    {
        $result = self::find()->where($condition)->asArray()->all();
        if (!$conversion) {
            return $result;
        }
        $return = [];
        foreach ($result as $k => $v) {
            $return[$v['id']] = $v['name'];
        }
        return $return;
    }


}