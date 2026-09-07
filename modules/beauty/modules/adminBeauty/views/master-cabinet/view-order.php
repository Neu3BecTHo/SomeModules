<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Заявка #' . $order->id . ' - Кабинет мастера';

$statusConfig = [
    'new' => ['label' => 'Новая', 'class' => 'status-new', 'icon' => '📋'],
    'accepted' => ['label' => 'Принята', 'class' => 'status-confirmed', 'icon' => '✅'],
    'in_progress' => ['label' => 'В процессе', 'class' => 'status-progress', 'icon' => '💆'],
    'completed' => ['label' => 'Завершена', 'class' => 'status-completed', 'icon' => '✨'],
    'cancelled' => ['label' => 'Отменена', 'class' => 'status-cancelled', 'icon' => '❌'],
    'rejected' => ['label' => 'Отклонена', 'class' => 'status-cancelled', 'icon' => '🚫'],
];

$status = $statusConfig[$order->status] ?? ['label' => $order->status, 'class' => '', 'icon' => '📋'];
?>
<div class="beauty-container">
    <div class="order-view-elegant">
        <!-- Header -->
        <div class="view-header">
            <div class="header-left">
                <h1>Заявка #<?= $order->id ?></h1>
                <p class="order-date">Создана: <?= Yii::$app->formatter->asDate($order->created_at, 'd MMMM yyyy в HH:mm') ?></p>
            </div>
            <div class="status-badge-large <?= $status['class'] ?>">
                <span class="status-icon"><?= $status['icon'] ?></span>
                <span class="status-text"><?= $status['label'] ?></span>
            </div>
        </div>

        <div class="view-content">
            <!-- Client Info -->
            <div class="info-card">
                <h3>Клиент</h3>
                <div class="client-info">
                    <div class="client-avatar">
                        <?= strtoupper(mb_substr($order->client->full_name, 0, 1)) ?>
                    </div>
                    <div class="client-details">
                        <h4><?= Html::encode($order->client->full_name) ?></h4>
                        <p>📞 <?= Html::encode($order->client->phone) ?></p>
                    </div>
                </div>
            </div>

            <!-- Service Info -->
            <div class="info-card">
                <h3>Услуга</h3>
                <div class="service-info-detail">
                    <?php if ($order->service->image): ?>
                        <img src="<?= $order->service->image ?>" alt="<?= Html::encode($order->service->name) ?>">
                    <?php else: ?>
                        <div class="service-img-placeholder">💅</div>
                    <?php endif; ?>
                    <div class="service-text">
                        <h4><?= Html::encode($order->service->name) ?></h4>
                        <p>⏱ <?= $order->service->duration ?> минут</p>
                        <p class="price"><?= number_format($order->total_price, 0, '.', ' ') ?> ₽</p>
                    </div>
                </div>
            </div>

            <!-- Appointment Info -->
            <div class="info-card">
                <h3>Запись</h3>
                <div class="appointment-detail">
                    <div class="detail-row">
                        <span class="label">Дата:</span>
                        <span class="value"><?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMMM yyyy') ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Время:</span>
                        <span class="value"><?= $order->appointment_time ?></span>
                    </div>
                    <div class="detail-row">
                        <span class="label">Оплата:</span>
                        <span class="value"><?= $order->payment_method === 'cash' ? 'Наличными' : ($order->payment_method === 'card' ? 'Картой' : $order->payment_method) ?></span>
                    </div>
                </div>
            </div>

            <?php if ($order->notes): ?>
                <div class="info-card notes-card">
                    <h3>Примечания клиента</h3>
                    <p class="notes-text"><?= Html::encode($order->notes) ?></p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="view-actions">
            <h3>Изменить статус</h3>
            <div class="status-actions">
                <?php if ($order->status === 'new'): ?>
                    <?= Html::a('✅ Принять', '/beauty/admin/master-cabinet/orders/update-status/' . $order->id . '/accepted', [
                        'class' => 'btn btn-success',
                    ]) ?>
                    <?= Html::a('🚫 Отклонить', '/beauty/admin/master-cabinet/orders/update-status/' . $order->id . '/rejected', [
                        'class' => 'btn btn-danger',
                        'data-confirm' => 'Отклонить заявку?',
                    ]) ?>
                <?php elseif ($order->status === 'accepted'): ?>
                    <?= Html::a('💆 В процессе', '/beauty/admin/master-cabinet/orders/update-status/' . $order->id . '/in_progress', [
                        'class' => 'btn btn-primary',
                    ]) ?>
                    <?= Html::a('❌ Отменить', '/beauty/admin/master-cabinet/orders/update-status/' . $order->id . '/cancelled', [
                        'class' => 'btn btn-outline-danger',
                        'data-confirm' => 'Отменить заявку?',
                    ]) ?>
                <?php elseif ($order->status === 'in_progress'): ?>
                    <?= Html::a('✨ Завершить', '/beauty/admin/master-cabinet/orders/update-status/' . $order->id . '/completed', [
                        'class' => 'btn btn-success',
                    ]) ?>
                <?php endif; ?>
            </div>
            <div class="back-link">
                <?= Html::a('← Назад к списку', ['/beauty/admin/master-cabinet/orders'], ['class' => 'btn btn-outline']) ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerCss("
.order-view-elegant {
    max-width: 800px;
    margin: 0 auto;
    padding: var(--space-lg) 0;
}

/* Header */
.view-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-lg);
    padding-bottom: var(--space-md);
    border-bottom: 2px solid var(--secondary-blush);
}

