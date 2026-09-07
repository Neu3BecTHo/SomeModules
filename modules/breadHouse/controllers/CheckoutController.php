<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseCheckoutAsset;
use app\modules\breadHouse\models\OrderForm;
use app\modules\breadHouse\models\Orders;
use app\modules\breadHouse\models\OrderItem;
use app\modules\breadHouse\models\Product;
use Yii;
use yii\web\Controller;

/**
 * Checkout controller for order processing
 */
class CheckoutController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseCheckoutAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Checkout form
     */
    public function actionIndex()
    {
        if (Yii::$app->userBreadHouse->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        if (empty($cart['items'])) {
            return $this->redirect(['cart/index']);
        }

        if (Yii::$app->request->isPost) {
            $delivery_type = Yii::$app->request->post('delivery_type');
            $delivery_address = Yii::$app->request->post('delivery_address');
            $delivery_date = Yii::$app->request->post('delivery_date');
            $delivery_time = Yii::$app->request->post('delivery_time');
            $payment_method = Yii::$app->request->post('payment_method');

            // Combine date and time into proper datetime format
            $delivery_datetime = null;
            if ($delivery_date && $delivery_time) {
                $delivery_datetime = $delivery_date . ' ' . $delivery_time . ':00';
            }

            // Calculate total
            $total = 0;
            $items = [];
            foreach ($cart['items'] as $productId => $quantity) {
                $product = Product::findOne($productId);
                if ($product) {
                    $subtotal = $product->price * $quantity;
                    $total += $subtotal;
                    $items[] = ['product' => $product, 'quantity' => $quantity, 'price' => $product->price];
                }
            }

            // Save order
            $order = new Orders();
            $order->user_id = Yii::$app->userBreadHouse->id;
            // Set category_id to the category of the first product in the order
            $firstProduct = reset($items);
            $order->category_id = $firstProduct ? $firstProduct['product']->category_id : 1;
            $order->address = $delivery_type == 'pickup' ? 'Самовывоз' : $delivery_address;
            $order->payment_type = $payment_method == 'cash' ? 'Наличными' : 'Картой';
            $order->delivery_type = $delivery_type;
            $order->delivery_address = $delivery_address;
            $order->delivery_time = $delivery_datetime;
            $order->payment_method = $payment_method;
            $order->total = $total;
            $order->status_id = 1; // New

            if ($order->save()) {
                // Save order items
                foreach ($items as $item) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $item['product']->id;
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    $orderItem->save();
                }

                // Clear cart
                Yii::$app->session->remove('cart');

                Yii::$app->session->setFlash('success', 'Заказ оформлен!');
                return $this->redirect(['orders/index']);
            } else {
                // Debug: show validation errors
                $errors = $order->getErrors();
                $errorMessage = 'Ошибка при сохранении заказа: ' . json_encode($errors);
                Yii::$app->session->setFlash('error', $errorMessage);

                // Also log the errors and data
                Yii::error('Order save failed: ' . json_encode($errors), 'orders');
                Yii::error('Order data: ' . json_encode($order->attributes), 'orders');
                Yii::error('POST data: ' . json_encode(Yii::$app->request->post()), 'orders');
            }
        }

        // Calculate for display
        $total = 0;
        $products = [];
        foreach ($cart['items'] as $productId => $quantity) {
            $product = Product::findOne($productId);
            if ($product) {
                $subtotal = $product->price * $quantity;
                $total += $subtotal;
                $products[] = ['product' => $product, 'quantity' => $quantity, 'subtotal' => $subtotal];
            }
        }

        return $this->render('index', [
            'products' => $products,
            'total' => $total,
            'delivery' => [
                'type' => 'pickup',
                'address' => '',
                'date' => '',
                'time' => '',
            ],
        ]);
    }
}
