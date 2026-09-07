<?php

namespace app\modules\cleaner\modules\adminCleaner;

use Yii;

/**
 * adminCleaner module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\cleaner\modules\adminCleaner\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userCleaner->isGuest || !Yii::$app->userCleaner->identity->can('admin')) {
            return Yii::$app->response->redirect(['/cleaner/main/index']);
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
