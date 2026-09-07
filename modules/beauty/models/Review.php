<?php

namespace app\modules\beauty\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Review model
 *
 * @property int $id
 * @property int $order_id
 * @property int $client_id
 * @property int $master_id
 * @property int $rating
 * @property string $comment
 * @property string $created_at
 */
class Review extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%beauty_reviews}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'client_id', 'master_id', 'rating'], 'required'],
            [['order_id', 'client_id', 'master_id', 'rating'], 'integer'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5],
            [['comment'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Заказ',
            'client_id' => 'Клиент',
            'master_id' => 'Мастер',
            'rating' => 'Рейтинг',
            'comment' => 'Комментарий',
            'created_at' => 'Создан',
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
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
}
