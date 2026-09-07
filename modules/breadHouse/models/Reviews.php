<?php

namespace app\modules\breadHouse\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "breadHouse_reviews".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property int $product_id
 * @property int $rating
 * @property string|null $comment
 * @property int $created_at
 *
 * @property Orders $order
 * @property Product $product
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
        return Yii::$app->get('breadHouse');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'default', 'value' => null],
            [['order_id', 'user_id', 'product_id', 'rating'], 'required'],
            [['order_id', 'user_id', 'product_id', 'rating'], 'integer'],
            [['comment'], 'string'],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::class, 'targetAttribute' => ['order_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        return [
            'id',
            'order_id',
            'user_id',
            'product_id',
            'rating',
            'comment',
            'created_at',
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
            'product_id' => Yii::t('app', 'Товар'),
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
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
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

    /**
     * Update product rating after saving a review
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->updateProductRating();
    }

    /**
     * Update product rating after deleting a review
     */
    public function afterDelete()
    {
        parent::afterDelete();
        $this->updateProductRating();
    }

    /**
     * Recalculate ratings for all products (useful for existing reviews)
     */
    public static function recalculateAllProductRatings()
    {
        // Get all unique product IDs that have reviews
        $productIds = Reviews::find()
            ->select('product_id')
            ->distinct()
            ->column();

        foreach ($productIds as $productId) {
            // Calculate average rating for this product
            $averageRating = Reviews::find()
                ->where(['product_id' => $productId])
                ->average('rating');

            // Round to 1 decimal place
            $averageRating = round($averageRating, 1);

            // Update the product rating
            Product::updateAll(['rating' => $averageRating], ['id' => $productId]);

            Yii::info("Recalculated rating for product $productId: $averageRating", 'ratings');
        }

        return count($productIds);
    }

    protected function updateProductRating()
    {
        $productId = $this->product_id;

        // Calculate average rating from all reviews for this product
        $reviews = Reviews::find()
            ->where(['product_id' => $productId])
            ->all();

        $totalRating = 0;
        $reviewCount = count($reviews);

        foreach ($reviews as $review) {
            $totalRating += $review->rating;
        }

        $averageRating = $reviewCount > 0 ? $totalRating / $reviewCount : 0;
        $averageRating = round($averageRating, 1);

        // Debug logging
        Yii::info("Updating product $productId rating: $averageRating (from $reviewCount reviews)", 'ratings');

        // Update the product rating
        $updated = Product::updateAll(['rating' => $averageRating], ['id' => $productId]);

        Yii::info("Product rating update result: $updated rows affected for product $productId", 'ratings');

        return $averageRating;
    }
}
