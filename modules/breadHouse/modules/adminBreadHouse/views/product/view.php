<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Product */

$this->title = $model->name;
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">🛍️ <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['index']) ?>">Товары</a>
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
                <h2 class="admin-card__title">📋 Основная информация</h2>
            </div>
            <div class="admin-card__body">
                <div class="admin-info-list">
                    <div class="admin-info-item">
                        <span class="admin-info-label">ID:</span>
                        <span class="admin-info-value"><?= $model->id ?></span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Название:</span>
                        <span class="admin-info-value"><?= Html::encode($model->name) ?></span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Категория:</span>
                        <span class="admin-info-value"><?= $model->category ? Html::encode($model->category->title) : '-' ?></span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Цена:</span>
                        <span class="admin-info-value admin-price"><?= number_format($model->price, 2, '.', ' ') ?> ₽</span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">В наличии:</span>
                        <span class="admin-info-value"><?= $model->stock ?> шт.</span>
                    </div>
                    <div class="admin-info-item">
                        <span class="admin-info-label">Рейтинг:</span>
                        <span class="admin-info-value">⭐ <?= number_format($model->rating, 1) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="admin-card">
            <div class="admin-card__header">
                <h2 class="admin-card__title">🖼️ Изображения</h2>
            </div>
            <div class="admin-card__body">
                <?php if ($model->productImages): ?>
                    <div class="admin-image-grid">
                        <?php foreach ($model->productImages as $image): ?>
                            <div class="admin-image-item">
                                <img src="<?= $image->image ?>" alt="<?= Html::encode($model->name) ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="admin-alert admin-alert--info">
                        <div class="admin-alert__icon">ℹ️</div>
                        <div class="admin-alert__content">Нет изображений</div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="admin-card admin-card--full-width">
            <div class="admin-card__header">
                <h2 class="admin-card__title">📝 Описание</h2>
            </div>
            <div class="admin-card__body">
                <?= nl2br(Html::encode($model->description ?: 'Описание отсутствует')) ?>
            </div>
        </div>
    </div>
</div>
