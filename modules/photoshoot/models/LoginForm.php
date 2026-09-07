<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $login;
    public $password;
    public $rememberMe = true;

    /** @var User|null */
    private $_user;

    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
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
            $this->addError($attribute, 'Неверный логин или пароль.');
        }
    }

    public function login(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        return Yii::$app->userPhotoshoot->login(
            $this->getUser(),
            $this->rememberMe ? 3600 * 24 * 30 : 0
        );
    }

    protected function getUser(): ?User
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(['login' => $this->login]);
        }
        return $this->_user;
    }
}
