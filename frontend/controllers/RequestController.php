<?php

namespace frontend\controllers;

use common\models\Comment;
use common\models\LeaveMsg;
use common\models\User;
use yii\helpers\Json;

/**
 * -------------------------------------------
 *
 * Class RequestController      ajax 请求放在这个类
 * @package frontend\controllers
 *
 * -------------------------------------------
 */
class RequestController extends BaseController
{
    public $mustCheck = ['leave-msg', 'reply', 'comment', 'comment-reply'];
    public $noMustCheck = ['send-check-code', 'register', 'login', 'leave-msg', 'reply', 'comment', 'comment-reply'];
    public $enableCsrfValidation = false;

    /**
     * -------------------------------------------
     * actionSendCheckCode  发送邮箱验证码
     * @return mixed
     * -------------------------------------------
     */
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

    /**
     * -------------------------------------------
     * actionRegister  账号注册
     * @return mixed
     * -------------------------------------------
     */
    public function actionRegister()
    {
        $post['User'] = \yii::$app->request->post();
        $model = new User;
        $msg = '';
        if ($model->register($post, $this->randPortrait())) {
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

    /**
     * -------------------------------------------
     * actionLogin  账号登录
     * @return mixed
     * -------------------------------------------
     */

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

    /**
     * -------------------------------------------
     * actionLeaveMsg  博客留言
     * @return mixed
     * -------------------------------------------
     */
    public function actionLeaveMsg()
    {
        if (\yii::$app->user->isGuest) {

            return json_encode([
                'error' => '-1',
                'msg' => '请登陆后在留言'
            ]);
        } else {
            $model = new LeaveMsg;
            $post['LeaveMsg'] = \yii::$app->request->post();

            if ($model->addLeaveMsg($post)) {
                $data = $model->find()
                    ->select('{{%user}}.nick_name,,{{%user}}.ip,{{%user}}.portrait,{{%leave_msg}}.*')
                    ->leftJoin('{{%user}}', '{{%user}}.id = {{%leave_msg}}.uid')
                    ->where(['uid' => $post['LeaveMsg']['uid']])
                    ->orderBy('leave_msg_time desc')
                    ->asArray()
                    ->one();
                return json_encode([
                    'error' => '0',
                    'msg' => '留言成功',
                    'data' => $data
                ]);
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => '非法操作'
        ]);
    }

    /**
     * -------------------------------------------
     * actionReply  博客回复
     * @return mixed
     * -------------------------------------------
     */
    public function actionReply()
    {
        if (\yii::$app->user->isGuest) {
            return json_encode([
                'error' => '-1',
                'msg' => '请登陆后在回复'
            ]);
        } else {
            $model = new LeaveMsg;
            $post['LeaveMsg'] = \yii::$app->request->post();

            if ($model->addLeaveMsg($post)) {
                $data = $model->find()
                    ->select('{{%user}}.nick_name,,{{%user}}.ip,{{%user}}.portrait,{{%leave_msg}}.*')
                    ->leftJoin('{{%user}}', '{{%user}}.id = {{%leave_msg}}.uid')
                    ->where(['uid' => $post['LeaveMsg']['uid']])
                    ->orderBy('leave_msg_time desc')
                    ->asArray()
                    ->one();
                return json_encode([
                    'error' => '0',
                    'msg' => '回复成功',
                    'data' => $data
                ]);
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => '非法操作'
        ]);
    }

    /**
     * -------------------------------------------
     * actionComment  文章评论
     * @return mixed
     * -------------------------------------------
     */
    public function actionComment()
    {

        if (\yii::$app->user->isGuest) {
            return json_encode([
                'error' => '-1',
                'msg' => '请登陆后在回复'
            ]);
        } else {
            $model = new Comment;
            $post['Comment'] = \yii::$app->request->post();
            if ($model->addComment($post)) {
                $data = $model->find()
                    ->select('{{%user}}.nick_name,,{{%user}}.ip,{{%user}}.portrait,{{%comment}}.*')
                    ->leftJoin('{{%user}}', '{{%user}}.id = {{%comment}}.uid')
                    ->where(['uid' => $post['Comment']['uid']])
                    ->orderBy('comment_time desc')
                    ->asArray()
                    ->one();
                return json_encode([
                    'error' => '0',
                    'msg' => '评论成功',
                    'data' => $data
                ]);
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => '非法操作'
        ]);

    }

    /**
     * -------------------------------------------
     * actionCommentReply  文章评论回复
     * @return mixed
     * -------------------------------------------
     */
    public function actionCommentReply()
    {
        if (\yii::$app->user->isGuest) {
            return json_encode([
                'error' => '-1',
                'msg' => '请登陆后在回复'
            ]);
        } else {
            $model = new Comment;
            $post['Comment'] = \yii::$app->request->post();
            if ($model->addComment($post)) {
                $data = $model->find()
                    ->select('{{%user}}.nick_name,,{{%user}}.ip,{{%user}}.portrait,{{%comment}}.*')
                    ->leftJoin('{{%user}}', '{{%user}}.id = {{%comment}}.uid')
                    ->where(['uid' => $post['Comment']['uid']])
                    ->orderBy('comment_time desc')
                    ->asArray()
                    ->one();
                return json_encode([
                    'error' => '0',
                    'msg' => '回复成功',
                    'data' => $data
                ]);
            }
        }
        return json_encode([
            'error' => '-2',
            'msg' => '非法操作'
        ]);
    }

    /**
     * -------------------------------------------
     * generateCheckCode  生成随机邮箱验证码
     * @return int
     * -------------------------------------------
     */
    private function generateCheckCode()
    {
        return substr(round(substr(time(), -6) * rand(1, 99) / 8), -6);
    }

    /**
     * -------------------------------------------
     * randPortrait  生成随头像地址
     * @return string
     * -------------------------------------------
     */
    private function randPortrait()
    {
        $portraitUrl = dirname(dirname(__FILE__)) . '/web/frontend/default_portrait/';
        $resource = scandir($portraitUrl);
        unset($resource[0]);
        unset($resource[1]);
        return \yii\helpers\Url::base(true) . '/frontend/default_portrait/' . $resource[array_rand($resource, 1)];
    }


}