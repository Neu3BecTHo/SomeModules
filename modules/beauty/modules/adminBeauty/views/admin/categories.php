<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Категории услуг';
?>

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Категории услуг</h1>
        <?= Html::a('+ Добавить категорию', ['create-category'], ['class' => 'btn btn-primary']) ?>
    </div>

    <div class="card">
        <div class="card-body">
            <?php if ($categories): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Описание</th>
                                <th class="text-end">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category->id ?></td>
                                    <td><?= Html::encode($category->name) ?></td>
                                    <td><?= Html::encode(mb_strimwidth($category->description ?? '', 0, 100, '...')) ?></td>
                                    <td class="text-end">
                                        <?= Html::a('✏️', ['edit-category', 'id' => $category->id], ['class' => 'btn btn-sm btn-outline-primary', 'title' => 'Редактировать']) ?>
                                        <?= Html::a('🗑️', ['delete-category', 'id' => $category->id], [
                                            'class' => 'btn btn-sm btn-outline-danger',
                                            'title' => 'Удалить',
                                            'data' => [
                                                'confirm' => 'Удалить категорию? Услуги останутся без категории.',
                                                'method' => 'post',
                                            ],
                                        ]) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-muted">Категории не созданы</p>
            <?php endif; ?>
        </div>
    </div>
</div>
