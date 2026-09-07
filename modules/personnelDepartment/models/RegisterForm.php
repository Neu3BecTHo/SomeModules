<?php

namespace app\modules\personnelDepartment\models;

use app\modules\personnelDepartment\models\User;
use Yii;
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
    public $rules;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'patronymic', 'phone', 'email', 'password', 'password_repeat', 'rules'], 'required'],
            [['first_name', 'last_name', 'patronymic'], 'match', 'pattern' => '/^[А-ЯЁа-яё ]+$/u', 'message' => 'Используйте только кириллицу и пробелы.'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат: +7(XXX)XXX-XX-XX.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email', 'message' => 'Пользователь с такой почтой уже зарегистрирован.'],
            ['phone', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone', 'message' => 'Пользователь с таким телефоном уже зарегистрирован.'],
            ['password', 'string', 'min' => 7],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать.'],
            ['rules', 'boolean'],
            ['rules', 'compare', 'compareValue' => 1, 'message' => 'Необходимо согласиться с правилами регистрации.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'patronymic' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Адрес электронной почты',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'rules' => 'Согласен с правилами регистрации',
        ];
    }

    public function register()
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
        $user->password = $this->password;
        $user->rules = 1;

        return $user->save() ? $user : null;
    }
}