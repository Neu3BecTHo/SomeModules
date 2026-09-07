<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\photoshoot\models\BookingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\bootstrap5\Html;
use yii\grid\GridView;
use app\modules\photoshoot\models\Booking;

$this->title = 'Управление бронированиями';
?>
<div class="container-fluid py-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'user_id',
                'value' => function($model) {
                    return $model->user ? $model->user->full_name : 'N/A';
                },
            ],
            [
                'attribute' => 'service_type',
                'value' => function($model) {
                    return Booking::getServiceTypeLabels()[$model->service_type] ?? $model->service_type;
                },
                'filter' => Booking::getServiceTypeLabels(),
            ],
            [
                'attribute' => 'booking_date',
                'format' => 'datetime',
            ],
            [
                'attribute' => 'total_price',
                'format' => 'currency',
            ],
            [
                'attribute' => 'status',
                'value' => function($model) {
                    $labels = [
                        'new' => '<span class="badge bg-warning">Новая</span>',
                        'accepted' => '<span class="badge bg-info">Принята</span>',
                        'completed' => '<span class="badge bg-success">Услуга оказана</span>',
                        'cancelled' => '<span class="badge bg-danger">Отменена</span>',
                    ];
                    return $labels[$model->status] ?? $model->status;
                },
                'format' => 'raw',
                'filter' => Booking::getStatusLabels(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {accept} {complete} {cancel}',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'accept' => function($url, $model) {
                        if ($model->status === Booking::STATUS_NEW) {
                            return Html::a('Принять', ['update-status', 'id' => $model->id, 'status' => 'accepted'], [
                                'class' => 'btn btn-sm btn-outline-success',
                                'data-confirm' => 'Принять заявку?'
                            ]);
                        }
                        return '';
                    },
                    'complete' => function($url, $model) {
                        if ($model->status === Booking::STATUS_ACCEPTED) {
                            return Html::a('Завершить', ['update-status', 'id' => $model->id, 'status' => 'completed'], [
                                'class' => 'btn btn-sm btn-outline-info',
                                'data-confirm' => 'Отметить услугу как оказанную?'
                            ]);
                        }
                        return '';
                    },
                    'cancel' => function($url, $model) {
                        if (in_array($model->status, [Booking::STATUS_NEW, Booking::STATUS_ACCEPTED])) {
                            return Html::a('Отменить', ['update-status', 'id' => $model->id, 'status' => 'cancelled'], [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data-confirm' => 'Отменить заявку?'
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>
</div>
