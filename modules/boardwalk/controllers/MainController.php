<?php

namespace app\modules\boardwalk\controllers;

use app\modules\boardwalk\assets\BoardwalkMainAsset;
use app\modules\boardwalk\models\Booking;
use app\modules\boardwalk\models\Games;
use app\modules\boardwalk\models\GameSessions;
use app\modules\boardwalk\models\Reviews;
use app\modules\boardwalk\models\Subscriptions;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BoardwalkMainAsset::register($this->view);
            return true;
        }
        return false;
    }
    
    public function actionIndex()
    {
        // 1. Популярные игры для слайдера
        $popularGames = Games::find()->where(['is_popular' => true])->limit(5)->all();

        // 2. Каталог игр (например, последние 6)
        $catalogGames = Games::find()->limit(6)->orderBy(['created_at' => SORT_DESC])->all();

        // 3. График игр на ближайший месяц
        $nextMonth = date('Y-m-d H:i:s', strtotime('+1 month'));
        $sessions = GameSessions::find()
            ->where(['between', 'start_at', date('Y-m-d H:i:s'), $nextMonth])
            ->with('game') // жадная загрузка связи с игрой
            ->orderBy(['start_at' => SORT_ASC])
            ->all();

        // 4. Отзывы (только опубликованные)
        $reviews = Reviews::find()->where(['is_published' => true])->limit(3)->all();

        // Модели для форм (запись и подписка)
        $bookingModel = new Booking();
        $subscriptionModel = new Subscriptions();

        return $this->render('index', [
            'popularGames' => $popularGames,
            'catalogGames' => $catalogGames,
            'sessions' => $sessions,
            'reviews' => $reviews,
            'bookingModel' => $bookingModel,
            'subscriptionModel' => $subscriptionModel,
        ]);
    }

    public function actionBooking()
    {
        $model = new Booking();

        if ($model->load(Yii::$app->request->post())) {
            if (!Yii::$app->userBoardwalk->isGuest) {
                $model->user_id = Yii::$app->userBoardwalk->id;
                $model->email = Yii::$app->userBoardwalk->identity->email;
            }

            $model->status = 'new';

            if ($model->save()) {
                $this->sendBookingEmail($model);

                Yii::$app->session->setFlash('success', 'Вы успешно записаны на игру! Проверьте почту.');
                return $this->redirect(['index', '#' => 'booking']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка заполнения формы.');
            }
        }

        return $this->redirect(['index']);
    }

    protected function sendBookingEmail($model)
    {
        try {
            return Yii::$app->mailer->compose(
                ['html' => 'booking-notification-html'], 
                ['model' => $model]
            )
            ->setFrom([Yii::$app->params['adminEmail'] => 'Boardwalk Club'])
            ->setTo($model->email)
            ->setSubject('Подтверждение бронирования: ' . $model->session->game->title)
            ->send();
        } catch (\Exception $e) {
            Yii::error("Ошибка отправки почты: " . $e->getMessage());
            return false;
        }
    }

    public function actionPolicy()
    {
        return $this->render('policy');
    }
}
