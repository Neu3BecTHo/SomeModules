<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photoshoot_bookings".
 *
 * @property int $id
 * @property int $user_id
 * @property string $service_type
 * @property string|null $hall_type
 * @property string $duration
 * @property string|null $photo_session_type
 * @property string $booking_date
 * @property int $people_count
 * @property string|null $wishes
 * @property string $payment_method
 * @property string $status
 * @property float $total_price
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 * @property Review $review
 */
class Booking extends ActiveRecord
{
    const STATUS_NEW = 'new';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    const SERVICE_RENT = 'rent';
    const SERVICE_PHOTOSESSION = 'photoshoot';
    const SERVICE_RETouch = 'retouch';
    const SERVICE_PHOTOBOOK = 'photobook';

    const HALL_SMALL = 'small';
    const HALL_LARGE = 'large';

    const DURATION_25 = '25min';
    const DURATION_55 = '55min';
    const DURATION_2H = '2hour';
    const DURATION_3H = '3hour';

    const SESSION_SCHOOL = 'school';
    const SESSION_FAMILY = 'family';
    const SESSION_INDIVIDUAL = 'individual';
    const SESSION_THEMATIC = 'thematic';

    const PAYMENT_CASH = 'cash';
    const PAYMENT_CARD = 'card';
    const PAYMENT_TRANSFER = 'transfer';

    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
    }

    public static function tableName()
    {
        return '{{%bookings}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'service_type', 'duration', 'booking_date', 'people_count', 'payment_method'], 'required'],
            [['user_id', 'people_count'], 'integer'],
            [['booking_date', 'created_at', 'updated_at'], 'safe'],
            [['total_price'], 'number'],
            [['service_type'], 'in', 'range' => [self::SERVICE_RENT, self::SERVICE_PHOTOSESSION, self::SERVICE_RETouch, self::SERVICE_PHOTOBOOK]],
            [['hall_type'], 'in', 'range' => [self::HALL_SMALL, self::HALL_LARGE]],
            [['duration'], 'in', 'range' => [self::DURATION_25, self::DURATION_55, self::DURATION_2H, self::DURATION_3H]],
            [['photo_session_type'], 'in', 'range' => [self::SESSION_SCHOOL, self::SESSION_FAMILY, self::SESSION_INDIVIDUAL, self::SESSION_THEMATIC]],
            [['payment_method'], 'in', 'range' => [self::PAYMENT_CASH, self::PAYMENT_CARD, self::PAYMENT_TRANSFER]],
            [['status'], 'in', 'range' => [self::STATUS_NEW, self::STATUS_ACCEPTED, self::STATUS_COMPLETED, self::STATUS_CANCELLED]],
            [['wishes'], 'string'],
            [['hall_type'], 'required', 'when' => function($model) {
                return in_array($model->service_type, [self::SERVICE_RENT, self::SERVICE_PHOTOSESSION]);
            }, 'whenClient' => "function (attribute, value) {\n                return $('#booking-service_type').val() === 'rent' || $('#booking-service_type').val() === 'photoshoot';\n            }"],
            [['photo_session_type'], 'required', 'when' => function($model) {
                return $model->service_type === self::SERVICE_PHOTOSESSION;
            }, 'whenClient' => "function (attribute, value) {\n                return $('#booking-service_type').val() === 'photoshoot';\n            }"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'service_type' => 'Тип услуги',
            'hall_type' => 'Зал',
            'duration' => 'Длительность',
            'photo_session_type' => 'Тип фотосессии',
            'booking_date' => 'Дата и время',
            'people_count' => 'Количество человек',
            'wishes' => 'Пожелания',
            'payment_method' => 'Способ оплаты',
            'status' => 'Статус',
            'total_price' => 'Итоговая цена',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getReview()
    {
        return $this->hasOne(Review::class, ['booking_id' => 'id']);
    }

    public static function getServiceTypeLabels()
    {
        return [
            self::SERVICE_RENT => 'Аренда зала',
            self::SERVICE_PHOTOSESSION => 'Фотосессия',
            self::SERVICE_RETouch => 'Ретушь фото',
            self::SERVICE_PHOTOBOOK => 'Фотокнига',
        ];
    }

    public static function getHallTypeLabels()
    {
        return [
            self::HALL_SMALL => 'Малый зал',
            self::HALL_LARGE => 'Большой зал',
        ];
    }

    public static function getDurationLabels()
    {
        return [
            self::DURATION_25 => '25 минут',
            self::DURATION_55 => '55 минут',
            self::DURATION_2H => '2 часа',
            self::DURATION_3H => '3 часа',
        ];
    }

    public static function getSessionTypeLabels()
    {
        return [
            self::SESSION_SCHOOL => 'Школьная',
            self::SESSION_FAMILY => 'Семейная',
            self::SESSION_INDIVIDUAL => 'Индивидуальная',
            self::SESSION_THEMATIC => 'Тематическая',
        ];
    }

    public static function getPaymentMethodLabels()
    {
        return [
            self::PAYMENT_CASH => 'Наличными',
            self::PAYMENT_CARD => 'Банковской картой',
            self::PAYMENT_TRANSFER => 'Перевод',
        ];
    }

    public static function getStatusLabels()
    {
        return [
            self::STATUS_NEW => 'Новая',
            self::STATUS_ACCEPTED => 'Принята',
            self::STATUS_COMPLETED => 'Услуга оказана',
            self::STATUS_CANCELLED => 'Отменена',
        ];
    }

    public function getStatusLabel()
    {
        return self::getStatusLabels()[$this->status] ?? $this->status;
    }

    public function calculatePrice()
    {
        $prices = [
            self::SERVICE_RENT => [
                self::HALL_SMALL => [
                    self::DURATION_25 => 1200,
                    self::DURATION_55 => 2000,
                    self::DURATION_2H => 4000,
                    self::DURATION_3H => 6000,
                ],
                self::HALL_LARGE => [
                    self::DURATION_25 => 1500,
                    self::DURATION_55 => 2500,
                    self::DURATION_2H => 5000,
                    self::DURATION_3H => 7500,
                ],
            ],
            self::SERVICE_PHOTOSESSION => [
                self::HALL_SMALL => [
                    self::DURATION_25 => 6000,
                    self::DURATION_55 => 10000,
                ],
                self::HALL_LARGE => [
                    self::DURATION_25 => 6000,
                    self::DURATION_55 => 10000,
                ],
            ],
        ];

        if (isset($prices[$this->service_type][$this->hall_type][$this->duration])) {
            return $prices[$this->service_type][$this->hall_type][$this->duration];
        }

        return 0;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->status = self::STATUS_NEW;
            }
            $this->total_price = $this->calculatePrice();
            return true;
        }
        return false;
    }
}
