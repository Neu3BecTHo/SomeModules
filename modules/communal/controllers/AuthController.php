<?php

namespace app\modules\communal\controllers;

use Yii;
use yii\web\Controller;
use app\common\components\AuthBehavior;
use app\modules\communal\models\LoginForm;
use app\modules\communal\models\RegisterForm;

class AuthController extends Controller
{
    public function behaviors()
    {
        return [
            'auth' => [
                'class' => AuthBehavior::class,
                'loginFormClass' => LoginForm::class,
                'registerFormClass' => RegisterForm::class,
                'successRedirect' => ['/communal/main/index'],
            ],
        ];
    }
}
