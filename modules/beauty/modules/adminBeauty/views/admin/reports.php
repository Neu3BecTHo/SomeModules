<?php
use yii\helpers\Html;

$this->title = 'Отчеты - Админ панель';

$statusColors = [
    'new' => 'primary',
    'accepted' => 'info',
    'completed' => 'success',
    'rejected' => 'danger',
    'cancelled' => 'secondary',
];

$statusLabels = ['new' => 'Новые', 'accepted' => 'Приняты', 'completed' => 'Завершены', 'rejected' => 'Отклонены', 'cancelled' => 'Отменены'];
?>
<div class="admin-reports">
    <h1>Отчеты и аналитика</h1>
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Заявки по статусам</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($ordersByStatus)): ?>
                        <p class="text-muted">Нет данных</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Статус</th>
                                    <th>Количество</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ordersByStatus as $item): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-<?= $statusColors[$item['status']] ?? 'secondary' ?>">
                                            <?= $statusLabels[$item['status']] ?? $item['status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $item['count'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Выручка по месяцам</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($revenueData)): ?>
                        <p class="text-muted">Нет данных</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Месяц</th>
                                    <th>Заявок</th>
                                    <th>Выручка</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($revenueData as $item): ?>
                                <tr>
                                    <td><?= $item['month'] ?></td>
                                    <td><?= $item['count'] ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item['revenue']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Популярные услуги</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($popularServices)): ?>
                        <p class="text-muted">Нет данных</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Услуга</th>
                                    <th>Количество</th>
                                    <th>Выручка</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($popularServices as $item): ?>
                                <tr>
                                    <td><?= Html::encode($item['service']['name'] ?? 'Услуга #' . $item['service_id']) ?></td>
                                    <td><?= $item['count'] ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item['revenue']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Загруженность мастеров</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($masterWorkload)): ?>
                        <p class="text-muted">Нет данных</p>
                    <?php else: ?>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Мастер</th>
                                    <th>Заявок</th>
                                    <th>Выручка</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($masterWorkload as $item): ?>
                                <tr>
                                    <td><?= Html::encode($item['master']['user']['full_name'] ?? 'Мастер #' . $item['master_id']) ?></td>
                                    <td><?= $item['count'] ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($item['revenue']) ?></td>
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
