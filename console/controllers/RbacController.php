<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    // yii rbac/init
    // category/* category/add category/delete

    public function actionInit()
    {

        $trans = Yii::$app->db->beginTransaction();
        try {
            $dir = dirname(dirname(dirname(__FILE__))) . '/backend/controllers';
            $controllers = glob($dir . '/*');
            $permissions = [];
            foreach ($controllers as $controller) {
                $content = file_get_contents($controller);
                preg_match('/class ([a-zA-Z]+)Controller/', $content, $match);
                $cName = $match[1];
                //$permissions[] = strtolower($cName . '/*');
                preg_match_all('/public function action([a-zA-Z_]+)/', $content, $matches);
                foreach ($matches[1] as $aName) {

                    switch ($cName) {
                        case 'base':
                        case 'admin':
                        case 'error':
                            continue;
                        default:
                            if ($aName != 's') {
                                $permissions[] = $this->humpTo_($cName) . '/' . $this->humpTo_($aName);
                            }
                    }

                }
            }
            $auth = Yii::$app->authManager;
            foreach ($permissions as $permission) {
                if (!$auth->getPermission($permission)) {
                    $obj = $auth->createPermission($permission);
                    $obj->description = $permission;
                    $auth->add($obj);
                }
            }
            $trans->commit();
            echo "import success \n";
        } catch (\Exception $e) {
            $trans->rollback();
            echo "import failed \n";
        }
    }


    public function humpTo_($str)
    {
        $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
            return '-' . strtolower($matchs[0]);
        }, $str);
        return trim(preg_replace('/-{2,}/', '-', $dstr), '-');
    }

}




