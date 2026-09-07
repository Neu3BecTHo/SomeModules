<?php

use yii\bootstrap5\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="container-fluid py-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'login',
            'full_name',
            'phone',
            'email',
            [
                'attribute' => 'is_admin',
                'value' => function($model) {
                    return $model->is_admin ? '<span class="badge bg-success">Админ</span>' : '<span class="badge bg-secondary">Клиент</span>';
                },
                'format' => 'raw',
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {toggle}',
                'buttons' => [
                    'view' => function($url, $model) {
                        return Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-primary']);
                    },
                    'toggle' => function($url, $model) {
                        $label = $model->is_admin ? 'Снять админ' : 'Сделать админ';
                        $class = $model->is_admin ? 'btn-outline-danger' : 'btn-outline-success';
                        return Html::a($label, ['toggle-admin', 'id' => $model->id], [
                            'class' => 'btn btn-sm ' . $class,
                            'data-confirm' => 'Изменить роль пользователя?'
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
