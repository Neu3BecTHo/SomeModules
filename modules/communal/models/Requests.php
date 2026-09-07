<?php

namespace app\modules\communal\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "comm_requests".
 *
 * @property int $id
 * @property int $user_id
 * @property int $service_type_id
 * @property int $status_id
 * @property string|null $date_submitted
 * @property float $previous_value
 * @property float $current_value
 * @property float $consumption
 * @property float $tariff_snapshot
 * @property float $amount
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property ServiceTypes $serviceType
 * @property RequestStatuses $status
 * @property User $user
 */
class Requests extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%requests}}';
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
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['status_id'], 'default', 'value' => 1],
            [['user_id', 'service_type_id', 'previous_value', 'current_value', 'consumption', 'tariff_snapshot', 'amount'], 'required'],
            [['user_id', 'service_type_id', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['date_submitted'], 'safe'],
            [['previous_value', 'current_value', 'consumption', 'tariff_snapshot', 'amount'], 'number'],
            ['current_value', 'compare', 'compareAttribute' => 'previous_value', 'operator' => '>=', 'type' => 'number', 'message' => 'Текущие показания не могут быть меньше предыдущих.'],
            [['service_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => ServiceTypes::class, 'targetAttribute' => ['service_type_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => RequestStatuses::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'service_type_id' => Yii::t('app', 'Тип сервиса'),
            'status_id' => Yii::t('app', 'Статус'),
            'date_submitted' => Yii::t('app', 'Дата передачи показаний'),
            'previous_value' => Yii::t('app', 'Предыдущие показания'),
            'current_value' => Yii::t('app', 'Текущие показания'),
            'consumption' => Yii::t('app', 'Расход'),
            'tariff_snapshot' => Yii::t('app', 'Тариф'),
            'amount' => Yii::t('app', 'Сумма к оплате'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[ServiceType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServiceType()
    {
        return $this->hasOne(ServiceTypes::class, ['id' => 'service_type_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(RequestStatuses::class, ['id' => 'status_id']);
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

    // Расход
    public function getConsumption()
    {
        $diff = $this->current_value - $this->previous_value;
        return $diff > 0 ? $diff : 0;
    }

    // Итоговая стоимость: берем тариф из связанной услуги
    public function getTotalCost()
    {
        // Если связь есть, берем tariff, иначе 0
        $tariff = $this->serviceType ? $this->serviceType->tariff : 0;
        
        return $this->getConsumption() * $tariff;
    }
}
