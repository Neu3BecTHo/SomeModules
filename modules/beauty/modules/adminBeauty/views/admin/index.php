<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Панель администратора - Салон красоты';
?>
<div class="admin-dashboard">
    <h1>Панель администратора</h1>
    
    <div class="row stats-row">
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $stats['users'] ?></h3>
                <p>Клиентов</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $stats['masters'] ?></h3>
                <p>Мастеров</p>
                <?php if ($stats['masters_pending'] > 0): ?>
                    <span class="badge bg-warning"><?= $stats['masters_pending'] ?> на одобрении</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $stats['services'] ?></h3>
                <p>Услуг</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <h3><?= $stats['orders_total'] ?></h3>
                <p>Заявок</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Недавние заявки</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Клиент</th>
                                <th>Услуга</th>
                                <th>Статус</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td><?= $order->id ?></td>
                                <td><?= Html::encode($order->client->full_name) ?></td>
                                <td><?= Html::encode($order->service->name) ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $order->status === 'completed' ? 'success' : 
                                        ($order->status === 'new' ? 'primary' : 
                                        ($order->status === 'rejected' ? 'danger' : 'warning'))
                                    ?>">
                                        <?= $order->status ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Мастера на одобрении</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($pendingMasters)): ?>
                        <p class="text-muted">Нет мастеров на одобрении</p>
                    <?php else: ?>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Имя</th>
                                    <th>Специализация</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pendingMasters as $master): ?>
                                <tr>
                                    <td><?= Html::encode($master->user->full_name) ?></td>
                                    <td><?= Html::encode($master->specialization) ?></td>
                                    <td>
                                        <?= Html::a('Одобрить', '/beauty/admin/masters/approve/' . $master->id, ['class' => 'btn btn-sm btn-success']) ?>
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
