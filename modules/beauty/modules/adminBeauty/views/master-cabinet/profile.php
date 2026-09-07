<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Профиль мастера - Личный кабинет';
?>
<div class="master-profile">
    <h1>Профиль мастера</h1>
    
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                
                <?= $form->field($master, 'specialization')->textInput(['maxlength' => true]) ?>
                
                <?= $form->field($master, 'bio')->textarea(['rows' => 4]) ?>
                
                <?php if ($master->photo): ?>
                    <div class="mb-3">
                        <label>Текущее фото</label>
                        <div>
                            <?= Html::img($master->photo, ['class' => 'img-thumbnail', 'style' => 'max-height: 200px;']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?= $form->field($master, 'photoFile')->fileInput()->label('Фото профиля') ?>
                
                <?= $form->field($master, 'certificate_expiry')->input('date') ?>
                
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
