<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Услуги - Админ панель';
?>
<div class="admin-services">
    <h1>Услуги</h1>
    
    <div class="mb-3">
        <?= Html::a('Создать услугу', ['/beauty/admin/services/create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'label' => 'Название',
                    ],
                    [
                        'attribute' => 'category.name',
                        'label' => 'Категория',
                        'value' => function($model) {
                            return $model->category ? Html::encode($model->category->name) : '<span class="text-muted">-</span>';
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'duration',
                        'label' => 'Длительность (мин)',
                    ],
                    [
                        'attribute' => 'price',
                        'label' => 'Цена',
                        'format' => 'currency',
                    ],
                    [
                        'attribute' => 'is_active',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->is_active
                                ? '<span class="badge bg-success">Активна</span>' 
                                : '<span class="badge bg-secondary">Неактивна</span>';
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{masters} {update} {delete}',
                        'buttons' => [
                            'masters' => function($url, $model) {
                                return Html::a('👥', '/beauty/admin/services/masters/' . $model->id, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Мастера']);
                            },
                            'update' => function($url, $model) {
                                return Html::a('✏️', '/beauty/admin/services/edit/' . $model->id, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Редактировать']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('🗑️', '/beauty/admin/services/delete/' . $model->id, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Удалить',
                                    'data-confirm' => 'Удалить услугу?',
                                ]);
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
