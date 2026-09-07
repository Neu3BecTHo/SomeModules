<?php

namespace app\modules\beauty\modules\adminBeauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\User;
use app\modules\beauty\models\Order;
use app\modules\beauty\models\Service;
use app\modules\beauty\models\Category;
use app\modules\beauty\models\Schedule;
use app\modules\beauty\models\Photo;
use app\modules\beauty\models\Certificate;

/**
 * Master controller for admin module
 */
class MasterController extends Controller
{
    /**
     * Displays master dashboard.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->with(['orders', 'services'])
            ->one();

        if (!$master) {
            return $this->redirect(['create']);
        }

        $orders = Order::find()
            ->where(['master_id' => $master->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(10)
            ->all();

        return $this->render('index', [
            'master' => $master,
            'orders' => $orders,
        ]);
    }

    /**
     * Creates or updates master profile.
     *
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->one();

        if (!$master) {
            $master = new Master();
            $master->user_id = $user->id;
        }

        if ($master->load(Yii::$app->request->post()) && $master->save()) {
            Yii::$app->session->setFlash('success', 'Профиль мастера успешно сохранен!');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'master' => $master,
        ]);
    }

    /**
     * Manages master services.
     *
     * @return string
     */
    public function actionServices()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->with(['services'])
            ->one();

        if (!$master) {
            throw new NotFoundHttpException('Профиль мастера не найден.');
        }

        $allServices = Service::find()->all();

        return $this->render('services', [
            'master' => $master,
            'allServices' => $allServices,
        ]);
    }

    /**
     * Manages master schedule.
     *
     * @return string
     */
    public function actionSchedule()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->with(['schedule'])
            ->one();

        if (!$master) {
            throw new NotFoundHttpException('Профиль мастера не найден.');
        }

        return $this->render('schedule', [
            'master' => $master,
        ]);
    }

    /**
     * Manages master orders.
     *
     * @return string
     */
    public function actionOrders()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->one();

        if (!$master) {
            throw new NotFoundHttpException('Профиль мастера не найден.');
        }

        $status = Yii::$app->request->get('status');
        $query = Order::find()
            ->where(['master_id' => $master->id]);

        if ($status) {
            $query->andWhere(['status' => $status]);
        }

        $orders = $query->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('orders', [
            'orders' => $orders,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Updates order status.
     *
     * @param int $id
     * @param string $status
     * @return \yii\web\Response
     */
    public function actionUpdateOrder($id, $status)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()
            ->where(['user_id' => $user->id])
            ->one();

        if (!$master) {
            throw new NotFoundHttpException('Профиль мастера не найден.');
        }

        $order = Order::find()
            ->where(['id' => $id, 'master_id' => $master->id])
            ->one();

        if (!$order) {
            throw new NotFoundHttpException('Заказ не найден.');
        }

        $order->status = $status;
        $order->save();

        Yii::$app->session->setFlash('success', 'Статус заказа обновлен.');
        return $this->redirect(['orders']);
    }
}
