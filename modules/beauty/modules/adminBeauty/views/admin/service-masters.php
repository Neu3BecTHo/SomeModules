<?php
use yii\helpers\Html;

$this->title = 'Мастера услуги - Админ панель';
?>
<div class="admin-service-masters">
    <h1>Мастера для услуги: <?= Html::encode($service->name) ?></h1>
    
    <div class="card">
        <div class="card-body">
            <?= Html::beginForm('/beauty/admin/services/masters/' . $service->id, 'post') ?>
                <?= Html::hiddenInput('id', $service->id) ?>
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                <?= Html::checkbox('select_all', false, ['id' => 'select-all']) ?>
                            </th>
                            <th>Мастер</th>
                            <th>Специализация</th>
                            <th>Индивидуальная цена</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($masters as $master): ?>
                        <tr>
                            <td>
                                <?= Html::checkbox('masters[]', isset($serviceMasters[$master->id]), [
                                    'value' => $master->id,
                                    'class' => 'master-checkbox'
                                ]) ?>
                            </td>
                            <td><?= Html::encode($master->user->full_name) ?></td>
                            <td><?= Html::encode($master->specialization) ?></td>
                            <td>
                                <?= Html::textInput("price_{$master->id}", 
                                    $serviceMasters[$master->id]->custom_price ?? '', 
                                    ['class' => 'form-control form-control-sm', 'placeholder' => 'Стандартная']
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a('Отмена', ['/beauty/admin/services'], ['class' => 'btn btn-secondary']) ?>
                </div>
            <?= Html::endForm() ?>
        </div>
    </div>
</div>

<?php
$js = <<<JS
// Prevent any accidental form submissions
$('form').on('submit', function(e) {
    // Only allow submit from the actual submit button
    if (e.originalEvent && e.originalEvent.submitter) {
        return true;
    }
    // Prevent other submissions
    e.preventDefault();
    return false;
});

$('#select-all').on('click', function(e) {
    e.preventDefault();
    $('.master-checkbox').prop('checked', this.checked);
});

// Prevent form submission on enter or blur in any input
$('input').on('keydown blur change', function(e) {
    if (e.type === 'keydown' && e.key === 'Enter') {
        e.preventDefault();
        return false;
    }
    // Don't stop change/blur events, just don't submit
});
JS;
$this->registerJs($js);
?>
