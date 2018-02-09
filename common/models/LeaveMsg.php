<?php

namespace common\models;

use yii\db\ActiveRecord;

class LeaveMsg extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%leave_msg}}';
    }

    public function rules()
    {

        return [
            [['uid', 'id', 'pid'], 'integer', 'message' => '非法操作'],
            ['leave_msg_time', 'safe'],
            ['leave_msg', 'required', 'message' => '留言不能为空']
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->leave_msg_time = date('Y-m-d H:i:s', time());
            return true;
        }
        return false;
    }

    public function addLeaveMsg($data)
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


    public function disFormat()
    {
        $obj = $this->find();
        $obj->joinWith('user');
        $result = $obj->select('{{%leave_msg}}.*,{{%user}}.nick_name ,{{%user}}.portrait')->asArray()->all();
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