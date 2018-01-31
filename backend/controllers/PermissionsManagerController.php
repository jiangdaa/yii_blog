<?php
/**
 * Created by IntelliJ IDEA.
 * User: JiangDa
 * Date: 2018/1/22
 * Time: 11:42
 */

namespace backend\controllers;

use yii\data\ActiveDataProvider;
use yii\db\Query;
use backend\models\Rbac;
use backend\models\Admin;

/*
 * 权限管理
 */

class PermissionsManagerController extends BaseController
{

    public $layout = 'main';

    public function actionAddRole()
    {
        if (\yii::$app->request->isPost) {
            $auth = \yii::$app->authManager;
            $role = $auth->createRole(null);
            $post = \yii::$app->request->post();
            if (empty($post['name']) || empty($post['description'])) {
                throw new \Exception('参数错误');
            }
            $role->name = $post['name'];
            $role->description = $post['description'];
            $role->ruleName = empty($post['rule_name']) ? null : $post['rule_name'];
            $role->data = empty($post['data']) ? null : $post['data'];
            if ($auth->add($role)) {
                \yii::$app->session->setFlash('info', '添加成功');
            }
        }
        return $this->render('add-role', []);
    }

    public function actionRoleList()
    {

        $auth = \yii::$app->authManager;
        $data = new ActiveDataProvider([
            'query' => (new Query)->from($auth->itemTable)->where('type=1')->orderBy('created_at desc'),
            'pagination' => [
                'pageSize' => 5
            ]
        ]);

        return $this->render('role-list', ['dataProvider' => $data]);

    }

    public function actionAssignPermission($name)
    {
        $name = htmlspecialchars($name);
        $auth = \yii::$app->authManager;
        $parent = $auth->getRole($name);
        $roles = Rbac::getOptions($auth->getRoles(), $parent);
        $permissions = Rbac::getOptions($auth->getPermissions(), $parent);
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            if (Rbac::addChild($post['children'], $name)) {
                \yii::$app->session->setFlash('info', '分配成功');
            }
        }
        $children = Rbac::getChildByName($name);
        return $this->render('assign-permission', ['parent' => $parent, 'roles' => $roles, 'permissions' => $permissions, 'children' => $children]);
    }

    public function actionAssignAuth($adminid)
    {
        $adminid = (int)$adminid;
        if (empty($adminid)) {
            throw new \Exception('参数错误');
        }
        $admin = Admin::findOne($adminid);
        if (empty($admin)) {
            throw new \yii\web\NotFoundHttpException('admin not found');
        }
        $auth = \yii::$app->authManager;

        $roles = Rbac::getOptions($auth->getRoles(), null);
        $permissions = Rbac::getOptions($auth->getPermissions(), null);
        if (\yii::$app->request->isPost) {
            $post = \yii::$app->request->post();
            $children = !empty($post['children']) ? $post['children'] : [];
            if (Rbac::grant($adminid, $children)) {
                \yii::$app->session->setFlash('info', '权限分配成功');
            }
        }
        $children = Rbac::getChildrenByUser($adminid);

        return $this->render('assign-auth', [
            'roles' => $roles,
            'permissions' => $permissions,
            'admin' => $admin,
            'children' => $children
        ]);

    }


}