<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii;

class Announcement extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%announcement}}";
    }

    public function rules()
    {

        return [
            ['content', 'required', 'message' => '公告内容用不能为空'],
            ['is_disable', 'in', 'range' => ['0', '1'], 'message' => '非法操作'],
            ['is_disable', 'required', 'message' => '非法操作'],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->uid = \yii::$app->user->id;
                $this->uname = \yii::$app->user->identity->adminname;
                $this->created_time = date('Y-m-d H:i:s', time());
                return true;
            }
        }
        return false;
    }

    public function addAnnouncement($data)
    {
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    public function getAnnouncement($condition = [])
    {

        return $this->find()->where($condition)->asArray()->all();

    }


}