<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "breadHouse_categories".
 *
 * @property int $id
 * @property string $title
 *
 * @property Orders[] $orders
 */
class Categories extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%categories}}';
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

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['category_id' => 'id']);
    }

    /**
     * Gets products for this category.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }

    /**
     * Gets active products for this category.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getActiveProducts()
    {
        return $this->getProducts()->andWhere(['>', 'stock', 0]);
    }

}
