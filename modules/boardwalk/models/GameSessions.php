<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "board_game_sessions".
 *
 * @property int $id
 * @property int $game_id
 * @property string $start_at
 * @property string|null $end_at
 * @property int $seats_total
 * @property int $seats_taken
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Booking[] $bookings
 * @property Games $game
 */
class GameSessions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%game_sessions}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('boardwalk');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['end_at'], 'default', 'value' => null],
            [['seats_total'], 'default', 'value' => 4],
            [['seats_taken'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 'planned'],
            [['game_id', 'start_at'], 'required'],
            [['game_id', 'seats_total', 'seats_taken'], 'integer'],
            [['start_at', 'end_at', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'string', 'max' => 20],
            [['game_id'], 'exist', 'skipOnError' => true, 'targetClass' => Games::class, 'targetAttribute' => ['game_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('app', 'Игра'),
            'start_at' => Yii::t('app', 'Начало'),
            'end_at' => Yii::t('app', 'Конец'),
            'seats_total' => Yii::t('app', 'Количество мест'),
            'seats_taken' => Yii::t('app', 'Количество занятых мест'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[Bookings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookings()
    {
        return $this->hasMany(Booking::class, ['session_id' => 'id']);
    }

    /**
     * Gets query for [[Game]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGame()
    {
        return $this->hasOne(Games::class, ['id' => 'game_id']);
    }

}
