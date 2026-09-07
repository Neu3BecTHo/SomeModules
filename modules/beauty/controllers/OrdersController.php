<?php

namespace app\modules\beauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\beauty\models\Order;
use app\modules\beauty\models\Review;

/**
 * Orders controller
 */
class OrdersController extends Controller
{
    /**
     * Lists all user orders.
     *
     * @return string
     */
    public function actionIndex()
    {
        $orders = Order::find()
            ->where(['client_id' => Yii::$app->userBeauty->id])
            ->with(['master.user', 'service'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Displays a single Order model.
     *
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        $order = Order::find()
            ->where(['id' => $id, 'client_id' => Yii::$app->userBeauty->id])
            ->with(['master.user', 'service'])
            ->one();

        if (!$order) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        return $this->render('view', [
            'order' => $order,
        ]);
    }

    /**
     * Creates a review for completed order.
     *
     * @param int $id
     * @return string|\yii\web\Response
     */
    public function actionReview($id)
    {
        $order = Order::find()
            ->where(['id' => $id, 'client_id' => Yii::$app->userBeauty->id, 'status' => 'completed'])
            ->one();

        if (!$order) {
            throw new NotFoundHttpException('Заказ не найден или не завершен.');
        }

        $model = new Review();
        $model->order_id = $order->id;
        $model->client_id = Yii::$app->user->id;
        $model->master_id = $order->master_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Отзыв успешно добавлен!');
            return $this->redirect(['view', 'id' => $order->id]);
        }

        return $this->render('review', [
            'model' => $model,
            'order' => $order,
        ]);
    }

    /**
     * Cancels an order.
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionCancel($id)
    {
        $order = Order::find()
            ->where(['id' => $id, 'client_id' => Yii::$app->userBeauty->id])
            ->one();

        if (!$order) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        if ($order->status !== 'new') {
            Yii::$app->session->setFlash('error', 'Нельзя отменить заказ в статусе "' . $order->status . '"');
            return $this->redirect(['view', 'id' => $order->id]);
        }

        $order->status = 'cancelled';
        $order->save();

        Yii::$app->session->setFlash('success', 'Заказ успешно отменен.');
        return $this->redirect(['index']);
    }
}
