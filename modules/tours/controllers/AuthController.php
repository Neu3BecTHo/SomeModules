<?php

namespace app\modules\tours\controllers;

use app\modules\tours\assets\ToursAuthAsset;
use app\modules\tours\models\LoginForm;
use app\modules\tours\models\RegisterForm;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            ToursAuthAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionRegister()
    {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && ($user = $model->signup())) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно. Теперь Вы можете войти.');
            return $this->redirect(['login']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/tours/main/index']);
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userTours->logout();
        return $this->redirect(['/tours/main/index']);
    }
}
