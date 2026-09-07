<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $phone;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    public function rules()
    {
        return [
            [['phone', 'password'], 'required'],
            // Валидация формата телефона для соответствия ТЗ
            ['phone', 'match', 'pattern' => '/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат телефона: 8(XXX)XXX-XX-XX'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            // Если пользователя нет или пароль не подходит — выводим общую ошибку
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверный номер телефона или пароль.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->userBoardwalk->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    protected function getUser()
    {
        if ($this->_user === false) {
            // Ищем пользователя по полю phone
            $this->_user = User::findByPhone($this->phone);
        }
        return $this->_user;
    }
}