<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Пользователи - Админ панель';
?>
<div class="admin-users">
    <h1>Пользователи</h1>
    
    <div class="card">
        <div class="card-body">
            <?= Html::beginForm(['users'], 'get', ['class' => 'form-inline']) ?>
                <div class="input-group mb-3">
                    <?= Html::textInput('search', $search, ['class' => 'form-control', 'placeholder' => 'Поиск по имени или телефону']) ?>
                    <div class="input-group-append">
                        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            <?= Html::endForm() ?>
            
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    'id',
                    [
                        'attribute' => 'full_name',
                        'label' => 'Имя',
                    ],
                    [
                        'attribute' => 'phone',
                        'label' => 'Телефон',
                    ],
                    [
                        'attribute' => 'role',
                        'label' => 'Роль',
                        'value' => function($model) {
                            $roles = ['client' => 'Клиент', 'master' => 'Мастер', 'admin' => 'Админ'];
                            return $roles[$model->role] ?? $model->role;
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата регистрации',
                        'format' => 'datetime',
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function($url, $model) {
                                return Html::a('👁️', '/beauty/admin/users/view/' . $model->id, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Просмотр']);
                            },
                            'update' => function($url, $model) {
                                return Html::a('✏️', '/beauty/admin/users/edit/' . $model->id, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Редактировать']);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('🗑️', '/beauty/admin/users/delete/' . $model->id, [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Удалить',
                                    'data-confirm' => 'Вы уверены?',
                                ]);
                            },
                        ],
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
