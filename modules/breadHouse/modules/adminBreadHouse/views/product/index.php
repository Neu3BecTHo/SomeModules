<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\breadHouse\modules\adminBreadHouse\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление товарами';

$products = $dataProvider->getModels();
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">🛍️ <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['/breadHouse/admin']) ?>">Главная</a>
                <span class="separator">›</span>
                <span>Товары</span>
            </div>
        </div>
        <div class="admin-actions">
            <?= Html::a('➕ Создать товар', ['create'], ['class' => 'admin-btn admin-btn--success']) ?>
        </div>
    </div>

    <!-- Stats -->
    <div class="admin-stats">
        <div class="admin-stat-card">
            <div class="admin-stat-card__title">Всего товаров</div>
            <div class="admin-stat-card__value"><?= $dataProvider->totalCount ?></div>
        </div>
        <?php
        $inStock = 0;
        $outOfStock = 0;
        foreach ($products as $p) {
            if ($p->stock > 0) $inStock++;
            else $outOfStock++;
        }
        ?>
        <div class="admin-stat-card admin-stat-card--success">
            <div class="admin-stat-card__title">В наличии</div>
            <div class="admin-stat-card__value"><?= $inStock ?></div>
        </div>
        <div class="admin-stat-card admin-stat-card--danger">
            <div class="admin-stat-card__title">Нет в наличии</div>
            <div class="admin-stat-card__value"><?= $outOfStock ?></div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="admin-cards-grid">
        <?php foreach ($products as $product): ?>
            <div class="admin-product-card">
                <div class="admin-product-card__image">
                    <?php if ($product->image): ?>
                        <img src="<?= $product->image ?>" alt="<?= Html::encode($product->name) ?>">
                    <?php else: ?>
                        <div class="admin-product-card__placeholder">🖼️</div>
                    <?php endif; ?>
                </div>
                <div class="admin-product-card__content">
                    <div class="admin-product-card__category"><?= $product->category ? Html::encode($product->category->title) : 'Без категории' ?></div>
                    <h3 class="admin-product-card__title"><?= Html::encode($product->name) ?></h3>
                    <div class="admin-product-card__price"><?= number_format($product->price, 2, '.', ' ') ?> ₽</div>
                    <div class="admin-product-card__meta">
                        <span class="admin-stock <?= $product->stock > 10 ? 'admin-stock--in' : ($product->stock > 0 ? 'admin-stock--low' : 'admin-stock--out') ?>">
                            <?= $product->stock > 10 ? '✓ В наличии' : ($product->stock > 0 ? '⚠️ ' . $product->stock . ' шт.' : '✗ Нет') ?>
                        </span>
                        <span class="admin-rating">⭐ <?= number_format($product->rating, 1) ?></span>
                    </div>
                </div>
                <div class="admin-product-card__actions">
                    <?= Html::a('👁️', ['view', 'id' => $product->id], ['class' => 'admin-btn admin-btn--small admin-btn--info', 'title' => 'Просмотр']) ?>
                    <?= Html::a('✏️', ['update', 'id' => $product->id], ['class' => 'admin-btn admin-btn--small admin-btn--warning', 'title' => 'Редактировать']) ?>
                    <?= Html::a('🗑️', ['delete', 'id' => $product->id], [
                        'class' => 'admin-btn admin-btn--small admin-btn--danger',
                        'title' => 'Удалить',
                        'data-confirm' => 'Вы уверены?',
                        'data-method' => 'post',
                    ]) ?>
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
