<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Мастера - Админ панель';
?>
<div class="admin-masters">
    <h1>Мастера</h1>
    
    <div class="mb-3">
        <?= Html::a('Все', ['/beauty/admin/masters'], ['class' => 'btn ' . (empty($status) ? 'btn-primary' : 'btn-outline-primary')]) ?>
        <?= Html::a('Одобренные', ['/beauty/admin/masters', 'status' => 'approved'], ['class' => 'btn ' . ($status === 'approved' ? 'btn-primary' : 'btn-outline-primary')]) ?>
        <?= Html::a('На одобрении', ['/beauty/admin/masters', 'status' => 'pending'], ['class' => 'btn ' . ($status === 'pending' ? 'btn-primary' : 'btn-outline-primary')]) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'user.full_name',
                        'label' => 'Имя',
                    ],
                    [
                        'attribute' => 'specialization',
                        'label' => 'Специализация',
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => 'Рейтинг',
                    ],
                    [
                        'attribute' => 'is_approved',
                        'label' => 'Статус',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->is_approved 
                                ? '<span class="badge bg-success">Одобрен</span>' 
                                : '<span class="badge bg-warning">На одобрении</span>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата регистрации',
                        'format' => 'datetime',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {approve} {delete}',
                        'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('👁️', '/beauty/admin/masters/view/' . $model->id, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Просмотр']);
                            },
                            'approve' => function($url, $model) {
                                if (!$model->is_approved) {
                                    return Html::a('✅', '/beauty/admin/masters/approve/' . $model->id, [
                                        'class' => 'btn btn-sm btn-success',
                                        'title' => 'Одобрить',
                                    ]);
                                }
                                return '';
                            },
                            'delete' => function($url, $model) {
                                return Html::a('🗑️', '/beauty/admin/masters/delete/' . $model->id, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Удалить',
                                    'data-confirm' => 'Удалить мастера?',
                                ]);
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
