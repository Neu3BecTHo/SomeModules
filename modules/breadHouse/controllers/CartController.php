<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseCartAsset;
use app\modules\breadHouse\models\Product;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Cart controller for managing shopping cart
 */
class CartController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseCartAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Add product to cart
     */
    public function actionAdd()
    {
        $productId = Yii::$app->request->post('product_id');
        $quantity = (int)Yii::$app->request->post('quantity', 1);
        $delivery_type = Yii::$app->request->post('delivery_type');
        $delivery_date = Yii::$app->request->post('delivery_date');
        $delivery_time = Yii::$app->request->post('delivery_time');

        $product = Product::findOne(['id' => $productId, ['>', 'stock', 0]]);
        if (!$product) {
            throw new NotFoundHttpException('Товар не найден.');
        }

        if ($quantity > $product->stock) {
            $quantity = $product->stock;
        }

        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        if (isset($cart['items'][$productId])) {
            $cart['items'][$productId] += $quantity;
        } else {
            $cart['items'][$productId] = $quantity;
        }

        // Update delivery if provided
        if ($delivery_type) {
            $cart['delivery'] = [
                'type' => $delivery_type,
                'date' => $delivery_date,
                'time' => $delivery_time,
            ];
        }

        Yii::$app->session->set('cart', $cart);

        Yii::$app->session->setFlash('success', 'Товар добавлен в корзину.');
        return $this->redirect(Yii::$app->request->referrer ?: ['main/index']);
    }

    /**
     * View cart
     */
    public function actionIndex()
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        $products = [];
        $total = 0;

        foreach ($cart['items'] as $productId => $quantity) {
            $product = Product::findOne($productId);
            if ($product && $product->stock > 0) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity,
                ];
                $total += $product->price * $quantity;
            }
        }

        return $this->render('index', [
            'products' => $products,
            'total' => $total,
            'delivery' => $cart['delivery'],
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function actionUpdate($id)
    {
        $quantity = (int)Yii::$app->request->post('quantity', 1);

        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        if (isset($cart['items'][$id])) {
            if ($quantity <= 0) {
                unset($cart['items'][$id]);
            } else {
                $product = Product::findOne($id);
                if ($product && $quantity <= $product->stock) {
                    $cart['items'][$id] = $quantity;
                }
            }
            Yii::$app->session->set('cart', $cart);
        }

        return $this->redirect(['index']);
    }

    /**
     * Remove item from cart
     */
    public function actionDelete($id)
    {
        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        unset($cart['items'][$id]);
        Yii::$app->session->set('cart', $cart);

        return $this->redirect(['index']);
    }
}
