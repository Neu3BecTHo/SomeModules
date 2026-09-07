<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseProductAsset;
use app\modules\breadHouse\models\Product;
use app\modules\breadHouse\models\Reviews;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Product controller for viewing single product
 */
class ProductController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseProductAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Displays a single product with reviews
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $product = Product::findOne(['id' => $id]);
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        // Load reviews for the product
        $reviews = Reviews::find()
            ->where(['product_id' => $id])
            ->with('user')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        // One-time fix: recalculate rating for this product (for existing reviews)
        if (!empty($reviews)) {
            $totalRating = 0;
            foreach ($reviews as $review) {
                $totalRating += $review->rating;
            }
            $averageRating = round($totalRating / count($reviews), 1);

            // Update product rating if it's different
            if ($product->rating != $averageRating) {
                $product->rating = $averageRating;
                $product->save(false); // Skip validation for this update
                Yii::info("Fixed rating for product $id: $averageRating", 'ratings');
            }
        }

        // Check if user can review this product (has any completed orders)
        $userCanReview = false;
        $userOrderId = null;
        if (!Yii::$app->userBreadHouse->isGuest) {
            $userId = Yii::$app->userBreadHouse->id;
            // Find if user has any orders (temporarily remove status restriction for debugging)
            $order = \app\modules\breadHouse\models\Orders::find()
                ->where(['user_id' => $userId])
                ->orderBy(['created_at' => SORT_DESC])
                ->one();

            if ($order) {
                $userCanReview = true;
                $userOrderId = $order->id;
            }
        }

        return $this->render('view', [
            'product' => $product,
            'reviews' => $reviews,
            'reviewModel' => new Reviews(),
            'userCanReview' => $userCanReview,
            'userOrderId' => $userOrderId,
        ]);
    }

    public function actionReview($id)
    {
        if (Yii::$app->userBreadHouse->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $product = Product::findOne(['id' => $id]);
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        // Find the user's most recent order (temporarily remove status restriction)
        $userId = Yii::$app->userBreadHouse->id;
        $order = \app\modules\breadHouse\models\Orders::find()
            ->where(['user_id' => $userId])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        if (!$order) {
            Yii::$app->session->setFlash('error', 'Вы можете оставлять отзывы только если у вас есть завершенные заказы.');
            return $this->redirect(['view', 'id' => $id]);
        }

        $review = new Reviews();
        $review->product_id = $id;
        $review->user_id = $userId;
        $review->order_id = $order->id;

        if ($review->load(Yii::$app->request->post())) {
            // Check if user has already reviewed this product
            $existingReview = Reviews::find()
                ->where(['product_id' => $id, 'user_id' => $userId])
                ->one();

            if ($existingReview) {
                Yii::$app->session->setFlash('error', 'Вы уже оставляли отзыв на этот товар.');
                return $this->redirect(['view', 'id' => $id]);
            }

            if ($review->save()) {
                Yii::$app->session->setFlash('success', 'Отзыв добавлен успешно!');
                return $this->redirect(['view', 'id' => $id]);
            } else {
                $errors = $review->getErrors();
                $errorMessage = 'Ошибка при сохранении отзыва: ' . json_encode($errors);
                Yii::$app->session->setFlash('error', $errorMessage);
            }
        }
        return $this->redirect(['view', 'id' => $id]);
    } 

    public function actionRecalculateRatings()
    {
        if (!Yii::$app->userBreadHouse->isGuest && Yii::$app->userBreadHouse->identity->is_admin) {
            $count = Reviews::recalculateAllProductRatings();
            Yii::$app->session->setFlash('success', "Пересчитаны рейтинги для $count товаров.");
        } else {
            Yii::$app->session->setFlash('error', 'Недостаточно прав для выполнения операции.');
        }

        return $this->redirect(['catalog/index']);
    }
}