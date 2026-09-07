<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Order model
 *
 * @property int $id
 * @property int $client_id
 * @property int $master_id
 * @property int $service_id
 * @property string $appointment_date
 * @property string $appointment_time
 * @property string $status
 * @property string $payment_method
 * @property string $total_price
 * @property string $notes
 * @property string $created_at
 * @property string $updated_at
 */
class Order extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'master_id', 'service_id', 'appointment_date', 'appointment_time', 'status', 'payment_method', 'total_price'], 'required'],
            [['client_id', 'master_id', 'service_id'], 'integer'],
            [['appointment_date'], 'safe'],
            [['appointment_time'], 'safe'],
            [['notes'], 'string'],
            [['total_price'], 'number', 'min' => 0],
            [['status', 'payment_method'], 'string', 'max' => 20],
            [['status'], 'default', 'value' => 'new'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'master_id' => 'Мастер',
            'service_id' => 'Услуга',
            'appointment_date' => 'Дата записи',
            'appointment_time' => 'Время записи',
            'status' => 'Статус',
            'payment_method' => 'Способ оплаты',
            'total_price' => 'Итоговая цена',
            'notes' => 'Примечания',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(User::class, ['id' => 'client_id']);
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

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['order_id' => 'id']);
    }
}
