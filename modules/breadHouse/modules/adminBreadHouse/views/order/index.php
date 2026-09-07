<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\breadHouse\modules\adminBreadHouse\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление заказами';

$orders = $dataProvider->getModels();
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">📋 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['/breadHouse/admin']) ?>">Главная</a>
                <span class="separator">›</span>
                <span>Заказы</span>
            </div>
        </div>
    </div>

    <!-- Orders Grid -->
    <div class="admin-cards-grid">
        <?php foreach ($orders as $order): ?>
            <div class="admin-order-card">
                <div class="admin-order-card__header">
                    <div class="admin-order-card__id">#<?= $order->id ?></div>
                    <div class="admin-order-card__date"><?= Yii::$app->formatter->asDatetime($order->created_at, 'php:d.m.Y H:i') ?></div>
                </div>
                
                <div class="admin-order-card__body">
                    <div class="admin-order-card__customer">
                        <div class="admin-order-card__label">👤 Клиент</div>
                        <div class="admin-order-card__value">
                            <?= $order->user ? Html::encode($order->user->first_name . ' ' . $order->user->last_name) : '<em>Не указан</em>' ?>
                        </div>
                        <?php if ($order->user): ?>
                            <div class="admin-order-card__phone"><?= $order->user->phone ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="admin-order-card__info-row">
                        <div class="admin-order-card__info-item">
                            <div class="admin-order-card__label">💰 Сумма</div>
                            <div class="admin-order-card__price"><?= number_format($order->total, 2, '.', ' ') ?> ₽</div>
                        </div>
                        <div class="admin-order-card__info-item">
                            <div class="admin-order-card__label">📦 Статус</div>
                            <span class="admin-status admin-status--<?= $order->status_id ?>">
                                <?= $order->status ? $order->status->title : '-' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="admin-order-card__info-row">
                        <div class="admin-order-card__info-item">
                            <div class="admin-order-card__label">💳 Оплата</div>
                            <div class="admin-order-card__value">
                                <?= $order->payment_method == 'cash' ? 'Наличные' : 'Карта' ?>
                            </div>
                        </div>
                        <div class="admin-order-card__info-item">
                            <div class="admin-order-card__label">🚚 Доставка</div>
                            <div class="admin-order-card__value">
                                <?= $order->delivery_type == 'pickup' ? 'Самовывоз' : 'Курьер' ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="admin-order-card__footer">
                    <?= Html::a('👁️ Просмотр', ['view', 'id' => $order->id], ['class' => 'admin-btn admin-btn--small admin-btn--info']) ?>
                    <?= Html::a('⚡ Статус', ['update-status', 'id' => $order->id], ['class' => 'admin-btn admin-btn--small admin-btn--warning']) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination-wrapper">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'admin-pagination'],
            'linkOptions' => ['class' => 'admin-pagination-link'],
            'activePageCssClass' => 'admin-pagination-link--active',
            'disabledPageCssClass' => 'admin-pagination-link--disabled',
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
        ]) ?>
    </div>
</div>
