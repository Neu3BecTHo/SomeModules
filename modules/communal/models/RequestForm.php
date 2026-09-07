<?php

namespace app\modules\communal\models;

use Yii;
use yii\base\Model;
use yii\behaviors\TimestampBehavior; // Если в модели Request подключен TimestampBehavior

class RequestForm extends Model
{
    public $service_type_id;
    public $current_value;
    public $previous_value;

    public function rules()
    {
        return [
            [['service_type_id', 'current_value', 'previous_value'], 'required', 'message' => 'Обязательно для заполнения'],
            [['current_value', 'previous_value'], 'number', 'min' => 0],
            [['service_type_id'], 'integer'],
            // Валидация: текущее >= предыдущее
            ['current_value', 'compare', 'compareAttribute' => 'previous_value', 'operator' => '>=', 'type' => 'number', 'message' => 'Текущие показания не могут быть меньше предыдущих.'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'service_type_id' => 'Тип услуги',
            'current_value' => 'Текущие показания',
            'previous_value' => 'Предыдущие показания',
        ];
    }

    /**
     * Создает новую запись в таблице requests, заполняя все обязательные поля
     */
    public function createRequest($user_id)
    {
        if (!$this->validate()) {
            return false;
        }

        $request = new Requests();
        $request->user_id = $user_id;
        $request->service_type_id = $this->service_type_id;
        $request->previous_value = $this->previous_value;
        $request->current_value = $this->current_value;

        $request->status_id = 1;

        // 2. Расчет расхода (Consumption)
        // По ТЗ это notNull, поэтому считаем здесь
        $consumption = $this->current_value - $this->previous_value;
        // Защита от отрицательного значения (на всякий случай, хотя валидатор выше не пустит)
        $request->consumption = ($consumption > 0) ? $consumption : 0;

        // 3. Получение тарифа (Tariff Snapshot)
        // Нам нужно найти тариф из БД service_types, чтобы сохранить его в заявку
        $service = ServiceTypes::findOne($this->service_type_id);
        
        if (!$service) {
            $this->addError('service_type_id', 'Услуга не найдена');
            return false;
        }

        $request->tariff_snapshot = $service->tariff; // Сохраняем "снимок" тарифа

        // 4. Расчет итоговой суммы (Amount)
        $request->amount = $request->consumption * $request->tariff_snapshot;

        // 5. Дата подачи
        $request->date_submitted = date('Y-m-d H:i:s'); // Для поля date_submitted

        return $request->save();
    }
}
