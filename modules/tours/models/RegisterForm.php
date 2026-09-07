<?php

namespace app\modules\tours\models;

use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $first_name;
    public $last_name;
    public $patronymic;
    public $phone;
    public $email;
    public $passport_series;
    public $passport_number;
    public $address;
    public $password;
    public $password_repeat;
    public $agree;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'patronymic', 'phone', 'email', 'passport_series', 'passport_number', 'address', 'password', 'password_repeat', 'agree'], 'required'],

            [['first_name', 'last_name', 'patronymic'], 'match', 'pattern' => '/^[А-Яа-яЁё\s]+$/u', 'message' => 'Используйте кириллицу и пробелы.'],

            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат: +7(XXX)XXX-XX-XX.'],

            ['email', 'email'],
            ['email', 'string', 'max' => 100],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Этот email уже зарегистрирован.'],

            ['passport_series', 'match', 'pattern' => '/^\d{4}$/', 'message' => 'Серия паспорта: 4 цифры.'],
            ['passport_number', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Номер паспорта: 6 цифр.'],

            ['address', 'string', 'max' => 255],

            ['password', 'string', 'min' => 7],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать.'],

            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Email',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'address' => 'Адрес проживания',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'agree' => 'Согласие с правилами регистрации',
        ];
    }

    public function signup(): ?User
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
        $user->passport_series = $this->passport_series;
        $user->passport_number = $this->passport_number;
        $user->address = $this->address;
        $user->password = $this->password;

        if ($user->save()) {
            return $user;
        }

        $this->addErrors($user->getErrors());
        return null;
    }
}