<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property int $id
 * @property string $phone
 * @property string $password_hash
 * @property string $auth_key
 * @property string $full_name
 * @property string $role
 * @property bool $is_active
 * @property string $created_at
 * @property string $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @var string|null
     */
    public $currentPassword;

    /**
     * @var string|null
     */
    public $newPassword;

    /**
     * @var string|null
     */
    public $confirmPassword;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public static function getDb()
    {
        return Yii::$app->get('beauty');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'password_hash', 'full_name', 'role'], 'required'],
            [['phone'], 'unique'],
            [['phone'], 'match', 'pattern' => '/^\+7\(\d{3}\)\d{3}-\d{2}-\d{2}$/', 'message' => 'Формат телефона: +7(XXX)XXX-XX-XX'],
            [['full_name'], 'string', 'max' => 255],
            [['role'], 'in', 'range' => ['client', 'master', 'admin']],
            [['is_active'], 'boolean'],
            [['is_active'], 'default', 'value' => true],
            [['role'], 'default', 'value' => 'client'],
            // Password change validation
            [['currentPassword'], 'validateCurrentPassword', 'when' => function($model) {
                return !empty($model->newPassword);
            }],
            [['newPassword'], 'string', 'min' => 6, 'when' => function($model) {
                return !empty($model->newPassword);
            }],
            [['confirmPassword'], 'compare', 'compareAttribute' => 'newPassword', 'when' => function($model) {
                return !empty($model->newPassword);
            }],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'password_hash' => 'Пароль',
            'auth_key' => 'Ключ аутентификации',
            'full_name' => 'ФИО',
            'role' => 'Роль',
            'is_active' => 'Активен',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'is_active' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Validates current password
     *
     * @param string $attribute
     * @param array $params
     */
    public function validateCurrentPassword($attribute, $params)
    {
        if (!$this->validatePassword($this->$attribute)) {
            $this->addError($attribute, 'Неверный текущий пароль');
        }
    }

    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByPhone($phone)
    {
        return static::findOne(['phone' => $phone, 'is_active' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
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

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Gets query for [[Master]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(Master::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['client_id' => 'id']);
    }
}
