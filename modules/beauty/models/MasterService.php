<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * MasterService model
 *
 * @property int $id
 * @property int $master_id
 * @property int $service_id
 */
class MasterService extends ActiveRecord
{
    /**
     * @var float|null
     */
    public $custom_price;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_master_services}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['master_id', 'service_id'], 'required'],
            [['master_id', 'service_id'], 'integer'],
            [['custom_price'], 'number'],
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
            'service_id' => 'Услуга',
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

    /**
     * Gets query for [[Service]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::class, ['id' => 'service_id']);
    }
}
