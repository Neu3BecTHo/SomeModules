<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot\controllers;

use app\modules\photoshoot\models\Booking;
use app\modules\photoshoot\models\BookingSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class BookingController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new BookingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdateStatus($id, $status)
    {
        $model = $this->findModel($id);

        $allowedStatuses = [Booking::STATUS_NEW, Booking::STATUS_ACCEPTED, Booking::STATUS_COMPLETED, Booking::STATUS_CANCELLED];
        if (!in_array($status, $allowedStatuses, true)) {
            throw new NotFoundHttpException('Некорректный статус.');
        }

        $model->status = $status;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Статус заявки обновлен.');
        } else {
            Yii::$app->session->setFlash('error', 'Не удалось обновить статус.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Booking::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Заявка не найдена.');
    }
}
