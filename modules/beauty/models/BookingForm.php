<?php

namespace app\modules\beauty\models;

use Yii;
use yii\base\Model;

/**
 * BookingForm is the model behind the booking form.
 */
class BookingForm extends Model
{
    public $service_id;
    public $master_id;
    public $appointment_date;
    public $appointment_time;
    public $payment_method;
    public $notes;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['service_id', 'master_id', 'appointment_date', 'appointment_time', 'payment_method'], 'required'],
            ['service_id', 'exist', 'targetClass' => '\app\modules\beauty\models\Service', 'targetAttribute' => 'id'],
            ['master_id', 'exist', 'targetClass' => '\app\modules\beauty\models\Master', 'targetAttribute' => 'id'],
            ['appointment_date', 'date', 'format' => 'php:Y-m-d'],
            ['appointment_date', 'compare', 'compareValue' => date('Y-m-d'), 'operator' => '>=', 'message' => 'Дата должна быть не раньше сегодняшнего дня'],
            ['appointment_time', 'match', 'pattern' => '/^\d{2}:\d{2}$/', 'message' => 'Неверный формат времени'],
            ['payment_method', 'in', 'range' => ['cash', 'card']],
            ['notes', 'string', 'max' => 1000],
            ['appointment_time', 'validateAvailableTime'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'service_id' => 'Услуга',
            'master_id' => 'Мастер',
            'appointment_date' => 'Дата записи',
            'appointment_time' => 'Время записи',
            'payment_method' => 'Способ оплаты',
            'notes' => 'Дополнительная информация',
        ];
    }

    /**
     * Validates if the selected time is available for the master.
     */
    public function validateAvailableTime($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $master = Master::findOne($this->master_id);
            if (!$master) {
                $this->addError($attribute, 'Мастер не найден.');
                return;
            }

            $dayOfWeek = date('N', strtotime($this->appointment_date)); // 1 = Monday, 7 = Sunday

            $schedule = Schedule::find()
                ->where(['master_id' => $this->master_id, 'day_of_week' => $dayOfWeek, 'is_available' => true])
                ->one();

            if (!$schedule) {
                $this->addError($attribute, 'Мастер не работает в выбранный день.');
                return;
            }

            if ($this->appointment_time < $schedule->start_time || $this->appointment_time > $schedule->end_time) {
                $this->addError($attribute, 'Мастер не работает в выбранное время.');
                return;
            }

            // Check if time slot is already booked
            $service = Service::findOne($this->service_id);
            if ($service) {
                $endTime = date('H:i', strtotime($this->appointment_time) + ($service->duration * 60));

                $existingOrder = Order::find()
                    ->where(['master_id' => $this->master_id, 'appointment_date' => $this->appointment_date])
                    ->andWhere(['or',
                        ['and', ['<=', 'appointment_time', $this->appointment_time], ['>', 'appointment_time', $endTime]],
                        ['and', ['<', 'appointment_time', $endTime], ['>=', 'appointment_time', $this->appointment_time]]
                    ])
                    ->one();

                if ($existingOrder) {
                    $this->addError($attribute, 'Это время уже занято.');
                }
            }
        }
    }

    /**
     * Creates an order using the provided data.
     * @return Order|null the saved model or null if saving fails
     */
    public function createOrder()
    {
        if (!$this->validate()) {
            return null;
        }

        $service = Service::findOne($this->service_id);
        if (!$service) {
            return null;
        }

        $order = new Order();
        $order->client_id = Yii::$app->userBeauty->id;
        $order->master_id = $this->master_id;
        $order->service_id = $this->service_id;
        $order->appointment_date = $this->appointment_date;
        $order->appointment_time = $this->appointment_time;
        $order->status = 'new';
        $order->payment_method = $this->payment_method;
        $order->total_price = $service->price;
        $order->notes = $this->notes;

        if ($order->save()) {
            return $order;
        }

        // Логируем ошибки сохранения
        Yii::error('Order save failed: ' . json_encode($order->getErrors()), 'booking');
        return null;
    }
}
