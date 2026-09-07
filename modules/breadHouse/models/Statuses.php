<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "breadHouse_statuses".
 *
 * @property int $id
 * @property string $title
 */
class Statuses extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%statuses}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('breadHouse');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title'], 'string', 'max' => 150],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Заголовок'),
        ];
    }

    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['status_id' => 'id']);
    }
}
