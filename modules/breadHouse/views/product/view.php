<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $product app\modules\breadHouse\models\Product */
/* @var $reviews app\modules\breadHouse\models\Reviews[] */
/* @var $reviewModel app\modules\breadHouse\models\Reviews */
/* @var $orders app\modules\breadHouse\models\Orders[] */
/* @var $pagination \yii\data\Pagination */
/* @var $userCanReview bool */
/* @var $userOrderId int */

$this->title = $product->name . ' — Хлебный дворик';
?>

<!-- ===== MAIN PRODUCT SECTION ===== -->
<section class="bh-product-detail">
    <div class="container">
        <!-- Flash Messages -->
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="bh-alert bh-alert--success">
                <span class="bh-alert-icon">✓</span>
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="bh-alert bh-alert--danger">
                <span class="bh-alert-icon">✗</span>
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <div class="bh-product-layout">
            <!-- Product Gallery -->
            <div class="bh-product-gallery">
                <?php
                $allImages = $product->getAllImages();
                if (!empty($allImages)):
                ?>
                    <div class="bh-gallery-main">
                        <img src="<?= $allImages[0] ?>" alt="<?= $product->name ?>" id="mainImage" class="bh-gallery-image">
                        <?php if (count($allImages) > 1): ?>
                            <div class="bh-gallery-nav">
                                <button class="bh-gallery-btn bh-gallery-btn--prev" onclick="changeImage(-1)" aria-label="Предыдущее фото">‹</button>
                                <button class="bh-gallery-btn bh-gallery-btn--next" onclick="changeImage(1)" aria-label="Следующее фото">›</button>
                            </div>
                            <div class="bh-gallery-counter">
                                <span class="bh-gallery-current">1</span> / <span class="bh-gallery-total"><?= count($allImages) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if (count($allImages) > 1): ?>
                        <div class="bh-gallery-thumbnails">
                            <?php foreach ($allImages as $index => $image): ?>
                                <button class="bh-gallery-thumbnail <?= $index === 0 ? 'bh-gallery-thumbnail--active' : '' ?>"
                                        onclick="setMainImage('<?= $image ?>', <?= $index ?>)">
                                    <img src="<?= $image ?>" alt="<?= $product->name ?> - фото <?= $index + 1 ?>" class="bh-thumbnail-img">
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="bh-gallery-main">
                        <img src="/images/no-image.png" alt="<?= $product->name ?>" class="bh-gallery-image">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Information -->
            <div class="bh-product-info">
                <div class="bh-product-header">
                    <h1 class="bh-product-title"><?= Html::encode($product->name) ?></h1>
                    <div class="bh-product-rating">
                        <div class="bh-rating-stars">
                            <?php
                            $ratingRounded = round($product->rating);
                            for ($i = 1; $i <= 5; $i++): ?>
                                <span class="bh-star <?= $i <= $ratingRounded ? 'bh-star--filled' : '' ?>">★</span>
                            <?php endfor; ?>
                        </div>
                        <span class="bh-rating-value">(<?= number_format($product->rating, 1) ?>/5)</span>
                    </div>
                </div>

                <div class="bh-product-price-section">
                    <div class="bh-current-price">
                        <span class="bh-price-amount"><?= $product->price ?></span>
                        <span class="bh-price-currency">₽</span>
                        <span class="bh-price-unit">за шт.</span>
                    </div>
                    <div class="bh-stock-status">
                        <?php if ($product->stock > 10): ?>
                            <span class="bh-stock-indicator bh-stock-indicator--in">✓ В наличии</span>
                        <?php elseif ($product->stock > 0): ?>
                            <span class="bh-stock-indicator bh-stock-indicator--low">⚠ Осталось <?= $product->stock ?> шт.</span>
                        <?php else: ?>
                            <span class="bh-stock-indicator bh-stock-indicator--out">✗ Нет в наличии</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bh-product-description">
                    <h3>Описание</h3>
                    <p><?= Html::encode($product->description) ?></p>
                </div>

                <div class="bh-product-details">
                    <?php if ($product->composition): ?>
                        <div class="bh-detail-item">
                            <h4>Состав</h4>
                            <p><?= Html::encode($product->composition) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($product->allergens): ?>
                        <div class="bh-detail-item">
                            <h4>Аллергены</h4>
                            <p><?= Html::encode($product->allergens) ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if ($product->nutrition): ?>
                        <div class="bh-detail-item">
                            <h4>Пищевая ценность</h4>
                            <p><?= Html::encode($product->nutrition) ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Add to Cart Form -->
                <div class="bh-add-to-cart">
                    <form action="<?= Url::to(['cart/add']) ?>" method="post" class="bh-cart-form">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <input type="hidden" name="product_id" value="<?= $product->id ?>">

                        <div class="bh-form-group">
                            <label for="quantity" class="bh-form-label">Количество</label>
                            <div class="bh-quantity-selector">
                                <button type="button" class="bh-quantity-btn bh-quantity-btn--minus" onclick="changeQuantity(this, -1)">−</button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product->stock ?>" class="bh-quantity-input">
                                <button type="button" class="bh-quantity-btn bh-quantity-btn--plus" onclick="changeQuantity(this, 1)">+</button>
                            </div>
                        </div>

                        <div class="bh-form-group">
                            <label for="delivery_type" class="bh-form-label">Тип доставки</label>
                            <select id="delivery_type" name="delivery_type" class="bh-form-select">
                                <option value="pickup">Самовывоз</option>
                                <option value="courier">Курьерская доставка</option>
                            </select>
                        </div>

                        <div class="bh-form-row">
                            <div class="bh-form-group">
                                <label for="delivery_date" class="bh-form-label">Дата доставки</label>
                                <input type="date" id="delivery_date" name="delivery_date" class="bh-form-input" min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="bh-form-group">
                                <label for="delivery_time" class="bh-form-label">Время доставки</label>
                                <input type="time" id="delivery_time" name="delivery_time" class="bh-form-input">
                            </div>
                        </div>

                        <button type="submit" class="bh-btn bh-btn--primary bh-btn--large bh-btn--full-width" <?= $product->stock <= 0 ? 'disabled' : '' ?>>
                            <span class="bh-btn-icon">🛒</span>
                            <span class="bh-btn-text">
                                <?php if ($product->stock <= 0): ?>
                                    Нет в наличии
                                <?php else: ?>
                                    Добавить в корзину
                                <?php endif; ?>
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== REVIEWS SECTION ===== -->
<section class="bh-reviews">
    <div class="container">
        <div class="bh-reviews-header">
            <h2 class="bh-reviews-title">Отзывы клиентов</h2>
            <div class="bh-reviews-stats">
                <span class="bh-reviews-count"><?= count($reviews) ?> отзывов</span>
                <span class="bh-average-rating">Средний рейтинг: <?= $product->rating ?>/5</span>
            </div>
        </div>

        <div class="bh-reviews-list">
            <?php if ($reviews): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="bh-review-card">
                        <div class="bh-review-header">
                            <div class="bh-review-author">
                                <div class="bh-author-avatar">
                                    <?= mb_substr(Html::encode($review->user->first_name ?? 'Г'), 0, 1) ?>
                                </div>
                                <div class="bh-author-info">
                                    <div class="bh-author-name"><?= Html::encode($review->user->fullName()) ?></div>
                                    <div class="bh-review-date"><?= date('d.m.Y', strtotime($review->created_at)) ?></div>
                                </div>
                            </div>
                            <div class="bh-review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="bh-star <?= $i <= $review->rating ? 'bh-star--filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="bh-review-content">
                            <p class="bh-review-text"><?= Html::encode($review->comment) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="bh-empty-reviews">
                    <div class="bh-empty-icon">💬</div>
                    <h3>Отзывов пока нет</h3>
                    <p>Будьте первым, кто оставит отзыв об этом товаре!</p>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($userCanReview): ?>
            <div class="bh-add-review">
                <h3 class="bh-add-review-title">Оставить отзыв</h3>
                <div class="bh-review-notice">
                    <p>Вы можете оставить отзыв на этот товар, так как уже заказывали его и заказ был выполнен.</p>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => ['/breadHouse/product/review', 'id' => $product->id],
                    'method' => 'post',
                    'options' => ['class' => 'bh-review-form'],
                ]); ?>

                    <div class="bh-form-group">
                        <label for="review_rating" class="bh-form-label">Ваша оценка</label>
                        <div class="bh-rating-input">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" id="star<?= $i ?>" name="Reviews[rating]" value="<?= $i ?>" <?= $i == 5 ? 'checked' : '' ?>>
                                <label for="star<?= $i ?>" title="<?= $i ?> звезд">★</label>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <div class="bh-form-group">
                        <?= $form->field($reviewModel, 'comment')->textarea([
                            'rows' => 4,
                            'placeholder' => 'Расскажите о вашем опыте использования этого товара...',
                            'class' => 'bh-form-textarea',
                        ])->label('Ваш отзыв') ?>
                    </div>

                    <button type="submit" class="bh-btn bh-btn--primary">
                        <span class="bh-btn-text">Отправить отзыв</span>
                        <span class="bh-btn-icon">📝</span>
                    </button>

                <?php ActiveForm::end(); ?>
            </div>
        <?php elseif (!Yii::$app->userBreadHouse->isGuest): ?>
            <div class="bh-review-notice">
                <p>Чтобы оставить отзыв на этот товар, сначала закажите его.</p>
                <form action="<?= Url::to(['cart/add']) ?>" method="post" style="display: inline;">
                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bh-btn bh-btn--primary">Добавить в корзину</button>
                </form>
            </div>
        <?php else: ?>
            <div class="bh-login-prompt">
                <p>Чтобы оставить отзыв, <a href="<?= Url::to(['auth/login']) ?>" class="bh-link">войдите в аккаунт</a></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
