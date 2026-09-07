<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Личный кабинет - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="profile-elegant">
        <!-- Profile Header with Avatar -->
        <div class="profile-hero">
            <div class="profile-avatar">
                <?php if ($master && $master->photo): ?>
                    <img src="<?= $master->photo ?>" alt="<?= Html::encode($user->full_name) ?>">
                <?php else: ?>
                    <div class="avatar-placeholder">
                        <?= mb_substr($user->full_name, 0, 1) ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="profile-title">
                <h1><?= Html::encode($user->full_name) ?></h1>
                <p class="profile-role">
                    <?php
                    $roles = [
                        'client' => 'Клиент',
                        'master' => 'Мастер',
                        'admin' => 'Администратор'
                    ];
                    echo $roles[$user->role] ?? $user->role;
                    ?>
                    <?php if ($master && $master->is_approved): ?>
                        <span class="verified-badge">✓ Подтвержден</span>
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Navigation Cards -->
        <div class="profile-nav-grid">
            <a href="<?= Url::to(['/beauty/profile/update']) ?>" class="nav-card">
                <div class="nav-icon">👤</div>
                <h3>Редактировать профиль</h3>
                <p>Изменить личные данные и настройки</p>
            </a>
            <a href="<?= Url::to(['/beauty/orders/index']) ?>" class="nav-card">
                <div class="nav-icon">📋</div>
                <h3>Мои заказы</h3>
                <p>История записей и текущие заявки</p>
            </a>
            <?php if ($user->role === 'master'): ?>
                <a href="<?= Url::to(['/beauty/admin/master-cabinet']) ?>" class="nav-card highlight">
                    <div class="nav-icon">💼</div>
                    <h3>Панель мастера</h3>
                    <p>Управление услугами и расписанием</p>
                </a>
            <?php endif; ?>
            <?php if ($user->role === 'admin'): ?>
                <a href="<?= Url::to(['/beauty/admin']) ?>" class="nav-card highlight">
                    <div class="nav-icon">⚙️</div>
                    <h3>Админ панель</h3>
                    <p>Управление системой</p>
                </a>
            <?php endif; ?>
        </div>

        <div class="profile-content-grid">
            <!-- Left Column - Info -->
            <div class="profile-column">
                <div class="info-card">
                    <h2>Контактная информация</h2>
                    <div class="info-list">
                        <div class="info-row">
                            <span class="info-label">Телефон</span>
                            <span class="info-value"><?= Html::encode($user->phone) ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Email</span>
                            <span class="info-value"><?= Html::encode($user->email ?? 'Не указан') ?></span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Дата регистрации</span>
                            <span class="info-value"><?= Yii::$app->formatter->asDate($user->created_at, 'd MMMM yyyy') ?></span>
                        </div>
                    </div>
                </div>

                <?php if ($master): ?>
                    <div class="info-card master-card">
                        <h2>Профессиональная информация</h2>
                        <div class="master-stats">
                            <div class="stat-item">
                                <span class="stat-value"><?= number_format($master->rating, 1) ?></span>
                                <span class="stat-label">Рейтинг</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value"><?= \app\modules\beauty\models\Order::find()->where(['master_id' => $master->id, 'status' => 'completed'])->count() ?></span>
                                <span class="stat-label">Заказов</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value"><?= count($master->services) ?></span>
                                <span class="stat-label">Услуг</span>
                            </div>
                        </div>
                        <div class="master-spec">
                            <span class="spec-label">Специализация:</span>
                            <span class="spec-value"><?= Html::encode($master->specialization) ?></span>
                        </div>
                        <?php if (!empty($master->bio)): ?>
                            <div class="master-bio-elegant">
                                <h4>О себе</h4>
                                <p><?= Html::encode($master->bio) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column - Orders -->
            <div class="profile-column">
                <div class="orders-card">
                    <div class="orders-header">
                        <h2>Последние заказы</h2>
                        <a href="<?= Url::to(['/beauty/orders/index']) ?>" class="view-all-link">Все заказы →</a>
                    </div>
                    
                    <?php 
                    $recentOrders = \app\modules\beauty\models\Order::find()
                        ->where(['client_id' => $user->id])
                        ->with(['service', 'master.user'])
                        ->orderBy(['created_at' => SORT_DESC])
                        ->limit(3)
                        ->all();
                    ?>
                    
                    <?php if (!empty($recentOrders)): ?>
                        <div class="orders-mini-list">
                            <?php foreach ($recentOrders as $order): ?>
                                <div class="mini-order-item">
                                    <div class="order-service-img">
                                        <?php if ($order->service->image): ?>
                                            <img src="<?= $order->service->image ?>" alt="">
                                        <?php else: ?>
                                            <div class="img-placeholder">💇</div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="order-info-compact">
                                        <h4><?= Html::encode($order->service->name) ?></h4>
                                        <p class="order-meta">
                                            <?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMM') ?> • 
                                            <?= substr($order->appointment_time, 0, 5) ?>
                                        </p>
                                        <span class="mini-status status-<?= $order->status ?>">
                                            <?php
                                            $statusLabels = [
                                                'new' => 'Новый',
                                                'confirmed' => 'Подтвержден',
                                                'in_progress' => 'В процессе',
                                                'completed' => 'Завершен',
                                                'cancelled' => 'Отменен',
                                            ];
                                            echo $statusLabels[$order->status] ?? $order->status;
                                            ?>
                                        </span>
                                    </div>
                                    <div class="order-price">
                                        <?= number_format($order->total_price, 0, '.', ' ') ?> ₽
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-orders-elegant">
                            <p>У вас пока нет заказов</p>
                            <?= Html::a('Записаться', ['/beauty/main/catalog'], ['class' => 'btn btn-primary btn-sm']) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ($master && !empty($master->services)): ?>
                    <div class="services-card">
                        <h2>Мои услуги</h2>
                        <div class="services-tags">
                            <?php foreach (array_slice($master->services, 0, 5) as $service): ?>
                                <span class="service-tag">
                                    <?= Html::encode($service->name) ?>
                                    <small><?= number_format($service->price, 0, '.', ' ') ?> ₽</small>
                                </span>
                            <?php endforeach; ?>
                            <?php if (count($master->services) > 5): ?>
                                <span class="service-tag more">+<?= count($master->services) - 5 ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Elegant profile styles
