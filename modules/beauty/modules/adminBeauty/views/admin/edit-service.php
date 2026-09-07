<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Редактировать услугу - Админ панель';
?>
<div class="admin-edit-service">
    <h1>Редактировать услугу</h1>
    
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
                
                <?= $form->field($service, 'is_active')->checkbox() ?>
                
                <?php if ($service->image): ?>
                    <div class="mb-3">
                        <label>Текущее изображение</label>
                        <div>
                            <?= Html::img($service->image, ['class' => 'img-thumbnail', 'style' => 'max-height: 200px;']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?= $form->field($service, 'imageFile')->fileInput()->label('Новое изображение') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Отмена', ['/beauty/admin/services'], ['class' => 'btn btn-secondary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
