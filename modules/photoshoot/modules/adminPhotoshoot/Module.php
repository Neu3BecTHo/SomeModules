<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot;

use Yii;

/**
 * adminPhotoshoot module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\photoshoot\modules\adminPhotoshoot\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userPhotoshoot->isGuest || !Yii::$app->userPhotoshoot->identity->is_admin) {
            return Yii::$app->response->redirect(['/photoshoot/main/index']);
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
