<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public $check_code;
    public $file;

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            ['password', 'required', 'message' => '密码不能为空', 'on' => ['register', 'login']],
            ['email', 'email', 'message' => '邮箱格式不正确', 'on' => ['register', 'login']],
            ['email', 'unique', 'message' => '邮箱已被注册', 'on' => ['register']],
            ['nick_name', 'required', 'message' => '昵称不能为空', 'on' => ['register', 'edit']],
            ['nick_name', 'unique', 'message' => '昵称已存在', 'on' => ['register', 'edit']],
            ['check_code', 'verifyEmailCode', 'on' => ['register']],
            [['portrait', 'ip', 'login_time', 'created_time', 'state'], 'safe'],
            [['file'], 'file', 'extensions' => 'jpg,png', 'checkExtensionByMimeType' => false, 'on' => 'upload'],
        ];

    }

    public function validatePassword()
    {
        $this->scenario = 'login';
        $pass = sha1(md5($this->password) . 'David');
        $result = $this->find()->where('(user_name=:email or email = :email) and password = :password ', [
            ':email' => $this->email,
            ':password' => $pass
        ])->one();
        if (empty($result)) {
            return $this->addError('password', '密码错误');
        }
        return $result;

    }

    public function verifyEmailCode()
    {
        $this->scenario = 'register';
        if (!$this->hasErrors()) {
            if ($this->check_code !== yii::$app->session->get('code')) {
                $this->addError('check_code', '邮箱验证码不正确');
                return false;
            }
        }
        return true;
    }

    public static function checkEmail($email)
    {
        if ((self::find()->where('email = :email or user_name=:email', [':email' => $email])->count()) != 1) {
            return true;
        }
        return false;
    }

    public function register($data, $rand_portrait)
    {
        $this->scenario = 'register';
        if ($this->load($data) && $this->validate($data) && $this->verifyEmailCode()) {
            $this->password = sha1(md5($this->password) . 'David');
            $this->created_time = date('Y-m-d H:i:s', time());
            $this->user_name = $this->email;
            $this->state = '0';
            $this->portrait = $rand_portrait;
            return $this->save();
        }
        return false;

    }

    public function login($data)
    {
        $this->scenario = 'login';
        $checkResult = null;
        if ($this->load($data) && $this->validate() && $checkResult = $this->validatePassword()) {
            if (\yii::$app->user->login($checkResult)) {
                return (bool)$this->updateAll(['ip' => ip2long(\yii::$app->request->userIP), 'login_time' => date('Y-m-d H:i:s', time())], ['id' => \yii::$app->user->id]);
            }
        }

        return false;
    }


    private function checkBlacklist()
    {

        if (\yii::$app->user->id === '1') {
            $this->addError('user_name', '账号已被禁用');
            return false;
        }
        return true;

    }


    public static function findIdentity($id)
    {

        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return '';
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }

}
