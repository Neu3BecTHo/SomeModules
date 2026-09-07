<?php

namespace app\modules\beauty\modules\adminBeauty;

use Yii;
use yii\base\Module as BaseModule;

/**
 * adminBeauty module definition class
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\beauty\modules\adminBeauty\controllers';

    /**
     * {@inheritdoc}
     */
    public $layout = 'main';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // Check if user is logged in with userBeauty component
        if (Yii::$app->userBeauty->isGuest) {
            Yii::$app->session->setFlash('error', 'Необходимо войти в систему');
            return Yii::$app->response->redirect(['/beauty/auth/login']);
        }

        $user = Yii::$app->userBeauty->identity;
        $controller = $action->controller->id;

        // Admin has access to everything
        if ($user->role === 'admin') {
            return true;
        }

        // Master can only access their own cabinet
        if ($user->role === 'master') {
            if ($controller === 'master-cabinet') {
                return true;
            }
            // Masters trying to access admin controllers
            Yii::$app->session->setFlash('error', 'Доступ запрещен');
            return Yii::$app->response->redirect(['/beauty/admin/master-cabinet']);
        }

        // Regular clients don't have admin access
        Yii::$app->session->setFlash('error', 'Доступ запрещен');
        return Yii::$app->response->redirect(['/beauty/main/index']);
    }
}
