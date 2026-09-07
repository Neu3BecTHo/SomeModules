<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\communal\models\ProfileForm */

$this->title = 'Мой профиль';
?>

<div class="comm-container profile-page">
    
    <div class="profile-header">
        <h1><?= Html::encode($this->title) ?></h1>
        <p class="profile-subtitle">Управление личными данными и безопасностью</p>
    </div>

    <div class="profile-content">
        <?php $form = ActiveForm::begin([
            'id' => 'profile-form',
            'fieldConfig' => [
                'template' => "<div class=\"profile-field\"><div class=\"profile-label\">{label}</div><div class=\"profile-input\">{input}</div></div>\n<div class=\"profile-error\">{error}</div>",
                'options' => ['class' => 'profile-form-group'], // Общий контейнер для поля
            ],
        ]); ?>

        <!-- Секция: Личные данные -->
        <div class="profile-section">
            <h3 class="section-title">Личная информация</h3>
            
            <div class="profile-grid">
                <?= $form->field($model, 'lastName')->textInput(['class' => 'comm-input', 'placeholder' => 'Иванов']) ?>
                <?= $form->field($model, 'firstName')->textInput(['class' => 'comm-input', 'placeholder' => 'Иван']) ?>
                <?= $form->field($model, 'patronymic')->textInput(['class' => 'comm-input', 'placeholder' => 'Иванович']) ?>
                <?= $form->field($model, 'phone')->textInput(['class' => 'comm-input', 'placeholder' => '+7...']) ?>
                <?= $form->field($model, 'email')->textInput(['class' => 'comm-input', 'type' => 'email']) ?>
                
                <!-- Адрес на всю ширину -->
                <div class="full-width">
                    <?= $form->field($model, 'address')->textInput(['class' => 'comm-input']) ?>
                </div>
                
                <?= $form->field($model, 'residents_count')->textInput(['class' => 'comm-input', 'type' => 'number']) ?>
            </div>
        </div>

        <!-- Секция: Безопасность -->
        <div class="profile-section">
            <h3 class="section-title">Смена пароля</h3>
            <div class="password-hint">Заполните эти поля только если хотите изменить текущий пароль</div>
            
            <div class="profile-grid">
                <?= $form->field($model, 'newPassword')->passwordInput(['class' => 'comm-input', 'placeholder' => 'Новый пароль']) ?>
                <?= $form->field($model, 'newPasswordRepeat')->passwordInput(['class' => 'comm-input', 'placeholder' => 'Повторите пароль']) ?>
            </div>
        </div>

        <!-- Кнопки -->
        <div class="profile-actions">
            <?= Html::submitButton('Сохранить изменения', ['class' => 'comm-btn comm-btn-primary profile-save-btn']) ?>
            
            <?= Html::a('Выйти из аккаунта', ['auth/logout'], [
                'class' => 'profile-logout-link',
                'data' => ['method' => 'post'],
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
