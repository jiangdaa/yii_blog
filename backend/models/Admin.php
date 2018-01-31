<?php
/**
 * Created by IntelliJ IDEA.
 * User: JiangDa
 * Date: 2018/1/21
 * Time: 10:05
 */

namespace backend\models;

use yii\db\ActiveRecord;
use yii\web\Cookie;
use yii\web\IdentityInterface;

class Admin extends ActiveRecord implements IdentityInterface
{
    public $verifyCode;
    public $remember = 1;
    public $loginuser;

    public static function tableName()
    {

        return '{{%admin}}';
    }

    public function rules()
    {
        return [
            ['loginuser', 'required', 'message' => '登录名不能为空'],
            ['adminpassword', 'required', 'message' => '登录密码不能为空'],
            ['verifyCode', 'captcha', 'captchaAction' => 'login/captcha', 'message' => '验证码错误'],
            ['remember', 'in', 'range' => ['0', '1'], 'message' => '非法操作'],
            ['adminpassword', 'validatePassword'],
        ];
    }

    public function validatePassword()
    {

        if (!$this->hasErrors()) {
            $username = $this->loginuser;
            if (!$this->find()
                ->where("(adminname=:adminname or adminemail=:adminemail) and adminpassword=:adminpassword", [
                    'adminname' => $username,
                    'adminemail' => $username,
                    'adminpassword' => md5($this->adminpassword)
                ])->one()) {

                $this->addError('adminpassword', '账号或密码错误');
            }
        }
    }


    public function login($data)
    {

        if ($this->load($data) && $this->validate()) {
            if (!empty($this->remember)) {

                return \yii::$app->user->login($this->selfObj());
//                $cookie = new Cookie;
//                $cookie->name = 'remember';
//                $cookie->value = '1';
//                $cookie->expire = time() * 3600 * 24 * 7;
//                $cookie->httpOnly  = true;
//                \yii::$app->response->cookies->add($cookie);
            }
            return true;


        }
        return false;
    }

    private function selfObj()
    {
        return self::find()->where("adminname=:adminname or adminemail=:adminemail", [
            ':adminname' => $this->loginuser,
            ':adminemail' => $this->loginuser
        ])->one();
    }

    public static function a(){

    }



    public static function findIdentity($id)
    {
        return static::findOne($id);
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