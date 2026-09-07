<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Мои услуги - Личный кабинет';
?>
<div class="master-services">
    <h1>Мои услуги</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <h5>Добавить услугу</h5>
        </div>
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <?= Html::label('Услуга', 'service_id') ?>
                        <?= Html::dropDownList('service_id', '', 
                            \yii\helpers\ArrayHelper::map($availableServices, 'id', function($s) { 
                                return $s->name . ' (' . $s->duration . ' мин)'; 
                            }), 
                            ['class' => 'form-control', 'prompt' => 'Выберите услугу']
                        ) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('Моя цена', 'custom_price') ?>
                        <?= Html::input('number', 'custom_price', '', ['class' => 'form-control', 'placeholder' => 'Стандартная']) ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::label('&nbsp;') ?>
                        <div>
                            <?= Html::submitButton('Добавить', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Мои текущие услуги</h5>
        </div>
        <div class="card-body">
            <?php if (empty($masterServices)): ?>
                <p class="text-muted">Нет добавленных услуг</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Услуга</th>
                            <th>Категория</th>
                            <th>Длительность</th>
                            <th>Моя цена</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($masterServices as $ms): ?>
                            <tr>
                                <td><?= Html::encode($ms->service->name) ?></td>
                                <td><?= Html::encode($ms->service->category->name ?? '-') ?></td>
                                <td><?= $ms->service->duration ?> мин</td>
                                <td><?= $ms->custom_price ? number_format($ms->custom_price, 2) . ' ₽' : 'Стандартная (' . number_format($ms->service->price, 2) . ' ₽)' ?></td>
                                <td>
                                    <?= Html::a('Удалить', '/beauty/admin/master-cabinet/services/delete/' . $ms->id, [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-confirm' => 'Удалить услугу?',
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
