<?php

namespace frontend\controllers;

use common\models\User;
use yii\helpers\Json;

class RequestController extends BaseController
{
    public $mustCheck = [];
    public $noMustCheck = ['send-check-code', 'register', 'login'];
    public $enableCsrfValidation = false;

    public function actionSendCheckCode()
    {
        $email = \yii::$app->request->post('emial');
        if (!User::checkEmail($email)) {
            return json_encode([
                'error' => '-1',
                'msg' => '邮箱已注册'
            ]);
        }
        $code = $this->generateCheckCode();
        $mailer = \Yii::$app->mailer->compose();
        $mailer->setFrom('jiangdaa@qq.com');
        $mailer->setTo($email);
        $mailer->setSubject('David_Blog 邮箱注册码');
        $mailer->setHtmlBody("<br>{$code}");
        if ($mailer->send()) {
            \yii::$app->session->set('code', $code);
            return json_encode([
                'error' => '0',
                'msg' => '邮件已发送,请查看您的邮箱'
            ]);
        }
        return json_encode([
            'error' => '-2',
            'msg' => '非法操作'
        ]);
    }

    public function actionRegister()
    {
        $post['User'] = \yii::$app->request->post();
        $model = new User;
        $msg = '';

        if ($model->register($post)) {
            return json_encode([
                'error' => '0',
                'msg' => '账号注册成功'
            ]);
        }
        foreach ($model->getErrors() as $errors) {
            foreach ($errors as $error) {
                $msg .= $error . ',';
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => substr($msg, 0, strlen($msg) - 1)
        ]);

    }


    public function actionLogin()
    {
        $post['User'] = \yii::$app->request->post();
        $model = new User;
        $msg = '';
        if ($model->login($post)) {
            return json_encode(['error' => '0', 'msg' => '登陆成功']);
        }
        foreach ($model->getErrors() as $errors) {
            foreach ($errors as $error) {
                $msg .= $error . ',';
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => substr($msg, 0, strlen($msg) - 1)
        ]);
    }




    private function generateCheckCode()
    {

        return substr(round(substr(time(), -6) * rand(1, 99) / 8), -6);
    }


}