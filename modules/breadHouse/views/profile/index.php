<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $user app\modules\breadHouse\models\User */
/* @var $reviews app\modules\breadHouse\models\Reviews[] */

$this->title = 'Мой профиль — Хлебный дворик';
?>

<!-- ===== PROFILE PAGE ===== -->
<section class="bh-profile">
    <div class="container">
        <div class="bh-profile-header">
            <h1 class="bh-profile-title">👤 Мой профиль</h1>
            <p class="bh-profile-subtitle">Управление вашими данными и отзывами</p>
        </div>

        <div class="bh-profile-content">
            <div class="bh-profile-form-section">
                <div class="bh-card">
                    <div class="bh-card__header">
                        <h2 class="bh-card__title">📝 Редактировать данные</h2>
                    </div>
                    <div class="bh-card__body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'profile-form',
                            'enableClientValidation' => true,
                            'options' => ['class' => 'bh-form'],
                        ]); ?>

                        <div class="bh-form-row">
                            <div class="bh-form-group">
                                <?= $form->field($user, 'last_name')->textInput([
                                    'class' => 'bh-form-input',
                                    'placeholder' => 'Фамилия',
                                ])->label('👤 Фамилия', ['class' => 'bh-form-label']) ?>
                            </div>
                            <div class="bh-form-group">
                                <?= $form->field($user, 'first_name')->textInput([
                                    'class' => 'bh-form-input',
                                    'placeholder' => 'Имя',
                                ])->label('👤 Имя', ['class' => 'bh-form-label']) ?>
                            </div>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($user, 'patronymic')->textInput([
                                'class' => 'bh-form-input',
                                'placeholder' => 'Отчество',
                            ])->label('👤 Отчество', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($user, 'phone')->textInput([
                                'class' => 'bh-form-input',
                                'placeholder' => '+7(___)-___-__-__',
                                'readonly' => true,
                            ])->label('📱 Телефон', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($user, 'email')->input('email', [
                                'class' => 'bh-form-input',
                                'placeholder' => 'example@mail.com',
                            ])->label('📧 Email', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-actions">
                            <?= Html::submitButton('💾 Сохранить изменения', [
                                'class' => 'bh-btn bh-btn--primary bh-btn--large bh-btn--full-width',
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <div class="bh-profile-reviews-section">
                <div class="bh-card">
                    <div class="bh-card__header">
                        <h2 class="bh-card__title">⭐ Мои отзывы</h2>
                    </div>
                    <div class="bh-card__body">
                        <?php if ($reviews): ?>
                            <div class="bh-reviews-list">
                                <?php foreach ($reviews as $review): ?>
                                    <div class="bh-review-card">
                                        <div class="bh-review-header">
                                            <div class="bh-review-product">
                                                <span class="bh-review-product-name"><?= Html::encode($review->product->name) ?></span>
                                            </div>
                                            <div class="bh-review-meta">
                                                <div class="bh-review-rating">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <span class="bh-review-star <?= $i <= $review->rating ? 'bh-review-star--filled' : '' ?>">★</span>
                                                    <?php endfor; ?>
                                                    <span class="bh-review-rating-text"><?= $review->rating ?>/5</span>
                                                </div>
                                                <div class="bh-review-date">
                                                    <?= Yii::$app->formatter->asDate($review->created_at) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bh-review-content">
                                            <div class="bh-review-comment">
                                                <?= Html::encode($review->comment) ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="bh-empty-reviews">
                                <div class="bh-empty-icon">💬</div>
                                <h3 class="bh-empty-title">Вы еще не оставляли отзывы</h3>
                                <p class="bh-empty-description">Поделитесь впечатлениями о нашей продукции!</p>
                                <?= Html::a('🛍️ Перейти в каталог', ['catalog/index'], [
                                    'class' => 'bh-btn bh-btn--primary bh-btn--large'
                                ]) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
