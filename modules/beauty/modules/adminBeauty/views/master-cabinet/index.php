<?php
use yii\helpers\Html;

$this->title = 'Личный кабинет мастера';

$statusLabels = ['new' => 'Новая', 'accepted' => 'Принята', 'rejected' => 'Отклонена', 'completed' => 'Завершена', 'cancelled' => 'Отменена'];
$statusColors = ['new' => 'primary', 'accepted' => 'info', 'rejected' => 'danger', 'completed' => 'success', 'cancelled' => 'secondary'];
?>
<div class="master-cabinet">
    <h1>Личный кабинет мастера</h1>
    
    <?php if (!$master->is_approved): ?>
        <div class="alert alert-warning">
            Ваш профиль находится на рассмотрении администратора.
        </div>
    <?php endif; ?>
    
    <div class="row stats-row">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?= $stats['total'] ?></h3>
                    <p class="text-muted">Всего заявок</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?= $stats['new'] ?></h3>
                    <p class="text-muted">Новых</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?= $stats['accepted'] ?></h3>
                    <p class="text-muted">Приняты</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h3><?= $stats['completed'] ?></h3>
                    <p class="text-muted">Завершено</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Недавние заявки</h5>
                    <?= Html::a('Все заявки', ['/beauty/admin/master-cabinet/orders'], ['class' => 'btn btn-sm btn-primary float-end']) ?>
                </div>
                <div class="card-body">
                    <?php if (empty($recentOrders)): ?>
                        <p class="text-muted">Нет заявок</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Клиент</th>
                                    <th>Услуга</th>
                                    <th>Дата</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recentOrders as $order): ?>
                                <tr>
                                    <td><?= $order->id ?></td>
                                    <td><?= Html::encode($order->client->full_name) ?></td>
                                    <td><?= Html::encode($order->service->name) ?></td>
                                    <td><?= Yii::$app->formatter->asDate($order->appointment_date) ?> <?= $order->appointment_time ?></td>
                                    <td>
                                        <span class="badge bg-<?= $statusColors[$order->status] ?? 'secondary' ?>">
                                            <?= $statusLabels[$order->status] ?? $order->status ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?= Html::a('Просмотр', '/beauty/admin/master-cabinet/orders/view/' . $order->id, ['class' => 'btn btn-sm btn-info']) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
