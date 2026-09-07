<?php

namespace app\modules\cleaner\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "cleaner_orders".
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $address
 * @property string $payment_type
 * @property string|null $extra_info
 * @property string|null $item_type
 * @property string|null $material
 * @property string|null $pollution_level
 * @property string|null $carpet_size
 * @property int $status_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Categories $category
 * @property Reviews[] $reviews
 * @property User $user
 */
class Orders extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
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
            [['extra_info', 'item_type', 'material', 'pollution_level', 'carpet_size'], 'default', 'value' => null],
            [['status_id'], 'default', 'value' => 1],
            [['user_id', 'category_id', 'address', 'payment_type'], 'required'],
            [['user_id', 'category_id', 'created_at', 'updated_at'], 'integer'],
            [['extra_info'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['payment_type'], 'string', 'max' => 20],
            [['item_type', 'material'], 'string', 'max' => 100],
            [['pollution_level', 'carpet_size'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'category_id' => Yii::t('app', 'Категория'),
            'address' => Yii::t('app', 'Адрес'),
            'payment_type' => Yii::t('app', 'Тип оплаты'),
            'extra_info' => Yii::t('app', 'Дополнительная информация'),
            'item_type' => Yii::t('app', 'Тип предмета'),
            'material' => Yii::t('app', 'Материал'),
            'pollution_level' => Yii::t('app', 'Уровень загрязнения'),
            'carpet_size' => Yii::t('app', 'Размер коврика'),
            'status_id' => Yii::t('app', 'Статус'),
            'created_at' => Yii::t('app', 'Создано'),
            'updated_at' => Yii::t('app', 'Обновлено'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Reviews::class, ['order_id' => 'id']);
    }

    public function getStatus()
    {
        return $this->hasOne(Statuses::class, ['id' => 'status_id']);
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
