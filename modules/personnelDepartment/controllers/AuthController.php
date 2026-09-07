<?php

namespace app\modules\personnelDepartment\controllers;

use Yii;
use yii\web\Controller;
use app\modules\personnelDepartment\models\LoginForm;
use app\modules\personnelDepartment\models\RegisterForm;
use app\modules\personnelDepartment\assets\PersonnelAuthAsset;

class AuthController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            PersonnelAuthAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionLogin()
    {
        if (!Yii::$app->userPersonnelDepartment->isGuest) {
            return $this->redirect(['/personnel']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/personnel']);
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->userPersonnelDepartment->isGuest) {
            return $this->redirect(['/personnel']);
        }

        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно. Теперь вы можете войти.');
            return $this->redirect(['login']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userPersonnelDepartment->logout();
        return $this->redirect(['/personnel']);
    }
}
