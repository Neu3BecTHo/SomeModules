<?php

use yii\bootstrap5\Html;
use app\modules\photoshoot\models\Booking;

/* @var $this yii\web\View */
/* @var $bookings array */

$this->title = 'Мои бронирования';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="mb-3">
        <?= Html::a('Новое бронирование', ['/photoshoot/booking/create'], ['class' => 'btn btn-primary-custom']) ?>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Услуга</th>
                    <th>Дата</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking->id ?></td>
                        <td><?= Booking::getServiceTypeLabels()[$booking->service_type] ?></td>
                        <td><?= Yii::$app->formatter->asDatetime($booking->booking_date) ?></td>
                        <td><?= number_format($booking->total_price, 0, ',', ' ') ?> ₽</td>
                        <td>
                            <span class="badge bg-<?= $booking->status === 'new' ? 'warning' : ($booking->status === 'accepted' ? 'info' : ($booking->status === 'completed' ? 'success' : 'danger')) ?>">
                                <?= $booking->getStatusLabel() ?>
                            </span>
                        </td>
                        <td>
                            <?= Html::a('Просмотр', ['/photoshoot/booking/view', 'id' => $booking->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                            <?php if ($booking->status === Booking::STATUS_NEW): ?>
                                <?= Html::a('Отменить', ['/photoshoot/booking/cancel', 'id' => $booking->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'data-confirm' => 'Вы уверены, что хотите отменить бронирование?'
                                ]) ?>
                            <?php endif; ?>
                            <?php if ($booking->status === Booking::STATUS_COMPLETED && !$booking->review): ?>
                                <?= Html::a('Оставить отзыв', ['/photoshoot/booking/review', 'id' => $booking->id], ['class' => 'btn btn-sm btn-outline-success']) ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
