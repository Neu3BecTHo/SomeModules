<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Создать услугу - Админ панель';
?>
<div class="admin-create-service">
    <h1>Создать услугу</h1>
    
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                
                <?= $form->field($service, 'name')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($service, 'description')->textarea(['rows' => 4]) ?>
                
                <?= $form->field($service, 'category_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                    ['prompt' => 'Выберите категорию']
                ) ?>
                
                <?= $form->field($service, 'duration')->textInput(['type' => 'number', 'placeholder' => 'В минутах']) ?>
                
                <?= $form->field($service, 'price')->textInput(['type' => 'number', 'step' => '0.01']) ?>
                
                <?= $form->field($service, 'imageFile')->fileInput()->label('Изображение услуги') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Создать', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Отмена', ['/beauty/admin/services'], ['class' => 'btn btn-secondary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
