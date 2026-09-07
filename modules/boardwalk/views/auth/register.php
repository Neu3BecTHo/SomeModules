<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/** @var yii\web\View $this */
/** @var app\modules\boardwalk\models\RegisterForm $model */

$this->title = 'Регистрация';
?>
<div class="site-signup container section">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="form card">
        <?php $form = ActiveForm::begin(['id' => 'form-register']); ?>

            <?= $form->field($model, 'first_name')->textInput(['autofocus' => true, 'placeholder' => 'Иван']) ?>

            <?= $form->field($model, 'last_name')->textInput(['autofocus' => true, 'placeholder' => 'Иванов']) ?>

            <?= $form->field($model, 'patronymic')->textInput(['autofocus' => true, 'placeholder' => 'Иванович']) ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '8(999)999-99-99',
            ]) ?>
            <?= $form->field($model, 'email')->input('email', ['placeholder' => 'example@mail.ru']) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'password_repeat')->passwordInput() ?>

            <?= $form->field($model, 'agree')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Создать пользователя', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <div class="auth-links" style="margin-top: 20px; text-align: center;">
                <p>Уже есть аккаунт? <?= Html::a('Войти', ['auth/login'], ['class' => 'link-more']) ?></p>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
