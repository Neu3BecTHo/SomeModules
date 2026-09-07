<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var array $products */
/* @var float $total */
/* @var array $delivery */

$this->title = 'Корзина — Хлебный дворик';
?>

<!-- ===== CART PAGE ===== -->
<section class="bh-cart">
    <div class="container">
        <div class="bh-cart-header">
            <h1 class="bh-cart-title">🛒 Ваша корзина</h1>
            <div class="bh-cart-count">
                <?php if ($products): ?>
                    <?= count($products) ?> <?= count($products) == 1 ? 'товар' : (count($products) < 5 ? 'товара' : 'товаров') ?>
                <?php else: ?>
                    Корзина пуста
                <?php endif; ?>
            </div>
        </div>

        <?php if ($products): ?>
            <div class="bh-cart-content">
                <div class="bh-cart-table-wrapper">
                    <table class="bh-cart-table">
                        <thead>
                            <tr>
                                <th class="bh-cart-header-product">Товар</th>
                                <th class="bh-cart-header-price">Цена</th>
                                <th class="bh-cart-header-quantity">Количество</th>
                                <th class="bh-cart-header-total">Итого</th>
                                <th class="bh-cart-header-actions">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item): ?>
                                <tr class="bh-cart-item">
                                    <td class="bh-cart-product">
                                        <div class="bh-cart-item-info">
                                            <img src="<?= $item['product']->image ?: '/images/no-image.png' ?>" 
                                                 alt="<?= Html::encode($item['product']->name) ?>" 
                                                 class="bh-cart-item-image">
                                            <div class="bh-cart-item-details">
                                                <h3 class="bh-cart-item-name"><?= Html::encode($item['product']->name) ?></h3>
                                                <p class="bh-cart-item-category"><?= Html::encode($item['product']->category->title ?? '') ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="bh-cart-price">
                                        <div class="bh-price-display">
                                            <span class="bh-price-amount"><?= number_format($item['product']->price, 2, '.', ' ') ?></span>
                                            <span class="bh-price-currency">₽</span>
                                        </div>
                                    </td>
                                    <td class="bh-cart-quantity">
                                        <form action="<?= Url::to(['cart/update', 'id' => $item['product']->id]) ?>" method="post" class="bh-quantity-form">
                                            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                            <div class="bh-quantity-selector">
                                                <button type="button" class="bh-quantity-btn bh-quantity-btn--minus" 
                                                        onclick="changeQuantity(this, -1)">−</button>
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" 
                                                       min="1" max="<?= $item['product']->stock ?>" 
                                                       class="bh-quantity-input" onchange="this.form.submit()">
                                                <button type="button" class="bh-quantity-btn bh-quantity-btn--plus" 
                                                        onclick="changeQuantity(this, 1)">+</button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="bh-cart-subtotal">
                                        <div class="bh-price-display bh-price-display--highlighted">
                                            <span class="bh-price-amount"><?= number_format($item['subtotal'], 2, '.', ' ') ?></span>
                                            <span class="bh-price-currency">₽</span>
                                        </div>
                                    </td>
                                    <td class="bh-cart-actions">
                                        <?= Html::a('🗑️', ['cart/delete', 'id' => $item['product']->id], [
                                            'class' => 'bh-btn bh-btn--danger bh-btn--small',
                                            'title' => 'Удалить из корзины',
                                            'data-confirm' => 'Вы уверены, что хотите удалить этот товар из корзины?',
                                            'data-method' => 'post'
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="bh-cart-summary">
                    <div class="bh-summary-card">
                        <h3 class="bh-summary-title">Итого заказа</h3>
                        <div class="bh-summary-row">
                            <span class="bh-summary-label">Товары (<?= count($products) ?> шт.):</span>
                            <span class="bh-summary-value">
                                <span class="bh-price-amount"><?= number_format($total, 2, '.', ' ') ?></span>
                                <span class="bh-price-currency">₽</span>
                            </span>
                        </div>
                        
                        <?php if ($delivery && ($delivery['type'] || $delivery['date'] || $delivery['time'])): ?>
                            <div class="bh-summary-divider"></div>
                            <div class="bh-summary-section">
                                <h4 class="bh-summary-section-title">🚚 Параметры доставки</h4>
                                <div class="bh-summary-row">
                                    <span class="bh-summary-label">Тип:</span>
                                    <span class="bh-summary-value">
                                        <?= $delivery['type'] == 'pickup' ? 'Самовывоз' : 'Курьерская доставка' ?>
                                    </span>
                                </div>
                                <?php if ($delivery['date']): ?>
                                    <div class="bh-summary-row">
                                        <span class="bh-summary-label">Дата:</span>
                                        <span class="bh-summary-value"><?= $delivery['date'] ?></span>
                                    </div>
                                <?php endif; ?>
                                <?php if ($delivery['time']): ?>
                                    <div class="bh-summary-row">
                                        <span class="bh-summary-label">Время:</span>
                                        <span class="bh-summary-value"><?= $delivery['time'] ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="bh-cart-actions">
                        <a href="<?= Url::to(['catalog/index']) ?>" class="bh-btn bh-btn--secondary bh-btn--large">
                            <span class="bh-btn-icon">🛍️</span>
                            <span class="bh-btn-text">Продолжить покупки</span>
                        </a>
                        <a href="<?= Url::to(['checkout/index']) ?>" class="bh-btn bh-btn--primary bh-btn--large">
                            <span class="bh-btn-icon">✅</span>
                            <span class="bh-btn-text">Оформить заказ</span>
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="bh-empty-cart">
                <div class="bh-empty-icon">🛒</div>
                <h2 class="bh-empty-title">Ваша корзина пуста</h2>
                <p class="bh-empty-description">Добавьте товары из каталога, чтобы оформить заказ</p>
                <a href="<?= Url::to(['catalog/index']) ?>" class="bh-btn bh-btn--primary bh-btn--large">
                    <span class="bh-btn-icon">🛍️</span>
                    <span class="bh-btn-text">Перейти в каталог</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
function changeQuantity(button, delta) {
    const input = button.parentElement.querySelector('.bh-quantity-input');
    const currentValue = parseInt(input.value);
    const min = parseInt(input.min);
    const max = parseInt(input.max);

    let newValue = currentValue + delta;
    if (newValue < min) newValue = min;
    if (newValue > max) newValue = max;

    input.value = newValue;
}
</script>
