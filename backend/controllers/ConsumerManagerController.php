<?php
/**
 * Created by IntelliJ IDEA.
 * User: JiangDa
 * Date: 2018/1/22
 * Time: 11:19
 */

namespace backend\controllers;

use common\models\User;
use yii\data\ActiveDataProvider;

/**
 * -------------------------------------------
 *
 * Class ConsumerManagerController  用户管理类
 * @package backend\controllers
 *
 * -------------------------------------------
 */
class ConsumerManagerController extends BaseController
{
    public function actionBackendConsumer()
    {


        return $this->render('backend-consumer', []);
    }

    public function actionFrontendConsumer()
    {

        $gridViewData = new ActiveDataProvider([
            'query' => User::find(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('frontend-consumer', ['gridViewData' => $gridViewData]);
    }

    public function actionBlacklist()
    {

        $uid = (int)\yii::$app->request->get('uid');
        if (empty($uid)) {
            throw new \Exception('参数错误');
        }

        $state = User::find()->where(['id' => $uid])->one()['state'];

        if (User::updateAll(['state' => $state === '0' ? '1' : '0'], ['id' => $uid])) {
            \yii::$app->session->setFlash('info', '处理成功');
        } else {
            \yii::$app->session->setFlash('error', '处理失败');
        }
        return $this->redirect(['frontend-consumer']);
    }

    public function actionUserDelete()
    {

        $uid = (int)\yii::$app->request->get('uid');
        $ifrid = (int)\yii::$app->request->get('ifrid');

        if (empty($uid)) {
            throw new \Exception('参数错误');
        }
        if (User::deleteAll(['id' => $uid])) {
            \yii::$app->session->setFlash('info', '用户删除成功');
        } else {
            \yii::$app->session->setFlash('error', '用户删除失败');
        }
        return $this->redirect(['frontend-consumer?iframe-id=' . $ifrid]);


    }


}