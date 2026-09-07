<?php
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\boardwalk\models\Booking $model */

$session = $model->session;
$game = $session->game;
?>

<div class="booking-notification">
    <h2>Здравствуйте, <?= Html::encode($model->name) ?>!</h2>
    <p>Вы успешно забронировали место на игру в нашем клубе.</p>

    <table style="width: 100%; border-collapse: collapse; margin: 20px 0; font-family: sans-serif;">
        <tr style="background-color: #f8f9fa;">
            <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Игра:</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;"><?= Html::encode($game->title) ?> (<?= $game->category ?>)</td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Дата и время:</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;"><?= Yii::$app->formatter->asDatetime($session->start_at, 'php:d.m.Y в H:i') ?></td>
        </tr>
        <tr style="background-color: #f8f9fa;">
            <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Адрес:</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;"><?= Html::encode($session->address) ?></td>
        </tr>
        <tr>
            <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Стоимость:</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $session->price ?> ₽</td>
        </tr>
        <tr style="background-color: #f8f9fa;">
            <td style="padding: 10px; border: 1px solid #dee2e6; font-weight: bold;">Способ оплаты:</td>
            <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $model->payment_method ?></td>
        </tr>
    </table>

    <p>Ваш статус игрока: <strong><?= $model->player_status ?></strong></p>
    <p>Ждем вас! Если ваши планы изменятся, пожалуйста, сообщите нам заранее по телефону 8(800)555-35-35.</p>
    
    <hr>
    <p style="font-size: 12px; color: #6c757d;">
        Это автоматическое уведомление от системы бронирования «Настолка». 
        Просмотреть все свои заявки можно в <a href="<?= \yii\helpers\Url::to(['user/index'], true) ?>">Личном кабинете</a>.
    </p>
</div>
