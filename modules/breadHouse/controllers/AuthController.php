<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseAuthAsset;
use app\modules\breadHouse\models\LoginForm;
use app\modules\breadHouse\models\RegisterForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseAuthAsset::register($this->view);
            if (!Yii::$app->userBreadHouse->isGuest) {
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
            Yii::$app->userBreadHouse->login($user);
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
            return $this->redirect(['/breadHouse/main/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userBreadHouse->logout();
        return $this->redirect(['/breadHouse/main/index']);
    }
}
