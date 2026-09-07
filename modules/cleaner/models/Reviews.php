<?php

namespace app\modules\cleaner\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cleaner_reviews".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $rating
 * @property string|null $comment
 * @property int $created_at
 *
 * @property Orders $order
 * @property User $user
 */
class Reviews extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%reviews}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('cleaner');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'default', 'value' => null],
            [['order_id', 'user_id', 'rating', 'created_at'], 'required'],
            [['order_id', 'user_id', 'rating', 'created_at'], 'integer'],
            [['comment'], 'string'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
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
            'order_id' => Yii::t('app', 'Заказ'),
            'user_id' => Yii::t('app', 'Пользователь'),
            'rating' => Yii::t('app', 'Оценка'),
            'comment' => Yii::t('app', 'Комментарий'),
            'created_at' => Yii::t('app', 'Создано'),
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::class, ['id' => 'order_id']);
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
