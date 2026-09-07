<?php

use yii\helpers\Html;

/** @var \app\models\Order[] $orders */

$this->title = 'Мои заявки';
?>

<div class="orders-page">
    <div class="orders-header">
        <div class="orders-title">Мои заявки</div>
        <?= Html::a('Сформировать новую заявку', ['orders/create'], ['class' => 'btn btn-primary']) ?>
    </div>

    <?php if (empty($orders)): ?>
        <p class="text-muted">Вы ещё не оставляли заявок. Нажмите «Сформировать новую заявку», чтобы оформить первую.</p>
    <?php else: ?>
        <div class="orders-list">
            <?php foreach ($orders as $order): ?>
                <?php
                $statusTitle = $order->status ? $order->status->title : 'Неизвестно';
                $statusClass = 'order-status--' . str_replace(' ', '_', $statusTitle);
                ?>
                <div class="order-card">
                    <div class="order-card__row">
                        <div>
                            <div class="order-card__label">Категория</div>
                            <div>
                                <?= Html::encode($order->category->title ?? '—') ?>
                            </div>
                        </div>
                        <div>
                            <div class="order-card__label">Статус</div>
                            <div class="order-card__status <?= $statusClass ?>">
                                <?= Html::encode($statusTitle) ?>
                            </div>
                        </div>
                    </div>

                    <div class="order-card__row">
                        <div>
                            <div class="order-card__label">Адрес</div>
                            <div><?= Html::encode($order->address) ?></div>
                        </div>
                        <div>
                            <div class="order-card__label">Оплата</div>
                            <div><?= Html::encode($order->payment_type) ?></div>
                        </div>
                    </div>

                    <?php if ($order->item_type || $order->material): ?>
                        <div class="order-card__row">
                            <div>
                                <div class="order-card__label">Вид / материал</div>
                                <div>
                                    <?= Html::encode(trim(($order->item_type ?? '') . ' ' . ($order->material ?? ''))) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="order-card__meta">
                        Заявка от <?= Yii::$app->formatter->asDatetime($order->created_at) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>