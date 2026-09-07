<?php

namespace app\modules\photoshoot\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "photoshoot_reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property int $booking_id
 * @property int $rating
 * @property string $comment
 * @property int $is_published
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $user
 * @property Booking $booking
 */
class Review extends ActiveRecord
{
    public static function getDb()
    {
        return Yii::$app->get('photoshoot');
    }

    public static function tableName()
    {
        return '{{%reviews}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'booking_id', 'rating', 'comment'], 'required'],
            [['user_id', 'booking_id', 'rating', 'is_published'], 'integer'],
            [['comment'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['rating'], 'in', 'range' => [1, 2, 3, 4, 5]],
            [['booking_id'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'booking_id' => 'Бронирование',
            'rating' => 'Оценка',
            'comment' => 'Отзыв',
            'is_published' => 'Опубликован',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getBooking()
    {
        return $this->hasOne(Booking::class, ['id' => 'booking_id']);
    }
}
