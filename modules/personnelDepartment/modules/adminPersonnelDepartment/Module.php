<?php

namespace app\modules\personnelDepartment\modules\adminPersonnelDepartment;

use Yii;

/**
 * adminCommunal module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\personnelDepartment\modules\adminPersonnelDepartment\controllers';
    public $layout = 'main';

    public function beforeAction($action)
    {
        if (Yii::$app->userPersonnelDepartment->isGuest && !Yii::$app->userPersonnelDepartment->can('admin')) {
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
