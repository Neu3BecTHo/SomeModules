<?php

namespace app\modules\tours\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tour_reviews".
 *
 * @property int $id
 * @property int $user_id
 * @property int $tour_id
 * @property int|null $request_id
 * @property int $rating
 * @property string $text
 * @property string|null $created_at
 *
 * @property Requests $request
 * @property Tours $tour
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
        return Yii::$app->get('tours');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['request_id'], 'default', 'value' => null],
            [['rating'], 'default', 'value' => 5],
            ['rating', 'integer', 'min' => 1, 'max' => 5],
            [['user_id', 'tour_id', 'raiting', 'text'], 'required'],
            [['user_id', 'tour_id', 'request_id', 'rating'], 'integer'],
            [['text'], 'string'],
            [['created_at', 'request_id'], 'safe'],
            [['request_id'], 'exist', 'skipOnError' => true, 'targetClass' => Requests::class, 'targetAttribute' => ['request_id' => 'id']],
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
            'request_id' => Yii::t('app', 'Заявка'),
            'rating' => Yii::t('app', 'Рейтинг'),
            'text' => Yii::t('app', 'Текст'),
            'created_at' => Yii::t('app', 'Создано'),
        ];
    }

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Requests::class, ['id' => 'request_id']);
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
