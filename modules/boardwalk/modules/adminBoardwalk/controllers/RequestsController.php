<?php

namespace app\modules\boardwalk\modules\adminBoardwalk\controllers;

use app\modules\boardwalk\models\Booking;
use app\modules\boardwalk\assets\BoardwalkAdminAsset;
use Yii;
use yii\web\Controller;

class RequestsController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BoardwalkAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $bookings = Booking::find()->orderBy(['created_at' => SORT_DESC])->all();
        
        $stats = [
            'total' => Booking::find()->count(),
            'new' => Booking::find()->where(['status' => 'new'])->count(),
            'completed' => Booking::find()->where(['status' => 'completed'])->count(),
        ];

        return $this->render('index', [
            'bookings' => $bookings,
            'stats' => $stats
        ]);
    }

    public function actionUpdateStatus($id, $status)
    {
        $model = Booking::findOne($id);
        $validStatuses = ['approved', 'completed', 'cancelled'];
        
        if ($model && in_array($status, $validStatuses)) {
            $model->updateAttributes(['status' => $status]);
            Yii::$app->session->setFlash('success', "Статус заявки #{$id} обновлен.");
        }
        return $this->redirect(['index']);
    }
}