<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Мои заявки - Личный кабинет';

$statusLabels = ['new' => 'Новая', 'accepted' => 'Принята', 'rejected' => 'Отклонена', 'completed' => 'Завершена', 'cancelled' => 'Отменена'];
$statusColors = ['new' => 'primary', 'accepted' => 'info', 'rejected' => 'danger', 'completed' => 'success', 'cancelled' => 'secondary'];
?>
<div class="master-orders">
    <h1>Мои заявки</h1>
    
    <div class="mb-3">
        <?= Html::beginForm(['/beauty/admin/master-cabinet/orders'], 'get', ['class' => 'form-inline']) ?>
            <div class="row">
                <div class="col-md-3">
                    <?= Html::dropDownList('status', $status, [
                        '' => 'Все статусы',
                        'new' => 'Новые',
                        'accepted' => 'Приняты',
                        'completed' => 'Завершены',
                    ], ['class' => 'form-control']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::input('date', 'date_from', $dateFrom, ['class' => 'form-control']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::input('date', 'date_to', $dateTo, ['class' => 'form-control']) ?>
                </div>
                <div class="col-md-3">
                    <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        <?= Html::endForm() ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'client.full_name',
                        'label' => 'Клиент',
                    ],
                    [
                        'attribute' => 'service.name',
                        'label' => 'Услуга',
                    ],
                    [
                        'attribute' => 'appointment_date',
                        'label' => 'Дата',
                        'format' => 'date',
                    ],
                    [
                        'attribute' => 'appointment_time',
                        'label' => 'Время',
                    ],
                    [
                        'attribute' => 'total_price',
                        'label' => 'Сумма',
                        'format' => 'currency',
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function($model) use ($statusLabels, $statusColors) {
                            return '<span class="badge bg-' . ($statusColors[$model->status] ?? 'secondary') . '">' . ($statusLabels[$model->status] ?? $model->status) . '</span>';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {accept} {reject} {complete}',
                        'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('👁️', '/beauty/admin/master-cabinet/orders/view/' . $model->id, ['class' => 'btn btn-sm btn-outline-primary', 'title' => 'Просмотр']);
                            },
                            'accept' => function($url, $model) {
                                if ($model->status === 'new') {
                                    return Html::a('✅', '/beauty/admin/master-cabinet/orders/update-status/' . $model->id . '/accepted', [
                                        'class' => 'btn btn-sm btn-success',
                                        'title' => 'Принять',
                                        'data-confirm' => 'Принять заявку?',
                                    ]);
                                }
                                return '';
                            },
                            'reject' => function($url, $model) {
                                if (in_array($model->status, ['new', 'accepted'])) {
                                    return Html::a('❌', '/beauty/admin/master-cabinet/orders/update-status/' . $model->id . '/rejected', [
                                        'class' => 'btn btn-sm btn-danger',
                                        'title' => 'Отклонить',
                                        'data-confirm' => 'Отклонить заявку?',
                                    ]);
                                }
                                return '';
                            },
                            'complete' => function($url, $model) {
                                if ($model->status === 'accepted') {
                                    return Html::a('✨', '/beauty/admin/master-cabinet/orders/update-status/' . $model->id . '/completed', [
                                        'class' => 'btn btn-sm btn-primary',
                                        'title' => 'Завершить',
                                        'data-confirm' => 'Завершить заявку?',
                                    ]);
                                }
                                return '';
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
