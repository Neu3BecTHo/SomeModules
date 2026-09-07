<?php

namespace app\modules\cleaner\models;

use app\modules\cleaner\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = true;

    /** @var User|null */
    private $_user;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
        ];
    }

    public function validatePassword($attribute)
    {
        if ($this->hasErrors()) {
            return;
        }

        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError($attribute, 'Неверная электронная почта или пароль.');
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->userCleaner->login(
            $this->getUser(),
            $this->rememberMe ? 3600 * 24 * 30 : 0
        );
    }

    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['phone' => $this->phone]);
        }
        return $this->_user;
    }
}