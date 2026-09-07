<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление заявками';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="request-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-hover table-bordered'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'created_at',
                'format' => ['date', 'php:d.m.Y H:i'],
                'label' => 'Дата',
                'headerOptions' => ['style' => 'width: 150px;'],
            ],
            [
                'label' => 'Клиент',
                'value' => function($model) {
                    // Выводим ФИО и телефон
                    return ($model->user->fio ?? 'Пользователь') . "\n" . 
                           Html::tag('small', $model->user->phone ?? '', ['class' => 'text-muted']);
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'service_type_id',
                'label' => 'Услуга',
                'value' => 'serviceType.title',
            ],
            [
                'label' => 'Показания',
                'format' => 'raw',
                'value' => function($model) {
                    return $model->previous_value . ' <i class="fas fa-arrow-right"></i> <b>' . $model->current_value . '</b>';
                }
            ],
            [
                'attribute' => 'amount',
                'label' => 'Сумма',
                'format' => ['currency', 'RUB'],
                'contentOptions' => ['class' => 'text-end fw-bold'],
            ],
            [
                'attribute' => 'status_id',
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function($model) {
                    $code = $model->status->code ?? '';
                    $class = '';
                    switch ($code) {
                        case 'new':
                            $class = 'bg-warning text-dark';
                            break;
                        case 'approved':
                            $class = 'bg-success';
                            break;
                        case 'error':
                            $class = 'bg-danger';
                            break;
                        default:
                            $class = 'bg-secondary';
                            break;
                    }
                    return "<span class='badge {$class}'>" . ($model->status->title ?? '-') . "</span>";
                },
                'contentOptions' => ['class' => 'text-center'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{approve} {reject}',
                'header' => 'Решение',
                'buttons' => [
                    'approve' => function ($url, $model) {
                        if (($model->status->code ?? '') === 'new') {
                            return Html::a('✔', ['set-status', 'id' => $model->id, 'status_code' => 'approved'], [
                                'class' => 'btn btn-sm btn-outline-success',
                                'data-method' => 'post',
                            ]);
                        }
                        return '';
                    },
                    'reject' => function ($url, $model) {
                        if (($model->status->code ?? '') === 'new') {
                            return Html::a('✖', ['set-status', 'id' => $model->id, 'status_code' => 'error'], [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'data-method' => 'post',
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
    ]); ?>

</div>
