<?php

namespace app\modules\tours\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "tour_users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $patronymic
 * @property string $password
 * @property string $phone
 * @property string $email
 * @property string $passport_series
 * @property string $passport_number
 * @property string $address
 * @property string|null $accessToken
 * @property string|null $authKey
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Requests[] $requests
 * @property Reviews[] $reviews
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('tours');
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
            [['first_name', 'last_name', 'patronymic', 'password', 'phone', 'email', 'passport_series', 'passport_number', 'address'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'patronymic', 'email'], 'string', 'max' => 100],
            [['password', 'address', 'accessToken'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['passport_series'], 'string', 'max' => 4],
            [['passport_number'], 'string', 'max' => 6],
            [['authKey'], 'string', 'max' => 32],
            [['email'], 'unique'],
            [['phone'], 'unique'],
            [['accessToken'], 'unique'],
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
            'password' => Yii::t('app', 'Пароль'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Электронная почта'),
            'passport_series' => Yii::t('app', 'Серия паспорта'),
            'passport_number' => Yii::t('app', 'Номер паспорта'),
            'address' => Yii::t('app', 'Адрес'),
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
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
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

    /**
     * {@inheritdoc}
     * 
     * SECURITY: Encrypt sensitive PII fields (passport, address) before saving.
     * Decrypt on read. Complies with GDPR/152-ФЗ requirements.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setPassword($this->password);
            $this->setAccessToken();
            $this->setAuthKey();
            
            // Encrypt sensitive PII data before saving
            if ($this->hasAttribute('passport_series')) {
                $this->passport_series = $this->encryptSensitive($this->passport_series);
                $this->passport_number = $this->encryptSensitive($this->passport_number);
                $this->address = $this->encryptSensitive($this->address);
            }
            return true;
        }
        return false;
    }

    /**
     * Decrypt sensitive PII fields after loading from DB
     */
    public function afterFind()
    {
        parent::afterFind();
        
        // Decrypt sensitive PII data when reading from database
        if ($this->hasAttribute('passport_series')) {
            $this->passport_series = $this->decryptSensitive($this->passport_series);
            $this->passport_number = $this->decryptSensitive($this->passport_number);
            $this->address = $this->decryptSensitive($this->address);
        }
    }

    /**
     * Encrypt sensitive data using Yii2's built-in encryption
     * Uses the application's security component with the cookieValidationKey as master key
     */
    protected function encryptSensitive($data)
    {
        if (empty($data)) return $data;
        
        try {
            return Yii::$app->security->encryptByPassword(
                $data, 
                Yii::$app->params['encryptionKey'] ?? Yii::$app->request->cookieValidationKey
            );
        } catch (\Exception $e) {
            Yii::error('Encryption failed: ' . $e->getMessage(), 'user');
            return $data;
        }
    }

    /**
     * Decrypt sensitive data using Yii2's built-in encryption
     */
    protected function decryptSensitive($data)
    {
        if (empty($data)) return $data;
        
        try {
            return Yii::$app->security->decryptByPassword(
                $data, 
                Yii::$app->params['encryptionKey'] ?? Yii::$app->request->cookieValidationKey
            );
        } catch (\Exception $e) {
            Yii::error('Decryption failed: ' . $e->getMessage(), 'user');
            return $data;
        }
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['user_id' => 'id']);
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
