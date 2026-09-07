<?php

namespace app\modules\photoshoot\controllers;

use app\modules\photoshoot\models\Booking;
use app\modules\photoshoot\models\Review;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class BookingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'view', 'cancel'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'user' => 'userPhotoshoot',
            ],
        ];
    }

    public function actionIndex()
    {
        $bookings = Booking::find()
            ->where(['user_id' => Yii::$app->userPhotoshoot->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'bookings' => $bookings,
        ]);
    }

    public function actionCreate()
    {
        $model = new Booking();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id = Yii::$app->userPhotoshoot->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Бронирование успешно создано!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        $model = Booking::findOne(['id' => $id, 'user_id' => Yii::$app->userPhotoshoot->id]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Бронирование не найдено.');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCancel($id)
    {
        $model = Booking::findOne(['id' => $id, 'user_id' => Yii::$app->userPhotoshoot->id]);

        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Бронирование не найдено.');
        }

        if ($model->status === Booking::STATUS_NEW) {
            $model->status = Booking::STATUS_CANCELLED;
            $model->save();
            Yii::$app->session->setFlash('success', 'Бронирование отменено.');
        } else {
            Yii::$app->session->setFlash('error', 'Нельзя отменить это бронирование.');
        }

        return $this->redirect(['index']);
    }

    public function actionReview($id)
    {
        $booking = Booking::findOne(['id' => $id, 'user_id' => Yii::$app->userPhotoshoot->id]);

        if (!$booking || $booking->status !== Booking::STATUS_COMPLETED) {
            throw new \yii\web\NotFoundHttpException('Бронирование не найдено или услуга не оказана.');
        }

        $existingReview = Review::findOne(['booking_id' => $id]);
        if ($existingReview) {
            Yii::$app->session->setFlash('info', 'Вы уже оставили отзыв для этого бронирования.');
            return $this->redirect(['index']);
        }

        $model = new Review();
        $model->user_id = Yii::$app->userPhotoshoot->id;
        $model->booking_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Спасибо за ваш отзыв!');
            return $this->redirect(['index']);
        }

        return $this->render('review', [
            'model' => $model,
            'booking' => $booking,
        ]);
    }
}
