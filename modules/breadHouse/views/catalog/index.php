<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $categories app\modules\breadHouse\models\Categories[] */
/* @var $currentCategory int|null */
/* @var $currentSort string */

$this->title = 'Каталог товаров — Хлебный дворик';
?>

<!-- ===== PAGE HEADER ===== -->
<section class="bh-catalog-header">
    <div class="container">
        <div class="bh-catalog-header__inner">
            <h1 class="bh-catalog-title">Каталог товаров</h1>
            <p class="bh-catalog-subtitle">Свежие и вкусные хлебобулочные изделия на любой вкус</p>
        </div>
    </div>
</section>

<!-- ===== FILTERS AND SORTING ===== -->
<section class="bh-filters">
    <div class="container">
        <div class="bh-filters-wrapper">
            <form method="get" class="bh-filters-form">
                <div class="bh-filters-group">
                    <label class="bh-filters-label">Категория:</label>
                    <select name="category" class="bh-filters-select">
                        <option value="">Все категории</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?=$category->id?>" <?=$currentCategory == $category->id ? 'selected' : ''?>>
                                <?=$category->title?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="bh-filters-group">
                    <label class="bh-filters-label">Сортировка:</label>
                    <select name="sort" class="bh-filters-select">
                        <option value="new" <?=$currentSort == 'new' ? 'selected' : ''?>>По новизне</option>
                        <option value="name" <?=$currentSort == 'name' ? 'selected' : ''?>>По названию</option>
                        <option value="price_asc" <?=$currentSort == 'price_asc' ? 'selected' : ''?>>Цена по возрастанию</option>
                        <option value="price_desc" <?=$currentSort == 'price_desc' ? 'selected' : ''?>>Цена по убыванию</option>
                    </select>
                </div>

                <button type="submit" class="bh-btn bh-btn--primary">
                    <span>🔍</span>
                    <span>Применить</span>
                </button>
            </form>
        </div>
    </div>
</section>

<!-- ===== PRODUCTS GRID ===== -->
<section class="bh-catalog-products">
    <div class="container">
        <?php if ($dataProvider->totalCount > 0): ?>
            <div class="bh-products bh-products--catalog">
                <?php foreach ($dataProvider->models as $product): ?>
                    <div class="bh-product-card">
                        <div class="bh-product__image">
                            <?php 
                            $allImages = $product->getAllImages();
                            if (!empty($allImages)): 
                            ?>
                                <img src="<?= $allImages[0] ?>" alt="<?= $product->name ?>" class="bh-product-img">
                            <?php else: ?>
                                <img src="/images/no-image.png" alt="<?= $product->name ?>" class="bh-product-img">
                            <?php endif; ?>
                            
                            <?php if ($product->rating >= 4.5): ?>
                                <span class="bh-product__badge bh-product__badge--hit">⭐ Хит</span>
                            <?php elseif ($product->stock <= 5 && $product->stock > 0): ?>
                                <span class="bh-product__badge bh-product__badge--low">⚠ Осталось <?=$product->stock?> шт.</span>
                            <?php elseif ($product->stock <= 0): ?>
                                <span class="bh-product__badge bh-product__badge--out">✗ Нет в наличии</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="bh-product__info">
                            <h3 class="bh-product__title"><?= Html::encode($product->name) ?></h3>
                            <p class="bh-product__description"><?= Html::encode($product->description) ?></p>
                            
                            <div class="bh-product__meta">
                                <span class="bh-product__price"><?= $product->price ?> ₽</span>
                                <div class="bh-product__rating">
                                    ⭐ <?= number_format($product->rating, 1) ?>
                                </div>
                            </div>
                            
                            <div class="bh-product__actions">
                                <div class="bh-quantity-wrapper">
                                    <input type="number" name="quantity" value="1" min="1" max="<?= $product->stock ?>" 
                                           class="bh-quantity-input" form="cart-form-<?= $product->id ?>" 
                                           <?= $product->stock <= 0 ? 'disabled' : '' ?>>
                                </div>
                                <form action="<?= Url::to(['cart/add']) ?>" method="post" class="bh-cart-form" id="cart-form-<?= $product->id ?>">
                                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                    <button type="submit" class="bh-btn bh-btn--primary bh-btn--small bh-btn--cart" 
                                            <?= $product->stock <= 0 ? 'disabled' : '' ?> 
                                            title="<?= $product->stock <= 0 ? 'Нет в наличии' : 'В корзину' ?>">
                                        <?php if ($product->stock <= 0): ?>
                                            ✗
                                        <?php else: ?>
                                            🛒
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" 
                                   class="bh-btn bh-btn--outline bh-btn--small bh-btn--details" title="Подробнее">
                                    👁️
                                </a>
                            </div>
                            
                            <div class="bh-product__stock">
                                <?php if ($product->stock > 10): ?>
                                    <span class="bh-stock-indicator bh-stock-indicator--in">✓ В наличии</span>
                                <?php elseif ($product->stock > 0): ?>
                                    <span class="bh-stock-indicator bh-stock-indicator--low">⚠ Осталось <?=$product->stock?> шт.</span>
                                <?php else: ?>
                                    <span class="bh-stock-indicator bh-stock-indicator--out">✗ Нет в наличии</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- ===== PAGINATION ===== -->
            <div class="bh-pagination-wrapper">
                <?= LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                    'options' => ['class' => 'bh-pagination'],
                    'linkOptions' => ['class' => 'bh-pagination-link'],
                    'activePageCssClass' => 'bh-pagination-link--active',
                    'disabledPageCssClass' => 'bh-pagination-link--disabled',
                    'prevPageLabel' => '‹',
                    'nextPageLabel' => '›',
                    'firstPageLabel' => '«',
                    'lastPageLabel' => '»',
                ]) ?>
            </div>
        <?php else: ?>
            <div class="bh-empty-state">
                <div class="bh-empty-icon">🍞</div>
                <h3 class="bh-empty-title">Товары не найдены</h3>
                <p class="bh-empty-text">Попробуйте изменить фильтры или посмотреть другие категории.</p>
                <a href="<?= Url::to(['catalog/index']) ?>" class="bh-btn bh-btn--primary">
                    <span>🔄</span>
                    <span>Сбросить фильтры</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ===== CATEGORIES QUICK ACCESS ===== -->
