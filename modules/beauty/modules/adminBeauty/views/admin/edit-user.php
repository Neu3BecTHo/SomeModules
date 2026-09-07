<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap5\ActiveForm;

$this->title = 'Редактирование пользователя';
?>

<div class="admin-container">
    <h1 class="mb-4">Редактирование пользователя</h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($user, 'full_name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($user, 'phone')->textInput(['maxlength' => true]) ?>

                <?= $form->field($user, 'role')->dropDownList([
                    'client' => 'Клиент',
                    'master' => 'Мастер',
                    'admin' => 'Администратор',
                ]) ?>

                <div class="form-group mt-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Отмена', ['users'], ['class' => 'btn btn-outline']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
