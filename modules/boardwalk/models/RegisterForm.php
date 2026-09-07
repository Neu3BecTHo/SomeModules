<?php

namespace app\modules\boardwalk\models;

use app\modules\boardwalk\models\User;
use yii\base\Model;

class RegisterForm extends Model
{
    public $first_name;
    public $last_name;
    public $patronymic;
    public $phone;
    public $email;
    public $password;
    public $password_repeat;
    public $agree;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'patronymic', 'phone', 'email', 'password', 'password_repeat', 'agree'], 'required'],

            [['first_name', 'last_name', 'patronymic'], 'match', 'pattern' => '/^[А-Яа-яЁё\s]+$/u', 'message' => 'ФИО может содержать только символы кириллицы и пробелы.'],

            ['phone', 'match', 'pattern' => '/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат телефона должен быть 8(XXX)XXX-XX-XX.'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Этот адрес электронной почты уже занят.'],
            ['password', 'string', 'min' => 8],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
            'agree' => 'Я согласен с правилами регистрации',
        ];
    }

    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->patronymic = $this->patronymic;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->password_hash = $this->password;
        
        return $user->save() ? $user : null;
    }
}