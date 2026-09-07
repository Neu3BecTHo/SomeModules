<?php

namespace app\modules\beauty\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\beauty\models\LoginForm;
use app\modules\beauty\models\RegistrationForm;
use app\modules\beauty\models\User;

/**
 * Auth controller for beauty module
 */
class AuthController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->userBeauty->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // Use userBeauty component for login
            $user = $model->getUser();
            if ($user && Yii::$app->userBeauty->login($user, $model->rememberMe ? 3600*24*30 : 0)) {
            return $this->redirect(['/beauty/main/index']);
            }
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     *
     * @return string|\yii\web\Response
     */
    public function actionRegister()
    {
        if (!Yii::$app->userBeauty->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            // Auto login after registration
            $user = User::findByPhone($model->phone);
            if ($user) {
                Yii::$app->userBeauty->login($user, 3600*24*30);
            }
            return $this->redirect(['/beauty/main/index']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->userBeauty->logout();

        return $this->redirect(['/beauty/main/index']);
    }

    /**
     * Go back to previous page or home.
     *
     * @param string|array $defaultUrl the default return URL in case the previous one is not found
     * @return \yii\web\Response
     */
    public function goBack($defaultUrl = null)
    {
        if ($defaultUrl === null) {
            $defaultUrl = ['/beauty'];
        }
        return parent::goBack($defaultUrl);
    }

    /**
     * Go to home page.
     *
     * @return \yii\web\Response
     */
    public function goHome()
    {
        return $this->redirect(['/beauty']);
    }
}