<?php if (!empty($categories)): ?>
<section class="bh-categories-quick">
    <div class="container">
        <h2 class="bh-section-title">📂 Категории товаров</h2>
        <div class="bh-categories-grid">
            <?php foreach ($categories as $category): ?>
                <a href="<?= Url::to(['catalog/index', 'category' => $category->id]) ?>" 
                   class="bh-category-card <?= $currentCategory == $category->id ? 'bh-category-card--active' : '' ?>">
                    <div class="bh-category-icon">
                        🍞
                    </div>
                    <div class="bh-category-info">
                        <h3 class="bh-category-title"><?= Html::encode($category->title) ?></h3>
                        <p class="bh-category-count"><?= $category->getProducts()->count() ?> товаров</p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle image gallery thumbnails (if they exist)
    document.querySelectorAll('.thumbnail').forEach(function(thumbnail) {
        thumbnail.addEventListener('click', function() {
            const mainImg = this.closest('.product-images').querySelector('.product-main-img');
            const newImageSrc = this.dataset.image;
            
            // Update main image
            mainImg.src = newImageSrc;
            
            // Update active thumbnail
            this.closest('.image-thumbnails').querySelectorAll('.thumbnail').forEach(function(thumb) {
                thumb.classList.remove('active');
            });
            this.classList.add('active');
        });
    });
    
    // Add image counter badges (if they exist)
    document.querySelectorAll('.product-images').forEach(function(container) {
        const thumbnails = container.querySelectorAll('.thumbnail');
        if (thumbnails.length > 1) {
            const mainImg = container.querySelector('.main-image');
            const counter = document.createElement('div');
            counter.className = 'image-counter';
            counter.textContent = `1/${thumbnails.length}`;
            mainImg.appendChild(counter);
            
            // Update counter on thumbnail click
            container.querySelectorAll('.thumbnail').forEach(function(thumb, index) {
                thumb.addEventListener('click', function() {
                    counter.textContent = `${index + 1}/${thumbnails.length}`;
                });
            });
        }
    });
    
    // Handle quantity inputs
    document.querySelectorAll('.bh-quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const max = parseInt(this.max);
            const min = parseInt(this.min);
            const value = parseInt(this.value);
            
            if (value > max) this.value = max;
            if (value < min) this.value = min;
        });
    });
});
</script>
