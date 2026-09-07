<?php

namespace app\common\components;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

/**
 * AuthBehavior - shared authentication behavior for module AuthControllers
 *
 * Usage: attach to any AuthController to get standardized login/logout/register actions
 */
class AuthBehavior extends Behavior
{
    public $loginFormClass;
    public $registerFormClass;
    public $successRedirect;
    public $guestRedirect;

    public function events()
    {
        return [];
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect($this->getSuccessRedirect());
        }

        $model = new $this->loginFormClass();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($this->getSuccessRedirect());
        }

        return $this->controller->render('login', ['model' => $model]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect($this->getSuccessRedirect());
        }

        $model = new $this->registerFormClass();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно. Теперь вы можете войти.');
            return $this->controller->redirect(['login']);
        }

        return $this->controller->render('register', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect($this->getSuccessRedirect());
    }

    protected function getSuccessRedirect()
    {
        return $this->successRedirect ?? Yii::$app->homeUrl;
    }
}
