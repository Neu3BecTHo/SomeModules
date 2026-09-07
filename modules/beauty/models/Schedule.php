<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Schedule model
 *
 * @property int $id
 * @property int $master_id
 * @property int $day_of_week
 * @property string $start_time
 * @property string $end_time
 * @property bool $is_available
 */
class Schedule extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_schedules}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'day_of_week', 'start_time', 'end_time'], 'required'],
            [['master_id', 'day_of_week'], 'integer'],
            [['day_of_week'], 'integer', 'min' => 1, 'max' => 7],
            [['start_time', 'end_time'], 'safe'],
            [['is_available'], 'boolean'],
            [['is_available'], 'default', 'value' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'master_id' => 'Мастер',
            'day_of_week' => 'День недели',
            'start_time' => 'Начало работы',
            'end_time' => 'Конец работы',
            'is_available' => 'Доступен',
        ];
    }

    /**
     * Gets query for [[Master]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaster()
    {
        return $this->hasOne(Master::class, ['id' => 'master_id']);
    }
}