let currentImageIndex = 0;
const allImages = <?= json_encode($allImages ?: []) ?>;

function changeImage(direction) {
    if (allImages.length <= 1) return;

    currentImageIndex += direction;
    if (currentImageIndex < 0) currentImageIndex = allImages.length - 1;
    if (currentImageIndex >= allImages.length) currentImageIndex = 0;

    setMainImage(allImages[currentImageIndex], currentImageIndex);
}

function setMainImage(imageSrc, index) {
    document.getElementById('mainImage').src = imageSrc;
    currentImageIndex = index;

    // Update counter
    document.querySelector('.bh-gallery-current').textContent = index + 1;

    // Update active thumbnail
    document.querySelectorAll('.bh-gallery-thumbnail').forEach((btn, i) => {
        btn.classList.toggle('bh-gallery-thumbnail--active', i === index);
    });
}

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

// Star rating input handling
document.addEventListener('DOMContentLoaded', function() {
    const ratingInputs = document.querySelectorAll('.bh-rating-input input');
    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            const rating = this.value;
            const labels = this.closest('.bh-rating-input').querySelectorAll('label');
            labels.forEach((label, index) => {
                label.classList.toggle('bh-rating-label--active', index < rating);
            });
        });
    });

    // Initialize rating display
    const checkedInput = document.querySelector('.bh-rating-input input:checked');
    if (checkedInput) {
        checkedInput.dispatchEvent(new Event('change'));
    }
});
</script>
