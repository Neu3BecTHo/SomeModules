<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var app\modules\breadHouse\models\Orders[] $orders */
/** @var \yii\data\Pagination $pagination */

$this->title = 'Мои заказы — Хлебный дворик';
?>

<!-- ===== ORDERS PAGE ===== -->
<section class="bh-orders">
    <div class="container">
        <div class="bh-orders-header">
            <h1 class="bh-orders-title">📋 Мои заказы</h1>
            <p class="bh-orders-subtitle">История ваших заказов и их статус</p>
        </div>

        <?php if (empty($orders)): ?>
            <!-- Empty State -->
            <div class="bh-empty-orders">
                <div class="bh-empty-icon">📦</div>
                <h2 class="bh-empty-title">У вас пока нет заказов</h2>
                <p class="bh-empty-description">Пора сделать первый заказ свежей выпечки!</p>
                <?= Html::a('🛍️ Перейти в каталог', ['catalog/index'], ['class' => 'bh-btn bh-btn--primary bh-btn--large']) ?>
            </div>
        <?php else: ?>
            <!-- Orders Statistics -->
            <?php
            // Calculate statistics from all user orders (not just current page)
            $allOrders = \app\modules\breadHouse\models\Orders::find()
                ->where(['user_id' => Yii::$app->userBreadHouse->id])
                ->all();
            $totalOrders = count($allOrders);
            $completedOrders = count(array_filter($allOrders, function($order) {
                return $order->status_id == 3;
            }));
            $totalSpent = array_sum(array_map(function($order) {
                return $order->total;
            }, $allOrders));
            ?>
            <div class="bh-orders-stats">
                <div class="bh-stat-card">
                    <div class="bh-stat-number"><?= $totalOrders ?></div>
                    <div class="bh-stat-label">Всего заказов</div>
                </div>
                <div class="bh-stat-card">
                    <div class="bh-stat-number"><?= $completedOrders ?></div>
                    <div class="bh-stat-label">Выполнено</div>
                </div>
                <div class="bh-stat-card">
                    <div class="bh-stat-number"><?= number_format($totalSpent, 2, '.', ' ') ?> ₽</div>
                    <div class="bh-stat-label">Общая сумма</div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="bh-orders-grid">
                <?php foreach ($orders as $order): ?>
                    <?php
                    $statusTitle = $order->status ? $order->status->title : 'Неизвестно';
                    $statusClass = match($order->status_id) {
                        1 => 'bh-order-status--new',
                        2 => 'bh-order-status--processing',
                        3 => 'bh-order-status--completed',
                        4 => 'bh-order-status--cancelled',
                        default => 'bh-order-status--unknown'
                    };
                    ?>
                    <div class="bh-order-card">
                        <!-- Order Header -->
                        <div class="bh-order-header">
                            <div class="bh-order-meta">
                                <div class="bh-order-number">Заказ №<?= $order->id ?></div>
                                <div class="bh-order-date">
                                    <?= Yii::$app->formatter->asDate($order->created_at) ?>
                                </div>
                            </div>
                            <div class="bh-order-status <?= $statusClass ?>">
                                <?= Html::encode($statusTitle) ?>
                            </div>
                        </div>

                        <!-- Order Body -->
                        <div class="bh-order-body">
                            <!-- Products Summary -->
                            <div class="bh-order-products-summary">
                                <div class="bh-products-count">
                                    <?= count($order->orderItems) ?> <?= count($order->orderItems) == 1 ? 'товар' : (count($order->orderItems) < 5 ? 'товара' : 'товаров') ?>
                                </div>
                                <div class="bh-products-names">
                                    <?php
                                    $productNames = array_map(function($item) {
                                        return Html::encode($item->product->name);
                                    }, $order->orderItems);
                                    echo implode(', ', array_slice($productNames, 0, 3));
                                    if (count($productNames) > 3) {
                                        echo '...';
                                    }
                                    ?>
                                </div>
                            </div>

                            <!-- Order Info -->
                            <div class="bh-order-info">
                                <div class="bh-info-item">
                                    <span class="bh-info-label">Оплата:</span>
                                    <span class="bh-info-value">
                                        <?= $order->payment_method == 'cash' ? '💵 Наличными' : '💳 Картой' ?>
                                    </span>
                                </div>
                                <?php if ($order->delivery_type == 'courier'): ?>
                                    <div class="bh-info-item">
                                        <span class="bh-info-label">Доставка:</span>
                                        <span class="bh-info-value">🚚 Курьер</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Order Footer -->
                        <div class="bh-order-footer">
                            <div class="bh-order-total">
                                <span class="bh-total-label">Итого:</span>
                                <span class="bh-total-amount"><?= number_format($order->total, 2, '.', ' ') ?> ₽</span>
                            </div>
                            <div class="bh-order-actions">
                                <?= Html::a('🔄 Повторить', ['orders/repeat', 'id' => $order->id], [
                                    'class' => 'bh-btn bh-btn--secondary bh-btn--small'
                                ]) ?>
                                <button class="bh-btn bh-btn--primary bh-btn--small" onclick="toggleOrderDetails(this, <?= $order->id ?>)">
                                    📋 Подробно
                                </button>
                            </div>
                        </div>

                        <!-- Expandable Details (Hidden by default) -->
                        <div class="bh-order-details" id="order-details-<?= $order->id ?>" style="display: none;">
                            <div class="bh-order-details-content">
                                <!-- Full Product List -->
                                <div class="bh-order-products-details">
                                    <h5 class="bh-details-title">Товары в заказе:</h5>
                                    <div class="bh-products-detailed">
                                        <?php foreach ($order->orderItems as $item): ?>
                                            <div class="bh-product-detailed-item">
                                                <div class="bh-product-detailed-info">
                                                    <span class="bh-product-detailed-name"><?= Html::encode($item->product->name) ?></span>
                                                    <span class="bh-product-detailed-quantity">× <?= $item->quantity ?></span>
                                                </div>
                                                <span class="bh-product-detailed-price"><?= number_format($item->price * $item->quantity, 2, '.', ' ') ?> ₽</span>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Full Order Info -->
                                <div class="bh-order-details-info">
                                    <?php if ($order->delivery_time): ?>
                                        <div class="bh-details-info-item">
                                            <span class="bh-details-label">Время доставки:</span>
                                            <span class="bh-details-value">
                                                <?= Yii::$app->formatter->asDate($order->delivery_time) ?> в
                                                <?= Yii::$app->formatter->asTime($order->delivery_time) ?>
                                            </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($order->delivery_address): ?>
                                        <div class="bh-details-info-item">
                                            <span class="bh-details-label">Адрес доставки:</span>
                                            <span class="bh-details-value"><?= Html::encode($order->delivery_address) ?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if (!empty($orders) && $pagination->pageCount > 1): ?>
            <div class="bh-pagination">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'options' => ['class' => 'bh-pagination-wrapper'],
                    'linkContainerOptions' => ['class' => 'bh-page-item'],
                    'linkOptions' => ['class' => 'bh-page-link'],
                    'disabledPageCssClass' => 'bh-page-item--disabled',
                    'activePageCssClass' => 'bh-page-item--active',
                ]); ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function toggleOrderDetails(button, orderId) {
    const detailsDiv = document.getElementById('order-details-' + orderId);
    const isExpanded = detailsDiv.style.display !== 'none';

    if (isExpanded) {
        detailsDiv.style.display = 'none';
        button.innerHTML = '📋 Подробно';
        button.classList.remove('bh-btn--expanded');
    } else {
        detailsDiv.style.display = 'block';
        button.innerHTML = '📋 Свернуть';
        button.classList.add('bh-btn--expanded');
    }
}
</script>