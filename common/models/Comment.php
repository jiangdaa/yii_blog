<?php

namespace common\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%comment}}";
    }

    public function rules()
    {
        return [
            [['aid', 'pid', 'uid'], 'integer', 'message' => '非法操作'],
            ['comment_content', 'required', 'message' => '评论内容不能为空'],
            ['comment_time', 'safe']
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->comment_time = date('Y-m-d H:i:s', time());
            return true;
        }
        return false;
    }


    public function addComment($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'uid']);
    }

    public function disFormat($aid)
    {
        $obj = $this->find();
        $obj->joinWith('user');
        $result = $obj->select('{{%comment}}.*,{{%user}}.nick_name ,{{%user}}.portrait')->where(['aid' => $aid])->asArray()->all();
        $parent = [];
        $return = [];
        foreach ($result as $v_result) {
            if ($v_result['pid'] == 0) {
                unset($v_result['user']);
                $return[] = $v_result;
            }
        }

        foreach ($return as $k_return => $v_return) {
            foreach ($result as $k_result => $v_result) {
                if ($v_return['id'] == $v_result['pid']) {
                    unset($v_result['user']);
                    $return[$k_return]['child'][] = $v_result;
                }
            }
        }

        return $return;


    }

}