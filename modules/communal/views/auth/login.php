<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Вход в систему';
?>
<div class="c-container" style="max-width: 400px; padding-top: 40px;">
    <h1 style="margin-bottom: 24px; text-align: center;"><?= Html::encode($this->title) ?></h1>

    <div class="comm-card" style="background: var(--c-surface); padding: 24px; border-radius: var(--c-radius); border: 1px solid var(--c-border);">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['style' => 'color: var(--c-text-muted); font-size: 13px; margin-bottom: 4px;'],
                'inputOptions' => ['class' => 'form-control', 'style' => 'background: var(--c-bg); border: 1px solid var(--c-border); color: var(--c-text);'],
            ],
        ]); ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '8(999)999-99-99']) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'style' => 'accent-color: var(--c-accent);'
        ]) ?>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Войти', ['class' => 'c-btn c-btn-primary', 'style' => 'width: 100%; padding: 10px;']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
        <div style="margin-top: 16px; text-align: center; font-size: 14px;">
            <a href="<?= \yii\helpers\Url::to(['register']) ?>" style="color: var(--c-accent);">Еще не зарегистрированы? Регистрация</a>
        </div>
    </div>
</div>
