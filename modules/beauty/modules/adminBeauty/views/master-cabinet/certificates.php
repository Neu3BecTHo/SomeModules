<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Сертификаты - Личный кабинет';
?>
<div class="master-certificates">
    <h1>Мои сертификаты</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Загрузить новый сертификат</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <div class="row">
                    <div class="col-md-3">
                        <?= $form->field(new \app\modules\beauty\models\Certificate(), 'title')->textInput(['name' => 'cert_title'])->label('Название') ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Дата выдачи', 'cert_issued') ?>
                        <?= Html::input('date', 'cert_issued', date('Y-m-d'), ['class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Срок действия', 'cert_expiry') ?>
                        <?= Html::input('date', 'cert_expiry', '', ['class' => 'form-control']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Файл', 'certificates') ?>
                        <?= Html::fileInput('certificates[]', '', ['class' => 'form-control', 'multiple' => false]) ?>
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
            <h5>Мои сертификаты</h5>
        </div>
        <div class="card-body">
            <?php if (empty($certificates)): ?>
                <p class="text-muted">Нет загруженных сертификатов</p>
            <?php else: ?>
                <div class="row">
                    <?php foreach ($certificates as $cert): ?>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img src="<?= $cert->image ?>" class="card-img-top" alt="<?= Html::encode($cert->title) ?>" style="max-height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title"><?= Html::encode($cert->title) ?></h6>
                                    <?php if ($cert->expiry_date): ?>
                                        <p class="card-text small">Срок: <?= $cert->expiry_date ?></p>
                                    <?php endif; ?>
                                    <?= Html::a('Удалить', ['/beauty/admin/master-cabinet/certificates/delete', 'id' => $cert->id], [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' => 'Удалить сертификат?',
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
