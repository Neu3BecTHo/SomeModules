<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\TourRequestSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

use app\modules\tours\models\Tours;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Заявки пользователей';
?>

<h1>Заявки пользователей</h1>

<div class="tour-admin-box">
    <form method="get" class="tour-filter__form">
        <div class="form-group">
            <label>Тур</label>
            <select name="TourRequestSearch[tour_id]">
                <option value="">Все туры</option>
                <?php foreach (ArrayHelper::map(
                    Tours::find()->orderBy('title')->all(),
                    'id', 'title'
                ) as $id => $title): ?>
                    <option value="<?= $id ?>"
                        <?= $searchModel->tour_id == $id ? 'selected' : '' ?>>
                        <?= Html::encode($title) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Статус</label>
            <select name="TourRequestSearch[status]">
                <option value="">Все</option>
                <option value="new" <?= $searchModel->status === 'new' ? 'selected' : '' ?>>Новая</option>
                <option value="in_review" <?= $searchModel->status === 'in_review' ? 'selected' : '' ?>>На рассмотрении</option>
                <option value="accepted" <?= $searchModel->status === 'accepted' ? 'selected' : '' ?>>Принята</option>
            </select>
        </div>

        <div class="form-group">
            <label>Дата с</label>
            <input type="date" name="TourRequestSearch[date_from]" value="<?= Html::encode($searchModel->date_from) ?>">
        </div>

        <div class="form-group">
            <label>Дата по</label>
            <input type="date" name="TourRequestSearch[date_to]" value="<?= Html::encode($searchModel->date_to) ?>">
        </div>

        <div class="tour-filter__actions">
            <button class="btn btn-primary" type="submit">Фильтр</button>
            <a href="<?= Url::to(['requests']) ?>" class="btn btn-outline">Сбросить</a>
        </div>
    </form>
</div>

<div class="tour-admin-box">
    <table>
        <thead>
        <tr>
            <th>Тур</th>
            <th>Пользователь</th>
            <th>Дата поездки</th>
            <th>Участников</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php $requests = $dataProvider->getModels(); ?>
        <?php if ($requests): ?>
            <?php foreach ($requests as $r): ?>
                <tr>
                    <td><?= Html::encode($r->tour->title ?? '(удалённый тур)') ?></td>
                    <td><?= Html::encode($r->user->fullName()) ?> (<?= Html::encode($r->user->email) ?>)</td>
                    <td><?= Yii::$app->formatter->asDate($r->date, 'php:d.m.Y') ?></td>
                    <td><?= (int)$r->participants_count ?></td>
                    <td>
                        <?php
                        $map = [
                            'new' => ['Новая', 'tour-status tour-status--new'],
                            'in_review' => ['На рассмотрении', 'tour-status tour-status--review'],
                            'accepted' => ['Заявка принята', 'tour-status tour-status--accepted'],
                        ];
                        [$text, $class] = $map[$r->status] ?? ['Неизвестно', 'tour-status'];
                        ?>
                        <span class="<?= $class ?>"><?= $text ?></span>
                    </td>
                    <td>
                        <a href="<?= Url::to(['request-update-status', 'id' => $r->id, 'status' => 'new']) ?>"
                           class="btn-xs">Новая</a>
                        <a href="<?= Url::to(['request-update-status', 'id' => $r->id, 'status' => 'in_review']) ?>"
                           class="btn-xs">На рассмотрении</a>
                        <a href="<?= Url::to(['request-update-status', 'id' => $r->id, 'status' => 'accepted']) ?>"
                           class="btn-xs">Принята</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Заявок пока нет.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
