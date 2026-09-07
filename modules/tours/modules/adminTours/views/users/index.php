<?php
/** @var app\modules\tours\models\User[] $users */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Пользователи';
?>

<h1>Пользователи туров</h1>

<div class="tour-admin-box">
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Роль</th>
            <th>Создан</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($users): ?>
            <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= $u->id ?></td>
                    <td><?= Html::encode($u->fullName()) ?></td>
                    <td><?= Html::encode($u->email) ?></td>
                    <td><?= Html::encode($u->phone) ?></td>
                    <td><?= Yii::$app->formatter->asDatetime($u->created_at, 'php:d.m.Y H:i') ?></td>
                    <td>
                        <a href="<?= Url::to(['user-update', 'id' => $u->id]) ?>" class="btn-xs">Редактировать</a>
                        <a href="<?= Url::to(['user-delete', 'id' => $u->id]) ?>" class="btn-xs"
                           data-confirm="Удалить пользователя?" data-method="post">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7">Пользователей пока нет.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
