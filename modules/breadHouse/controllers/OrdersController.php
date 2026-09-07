<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseOrdersAsset;
use app\modules\breadHouse\models\Orders;
use app\modules\breadHouse\models\OrderForm;
use app\modules\breadHouse\models\Categories;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrdersController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseOrdersAsset::register($this->view);

            if (Yii::$app->userBreadHouse->isGuest) {
                return $this->redirect(['main/index']);
            }
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $userId = Yii::$app->userBreadHouse->id;

        $query = Orders::find()
            ->where(['user_id' => $userId])
            ->with('orderItems.product')
            ->orderBy(['created_at' => SORT_DESC]);

        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'pageSize' => 10, // 10 orders per page
        ]);

        $orders = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('index', [
            'orders' => $orders,
            'pagination' => $pagination,
        ]);
    }

    public function actionRepeat($id)
    {
        $order = Orders::findOne(['id' => $id, 'user_id' => Yii::$app->userBreadHouse->id]);
        if (!$order) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        $cart = Yii::$app->session->get('cart', ['items' => [], 'delivery' => []]);
        foreach ($order->orderItems as $item) {
            if ($item->product->stock > 0) {
                $cart['items'][$item->product_id] = ($cart['items'][$item->product_id] ?? 0) + $item->quantity;
            }
        }

        Yii::$app->session->set('cart', $cart);

        Yii::$app->session->setFlash('success', 'Заказ добавлен в корзину.');
        return $this->redirect(['cart/index']);
    }
}
