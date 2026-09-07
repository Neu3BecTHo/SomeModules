<?php

namespace app\modules\PersonnelDepartment\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pers_files".
 *
 * @property int $id
 * @property int $profile_id
 * @property string $type
 * @property string $file_path
 * @property string|null $file_name
 * @property string|null $mime_type
 * @property int|null $size
 * @property int $created_at
 *
 * @property Questionnaires $profile
 */
class Files extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%files}}';
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
            [['file_name', 'mime_type', 'size'], 'default', 'value' => null],
            [['profile_id', 'type', 'file_path', 'created_at'], 'required'],
            [['profile_id', 'size', 'created_at'], 'integer'],
            [['type'], 'string', 'max' => 50],
            [['file_path', 'file_name'], 'string', 'max' => 255],
            [['mime_type'], 'string', 'max' => 100],
            [['profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questionnaires::class, 'targetAttribute' => ['profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'profile_id' => Yii::t('app', 'Профиль'),
            'type' => Yii::t('app', 'Тип'),
            'file_path' => Yii::t('app', 'Файл'),
            'file_name' => Yii::t('app', 'Имя файла'),
            'mime_type' => Yii::t('app', 'Тип файла'),
            'size' => Yii::t('app', 'Размер'),
            'created_at' => Yii::t('app', 'Создан'),
        ];
    }

    /**
     * Gets query for [[Profile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Questionnaires::class, ['id' => 'profile_id']);
    }

}
