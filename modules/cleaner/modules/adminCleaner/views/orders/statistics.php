<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $ordersByStatus */
/** @var int $totalOrders */
/** @var array $ordersByCategory */

$this->title = Yii::t('app', 'Статистика');

$statusNames = [
    1 => 'Новые',
    2 => 'В работе',
    3 => 'Выполнены',
    4 => 'Отменены',
];

$statusBadges = [
    1 => '<span class="status-badge status-new">Новые</span>',
    2 => '<span class="status-badge status-process">В работе</span>',
    3 => '<span class="status-badge status-done">Выполнены</span>',
    4 => '<span class="status-badge status-cancel">Отменены</span>',
];
?>

<div class="admin-header">
    <div class="admin-header__top">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Статистика и аналитика заявок</p>
        </div>
    </div>
</div>

<!-- Total Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card__icon">📊</div>
        <div class="stat-card__value"><?= $totalOrders ?></div>
        <div class="stat-card__label">Всего заявок</div>
    </div>
    <?php foreach ($ordersByStatus as $item): ?>
        <div class="stat-card">
            <div class="stat-card__icon">📋</div>
            <div class="stat-card__value"><?= $item['count'] ?></div>
            <div class="stat-card__label">
                <?= $statusBadges[$item['status_id']] ?? $statusNames[$item['status_id']] ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Orders by Status -->
    <div class="glass-card">
        <div class="glass-card__header">
            <h3 class="glass-card__title">📈 Заявки по статусам</h3>
        </div>
        <div class="glass-card__body">
            <?php if (empty($ordersByStatus)): ?>
                <p style="color: var(--text-muted);">Нет данных</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Статус</th>
                            <th>Количество</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordersByStatus as $item): ?>
                            <tr>
                                <td>
                                    <?= $statusBadges[$item['status_id']] ?? $statusNames[$item['status_id']] ?>
                                </td>
                                <td><?= $item['count'] ?></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-bar__fill" style="width: <?= $totalOrders > 0 ? round(($item['count'] / $totalOrders) * 100, 1) : 0 ?>%"></div>
                                    </div>
                                    <?= $totalOrders > 0 ? round(($item['count'] / $totalOrders) * 100, 1) : 0 ?>%
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <!-- Orders by Category -->
    <div class="glass-card">
        <div class="glass-card__header">
            <h3 class="glass-card__title">📁 Заявки по категориям</h3>
        </div>
        <div class="glass-card__body">
            <?php if (empty($ordersByCategory)): ?>
                <p style="color: var(--text-muted);">Нет данных</p>
            <?php else: ?>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Категория</th>
                            <th>Количество</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ordersByCategory as $item): 
                            $category = \app\modules\cleaner\models\Categories::findOne($item['category_id']);
                        ?>
                            <tr>
                                <td><?= $category ? Html::encode($category->title) : 'Категория #' . $item['category_id'] ?></td>
                                <td><?= $item['count'] ?></td>
                                <td>
                                    <div class="progress-bar">
                                        <div class="progress-bar__fill" style="width: <?= $totalOrders > 0 ? round(($item['count'] / $totalOrders) * 100, 1) : 0 ?>%"></div>
                                    </div>
                                    <?= $totalOrders > 0 ? round(($item['count'] / $totalOrders) * 100, 1) : 0 ?>%
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
