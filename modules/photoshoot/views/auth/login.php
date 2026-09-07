<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\photoshoot\assets\PhotoshootAuthAsset;

PhotoshootAuthAsset::register($this);

$this->title = 'Вход';
?>
<div class="auth-container">
    <div class="auth-card">
        <h1 class="auth-title"><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'auth-form'],
        ]); ?>

        <?= $form->field($model, 'login')->textInput(['autofocus' => true, 'placeholder' => 'Введите логин']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn auth-btn', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-links">
            <p>Еще не зарегистрированы? <?= Html::a('Регистрация', ['/photoshoot/auth/register']) ?></p>
        </div>
    </div>
</div>
