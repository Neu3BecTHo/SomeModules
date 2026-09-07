<?php

use yii\bootstrap5\Html;
use app\modules\photoshoot\models\Booking;

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\Booking */

$this->title = 'Бронирование #' . $model->id;
?>
<div class="container-fluid py-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Пользователь</th>
                    <td><?= Html::encode($model->user->full_name) ?> (<?= Html::encode($model->user->email) ?>)</td>
                </tr>
                <tr>
                    <th>Телефон</th>
                    <td><?= Html::encode($model->user->phone) ?></td>
                </tr>
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
                    <td><?= number_format($model->total_price, 0, ',', ' ') ?> ₽</td>
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
                <tr>
                    <th>Создано</th>
                    <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                </tr>
            </table>

            <div class="d-flex gap-2">
                <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
                <?php if ($model->status === Booking::STATUS_NEW): ?>
                    <?= Html::a('Принять', ['update-status', 'id' => $model->id, 'status' => 'accepted'], [
                        'class' => 'btn btn-success',
                        'data-confirm' => 'Принять заявку?'
                    ]) ?>
                    <?= Html::a('Отменить', ['update-status', 'id' => $model->id, 'status' => 'cancelled'], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Отменить заявку?'
                    ]) ?>
                <?php elseif ($model->status === Booking::STATUS_ACCEPTED): ?>
                    <?= Html::a('Завершить', ['update-status', 'id' => $model->id, 'status' => 'completed'], [
                        'class' => 'btn btn-info',
                        'data-confirm' => 'Отметить услугу как оказанную?'
                    ]) ?>
                    <?= Html::a('Отменить', ['update-status', 'id' => $model->id, 'status' => 'cancelled'], [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Отменить заявку?'
                    ]) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
