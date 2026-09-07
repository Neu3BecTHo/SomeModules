<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Orders */

$this->title = 'Заказ #' . $model->id;
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">📋 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['index']) ?>">Заказы</a>
                <span class="separator">›</span>
                <span>Заказ #<?= $model->id ?></span>
            </div>
        </div>
        <div class="admin-actions">
            <?= Html::a('⚡ Изменить статус', ['update-status', 'id' => $model->id], ['class' => 'admin-btn admin-btn--warning']) ?>
            <?= Html::a('← К списку', ['index'], ['class' => 'admin-btn admin-btn--secondary']) ?>
        </div>
    </div>

    <div class="admin-order-view">
        <div class="admin-grid">
            <!-- Order Info Card -->
            <div class="admin-card">
                <div class="admin-card__header">
                    <h2 class="admin-card__title">📋 Информация о заказе</h2>
                </div>
                <div class="admin-card__body">
                    <div class="admin-info-list">
                        <div class="admin-info-item">
                            <span class="admin-info-label">ID заказа:</span>
                            <span class="admin-info-value">#<?= $model->id ?></span>
                        </div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Пользователь:</span>
                            <span class="admin-info-value">
                                <?= $model->user ? Html::encode($model->user->first_name . ' ' . $model->user->last_name) : '<em>Не указан</em>' ?>
                            </span>
                        </div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Телефон:</span>
                            <span class="admin-info-value"><?= $model->user ? Html::encode($model->user->phone) : '-' ?></span>
                        </div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Email:</span>
                            <span class="admin-info-value"><?= $model->user ? Html::encode($model->user->email) : '-' ?></span>
                        </div>
                        <div class="admin-divider"></div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Общая сумма:</span>
                            <span class="admin-info-value admin-price"><?= number_format($model->total, 2, '.', ' ') ?> ₽</span>
                        </div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Статус:</span>
                            <span class="admin-status admin-status--<?= $model->status_id ?>">
                                <?= $model->status ? Html::encode($model->status->title) : 'Неизвестно' ?>
                            </span>
                        </div>
                        <div class="admin-divider"></div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Способ оплаты:</span>
                            <span class="admin-info-value">
                                <?= $model->payment_method == 'cash' ? '💵 Наличными' : '💳 Картой онлайн' ?>
                            </span>
                        </div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Тип доставки:</span>
                            <span class="admin-info-value">
                                <?= $model->delivery_type == 'pickup' ? '🏪 Самовывоз' : '🚚 Курьерская доставка' ?>
                            </span>
                        </div>
                        <?php if ($model->delivery_address): ?>
                            <div class="admin-info-item admin-info-item--full">
                                <span class="admin-info-label">Адрес доставки:</span>
                                <span class="admin-info-value"><?= Html::encode($model->delivery_address) ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($model->delivery_time): ?>
                            <div class="admin-info-item">
                                <span class="admin-info-label">Время доставки:</span>
                                <span class="admin-info-value"><?= Yii::$app->formatter->asDatetime($model->delivery_time) ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="admin-divider"></div>
                        <div class="admin-info-item">
                            <span class="admin-info-label">Дата создания:</span>
                            <span class="admin-info-value"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items Card -->
            <div class="admin-card admin-card--full-width">
                <div class="admin-card__header">
                    <h2 class="admin-card__title">🛍️ Товары в заказе (<?= count($model->orderItems) ?>)</h2>
                </div>
                <div class="admin-card__body">
                    <div class="admin-table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Товар</th>
                                    <th>Цена за ед.</th>
                                    <th>Количество</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($model->orderItems as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <strong><?= Html::encode($item->product->name) ?></strong>
                                            <?php if ($item->product->category): ?>
                                                <br><small class="text-muted"><?= Html::encode($item->product->category->title) ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_format($item->price, 2, '.', ' ') ?> ₽</td>
                                        <td><?= $item->quantity ?> шт.</td>
                                        <td class="admin-price"><?= number_format($item->price * $item->quantity, 2, '.', ' ') ?> ₽</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Итого:</strong></td>
                                    <td class="admin-price admin-price--total"><?= number_format($model->total, 2, '.', ' ') ?> ₽</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
