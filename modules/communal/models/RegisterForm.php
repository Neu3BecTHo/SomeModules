<?php

namespace app\modules\communal\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $firstName;
    public $lastName;
    public $patronymic;
    public $phone;
    public $email;
    public $address;
    public $residents_count;
    public $password;
    public $password_repeat;
    public $agree;

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'patronymic', 'phone', 'email', 'address', 'residents_count', 'password', 'password_repeat'], 'required'],
            
            [['firstName', 'lastName', 'patronymic'], 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'ФИО может содержать только кириллицу и пробелы.'],
            
            ['phone', 'match', 'pattern' => '/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат телефона: 8(XXX)XXX-XX-XX'],
            ['phone', 'unique', 'targetClass' => User::class, 'message' => 'Такой телефон уже зарегистрирован.'],
            
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'Такой email уже занят.'],
            
            ['residents_count', 'integer', 'min' => 1],
            
            ['password', 'string', 'min' => 10],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            
            ['agree', 'required', 'requiredValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'firstName' => 'Имя',
            'lastName' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Email',
            'address' => 'Адрес проживания',
            'residents_count' => 'Количество проживающих',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'agree' => 'Согласие с правилами регистрации',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = new User();
        $user->firstName = $this->firstName;
        $user->lastName = $this->lastName;
        $user->password = $this->password;
        $user->patronymic = $this->patronymic;
        $user->phone = $this->phone;
        $user->email = $this->email;
        $user->address = $this->address;
        $user->residents_count = $this->residents_count;
        $user->rules = $this->agree;

        return $user->save(false);
    }
}
