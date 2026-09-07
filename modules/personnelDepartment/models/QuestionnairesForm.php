<?php

namespace app\modules\personnelDepartment\models;

use yii\base\Model;
use yii\web\UploadedFile;

class QuestionnairesForm extends Model
{
    public $birth_date;
    public $gender;
    public $citizenship;

    public $passport_series;
    public $passport_number;
    public $passport_issued_by;
    public $passport_issued_at;
    public $registration_address;
    public $marital_status;

    public $education_level;
    public $education_org_name;
    public $education_specialty;
    public $education_diploma_series;
    public $education_diploma_number;

    public $snils_number;

    public $workplace;
    public $position;
    public $experience_years;
    public $health_state;

    public $phone;
    public $email;
    public $extra_info;

    /** @var UploadedFile */
    public $photo_file;
    /** @var UploadedFile */
    public $passport_scan;
    /** @var UploadedFile */
    public $diploma_scan;
    /** @var UploadedFile */
    public $snils_scan;

    public function rules()
    {
        return [
            [['birth_date', 'gender', 'citizenship', 'registration_address', 'education_level'], 'required'],
            [['experience_years'], 'integer', 'min' => 0, 'max' => 100],
            [['extra_info'], 'string'],
            [['birth_date', 'passport_issued_at'], 'date', 'format' => 'php:Y-m-d'],

            [['gender', 'citizenship', 'marital_status', 'education_level'], 'string', 'max' => 50],
            [['passport_series', 'education_diploma_series'], 'string', 'max' => 10],
            [['passport_number', 'education_diploma_number', 'snils_number'], 'string', 'max' => 20],
            [['passport_issued_by', 'registration_address', 'education_org_name', 'education_specialty', 'workplace', 'position', 'health_state', 'phone', 'email'], 'string', 'max' => 255],

            [['photo_file'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg', 'pdf'], 'maxSize' => 10 * 1024 * 1024],
            [['passport_scan'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg', 'pdf'], 'maxSize' => 20 * 1024 * 1024],
            [['diploma_scan'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg', 'pdf'], 'maxSize' => 20 * 1024 * 1024],
            [['snils_scan'], 'file', 'skipOnEmpty' => true, 'extensions' => ['jpg', 'jpeg', 'pdf'], 'maxSize' => 10 * 1024 * 1024],
        ];
    }

    public function attributeLabels()
    {
        return [
            'birth_date' => 'Дата рождения',
            'gender' => 'Пол',
            'citizenship' => 'Гражданство',
            'passport_series' => 'Серия паспорта',
            'passport_number' => 'Номер паспорта',
            'passport_issued_by' => 'Кем выдан',
            'passport_issued_at' => 'Когда выдан',
            'registration_address' => 'Адрес регистрации',
            'marital_status' => 'Семейное положение',
            'education_level' => 'Образование',
            'education_org_name' => 'Образовательная организация',
            'education_specialty' => 'Специальность и квалификация',
            'education_diploma_series' => 'Серия диплома',
            'education_diploma_number' => 'Номер диплома',
            'snils_number' => 'Номер СНИЛС',
            'workplace' => 'Место работы',
            'position' => 'Должность',
            'experience_years' => 'Стаж работы (лет)',
            'health_state' => 'Состояние здоровья',
            'phone' => 'Номер телефона',
            'email' => 'Адрес электронной почты',
            'extra_info' => 'Дополнительная информация',
            'photo_file' => 'Фото сотрудника',
            'passport_scan' => 'Скан паспорта',
            'diploma_scan' => 'Скан диплома',
            'snils_scan' => 'Скан СНИЛС',
        ];
    }

    public function loadFiles()
    {
        $this->photo_file = UploadedFile::getInstance($this, 'photo_file');
        $this->passport_scan = UploadedFile::getInstance($this, 'passport_scan');
        $this->diploma_scan = UploadedFile::getInstance($this, 'diploma_scan');
        $this->snils_scan = UploadedFile::getInstance($this, 'snils_scan');
    }
}