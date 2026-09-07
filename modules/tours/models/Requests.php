<?php

namespace app\modules\tours\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tour_requests".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tour_id
 * @property string $date
 * @property int $participants_count
 * @property string|null $options
 * @property string|null $wishes
 * @property string|null $comment
 * @property string $payment_method
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Reviews[] $reviews
 * @property Tours $tour
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
        return Yii::$app->get('tours');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['options', 'wishes', 'comment'], 'default', 'value' => null],
            [['participants_count'], 'default', 'value' => 1],
            [['status'], 'default', 'value' => 'new'],
            [['user_id', 'tour_id', 'date', 'payment_method'], 'required'],
            [['user_id', 'tour_id', 'participants_count'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['comment'], 'string'],
            ['wishes', 'string', 'max' => 255],
            [['payment_method'], 'string', 'max' => 50],
            [['status'], 'string', 'max' => 30],
            [['tour_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tours::class, 'targetAttribute' => ['tour_id' => 'id']],
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
            'tour_id' => Yii::t('app', 'Тур'),
            'date' => Yii::t('app', 'Дата'),
            'participants_count' => Yii::t('app', 'Количество людей'),
            'options' => Yii::t('app', 'Опции'),
            'wishes' => Yii::t('app', 'Пожелания'),
            'comment' => Yii::t('app', 'Комментарий'),
            'payment_method' => Yii::t('app', 'Метод оплаты'),
            'status' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['request_id' => 'id']);
    }

    /**
     * Gets query for [[Tour]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTour()
    {
        return $this->hasOne(Tours::class, ['id' => 'tour_id']);
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
