<?php

namespace common\models;

use Yii;
use common\models\BloggerInfo;

/**
 * This is the model class for table "{{%article}}".
 **/
class AdminLog extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin_log}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'log_title' => '动作',
            'add_time' => '操作时间',
            'admin_name' => '操作人',
            'admin_ip' => 'ip',
            'admin_agent' => '浏览器',
            'controller' => '控制器',
            'log_info' => '日志信息',
            'type' => '类型',
            'model' => '表名',
            'action' => '方法',
            'objId' => '数据id',

        ];
    }


    public static function saveLog($controller, $action, $table, $log_title, $type, $result, $objId)
    {
        $model = new self;
        $model->admin_ip = Yii::$app->request->userIP;
        $headers = Yii::$app->request->headers;
        $model->add_time = time();
        if ($headers->has('User-Agent')) {
            $model->admin_agent = $headers->get('User-Agent');
        }
        $model->admin_id = Yii::$app->user->identity->id;
        $model->admin_name = 'David';
        $model->model = $table;
        $model->controller = $controller;
        $model->action = $action;
        $model->log_info = $result;
        $model->log_title = $log_title;
        $model->handle_id = $objId;
        $model->type = $type;
        $model->save(false);
    }
}