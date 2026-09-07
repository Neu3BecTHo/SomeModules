<?php

namespace app\modules\personnelDepartment\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "pers_users".
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $patronymic
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property int $rules
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Questionnaires $questionnaires
 */

class User extends ActiveRecord implements IdentityInterface
{
    public $authKey;
    public $accessToken;

    public static function getDb()
    {
        return Yii::$app->get('personnelDepartment');
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
            [['patronymic'], 'default', 'value' => null],
            [['rules'], 'default', 'value' => 0],
            [['first_name', 'last_name', 'phone', 'email', 'password'], 'required'],
            [['rules'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['first_name', 'last_name', 'patronymic'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],
            [['email', 'password'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['phone'], 'unique'],
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
            'password' => Yii::t('app', 'Пароль'),
            'rules' => Yii::t('app', 'Согласие с правилами регистрации'),
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
     * Gets query for [[Questionnaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasOne(Questionnaires::class, ['user_id' => 'id']);
    }
}
