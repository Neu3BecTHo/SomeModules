<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мастер: ' . $master->user->full_name;
?>

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($master->user->full_name) ?></h1>
        <div>
            <?= Html::a('← Назад', ['masters'], ['class' => 'btn btn-outline']) ?>
            <?= Html::a('Редактировать', ['profile'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <?php if ($master->photo): ?>
                        <img src="<?= $master->photo ?>" alt="" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <?php else: ?>
                        <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <span class="display-4">👤</span>
                        </div>
                    <?php endif; ?>
                    <h5 class="card-title"><?= Html::encode($master->user->full_name) ?></h5>
                    <p class="text-muted"><?= Html::encode($master->specialization) ?></p>
                    <p>
                        <?php if ($master->is_approved): ?>
                            <span class="badge bg-success">✅ Одобрен</span>
                        <?php else: ?>
                            <span class="badge bg-warning">⏳ На рассмотрении</span>
                        <?php endif; ?>
                    </p>
                    <div class="mt-3">
                        <p><strong>Рейтинг:</strong> <?= number_format($master->rating, 1) ?>/5</p>
                        <p><strong>Телефон:</strong> <?= Html::encode($master->user->phone) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">О мастере</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(Html::encode($master->bio)) ?></p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Услуги</h5>
                </div>
                <div class="card-body">
                    <?php if ($master->services): ?>
                        <ul class="list-group">
                            <?php foreach ($master->services as $service): ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <?= Html::encode($service->name) ?>
                                    <span class="text-muted"><?= $service->duration ?> мин / <?= $service->price ?> ₽</span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p class="text-muted">Услуги не добавлены</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Сертификаты</h5>
                </div>
                <div class="card-body">
                    <?php if ($master->certificates): ?>
                        <div class="row">
                            <?php foreach ($master->certificates as $cert): ?>
                                <div class="col-6 col-md-4 mb-3">
                                    <img src="<?= $cert->image ?>" alt="" class="img-fluid rounded">
                                    <small class="d-block text-muted"><?= Html::encode($cert->title) ?></small>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Сертификаты не добавлены</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Заказы мастера</h5>
                    <span class="badge bg-primary"><?= count($orders) ?> всего</span>
                </div>
                <div class="card-body">
                    <?php if ($orders): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Клиент</th>
                                        <th>Услуга</th>
                                        <th>Дата</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach (array_slice($orders, 0, 10) as $order): ?>
                                        <tr>
                                            <td>#<?= $order->id ?></td>
                                            <td><?= Html::encode($order->client->full_name) ?></td>
                                            <td><?= Html::encode($order->service->name) ?></td>
                                            <td><?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMM') ?></td>
                                            <td>
                                                <span class="badge bg-<?= $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'info') ?>">
                                                    <?= $order->status ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (count($orders) > 10): ?>
                            <p class="text-muted">И еще <?= count($orders) - 10 ?> заказов...</p>
                        <?php endif; ?>
                    <?php else: ?>
                        <p class="text-muted">Нет заказов</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
