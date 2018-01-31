<?php

namespace backend\models;

use yii\db\ActiveRecord;
use yii;

class Rbac extends ActiveRecord
{

    public static function getOptions($data, $parent)
    {

        $return = [];
        foreach ($data as $obj) {
            if (!empty($parent) && $parent->name != $obj->name && yii::$app->authManager->canAddChild($parent, $obj)) {
                $return[$obj->name] = $obj->description;
            }

            if (is_null($parent)) {
                $return[$obj->name] = $obj->description;
            }
        }

        return $return;
    }

    public static function addChild($children, $name)
    {
        $auth = yii::$app->authManager;
        $itemObj = $auth->getRole($name);
        if (empty($itemObj)) {
            return false;
        }
        $tran = yii::$app->db->beginTransaction();
        try {
            $auth->removeChildren($itemObj);
            foreach ($children as $item) {
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->addChild($itemObj, $obj);
            }
            $tran->commit();

        } catch (\Exception $e) {
            $tran->rollback();
            return false;
        }
        return true;
    }

    public static function getChildByName($name)
    {
        $return = [];
        $return['roles'] = [];
        $return['permission'] = [];
        $auth = yii::$app->authManager;
        $children = $auth->getChildren($name);
        if (empty($children)) {
            return [];
        }

        foreach ($children as $obj) {
            if ($obj->type == 1) {
                $return['roles'][] = $obj->name;
            } else {
                $return['permissions'][] = $obj->name;
            }
        }
        return $return;
    }

    private static function _getItemByUser($adminid, $type)
    {
        $fn = 'getPermissionsByUser';
        if ($type == 1) {
            $fn = 'getRolesByUser';
        }
        $data = [];
        $auth = yii::$app->authManager;
        $items = $auth->$fn($adminid);
        foreach ($items as $item) {
            $data[] = $item->name;
        }
        return $data;
    }


    public static function getChildrenByUser($adminid)
    {
        $return = [];
        $return['roles'] = self::_getItemByUser($adminid, 1);
        $return['permissions'] = self::_getItemByUser($adminid, 2);
        return $return;
    }


    public static function grant($adminid, $children)
    {
        $trans = yii::$app->db->beginTransaction();
        try {
            $auth = yii::$app->authManager;
            $auth->revokeAll($adminid);
            foreach ($children as $item) {
                $obj = empty($auth->getRole($item)) ? $auth->getPermission($item) : $auth->getRole($item);
                $auth->assign($obj, $adminid);
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollback();
            return false;
        }
        return true;
    }


}

