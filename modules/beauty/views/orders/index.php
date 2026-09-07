<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Мои заказы - Салон красоты Виктория';

$statusConfig = [
    'new' => ['label' => 'Новый', 'class' => 'status-new', 'icon' => '📋'],
    'confirmed' => ['label' => 'Подтвержден', 'class' => 'status-confirmed', 'icon' => '✅'],
    'in_progress' => ['label' => 'В процессе', 'class' => 'status-progress', 'icon' => '💆'],
    'completed' => ['label' => 'Завершен', 'class' => 'status-completed', 'icon' => '✨'],
    'cancelled' => ['label' => 'Отменен', 'class' => 'status-cancelled', 'icon' => '❌'],
];
?>
<div class="beauty-container">
    <div class="orders-elegant">
        <!-- Header -->
        <div class="orders-hero">
            <div class="hero-content">
                <h1>Мои заказы</h1>
                <p>История ваших записей на услуги</p>
            </div>
            <div class="hero-stats">
                <div class="stat">
                    <span class="stat-value"><?= count($orders) ?></span>
                    <span class="stat-label">Всего заказов</span>
                </div>
                <?php 
                $activeOrders = array_filter($orders, function($o) { 
                    return in_array($o->status, ['new', 'confirmed', 'in_progress']); 
                });
                ?>
                <div class="stat">
                    <span class="stat-value"><?= count($activeOrders) ?></span>
                    <span class="stat-label">Активных</span>
                </div>
            </div>
        </div>

        <?php if (empty($orders)): ?>
            <!-- Empty State -->
            <div class="empty-state-elegant">
                <div class="empty-icon">📅</div>
                <h3>У вас пока нет заказов</h3>
                <p>Запишитесь на первую услугу в нашем салоне</p>
                <?= Html::a('Перейти в каталог', ['/beauty/catalog'], ['class' => 'btn btn-primary']) ?>
            </div>
        <?php else: ?>
            <!-- Orders List -->
            <div class="orders-list-elegant">
                <?php foreach ($orders as $order): ?>
                    <?php $status = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => '', 'icon' => '📋']; ?>
                    <div class="order-card-elegant">
                        <!-- Card Header -->
                        <div class="card-header">
                            <div class="order-id">
                                <span class="order-number">#<?= $order->id ?></span>
                                <span class="order-date"><?= Yii::$app->formatter->asDate($order->created_at, 'd MMMM yyyy') ?></span>
                            </div>
                            <div class="status-badge <?= $status['class'] ?>">
                                <span class="status-icon"><?= $status['icon'] ?></span>
                                <span class="status-text"><?= $status['label'] ?></span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="service-info">
                                <div class="service-img">
                                    <?php if ($order->service->image): ?>
                                        <img src="<?= $order->service->image ?>" alt="<?= Html::encode($order->service->name) ?>">
                                    <?php else: ?>
                                        <div class="img-placeholder">💅</div>
                                    <?php endif; ?>
                                </div>
                                <div class="service-details">
                                    <h4><?= Html::encode($order->service->name) ?></h4>
                                    <p class="service-meta">⏱ <?= $order->service->duration ?> мин</p>
                                    <p class="service-price"><?= number_format($order->total_price, 0, '.', ' ') ?> ₽</p>
                                </div>
                            </div>

                            <div class="appointment-info">
                                <div class="info-item">
                                    <span class="info-label">Дата и время</span>
                                    <span class="info-value"><?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMMM') ?> в <?= $order->appointment_time ?></span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Мастер</span>
                                    <span class="info-value"><?= Html::encode($order->master->user->full_name) ?></span>
                                </div>
                                <?php if ($order->notes): ?>
                                    <div class="info-item notes">
                                        <span class="info-label">Примечания</span>
                                        <span class="info-value"><?= Html::encode($order->notes) ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="card-actions">
                            <?= Html::a('Подробнее', ['/beauty/orders/view', 'id' => $order->id], ['class' => 'btn btn-outline btn-sm']) ?>
                            
                            <?php if ($order->status === 'new'): ?>
                                <?= Html::a('Отменить', ['/beauty/orders/cancel', 'id' => $order->id], [
                                    'class' => 'btn btn-danger btn-sm',
                                    'data' => [
                                        'confirm' => 'Вы уверены, что хотите отменить заказ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>

                            <?php if ($order->status === 'completed'): ?>
                                <?php 
                                $hasReview = \app\modules\beauty\models\Review::find()
                                    ->where(['order_id' => $order->id, 'client_id' => Yii::$app->userBeauty->id])
                                    ->exists();
                                if (!$hasReview): ?>
                                    <?= Html::a('Оставить отзыв', ['/beauty/orders/review', 'id' => $order->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
$this->registerCss("
.orders-elegant {
    max-width: 900px;
    margin: 0 auto;
    padding: var(--space-lg) 0;
}

/* Hero Section */
.orders-hero {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, var(--secondary-blush) 0%, var(--secondary-champagne) 100%);
    padding: var(--space-xl);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-lg);
}

.hero-content h1 {
    font-family: var(--font-display);
    font-size: 1.75rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.hero-content p {
    color: var(--neutral-medium);
    font-size: 1rem;
    margin: 0;
}

.hero-stats {
    display: flex;
    gap: var(--space-lg);
}

.stat {
    text-align: center;
}

.stat-value {
    display: block;
    font-family: var(--font-display);
    font-size: 1.5rem;
    color: var(--primary-rose);
    font-weight: 600;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--neutral-medium);
}

/* Empty State */
.empty-state-elegant {
    text-align: center;
    padding: var(--space-xxl);
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
}

.empty-state-elegant .empty-icon {
    font-size: 4rem;
    margin-bottom: var(--space-md);
}

.empty-state-elegant h3 {
    font-family: var(--font-display);
    font-size: 1.25rem;
    color: var(--neutral-charcoal);
    margin-bottom: var(--space-sm);
}

.empty-state-elegant p {
    color: var(--neutral-medium);
    margin-bottom: var(--space-lg);
}

/* Orders List */
.orders-list-elegant {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}

.order-card-elegant {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    overflow: hidden;
    transition: all var(--transition-fast);
}

.order-card-elegant:hover {
    box-shadow: var(--shadow-medium);
    transform: translateY(-2px);
}

/* Card Header */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--space-md);
    background: var(--secondary-champagne);
    border-bottom: 1px solid var(--neutral-lighter);
}

.order-id {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

.order-number {
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: var(--neutral-charcoal);
    font-weight: 600;
}

.order-date {
    font-size: 0.85rem;
    color: var(--neutral-medium);
}

/* Status Badges */
.status-badge {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    padding: 0.4rem 0.75rem;
    border-radius: var(--radius-xl);
    font-size: 0.8rem;
    font-weight: 600;
}

.status-badge.status-new {
    background: rgba(201, 169, 97, 0.2);
    color: #9a7d3c;
}

.status-badge.status-confirmed {
    background: rgba(168, 181, 160, 0.2);
    color: #5a6b52;
}

.status-badge.status-progress {
    background: rgba(212, 165, 116, 0.2);
    color: #a05a4d;
}

.status-badge.status-completed {
    background: rgba(168, 181, 160, 0.3);
    color: #4a5a42;
}

.status-badge.status-cancelled {
    background: rgba(150, 150, 150, 0.2);
    color: #666;
}

.status-icon {
    font-size: 0.9rem;
}

/* Card Body */
.card-body {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-md);
    padding: var(--space-md);
}

@media (max-width: 640px) {
    .card-body {
        grid-template-columns: 1fr;
    }
}

.service-info {
    display: flex;
    gap: var(--space-sm);
}

.service-img {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-md);
    overflow: hidden;
    flex-shrink: 0;
}

.service-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.img-placeholder {
    width: 100%;
    height: 100%;
    background: var(--secondary-blush);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.service-details h4 {
    font-family: var(--font-display);
    font-size: 1rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.service-meta {
    font-size: 0.8rem;
    color: var(--neutral-medium);
    margin-bottom: 0.25rem;
}

.service-price {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--primary-rose);
}

/* Appointment Info */
.appointment-info {
    display: flex;
    flex-direction: column;
    gap: var(--space-xs);
}

.info-item {
    display: flex;
    flex-direction: column;
}

.info-item.notes {
    margin-top: var(--space-xs);
    padding-top: var(--space-xs);
    border-top: 1px solid var(--neutral-lighter);
}

.info-label {
    font-size: 0.75rem;
    color: var(--neutral-medium);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 0.9rem;
    color: var(--neutral-charcoal);
}

/* Card Actions */
.card-actions {
    display: flex;
    gap: var(--space-sm);
    padding: var(--space-sm) var(--space-md);
    background: var(--secondary-champagne);
    border-top: 1px solid var(--neutral-lighter);
}

.card-actions .btn {
    padding: 0.4rem 0.75rem;
    font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 768px) {
    .orders-hero {
        flex-direction: column;
        text-align: center;
        gap: var(--space-md);
    }
    
    .hero-stats {
        justify-content: center;
    }
}
");

