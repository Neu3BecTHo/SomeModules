<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Categories */

$this->title = $model->title;
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">📁 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['index']) ?>">Категории</a>
                <span class="separator">›</span>
                <span>Просмотр</span>
            </div>
        </div>
        <div class="admin-actions">
            <?= Html::a('✏️ Редактировать', ['update', 'id' => $model->id], ['class' => 'admin-btn admin-btn--warning']) ?>
            <?= Html::a('← К списку', ['index'], ['class' => 'admin-btn admin-btn--secondary']) ?>
        </div>
    </div>

    <div class="admin-grid">
        <div class="admin-card">
            <div class="admin-card__header">
                <h2 class="admin-card__title">📋 Информация о категории</h2>
            </div>
            <div class="admin-card__body">
                <div class="admin-info-list">
                    <div class="admin-info-item">
                        <span class="admin-info-label">ID:</span>
                        <span class="admin-info-value"><?= $model->id ?></span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Название:</span>
                        <span class="admin-info-value"><?= Html::encode($model->title) ?></span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Товаров в категории:</span>
                        <span class="admin-info-value"><?= count($model->products) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card admin-card--full-width">
            <div class="admin-card__header">
                <h2 class="admin-card__title">🛍️ Товары в категории</h2>
            </div>
            <div class="admin-card__body">
                <?php if ($model->products): ?>
                    <div class="admin-table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Цена</th>
                                    <th>В наличии</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($model->products as $product): ?>
                                    <tr>
                                        <td><?= $product->id ?></td>
                                        <td><?= Html::encode($product->name) ?></td>
                                        <td><?= number_format($product->price, 2, '.', ' ') ?> ₽</td>
                                        <td><?= $product->stock ?> шт.</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="admin-alert admin-alert--info">
                        <div class="admin-alert__icon">ℹ️</div>
                        <div class="admin-alert__content">В этой категории пока нет товаров</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
