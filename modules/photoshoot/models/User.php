<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "photoshoot_users".
 *
 * @property int $id
 * @property string $login
 * @property string $password
 * @property string $full_name
 * @property string $phone
 * @property string $email
 * @property string|null $accessToken
 * @property string|null $authKey
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $is_admin
 *
 * @property Booking[] $bookings
 * @property Review[] $reviews
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
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
            [['accessToken', 'authKey'], 'default', 'value' => null],
            [['login', 'password', 'full_name', 'phone', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_admin'], 'integer'],
            [['login'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 200],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['authKey'], 'string', 'max' => 32],
            [['login'], 'unique'],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['accessToken'], 'unique'],
            ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]{9,}$/', 'message' => 'Логин должен содержать минимум 9 символов, только латинские буквы и цифры.'],
            ['full_name', 'match', 'pattern' => '/^[А-Яа-яЁё\s]+$/u', 'message' => 'ФИО должно содержать только кириллицу и пробелы.'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат: +7(XXX)XXX-XX-XX.'],
            ['email', 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'login' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'full_name' => Yii::t('app', 'ФИО'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Электронная почта'),
            'is_admin' => Yii::t('app', 'Администратор'),
            'accessToken' => Yii::t('app', 'Токен доступа'),
            'authKey' => Yii::t('app', 'Ключ авторизации'),
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
     * Finds user by login
     *
     * @param string $login
     * @return static|null
     */
    public static function findByLogin($login)
    {
        return static::findOne(['login' => $login]);
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || $this->isAttributeChanged('password')) {
                $this->setPassword($this->password);
            }
            if ($this->isNewRecord) {
                $this->setAccessToken();
                $this->setAuthKey();
                $this->is_admin = 0;
            }
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
        return $this->hasMany(Review::class, ['user_id' => 'id']);
    }
}
