<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Заявка #' . $order->id;

$statusLabels = [
    'new' => 'Новая',
    'accepted' => 'Принята',
    'in_progress' => 'В процессе',
    'completed' => 'Завершена',
    'cancelled' => 'Отменена',
    'rejected' => 'Отклонена',
];

$statusColors = [
    'new' => 'info',
    'accepted' => 'primary',
    'in_progress' => 'warning',
    'completed' => 'success',
    'cancelled' => 'danger',
    'rejected' => 'secondary',
];
?>

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Заявка #<?= $order->id ?></h1>
        <div>
            <?= Html::a('← Назад', ['orders'], ['class' => 'btn btn-outline']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Информация о заявке</h5>
                    <span class="badge bg-<?= $statusColors[$order->status] ?? 'secondary' ?>">
                        <?= $statusLabels[$order->status] ?? $order->status ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Клиент:</strong><br>
                            <?= Html::encode($order->client->full_name) ?><br>
                            <small class="text-muted"><?= Html::encode($order->client->phone) ?></small></p>

                            <p><strong>Услуга:</strong><br>
                            <?= Html::encode($order->service->name) ?><br>
                            <small class="text-muted"><?= $order->service->duration ?> мин</small></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Мастер:</strong><br>
                            <?= Html::encode($order->master->user->full_name) ?><br>
                            <small class="text-muted"><?= Html::encode($order->master->specialization) ?></small></p>

                            <p><strong>Запись на:</strong><br>
                            <?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMMM yyyy') ?><br>
                            <?= $order->appointment_time ?></p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Сумма:</strong> <?= number_format($order->total_price, 0, '.', ' ') ?> ₽</p>
                            <p><strong>Оплата:</strong> <?= $order->payment_method === 'cash' ? 'Наличными' : ($order->payment_method === 'card' ? 'Картой' : $order->payment_method) ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Создана:</strong> <?= Yii::$app->formatter->asDate($order->created_at, 'd MMMM yyyy HH:mm') ?></p>
                        </div>
                    </div>

                    <?php if ($order->notes): ?>
                        <hr>
                        <p><strong>Примечания:</strong><br>
                        <?= Html::encode($order->notes) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($order->reviews): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Отзывы</h5>
                    </div>
                    <div class="card-body">
                        <?php foreach ($order->reviews as $review): ?>
                            <div class="border-bottom pb-3 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong><?= Html::encode($review->client->full_name) ?></strong>
                                    <span class="text-warning"><?= str_repeat('★', $review->rating) ?></span>
                                </div>
                                <p class="mb-1"><?= Html::encode($review->comment) ?></p>
                                <small class="text-muted"><?= Yii::$app->formatter->asDate($review->created_at, 'd MMMM yyyy') ?></small>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Управление статусом</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <?php if ($order->status === 'new'): ?>
                            <?= Html::a('✅ Принять', ['update-order-status', 'id' => $order->id, 'status' => 'accepted'], [
                                'class' => 'btn btn-success',
                                'data' => ['method' => 'post'],
                            ]) ?>
                            <?= Html::a('🚫 Отклонить', ['update-order-status', 'id' => $order->id, 'status' => 'rejected'], [
                                'class' => 'btn btn-danger',
                                'data' => ['method' => 'post'],
                            ]) ?>
                        <?php elseif ($order->status === 'accepted'): ?>
                            <?= Html::a('💆 В процессе', ['update-order-status', 'id' => $order->id, 'status' => 'in_progress'], [
                                'class' => 'btn btn-primary',
                                'data' => ['method' => 'post'],
                            ]) ?>
                            <?= Html::a('❌ Отменить', ['update-order-status', 'id' => $order->id, 'status' => 'cancelled'], [
                                'class' => 'btn btn-outline-danger',
                                'data' => ['method' => 'post'],
                            ]) ?>
                        <?php elseif ($order->status === 'in_progress'): ?>
                            <?= Html::a('✨ Завершить', ['update-order-status', 'id' => $order->id, 'status' => 'completed'], [
                                'class' => 'btn btn-success',
                                'data' => ['method' => 'post'],
                            ]) ?>
                        <?php else: ?>
                            <p class="text-muted">Статус не может быть изменен</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
