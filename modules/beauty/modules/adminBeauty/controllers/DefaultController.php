<?php

namespace app\modules\beauty\modules\adminBeauty\controllers;

use Yii;
use yii\web\Controller;

/**
 * Default controller for admin module
 */
class DefaultController extends Controller
{
    /**
     * Redirects based on user role
     *
     * @return \yii\web\Response
     */
    public function actionIndex()
    {
        $user = Yii::$app->userBeauty->identity;
        
        if ($user->role === 'admin') {
            return $this->redirect(['/beauty/admin/dashboard']);
        } elseif ($user->role === 'master') {
            return $this->redirect(['/beauty/admin/master-cabinet']);
        }
        
        return $this->redirect(['/beauty/main/index']);
    }
}
