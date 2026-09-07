<?php

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\Booking */

use yii\bootstrap5\Html;
use app\modules\photoshoot\models\Booking;

$this->title = 'Бронирование #' . $model->id;
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="service-card">
                <table class="table table-bordered">
                    <tr>
                        <th>Услуга</th>
                        <td><?= Booking::getServiceTypeLabels()[$model->service_type] ?></td>
                    </tr>
                    <?php if ($model->hall_type): ?>
                    <tr>
                        <th>Зал</th>
                        <td><?= Booking::getHallTypeLabels()[$model->hall_type] ?></td>
                    </tr>
                    <?php endif; ?>
                    <?php if ($model->photo_session_type): ?>
                    <tr>
                        <th>Тип фотосессии</th>
                        <td><?= Booking::getSessionTypeLabels()[$model->photo_session_type] ?></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th>Длительность</th>
                        <td><?= Booking::getDurationLabels()[$model->duration] ?></td>
                    </tr>
                    <tr>
                        <th>Дата и время</th>
                        <td><?= Yii::$app->formatter->asDatetime($model->booking_date) ?></td>
                    </tr>
                    <tr>
                        <th>Количество человек</th>
                        <td><?= $model->people_count ?></td>
                    </tr>
                    <tr>
                        <th>Способ оплаты</th>
                        <td><?= Booking::getPaymentMethodLabels()[$model->payment_method] ?></td>
                    </tr>
                    <tr>
                        <th>Итоговая цена</th>
                        <td class="price-tag"><?= number_format($model->total_price, 0, ',', ' ') ?> ₽</td>
                    </tr>
                    <tr>
                        <th>Статус</th>
                        <td>
                            <span class="badge bg-<?= $model->status === 'new' ? 'warning' : ($model->status === 'accepted' ? 'info' : ($model->status === 'completed' ? 'success' : 'danger')) ?>">
                                <?= $model->getStatusLabel() ?>
                            </span>
                        </td>
                    </tr>
                    <?php if ($model->wishes): ?>
                    <tr>
                        <th>Пожелания</th>
                        <td><?= Html::encode($model->wishes) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>

                <div class="d-flex gap-2">
                    <?= Html::a('Назад', ['/photoshoot/booking/index'], ['class' => 'btn btn-outline-secondary']) ?>
                    <?php if ($model->status === Booking::STATUS_NEW): ?>
                        <?= Html::a('Отменить', ['/photoshoot/booking/cancel', 'id' => $model->id], [
                            'class' => 'btn btn-outline-danger',
                            'data-confirm' => 'Вы уверены, что хотите отменить бронирование?'
                        ]) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
