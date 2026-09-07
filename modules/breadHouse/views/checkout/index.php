<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var array $products */
/* @var float $total */

$this->title = 'Оформление заказа';
?>

<div class="checkout-page">
    <div class="bh-container">
        <h1 class="bh-page-title">🛍️ <?= Html::encode($this->title) ?></h1>

        <div class="checkout-content bh-card">
            <form action="" method="post" class="bh-form">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->csrfToken?>">

                <!-- Delivery Type -->
                <div class="section">
                    <h2>📦 Способ доставки</h2>
                    <div class="bh-radio-group">
                        <label class="bh-radio-label">
                            <input type="radio" name="delivery_type" value="pickup" <?=$delivery['type'] == 'pickup' ? 'checked' : ''?>>
                            <span class="bh-radio-text">Самовывоз</span>
                        </label>
                        <label class="bh-radio-label">
                            <input type="radio" name="delivery_type" value="courier" <?=$delivery['type'] == 'courier' ? 'checked' : ''?>>
                            <span class="bh-radio-text">Курьерская доставка</span>
                        </label>
                    </div>
                </div>

                <!-- Address -->
                <div class="section" id="address-section" style="display:<?=$delivery['type'] == 'courier' ? 'block' : 'none'?>">
                    <h2>📍 Адрес доставки</h2>
                    <input type="text" name="delivery_address" value="<?=$delivery['address'] ?? ''?>" 
                           class="bh-input" placeholder="Введите адрес доставки">
                </div>

                <!-- Time -->
                <div class="section">
                    <h2>🕐 Время доставки</h2>
                    <div class="bh-datetime-row">
                        <input type="date" name="delivery_date" value="<?=$delivery['date'] ?? ''?>" class="bh-input">
                        <input type="time" name="delivery_time" value="<?=$delivery['time'] ?? ''?>" class="bh-input">
                    </div>
                </div>

                <!-- Payment -->
                <div class="section">
                    <h2>💳 Способ оплаты</h2>
                    <div class="bh-radio-group">
                        <label class="bh-radio-label">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <span class="bh-radio-text">Наличными</span>
                        </label>
                        <label class="bh-radio-label">
                            <input type="radio" name="payment_method" value="card">
                            <span class="bh-radio-text">Картой</span>
                        </label>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="section">
                    <h2>🛒 Ваш заказ</h2>
                    <table class="order-summary">
                        <thead>
                            <tr>
                                <th>Товар</th>
                                <th>Количество</th>
                                <th>Цена</th>
                                <th>Итого</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $item): ?>
                                <tr>
                                    <td><?=$item['product']->name?></td>
                                    <td><?=$item['quantity']?></td>
                                    <td><?=$item['product']->price?> ₽</td>
                                    <td><?=$item['subtotal']?> ₽</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"><strong>Общая сумма:</strong></td>
                                <td><strong><?=$total?> ₽</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <button type="submit" class="bh-btn bh-btn--primary bh-btn--large">
                    ✅ Оформить заказ
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('input[name="delivery_type"]').forEach(function(el) {
    el.addEventListener('change', function() {
        document.getElementById('address-section').style.display = this.value === 'courier' ? 'block' : 'none';
    });
});
</script>
