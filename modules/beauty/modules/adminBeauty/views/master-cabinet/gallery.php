<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Галерея работ - Личный кабинет';
?>
<div class="master-gallery">
    <h1>Моя галерея</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Загрузить новое фото</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::label('Фото работы', 'photos') ?>
                        <?= Html::fileInput('photos[]', '', ['class' => 'form-control', 'multiple' => true, 'accept' => 'image/*']) ?>
                        <small class="text-muted">Можно выбрать несколько фото</small>
                    </div>
                    <div class="col-md-6">
                        <?= Html::label('Описание', 'photo_desc') ?>
                        <?= Html::textInput('photo_desc', '', ['class' => 'form-control', 'placeholder' => 'Описание работы']) ?>
                    </div>
                </div>
                <div class="form-group mt-3">
                    <?= Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Мои работы</h5>
        </div>
        <div class="card-body">
            <?php if (empty($photos)): ?>
                <p class="text-muted">Нет загруженных фото</p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($photos as $photo): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="<?= $photo->image ?>" class="card-img-top" alt="<?= Html::encode($photo->description) ?>" style="max-height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <?php if ($photo->description): ?>
                                        <p class="card-text small"><?= Html::encode($photo->description) ?></p>
                                    <?php endif; ?>
                                    <?= Html::a('Удалить', ['/beauty/admin/master-cabinet/gallery/delete', 'id' => $photo->id], [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' => 'Удалить фото?',
                                    ]) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
