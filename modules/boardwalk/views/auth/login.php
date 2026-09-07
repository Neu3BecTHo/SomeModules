<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Авторизация';
?>

<div class="site-login container section">
    <div class="form card">
        <h1><?= Html::encode($this->title) ?></h1>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
                'mask' => '8(999)999-99-99',
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Введите пароль']) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'style' => 'width:100%']) ?>
            </div>

            <div class="auth-links" style="margin-top: 20px; text-align: center;">
                <p>Еще не зарегистрированы? <?= Html::a('Регистрация', ['auth/register'], ['class' => 'link-more']) ?></p>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
