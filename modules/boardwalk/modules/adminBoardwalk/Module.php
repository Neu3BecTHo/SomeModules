<?php

namespace app\modules\boardwalk\modules\adminBoardwalk;

use Yii;

/**
 * adminCommunal module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\boardwalk\modules\adminBoardwalk\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userBoardwalk->isGuest && !Yii::$app->userBoardwalk->can('admin')) {
            return Yii::$app->response->redirect(['/main/index']);
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
