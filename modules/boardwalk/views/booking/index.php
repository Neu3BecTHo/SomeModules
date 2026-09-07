<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\modules\boardwalk\models\Booking[] $bookings */

$this->title = 'Мои заявки';
?>

<div class="user-bookings container section">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Сформировать новую заявку', ['booking/create'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="card">
        <?php if ($bookings): ?>
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Игра</th>
                        <th>Дата сессии</th>
                        <th>Мест</th>
                        <th>Статус</th>
                        <th>Дата заявки</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td>#<?= $booking->id ?></td>
                        <td><?= Html::encode($booking->session->game->title) ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($booking->session->start_at, 'php:d.m.Y H:i') ?></td>
                        <td><?= $booking->players_count ?></td>
                        <td>
                            <span class="status-badge status-<?= $booking->status ?>">
                                <?= $booking->getStatusLabel() ?>
                            </span>
                        </td>
                        <td><?= Yii::$app->formatter->asDate($booking->created_at) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; color: var(--muted); padding: 40px;">
                У вас пока нет активных заявок.
            </p>
        <?php endif; ?>
    </div>
</div>
