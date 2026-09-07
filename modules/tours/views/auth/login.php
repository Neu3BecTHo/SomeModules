<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\LoginForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Вход';
?>

<h1>Вход</h1>

<div class="tour-auth">
    <?php $form = ActiveForm::begin([
        'id' => 'tours-login-form',
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary']) ?>
    </div>

    <p class="tour-auth__switch">
        Еще не зарегистрированы?
        <a href="<?= Url::to(['register']) ?>">Регистрация</a>
    </p>

    <?php ActiveForm::end(); ?>
</div>
