<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "board_users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $phone
 * @property string $email
 * @property string $password_hash
 * @property string $accessToken
 * @property string $authKey
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Booking[] $bookings
 * @property Reviews[] $reviews
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('boardwalk');
    }

    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status'], 'default', 'value' => 10],
            [['first_name', 'last_name', 'patronymic', 'phone', 'email', 'password_hash'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'patronymic', 'email', 'password_hash', 'accessToken'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['authKey'], 'string', 'max' => 32],
            [['email'], 'unique'],
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
            'email' => Yii::t('app', 'Электронная почта'),
            'password_hash' => Yii::t('app', 'Пароль'),
            'accessToken' => Yii::t('app', 'Токен доступа'),
            'authKey' => Yii::t('app', 'Ключ авторизации'),
            'status' => Yii::t('app', 'Статус'),
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
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . $this->patronymic;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password_hash);
            $this->setAccessToken();
            $this->setAuthKey();
            return true;
        }
        return false;
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::class, ['user_id' => 'id']);
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
