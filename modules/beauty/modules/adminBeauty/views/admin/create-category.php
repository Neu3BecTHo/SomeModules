<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Новая категория';
?>

<div class="admin-container">
    <h1 class="mb-4">Новая категория</h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($category, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Например: Маникюр']) ?>

                <?= $form->field($category, 'description')->textarea(['rows' => 4, 'placeholder' => 'Описание категории (необязательно)']) ?>

                <div class="form-group mt-4">
                    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Отмена', ['categories'], ['class' => 'btn btn-outline']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
