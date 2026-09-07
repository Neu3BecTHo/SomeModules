<?php

namespace app\modules\communal\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\common\models\BaseAuthTrait;

/**
 * This is the model class for table "comm_users".
 *
 * @property int $id
 * @property string $password
 * @property string $firstName
 * @property string $lastName
 * @property string $patronymic
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property int $residents_count
 * @property int $rules
 * @property string $authKey
 * @property string $accessToken
 * @property string $createdAt
 * @property string $updatedAt
 *
 * @property Requests[] $requests
 */

class User extends ActiveRecord implements IdentityInterface
{
    use BaseAuthTrait;

    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('communal');
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
            [['firstName', 'lastName', 'patronymic', 'phone', 'email', 'address', 'residents_count', 'authKey', 'accessToken'], 'default', 'value' => null],
            [['rules'], 'default', 'value' => 0],
            [['password'], 'required'],
            [['residents_count', 'rules'], 'integer'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['password', 'firstName', 'lastName', 'patronymic', 'phone', 'email', 'address', 'accessToken'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['email'], 'string', 'max' => 255],
            [['authKey'], 'string', 'max' => 32],
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
            'password' => Yii::t('app', 'Пароль'),
            'firstName' => Yii::t('app', 'Имя'),
            'lastName' => Yii::t('app', 'Фамилия'),
            'patronymic' => Yii::t('app', 'Отчество'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Электронная почта'),
            'address' => Yii::t('app', 'Адрес'),
            'residents_count' => Yii::t('app', 'Количество проживающих'),
            'rules' => Yii::t('app', 'Согласие с правилами регистрации'),
            'authKey' => Yii::t('app', 'Auth Key'),
            'accessToken' => Yii::t('app', 'Access Token'),
            'createdAt' => Yii::t('app', 'Created At'),
            'updatedAt' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public function setAccessToken()
    {
        $this->accessToken = Yii::$app->security->generateRandomString();
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
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['user_id' => 'id']);
    }
}
