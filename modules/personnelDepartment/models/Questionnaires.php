<?php

namespace app\modules\PersonnelDepartment\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pers_questionnaires".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $birth_date
 * @property string|null $gender
 * @property string|null $citizenship
 * @property string|null $passport_series
 * @property string|null $passport_number
 * @property string|null $passport_issued_by
 * @property string|null $passport_issued_at
 * @property string|null $registration_address
 * @property string|null $marital_status
 * @property string|null $education_level
 * @property string|null $education_org_name
 * @property string|null $education_specialty
 * @property string|null $education_diploma_series
 * @property string|null $education_diploma_number
 * @property string|null $snils_number
 * @property string|null $workplace
 * @property string|null $position
 * @property int|null $experience_years
 * @property string|null $health_state
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $extra_info
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Files[] $files
 * @property Statuses $status
 * @property User $user
 */
class Questionnaires extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%questionnaires}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('personnelDepartment');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['birth_date', 'gender', 'citizenship', 'passport_series', 'passport_number', 'passport_issued_by', 'passport_issued_at', 'registration_address', 'marital_status', 'education_level', 'education_org_name', 'education_specialty', 'education_diploma_series', 'education_diploma_number', 'snils_number', 'workplace', 'position', 'experience_years', 'health_state', 'phone', 'email', 'extra_info'], 'default', 'value' => null],
            [['user_id', 'status_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'experience_years', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['birth_date', 'passport_issued_at'], 'safe'],
            [['extra_info'], 'string'],
            [['gender', 'passport_number', 'snils_number', 'phone'], 'string', 'max' => 20],
            [['citizenship', 'marital_status'], 'string', 'max' => 100],
            [['passport_series'], 'string', 'max' => 10],
            [['passport_issued_by', 'registration_address', 'education_org_name', 'education_specialty', 'workplace', 'position', 'health_state', 'email'], 'string', 'max' => 255],
            [['education_level', 'education_diploma_series', 'education_diploma_number'], 'string', 'max' => 50],
            [['user_id'], 'unique'],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Statuses::class, 'targetAttribute' => ['status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'birth_date' => Yii::t('app', 'День рождения'),
            'gender' => Yii::t('app', 'Пол'),
            'citizenship' => Yii::t('app', 'Гражданство'),
            'passport_series' => Yii::t('app', 'Серия паспорта'),
            'passport_number' => Yii::t('app', 'Номер паспорта'),
            'passport_issued_by' => Yii::t('app', 'Паспорт выдан'),
            'passport_issued_at' => Yii::t('app', 'Паспорт выдан в'),
            'registration_address' => Yii::t('app', 'Адрес регистрации'),
            'marital_status' => Yii::t('app', 'Семейное положение'),
            'education_level' => Yii::t('app', 'Уровень образования'),
            'education_org_name' => Yii::t('app', 'Имя учебного учреждения'),
            'education_specialty' => Yii::t('app', 'Образовательная специальнось'),
            'education_diploma_series' => Yii::t('app', 'Серия диплома об образовании'),
            'education_diploma_number' => Yii::t('app', 'Номер диплома об образовании'),
            'snils_number' => Yii::t('app', 'Номер СНИЛСа'),
            'workplace' => Yii::t('app', 'Рабочее место'),
            'position' => Yii::t('app', 'Позиция'),
            'experience_years' => Yii::t('app', 'Год опыта работы'),
            'health_state' => Yii::t('app', 'Состояние здоровья'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Электронная почта'),
            'extra_info' => Yii::t('app', 'Дополнительная информация'),
            'status_id' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(Files::class, ['profile_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

}
