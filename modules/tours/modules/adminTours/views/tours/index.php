<?php
/** @var app\modules\tours\models\Tours[] $tours */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Туры';
?>

<h1>Управление турами</h1>

<p>
    <a href="<?= Url::to(['tour-create']) ?>" class="btn btn-primary">Добавить тур</a>
</p>

<div class="tour-admin-box">
    <table>
        <thead>
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Дней</th>
            <th>Активен</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($tours): ?>
            <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= Html::encode($tour->title) ?></td>
                    <td><?= Yii::$app->formatter->asCurrency($tour->price, 'RUB') ?></td>
                    <td><?= (int)$tour->duration_days ?></td>
                    <td><?= $tour->is_active ? 'Да' : 'Нет' ?></td>
                    <td>
                        <a href="<?= Url::to(['tour-update', 'id' => $tour->id]) ?>" class="btn-xs">Редактировать</a>
                        <a href="<?= Url::to(['tour-delete', 'id' => $tour->id]) ?>" class="btn-xs"
                           data-confirm="Удалить тур?" data-method="post">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Туров пока нет.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
