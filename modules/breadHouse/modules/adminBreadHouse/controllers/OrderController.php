<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\breadHouse\models\Orders;
use app\modules\breadHouse\modules\adminBreadHouse\models\OrdersSearch;
use app\modules\breadHouse\assets\BreadHouseAdminAsset;

/**
 * Orders management for admin
 */
class OrderController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            // Debug: check what data was loaded
            Yii::info('Order status update - loaded data: ' . json_encode($model->attributes), 'admin-orders');
            Yii::info('Order status update - POST data: ' . json_encode(Yii::$app->request->post()), 'admin-orders');

            if ($model->save()) {
                Yii::info('Order status updated successfully: ' . $model->id . ' -> status ' . $model->status_id, 'admin-orders');
                Yii::$app->session->setFlash('success', 'Статус заказа обновлен.');
                return $this->redirect(['index']);
            } else {
                $errors = $model->getErrors();
                Yii::error('Order status update failed: ' . json_encode($errors), 'admin-orders');
                Yii::$app->session->setFlash('error', 'Ошибка при обновлении статуса: ' . json_encode($errors));
            }
        } else {
            Yii::info('Order status update - load failed, POST data: ' . json_encode(Yii::$app->request->post()), 'admin-orders');
        }

        return $this->render('update-status', [
            'model' => $model,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заказ не найден.');
    }
}
