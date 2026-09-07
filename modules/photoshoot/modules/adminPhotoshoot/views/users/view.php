<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\User */

$this->title = 'Пользователь: ' . $model->full_name;
?>
<div class="container-fluid py-4">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td><?= $model->id ?></td>
                </tr>
                <tr>
                    <th>Логин</th>
                    <td><?= Html::encode($model->login) ?></td>
                </tr>
                <tr>
                    <th>ФИО</th>
                    <td><?= Html::encode($model->full_name) ?></td>
                </tr>
                <tr>
                    <th>Телефон</th>
                    <td><?= Html::encode($model->phone) ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= Html::encode($model->email) ?></td>
                </tr>
                <tr>
                    <th>Роль</th>
                    <td>
                        <?= $model->is_admin 
                            ? '<span class="badge bg-success">Администратор</span>' 
                            : '<span class="badge bg-secondary">Клиент</span>' 
                        ?>
                    </td>
                </tr>
                <tr>
                    <th>Создан</th>
                    <td><?= Yii::$app->formatter->asDatetime($model->created_at) ?></td>
                </tr>
            </table>

            <div class="d-flex gap-2">
                <?= Html::a('Назад', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
                <?= Html::a($model->is_admin ? 'Снять права админа' : 'Сделать админом', ['toggle-admin', 'id' => $model->id], [
                    'class' => $model->is_admin ? 'btn btn-danger' : 'btn btn-success',
                    'data-confirm' => 'Изменить роль пользователя?'
                ]) ?>
            </div>
        </div>
    </div>
</div>
