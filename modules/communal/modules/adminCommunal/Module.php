<?php

namespace app\modules\communal\modules\adminCommunal;

use Yii;

/**
 * adminCommunal module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\communal\modules\adminCommunal\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userCommunal->isGuest || !Yii::$app->userCommunal->can('admin')) {
            return Yii::$app->response->redirect(['/communal/main/index']);
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
