<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Редактирование категории';
?>

<div class="admin-container">
    <h1 class="mb-4">Редактирование категории</h1>

    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($category, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($category, 'description')->textarea(['rows' => 4]) ?>

                <div class="form-group mt-4">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Отмена', ['categories'], ['class' => 'btn btn-outline']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
