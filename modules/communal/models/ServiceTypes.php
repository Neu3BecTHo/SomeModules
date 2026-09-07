<?php

namespace app\modules\communal\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comm_service_types".
 *
 * @property int $id
 * @property string $title
 * @property string $code
 * @property float $tariff
 * @property string $unit
 *
 * @property Requests[] $requests
 */
class ServiceTypes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%service_types}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('communal');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'code', 'tariff', 'unit'], 'required'],
            [['tariff'], 'number'],
            [['title'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['unit'], 'string', 'max' => 20],
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
            'title' => Yii::t('app', 'Заголовок'),
            'code' => Yii::t('app', 'Код'),
            'tariff' => Yii::t('app', 'Тариф'),
            'unit' => Yii::t('app', 'Единица измерения'),
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Requests::class, ['service_type_id' => 'id']);
    }

}
