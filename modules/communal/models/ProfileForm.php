<?php

namespace app\modules\communal\models;

use Yii;
use yii\base\Model;

class ProfileForm extends Model
{
    public $firstName;
    public $lastName;
    public $patronymic;
    public $phone;
    public $email;
    public $address;
    public $residents_count;

    public $newPassword;
    public $newPasswordRepeat;

    /** @var User */
    private $_user;

    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        
        // Заполняем форму текущими данными
        $this->firstName = $user->firstName;
        $this->lastName = $user->lastName;
        $this->patronymic = $user->patronymic;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->residents_count = $user->residents_count;
        
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['firstName', 'lastName', 'patronymic', 'phone', 'email', 'address', 'residents_count'], 'required', 'message' => 'Поле обязательно'],
            ['email', 'email'],
            ['residents_count', 'integer', 'min' => 1],
            
            // Валидация пароля (не обязателен, только если меняем)
            ['newPassword', 'string', 'min' => 6],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'],
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
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите пароль',
        ];
    }

    public function update()
    {
        // Сначала валидируем саму форму (правила формы работают)
        if (!$this->validate()) {
            return false;
        }

        $user = $this->_user;

        // Собираем массив полей для обновления: 'имя_колонки_в_бд' => 'значение'
        $attributes = [
            'firstName'       => $this->firstName,
            'lastName'        => $this->lastName,
            'patronymic'      => $this->patronymic,
            'phone'           => $this->phone,
            'email'           => $this->email,
            'address'         => $this->address,
            'residents_count' => $this->residents_count,
            // Если есть поведение TimestampBehavior, оно не сработает в updateAttributes,
            // поэтому обновляем дату вручную (если нужно)
            'updatedAt'       => new \yii\db\Expression('NOW()'),
        ];

        // Логика для пароля
        if (!empty($this->newPassword)) {
            // ВАЖНО: Так как мы обходим beforeSave, хешируем пароль вручную здесь
            $hash = Yii::$app->security->generatePasswordHash($this->newPassword);
            
            // Добавляем хеш в список обновляемых полей
            $attributes['password'] = $hash;
            
            // Если нужно сменить токены безопасности при смене пароля:
            $attributes['authKey'] = Yii::$app->security->generateRandomString();
        }

        // Выполняем прямой SQL UPDATE только для этих полей
        // Это вернет количество затронутых строк (int)
        $user->updateAttributes($attributes);

        return true;
    }
}
