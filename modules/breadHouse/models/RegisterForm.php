<?php

namespace app\modules\breadHouse\models;

use yii\base\Model;

class RegisterForm extends Model
{
    public $last_name;
    public $first_name;
    public $patronymic;
    public $phone;
    public $email;
    public $password;
    public $password_repeat;
    public $agree;

    public function rules()
    {
        return [
            [['last_name', 'first_name', 'phone', 'email', 'password', 'password_repeat', 'agree'], 'required'],

            [['last_name', 'first_name', 'patronymic'], 'match',
                'pattern' => '/^[А-ЯЁа-яё\s\-]+$/u',
                'message' => 'Используйте только кириллицу, пробелы и тире.'],

            ['phone', 'match',
                'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/',
                'message' => 'Телефон должен быть в формате +7(XXX)XXX-XX-XX.'],

            ['phone', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'phone',
                'message' => 'Пользователь с таким телефоном уже существует.'],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'email',
                'message' => 'Пользователь с таким email уже существует.'],

            ['password', 'string', 'min' => 6],

            ['password_repeat', 'compare',
                'compareAttribute' => 'password',
                'message' => 'Пароли должны совпадать.'],

            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true,
                'message' => 'Нужно согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'last_name'        => 'Фамилия',
            'first_name'       => 'Имя',
            'patronymic'       => 'Отчество',
            'phone'            => 'Телефон',
            'email'            => 'Email',
            'password'         => 'Пароль',
            'password_repeat'  => 'Повтор пароля',
            'agree'            => 'Согласие с правилами регистрации',
        ];
    }

    public function register()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->last_name  = $this->last_name;
        $user->first_name = $this->first_name;
        $user->patronymic = $this->patronymic;
        $user->phone      = $this->phone;
        $user->email      = $this->email;
        $user->password   = $this->password;

        return $user->save() ? $user : null;
    }
}