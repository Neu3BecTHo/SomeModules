<?php

namespace app\modules\beauty\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $phone;
    public $full_name;
    public $role = 'client';
    public $password;
    public $password_repeat;
    public $agree = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['phone', 'full_name', 'password', 'password_repeat', 'role'], 'required'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Неверный формат телефона. Используйте: +7(XXX)XXX-XX-XX'],
            ['phone', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'phone', 'message' => 'Этот телефон уже зарегистрирован.'],
            ['full_name', 'string', 'min' => 2, 'max' => 255],
            ['role', 'in', 'range' => ['client', 'master']],
            ['password', 'string', 'min' => 8, 'message' => 'Пароль должен содержать минимум 8 символов.'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true, 'message' => 'Необходимо согласие с политикой конфиденциальности.'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'phone' => 'Телефон',
            'full_name' => 'ФИО',
            'role' => 'Роль',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'agree' => 'Согласен с политикой конфиденциальности',
        ];
    }

    /**
     * Registers a new user.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function register()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->phone = $this->phone;
        $user->full_name = $this->full_name;
        $user->role = $this->role;
        $user->is_active = true;
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = Yii::$app->security->generateRandomString();

        if ($user->save()) {
            return $user;
        }

        return null;
    }
}
