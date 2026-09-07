<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Заявки - Админ панель';

$statusLabels = $statusLabels ?? ['new' => 'Новая', 'accepted' => 'Принята', 'rejected' => 'Отклонена', 'completed' => 'Завершена', 'cancelled' => 'Отменена'];
?>
<div class="admin-orders">
    <h1>Заявки</h1>
    
    <?= Html::beginForm(['orders'], 'get', ['class' => 'form-inline mb-3']) ?>
        <div class="row">
            <div class="col-md-2">
                <?= Html::dropDownList('status', $status, [
                    '' => 'Все статусы',
                    'new' => 'Новые',
                    'accepted' => 'Приняты',
                    'completed' => 'Завершены',
                    'rejected' => 'Отклонены',
                    'cancelled' => 'Отменены',
                ], ['class' => 'form-control']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::dropDownList('master_id', $masterId, 
                    ['' => 'Все мастера'] + \yii\helpers\ArrayHelper::map($masters, 'id', function($m) { return $m->user->full_name; }),
                    ['class' => 'form-control']
                ) ?>
            </div>
            <div class="col-md-2">
                <?= Html::input('date', 'date_from', $dateFrom, ['class' => 'form-control', 'placeholder' => 'С даты']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::input('date', 'date_to', $dateTo, ['class' => 'form-control', 'placeholder' => 'По дату']) ?>
            </div>
            <div class="col-md-2">
                <?= Html::submitButton('Фильтр', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    <?= Html::endForm() ?>

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
                        'attribute' => 'master.user.full_name',
                        'label' => 'Мастер',
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
                        'value' => function($model) use ($statusLabels) {
                            $colors = [
                                'new' => 'primary',
                                'accepted' => 'info',
                                'completed' => 'success',
                                'rejected' => 'danger',
                                'cancelled' => 'secondary',
                            ];
                            $color = $colors[$model->status] ?? 'secondary';
                            return '<span class="badge bg-' . $color . '">' . ($statusLabels[$model->status] ?? $model->status) . '</span>';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('👁️', '/beauty/admin/orders/view/' . $model->id, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Просмотр']);
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
