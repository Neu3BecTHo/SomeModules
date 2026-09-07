<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $login;
    public $password;
    public $password_repeat;
    public $full_name;
    public $phone;
    public $email;
    public $agree;

    public function rules()
    {
        return [
            [['login', 'password', 'password_repeat', 'full_name', 'phone', 'email', 'agree'], 'required'],

            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]{9,}$/', 'message' => 'Логин должен содержать минимум 9 символов, только латинские буквы и цифры.'],
            ['login', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'login', 'message' => 'Этот логин уже занят.'],

            ['full_name', 'match', 'pattern' => '/^[А-Яа-яЁё\s]+$/u', 'message' => 'ФИО должно содержать только кириллицу и пробелы.'],

            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат: +7(XXX)XXX-XX-XX.'],

            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Этот email уже зарегистрирован.'],

            ['password', 'string', 'min' => 8],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать.'],

            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'login' => 'Логин',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'full_name' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'agree' => 'Согласие с правилами регистрации',
        ];
    }

    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->login = $this->login;
        $user->full_name = $this->full_name;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->is_admin = 0;

        if ($user->save()) {
            return $user;
        }

        $this->addErrors($user->getErrors());
        return null;
    }
}
