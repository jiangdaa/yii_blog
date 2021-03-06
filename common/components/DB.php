<?php

namespace common\components;



/**
 * -------------------------------------------
 *
 *  @class DB 单例模式
 *
 * -------------------------------------------
 */
class DB
{

    static protected $ins = [];

    static public function getInstance()
    {
        $cName = get_called_class();
        if (!isset(static::$ins[$cName])) {
            static::$ins[$cName] = new $cName;
        }
        return static::$ins[$cName];
    }

}