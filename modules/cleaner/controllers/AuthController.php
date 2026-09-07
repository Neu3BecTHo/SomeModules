<?php

namespace app\modules\cleaner\controllers;

use app\modules\cleaner\assets\CleanerAuthAsset;
use app\modules\cleaner\models\LoginForm;
use app\modules\cleaner\models\RegisterForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CleanerAuthAsset::register($this->view);
            if (!Yii::$app->userCleaner->isGuest && $action->id !== 'logout') {
                return $this->redirect(['main/index']);
            }
            return true;
        }
        return false;
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && ($user = $model->register())) {
            Yii::$app->userCleaner->login($user);
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно.');
            return $this->redirect(['main/index']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/cleaner/main/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userCleaner->logout();
        return $this->redirect(['/cleaner/main/index']);
    }
}
