<?php

namespace app\modules\boardwalk\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "board_subscriptions".
 *
 * @property int $id
 * @property string $email
 * @property int|null $confirmed_at
 * @property int $created_at
 * @property int|null $unsubscribed_at
 * @property string|null $token
 */
class Subscriptions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%subscriptions}}';
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
            [['confirmed_at', 'unsubscribed_at', 'token'], 'default', 'value' => null],
            [['email', 'created_at'], 'required'],
            [['confirmed_at', 'created_at', 'unsubscribed_at'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['token'], 'string', 'max' => 64],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Электронная почта'),
            'confirmed_at' => Yii::t('app', 'Подтверждён'),
            'created_at' => Yii::t('app', 'Создано'),
            'unsubscribed_at' => Yii::t('app', 'Отписан'),
            'token' => Yii::t('app', 'Токен'),
        ];
    }

}
