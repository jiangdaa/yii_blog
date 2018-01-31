<?php

namespace common\components;

use Yii;
use yii\web\UrlManager;

class MultipleAppUrlManager extends UrlManager
{
    public $apps = [];

    public function init()
    {
        if (isset($this->apps[Yii::$app->id])) {
            $currentAppConfig = $this->apps[Yii::$app->id];
            foreach ($currentAppConfig as $attribute => $value) {
                $this->$attribute = $value;
            }
        }

        parent::init();
    }

    /**
     * @param array $params
     * @param null $appId
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function createUrl($params = [], $appId = null)
    {
        if ($appId === null || $appId === Yii::$app->id) {
            return parent::createUrl($params);
        } else {
            if (!isset($this->apps[$appId])) {
                throw new \yii\base\InvalidConfigException('Please configure UrlManager of apps "' . $appId . '".');
            }
            $appUrlManager = $this->_loadOtherAppInstance($appId);

            return $appUrlManager->createUrl($params);
        }
    }

    /**
     * @param array|string $params
     * @param null $scheme
     * @param null $appId
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function createAbsoluteUrl($params, $scheme = null, $appId = null)
    {
        if ($appId === null || $appId === Yii::$app->id) {
            return parent::createAbsoluteUrl($params, $scheme);
        } else {
            if (!isset($this->apps[$appId])) {
                throw new \yii\base\InvalidConfigException('Please configure UrlManager of apps "' . $appId . '".');
            }
            $appUrlManager = $this->_loadOtherAppInstance($appId);

            return $appUrlManager->createAbsoluteUrl($params);
        }
    }

    private $_appInstances = [];

    /**
     * @param string $appId
     * @return UrlManager
     * @throws \yii\base\InvalidConfigException
     */
    private function _loadOtherAppInstance($appId)
    {
        if (!isset($this->_appInstances[$appId])) {
            $this->_appInstances[$appId] = Yii::createObject([
                    'class' => '\yii\web\UrlManager',
                ] + $this->apps[$appId]);
        }

        return $this->_appInstances[$appId];
    }

    public function getHostInfo($appId = null)
    {
        if ($appId === null || $appId === Yii::$app->id) {
            return parent::getHostInfo();
        } else {
            $appUrlManager = $this->_loadOtherAppInstance($appId);

            return $appUrlManager->getHostInfo();
        }
    }
}