.view-header h1 {
    font-family: var(--font-display);
    font-size: 1.75rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.order-date {
    color: var(--neutral-medium);
    font-size: 0.9rem;
    margin: 0;
}

.status-badge-large {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.25rem;
    border-radius: var(--radius-xl);
    font-size: 1rem;
    font-weight: 600;
}

.status-badge-large.status-new {
    background: rgba(201, 169, 97, 0.2);
    color: #9a7d3c;
}

.status-badge-large.status-confirmed {
    background: rgba(168, 181, 160, 0.2);
    color: #5a6b52;
}

.status-badge-large.status-progress {
    background: rgba(212, 165, 116, 0.2);
    color: #a05a4d;
}

.status-badge-large.status-completed {
    background: rgba(168, 181, 160, 0.3);
    color: #4a5a42;
}

.status-badge-large.status-cancelled {
    background: rgba(150, 150, 150, 0.2);
    color: #666;
}

/* Content Cards */
.view-content {
    display: grid;
    gap: var(--space-md);
    margin-bottom: var(--space-lg);
}

.info-card {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    padding: var(--space-md);
}

.info-card h3 {
    font-family: var(--font-display);
    font-size: 1rem;
    color: var(--neutral-charcoal);
    margin-bottom: var(--space-md);
    padding-bottom: var(--space-sm);
    border-bottom: 1px solid var(--neutral-lighter);
}

/* Client Info */
.client-info {
    display: flex;
    align-items: center;
    gap: var(--space-md);
}

.client-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary-rose), var(--accent-gold));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 600;
}

.client-details h4 {
    font-size: 1.1rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.client-details p {
    color: var(--neutral-medium);
    margin: 0;
}

/* Service Info */
.service-info-detail {
    display: flex;
    gap: var(--space-md);
    align-items: center;
}

.service-info-detail img,
.service-img-placeholder {
    width: 100px;
    height: 100px;
    border-radius: var(--radius-md);
    object-fit: cover;
}

.service-img-placeholder {
    background: var(--secondary-blush);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
}

.service-text h4 {
    font-size: 1.1rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.service-text p {
    color: var(--neutral-medium);
    margin: 0.25rem 0;
}

.service-text .price {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-rose);
}

/* Appointment Details */
.appointment-detail {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}

.detail-row {
    display: flex;
    gap: var(--space-sm);
}

.detail-row .label {
    font-weight: 500;
    color: var(--neutral-medium);
    min-width: 80px;
}

.detail-row .value {
    color: var(--neutral-charcoal);
}

/* Notes */
.notes-card .notes-text {
    color: var(--neutral-charcoal);
    line-height: 1.6;
    font-style: italic;
    background: var(--secondary-champagne);
    padding: var(--space-md);
    border-radius: var(--radius-md);
    margin: 0;
}

/* Actions */
.view-actions {
    background: white;
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-soft);
    padding: var(--space-md);
}

.view-actions h3 {
    font-family: var(--font-display);
    font-size: 1rem;
    color: var(--neutral-charcoal);
    margin-bottom: var(--space-md);
}

.status-actions {
    display: flex;
    gap: var(--space-sm);
    margin-bottom: var(--space-md);
}

.back-link {
    padding-top: var(--space-md);
    border-top: 1px solid var(--neutral-lighter);
}

/* Responsive */
@media (max-width: 640px) {
    .view-header {
        flex-direction: column;
        gap: var(--space-md);
    }
    
    .status-actions {
        flex-direction: column;
    }
}
");
