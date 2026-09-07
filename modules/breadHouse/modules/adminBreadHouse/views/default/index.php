<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\breadHouse\modules\adminBreadHouse\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Панель администратора';

$latestOrders = $dataProvider->getModels();
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">📊 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <span>Главная</span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-card__icon">📦</div>
            <div class="admin-stat-card__info">
                <div class="admin-stat-card__title">Всего заказов</div>
                <div class="admin-stat-card__value"><?= \app\modules\breadHouse\models\Orders::find()->count() ?></div>
            </div>
        </div>
        <div class="admin-stat-card admin-stat-card--warning">
            <div class="admin-stat-card__icon">⏳</div>
            <div class="admin-stat-card__info">
                <div class="admin-stat-card__title">Новые</div>
                <div class="admin-stat-card__value"><?= \app\modules\breadHouse\models\Orders::find()->where(['status_id' => 1])->count() ?></div>
            </div>
        </div>
        <div class="admin-stat-card admin-stat-card--info">
            <div class="admin-stat-card__icon">🔄</div>
            <div class="admin-stat-card__info">
                <div class="admin-stat-card__title">В обработке</div>
                <div class="admin-stat-card__value"><?= \app\modules\breadHouse\models\Orders::find()->where(['status_id' => 2])->count() ?></div>
            </div>
        </div>
        <div class="admin-stat-card admin-stat-card--success">
            <div class="admin-stat-card__icon">✅</div>
            <div class="admin-stat-card__info">
                <div class="admin-stat-card__title">Выполнено</div>
                <div class="admin-stat-card__value"><?= \app\modules\breadHouse\models\Orders::find()->where(['status_id' => 3])->count() ?></div>
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="admin-quick-links">
        <a href="<?= Url::to(['/breadHouse/admin/products']) ?>" class="admin-quick-link">
            <span class="admin-quick-link__icon">�️</span>
            <span class="admin-quick-link__text">Товары</span>
        </a>
        <a href="<?= Url::to(['/breadHouse/admin/categories']) ?>" class="admin-quick-link">
            <span class="admin-quick-link__icon">📁</span>
            <span class="admin-quick-link__text">Категории</span>
        </a>
        <a href="<?= Url::to(['/breadHouse/admin/orders']) ?>" class="admin-quick-link">
            <span class="admin-quick-link__icon">📋</span>
            <span class="admin-quick-link__text">Заказы</span>
        </a>
        <a href="<?= Url::to(['/breadHouse/admin/users']) ?>" class="admin-quick-link">
            <span class="admin-quick-link__icon">👥</span>
            <span class="admin-quick-link__text">Пользователи</span>
        </a>
    </div>

    <!-- Latest Orders -->
    <div class="admin-section-header">
        <h2 class="admin-section-title">🕐 Последние заказы</h2>
        <?= Html::a('Все заказы →', ['/breadHouse/admin/orders'], ['class' => 'admin-btn admin-btn--primary admin-btn--small']) ?>
    </div>

    <div class="admin-cards-grid admin-cards-grid--compact">
        <?php foreach (array_slice($latestOrders, 0, 6) as $order): ?>
            <div class="admin-order-card admin-order-card--compact">
                <div class="admin-order-card__header">
                    <div class="admin-order-card__id">#<?= $order->id ?></div>
                    <span class="admin-status admin-status--<?= $order->status_id ?>">
                        <?= $order->status ? $order->status->title : '-' ?>
                    </span>
                </div>
                <div class="admin-order-card__body">
                    <div class="admin-order-card__customer">
                        <?= $order->user ? Html::encode($order->user->first_name . ' ' . $order->user->last_name) : '<em>Не указан</em>' ?>
                    </div>
                    <div class="admin-order-card__price"><?= number_format($order->total, 2, '.', ' ') ?> ₽</div>
                    <div class="admin-order-card__date"><?= Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') ?></div>
                </div>
                <div class="admin-order-card__footer">
                    <?= Html::a('👁️ Просмотр', ['/breadHouse/admin/orders/view', 'id' => $order->id], ['class' => 'admin-btn admin-btn--small admin-btn--info']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
