<?php

namespace app\modules\boardwalk\controllers;

use app\modules\boardwalk\assets\BoardwalkAuthAsset;
use app\modules\boardwalk\models\LoginForm;
use app\modules\boardwalk\models\RegisterForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BoardwalkAuthAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionRegister()
    {
       $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию!');
            return $this->redirect(['/boardwalk/main/index']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->userBoardwalk->isGuest) {
            return $this->redirect(['/boardwalk/main/index']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/boardwalk/main/index']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userBoardwalk->logout();
        return $this->redirect(['/boardwalk/main/index']);
    }
}
