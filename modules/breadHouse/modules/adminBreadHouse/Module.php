<?php

namespace app\modules\breadHouse\modules\adminBreadHouse;

use Yii;

/**
 * adminBreadHouse module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\breadHouse\modules\adminBreadHouse\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userBreadHouse->isGuest || !Yii::$app->userBreadHouse->can('admin')) {
            return Yii::$app->response->redirect(['/breadHouse/main/index']);
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
