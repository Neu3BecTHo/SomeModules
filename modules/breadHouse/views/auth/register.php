<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация — Хлебный дворик';
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
                    <h2 class="bh-auth-title">Создать аккаунт</h2>
                    <p class="bh-auth-subtitle">
                        Регистрация открывает доступ к заказам и персональным предложениям
                    </p>

                    <?php $form = ActiveForm::begin([
                        'id' => 'form-register',
                        'enableClientValidation' => true,
                        'options' => ['class' => 'bh-auth-form'],
                    ]); ?>

                        <div class="bh-form-row">
                            <div class="bh-form-group">
                                <?= $form->field($model, 'last_name')->textInput([
                                    'maxlength' => true,
                                    'class' => 'bh-form-input',
                                    'placeholder' => 'Фамилия',
                                ])->label('👤 Фамилия', ['class' => 'bh-form-label']) ?>
                            </div>
                            <div class="bh-form-group">
                                <?= $form->field($model, 'first_name')->textInput([
                                    'maxlength' => true,
                                    'class' => 'bh-form-input',
                                    'placeholder' => 'Имя',
                                ])->label('👤 Имя', ['class' => 'bh-form-label']) ?>
                            </div>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($model, 'patronymic')->textInput([
                                'maxlength' => true,
                                'class' => 'bh-form-input',
                                'placeholder' => 'Отчество',
                            ])->label('👤 Отчество', ['class' => 'bh-form-label']) ?>
                        </div>

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
                            <?= $form->field($model, 'email')->input('email', [
                                'class' => 'bh-form-input',
                                'placeholder' => 'example@mail.com',
                            ])->label('📧 Email', ['class' => 'bh-form-label']) ?>
                        </div>

                        <div class="bh-form-row">
                            <div class="bh-form-group">
                                <?= $form->field($model, 'password')->passwordInput([
                                    'class' => 'bh-form-input bh-form-input--password',
                                    'placeholder' => 'Минимум 6 символов',
                                ])->label('🔒 Пароль', ['class' => 'bh-form-label']) ?>
                            </div>
                            <div class="bh-form-group">
                                <?= $form->field($model, 'password_repeat')->passwordInput([
                                    'class' => 'bh-form-input bh-form-input--password',
                                    'placeholder' => 'Подтвердите пароль',
                                ])->label('🔒 Пароль еще раз', ['class' => 'bh-form-label']) ?>
                            </div>
                        </div>

                        <div class="bh-form-group">
                            <?= $form->field($model, 'agree')->checkbox([
                                'class' => 'bh-form-checkbox',
                            ])->label('Я согласен с <a href="#" class="bh-link">условиями использования</a> и <a href="#" class="bh-link">политикой конфиденциальности</a>', ['class' => 'bh-form-checkbox-label']) ?>
                        </div>

                        <div class="bh-form-actions">
                            <?= Html::submitButton('📝 Создать аккаунт', [
                                'class' => 'bh-btn bh-btn--primary bh-btn--large bh-btn--full-width',
                            ]) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                </div>

                <div class="bh-auth-footer">
                    <p class="bh-auth-footer-text">
                        Уже есть аккаунт?
                    </p>
                    <?= Html::a('🔓 Войти в систему', ['auth/login'], [
                        'class' => 'bh-btn bh-btn--secondary bh-btn--full-width',
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</section>