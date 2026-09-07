<?php

namespace app\modules\tours\modules\adminTours;

use Yii;

/**
 * adminTours module definition class
 * 
 * REFACTORING NOTE: This module now extends the shared base from modules/common.
 * All 8 admin modules should follow this pattern to eliminate duplication.
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\tours\modules\adminTours\controllers';
    public $layout = '@app/modules/common/views/layouts/main.php';

    public function beforeAction($action)
    {
        // Use shared authentication from userTours component
        $user = Yii::$app->userTours;
        if ($user->isGuest && !$user->can('admin')) {
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
    }
}
