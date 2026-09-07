<?php

namespace app\modules\boardwalk\controllers;

use Yii;
use yii\web\Controller;
use app\modules\boardwalk\models\Booking;
use app\modules\boardwalk\assets\BoardwalkBookingAsset;
use app\modules\boardwalk\models\Games;
use app\modules\boardwalk\models\GameSessions;

class BookingController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BoardwalkBookingAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $bookings = Booking::find()
            ->where(['user_id' => Yii::$app->userBoardwalk->id])
            ->joinWith('session.game') 
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'bookings' => $bookings,
        ]);
    }

    public function actionCreate()
    {
        $model = new Booking();

        if (!Yii::$app->userBoardwalk->isGuest) {
            $user = Yii::$app->userBoardwalk->identity;
            $model->name = $user->fullName();
            $model->email = $user->email;
            $model->phone = $user->phone;
            $model->user_id = $user->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            
            GameSessions::updateAllCounters(
                ['seats_taken' => 1], 
                ['id' => $model->session_id]
            );

            Yii::$app->session->setFlash('success', 'Запись подтверждена!');
            return $this->redirect(['index']);
        }

        $sessions = GameSessions::find()
            ->where(['between', 'start_at', date('Y-m-d H:i:s'), date('Y-m-d H:i:s', strtotime('+1 month'))])
            ->all();

        return $this->render('create', [
            'model' => $model,
            'sessions' => $sessions,
        ]);
    }

    /**
     * Метод для отправки уведомления
     */
    protected function sendBookingEmail($model)
    {
        return Yii::$app->mailer->compose(
                ['html' => 'booking-notification-html'], // имя файла шаблона
                ['model' => $model] // данные для шаблона
            )
            ->setFrom([Yii::$app->params['adminEmail'] => 'Клуб Настолка'])
            ->setTo($model->email)
            ->setSubject('Подтверждение бронирования на игру: ' . $model->session->game->title)
            ->send();
    }

    public function actionGetGames($type)
    {
        $games = Games::find()->where(['category' => $type])->all();
        echo "<option value=''>Выберите игру...</option>";
        foreach ($games as $game) {
            echo "<option value='{$game->id}'>{$game->title}</option>";
        }
    }

    public function actionGetGamesByCategory($category)
    {
        $games = Games::find()->where(['category' => $category])->all();
        
        $options = "<option value=''>Выберите игру...</option>";
        foreach ($games as $game) {
            $options .= "<option value='{$game->id}'>{$game->title}</option>";
        }
        return $options;
    }
}