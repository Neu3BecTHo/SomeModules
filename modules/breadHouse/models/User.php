<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "breadHouse_users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $email
 * @property string $password
 * @property int $is_admin
 * @property string|null $auth_key
 * @property string|null $password_reset_token
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Orders[] $orders
 * @property Reviews[] $reviews
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('breadHouse');
    }

    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['profile'] = ['first_name', 'last_name', 'patronymic', 'phone', 'email'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['auth_key', 'password_reset_token'], 'default', 'value' => null],
            [['is_admin'], 'default', 'value' => 0],
            [['first_name', 'last_name', 'patronymic', 'phone', 'email', 'password'], 'required'],
            [['is_admin', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'patronymic'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 18],
            [['password', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['phone'], 'unique'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Пароль'),
            'is_admin' => Yii::t('app', 'Администратор'),
            'auth_key' => Yii::t('app', 'Ключ авторизации'),
            'password_reset_token' => Yii::t('app', 'Токен сброса пароля'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function setAccessToken() {
        $this->accessToken = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    public function setAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password);
            $this->setAccessToken();
            $this->setAuthKey();
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['user_id' => 'id']);
    }
}
