<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "board_booking".
 *
 * @property int $id
 * @property int $session_id
 * @property int|null $user_id
 * @property string $name
 * @property string $phone
 * @property string|null $email
 * @property int $players_count
 * @property string $game_type
 * @property string $player_status
 * @property string $payment_method
 * @property string $status
 * @property string|null $created_at
 *
 * @property GameSessions $session
 * @property User $user
 */
class Booking extends ActiveRecord
{
    public $agree;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%booking}}';
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
            [['user_id', 'email'], 'default', 'value' => null],
            [['players_count'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => 'new'],
            [['session_id', 'name', 'phone', 'game_type', 'agree', 'player_status', 'payment_method', 'players_count'], 'required'],
            [['session_id', 'user_id', 'players_count'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'email', 'player_status', 'payment_method'], 'string', 'max' => 255],
            ['session_id', function ($attribute) {
                $session = GameSessions::findOne($this->$attribute);
                if ($session && $session->seats_taken >= $session->seats_total) {
                    $this->addError($attribute, 'К сожалению, все места на эту игру уже заняты.');
                }
            }],
            [['phone'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 20],
            [['session_id'], 'exist', 'skipOnError' => true, 'targetClass' => GameSessions::class, 'targetAttribute' => ['session_id' => 'id']],
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
            'session_id' => Yii::t('app', 'Сессия'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'name' => Yii::t('app', 'Название'),
            'phone' => Yii::t('app', 'Номер телефона'),
            'email' => Yii::t('app', 'Элеткронная почта'),
            'players_count' => Yii::t('app', 'Число игроков'),
            'game_type' => Yii::t('app', 'Тип игры'),
            'agree' => Yii::t('app', 'Согласие'),
            'player_status' => Yii::t('app', 'Статус игрока'),
            'payment_method' => Yii::t('app', 'Способ оплаты'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
        ];
    }

    public function getStatusLabel()
    {
        $labels = [
            'new' => 'Новая',
            'confirmed' => 'Подтверждена',
            'cancelled' => 'Отменена',
        ];
        return $labels[$this->status] ?? $this->status;
    }


    /**
     * Gets query for [[Session]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSession()
    {
        return $this->hasOne(GameSessions::class, ['id' => 'session_id']);
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

}
