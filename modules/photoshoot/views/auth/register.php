<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\widgets\MaskedInput;
use app\modules\photoshoot\assets\PhotoshootAuthAsset;

PhotoshootAuthAsset::register($this);

$this->title = 'Регистрация';
?>
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'auth-form'],
        ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Минимум 9 символов, латиница и цифры']) ?>

        <?= $form->field($model, 'full_name')->textInput(['placeholder' => 'Фамилия Имя Отчество']) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '+7(999)999-99-99',
            'options' => ['placeholder' => '+7(XXX)XXX-XX-XX']
        ]) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'email@example.com']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Минимум 8 символов']) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Повторите пароль']) ?>

        <?= $form->field($model, 'agree')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Создать пользователя', ['class' => 'btn auth-btn', 'name' => 'register-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-links">
            <p>Уже есть аккаунт? <?= Html::a('Войти', ['/photoshoot/auth/login']) ?></p>
        </div>
    </div>
</div>
