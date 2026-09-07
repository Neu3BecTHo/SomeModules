<?php

namespace app\modules\PersonnelDepartment\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pers_statuses".
 *
 * @property int $id
 * @property string $code
 * @property string $title
 *
 * @property Questionnaires[] $questionnaires
 */
class Statuses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%statuses}}';
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
            [['code', 'title'], 'required'],
            [['code'], 'string', 'max' => 50],
            [['title'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Код'),
            'title' => Yii::t('app', 'Заголовок'),
        ];
    }

    /**
     * Gets query for [[Questionnaires]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaires()
    {
        return $this->hasMany(Questionnaires::class, ['status_id' => 'id']);
    }

}
