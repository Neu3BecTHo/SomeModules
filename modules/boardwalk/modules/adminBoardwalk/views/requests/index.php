<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Панель организатора';
$this->registerCssFile('@web/css/admin.css');
?>

<div class="admin-panel container">
    <header class="admin-header">
        <h1>Панель администратора</h1>
        <div class="admin-user">Организатор: 8(999)999-99-99</div>
    </header>

    <!-- Дашборд (Доп. функционал) -->
    <div class="admin-stats">
        <div class="stat-card">
            <span class="stat-value"><?= $stats['total'] ?></span>
            <span class="stat-label">Всего заявок</span>
        </div>
        <div class="stat-card highlight">
            <span class="stat-value"><?= $stats['new'] ?></span>
            <span class="stat-label">Новых сегодня</span>
        </div>
        <div class="stat-card">
            <span class="stat-value"><?= $stats['completed'] ?></span>
            <span class="stat-label">Завершено</span>
        </div>
    </div>

    <div class="admin-content card">
        <h3>Список всех заявок</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Клиент / Телефон</th>
                    <th>Игра</th>
                    <th>Дата сессии</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr class="status-row-<?= $booking->status ?>">
                    <td>#<?= $booking->id ?></td>
                    <td>
                        <strong><?= Html::encode($booking->name) ?></strong><br>
                        <small><?= Html::encode($booking->phone) ?></small>
                    </td>
                    <td><?= Html::encode($booking->session->game->title) ?></td>
                    <td><?= date('d.m H:i', strtotime($booking->session->start_at)) ?></td>
                    <td>
                        <span class="badge badge-<?= $booking->status ?>">
                            <?= $booking->getStatusLabel() ?>
                        </span>
                    </td>
                    <td class="admin-actions">
                        <?php if ($booking->status === 'new'): ?>
                            <?= Html::a('Одобрить', ['update-status', 'id' => $booking->id, 'status' => 'approved'], ['class' => 'btn-admin btn-approve']) ?>
                        <?php endif; ?>
                        
                        <?php if ($booking->status === 'approved'): ?>
                            <?= Html::a('Завершить', ['update-status', 'id' => $booking->id, 'status' => 'completed'], ['class' => 'btn-admin btn-complete']) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
