<?php

namespace app\modules\photoshoot\controllers;

use app\modules\photoshoot\models\LoginForm;
use app\modules\photoshoot\models\RegisterForm;
use yii\web\Controller;
use Yii;

class AuthController extends Controller
{
    public function actionRegister()
    {
        if (!Yii::$app->userPhotoshoot->isGuest) {
            return $this->redirect(['/photoshoot/main/index']);
        }

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
        if (!Yii::$app->userPhotoshoot->isGuest) {
            return $this->redirect(['/photoshoot/main/index']);
        }

        $model = new LoginForm();

        // Special admin login
        if ($model->load(Yii::$app->request->post())) {
            // Check for admin credentials
            $user = \app\modules\photoshoot\models\User::findByLogin($model->login);
            if ($user && $user->is_admin && $user->validatePassword($model->password)) {
                // Admin can log in from here too
            }

            if ($model->login()) {
                return $this->redirect(['/photoshoot/main/index']);
            }
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->userPhotoshoot->logout();
        return $this->redirect(['/photoshoot/main/index']);
    }
}
