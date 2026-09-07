<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Вход — Хлебный дворик';
?>

<!-- ===== AUTH PAGE ===== -->
<section class="bh-auth">
    <div class="container">
        <div class="bh-auth-wrapper">
            <div class="bh-auth-card">
                <div class="bh-auth-header">
                    <div class="bh-auth-logo">
                        <div class="bh-auth-logo-circle">🍞</div>
                        <div class="bh-auth-logo-text">
                            <h1 class="bh-auth-logo-title">Хлебный дворик</h1>
                            <p class="bh-auth-logo-subtitle">Свежий хлеб каждый день</p>
                        </div>
                    </div>
                </div>

                <div class="bh-auth-content">
                    <h2 class="bh-auth-title">Вход в личный кабинет</h2>
                    <p class="bh-auth-subtitle">
                        Введите телефон и пароль для доступа к вашему аккаунту
                    </p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'login-form',
                        'enableClientValidation' => true,
                        'options' => ['class' => 'bh-auth-form'],
                    ]); ?>

                        <div class="bh-form-group">
                            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                                'mask' => '+7(999)999-99-99',
                                'options' => [
                                    'class' => 'bh-form-input bh-form-input--phone',
                                    'placeholder' => '+7(___)-___-__-__',
                                ]
                            ])->label('📱 Телефон', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($model, 'password')->passwordInput([
                                'class' => 'bh-form-input bh-form-input--password',
                                'placeholder' => 'Введите ваш пароль',
                            ])->label('🔒 Пароль', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'class' => 'bh-form-checkbox',
                            ])->label('Запомнить меня', ['class' => 'bh-form-checkbox-label']) ?>
                        </div>

                        <div class="bh-form-actions">
                            <?= Html::submitButton('🔓 Войти', [
                                'class' => 'bh-btn bh-btn--primary bh-btn--large bh-btn--full-width',
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                </div>

                <div class="bh-auth-footer">
                    <p class="bh-auth-footer-text">
                        Еще не зарегистрированы?
                    </p>
                    <?= Html::a('📝 Создать аккаунт', ['auth/register'], [
                        'class' => 'bh-btn bh-btn--secondary bh-btn--full-width',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>