$this->registerCss("
.profile-elegant {
    max-width: 1200px;
    margin: 0 auto;
    padding: var(--space-lg) 0;
}

/* Hero Section */
.profile-hero {
    display: flex;
    align-items: center;
    gap: var(--space-lg);
    background: linear-gradient(135deg, var(--secondary-blush) 0%, var(--secondary-champagne) 100%);
    padding: var(--space-xl);
    border-radius: var(--radius-lg);
    margin-bottom: var(--space-lg);
}

.profile-avatar {
    flex-shrink: 0;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 4px solid white;
    box-shadow: var(--shadow-medium);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--primary-rose), var(--accent-gold));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    font-family: var(--font-display);
}

.profile-title h1 {
    font-family: var(--font-display);
    font-size: 1.75rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.profile-role {
    color: var(--neutral-medium);
    font-size: 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.verified-badge {
    background: rgba(168, 181, 160, 0.2);
    color: #5a6b52;
    padding: 0.25rem 0.75rem;
    border-radius: var(--radius-xl);
    font-size: 0.75rem;
    font-weight: 600;
}

/* Navigation Grid */
.profile-nav-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: var(--space-md);
    margin-bottom: var(--space-lg);
}

.nav-card {
    background: white;
    padding: var(--space-md);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-soft);
    text-decoration: none;
    transition: all var(--transition-fast);
    border: 1px solid transparent;
}

.nav-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-medium);
    border-color: var(--primary-rose);
}

.nav-card.highlight {
    background: linear-gradient(135deg, var(--secondary-blush), white);
    border-color: var(--primary-rose-light);
}

.nav-icon {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.nav-card h3 {
    font-family: var(--font-display);
    font-size: 1rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.25rem;
}

.nav-card p {
    font-size: 0.85rem;
    color: var(--neutral-medium);
    margin: 0;
}

/* Content Grid */
.profile-content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-lg);
}

