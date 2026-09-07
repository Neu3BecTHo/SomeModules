<?php
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
?>
<div class="c-container" style="max-width: 500px; padding-top: 40px;">
    <h1 style="margin-bottom: 24px; text-align: center;"><?= Html::encode($this->title) ?></h1>

    <div class="comm-card" style="background: var(--c-surface); padding: 24px; border-radius: var(--c-radius); border: 1px solid var(--c-border);">
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['style' => 'color: var(--c-text-muted); font-size: 13px; margin-bottom: 4px;'],
                'inputOptions' => ['class' => 'form-control', 'style' => 'background: var(--c-bg); border: 1px solid var(--c-border); color: var(--c-text);'],
            ],
        ]); ?>

        <?= $form->field($model, 'firstName')->textInput(['placeholder' => 'Имя']) ?>

        <?= $form->field($model, 'lastName')->textInput(['placeholder' => 'Фамилия']) ?>

        <?= $form->field($model, 'patronymic')->textInput(['placeholder' => 'Отчество']) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '8(999)999-99-99']) ?>

        <?= $form->field($model, 'email')->textInput(['type' => 'email']) ?>

        <?= $form->field($model, 'address')->textInput() ?>

        <?= $form->field($model, 'residents_count')->textInput(['type' => 'number', 'min' => 1]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <?= $form->field($model, 'agree')->checkbox([
             'label' => 'Согласен с правилами регистрации',
             'style' => 'accent-color: var(--c-accent);'
        ]) ?>

        <div class="form-group" style="margin-top: 24px;">
            <?= Html::submitButton('Создать пользователя', ['class' => 'c-btn c-btn-primary', 'style' => 'width: 100%; padding: 10px;']) ?>
        </div>

        <?php ActiveForm::end(); ?>
        
        <div style="margin-top: 16px; text-align: center; font-size: 14px;">
            <a href="<?= \yii\helpers\Url::to(['login']) ?>" style="color: var(--c-accent);">Уже есть аккаунт? Войти</a>
        </div>
    </div>
</div>