@media (max-width: 768px) {
    .profile-content-grid {
        grid-template-columns: 1fr;
    }
    
    .profile-hero {
        flex-direction: column;
        text-align: center;
    }
}

/* Info Cards */
.info-card, .orders-card, .services-card {
    background: white;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-soft);
    padding: var(--space-md);
    margin-bottom: var(--space-md);
}

.info-card h2, .orders-card h2, .services-card h2 {
    font-family: var(--font-display);
    font-size: 1.1rem;
    color: var(--neutral-charcoal);
    margin-bottom: var(--space-md);
    padding-bottom: var(--space-sm);
    border-bottom: 1px solid var(--neutral-lighter);
}

.info-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
}

.info-label {
    color: var(--neutral-medium);
    font-size: 0.9rem;
}

.info-value {
    color: var(--neutral-charcoal);
    font-weight: 500;
}

/* Master Stats */
.master-stats {
    display: flex;
    gap: var(--space-md);
    margin-bottom: var(--space-md);
}

.stat-item {
    text-align: center;
    flex: 1;
    padding: var(--space-sm);
    background: var(--secondary-champagne);
    border-radius: var(--radius-sm);
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

.master-spec {
    margin-bottom: var(--space-md);
}

.spec-label {
    color: var(--neutral-medium);
}

.spec-value {
    color: var(--neutral-charcoal);
    font-weight: 500;
}

.master-bio-elegant {
    margin-top: var(--space-md);
    padding-top: var(--space-md);
    border-top: 1px solid var(--neutral-lighter);
}

.master-bio-elegant h4 {
    font-size: 0.9rem;
    color: var(--neutral-medium);
    margin-bottom: 0.5rem;
}

.master-bio-elegant p {
    color: var(--neutral-charcoal);
    font-size: 0.9rem;
    line-height: 1.6;
    font-style: italic;
}

/* Orders Card */
.orders-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-md);
}

.view-all-link {
    color: var(--primary-rose);
    font-size: 0.85rem;
    text-decoration: none;
}

.view-all-link:hover {
    text-decoration: underline;
}

.orders-mini-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}

.mini-order-item {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    padding: var(--space-sm);
    background: var(--secondary-champagne);
    border-radius: var(--radius-md);
}

.order-service-img {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    flex-shrink: 0;
}

.order-service-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.img-placeholder {
    width: 100%;
    height: 100%;
    background: var(--primary-rose-light);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.order-info-compact {
    flex: 1;
    min-width: 0;
}

.order-info-compact h4 {
    font-size: 0.9rem;
    color: var(--neutral-charcoal);
    margin-bottom: 0.15rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.order-meta {
    font-size: 0.75rem;
    color: var(--neutral-medium);
    margin: 0;
}

.mini-status {
    display: inline-block;
    padding: 0.15rem 0.5rem;
    border-radius: var(--radius-xl);
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
}

.mini-status.status-new {
    background: rgba(201, 169, 97, 0.2);
    color: #9a7d3c;
}

.mini-status.status-confirmed,
.mini-status.status-completed {
    background: rgba(168, 181, 160, 0.2);
    color: #5a6b52;
}

.mini-status.status-in_progress {
    background: rgba(232, 153, 138, 0.2);
    color: #a05a4d;
}

.mini-status.status-cancelled {
    background: rgba(212, 165, 116, 0.2);
    color: #9a7d3c;
}

.order-price {
    font-weight: 600;
    color: var(--primary-rose);
    font-size: 0.9rem;
    white-space: nowrap;
}

.empty-orders-elegant {
    text-align: center;
    padding: var(--space-md);
    color: var(--neutral-medium);
}

/* Services Tags */
.services-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.service-tag {
    background: var(--secondary-blush);
    color: var(--neutral-charcoal);
    padding: 0.5rem 0.75rem;
    border-radius: var(--radius-md);
    font-size: 0.85rem;
}

.service-tag small {
    display: block;
    color: var(--primary-rose);
    font-size: 0.75rem;
}

.service-tag.more {
    background: var(--neutral-lighter);
    color: var(--neutral-medium);
}
");
