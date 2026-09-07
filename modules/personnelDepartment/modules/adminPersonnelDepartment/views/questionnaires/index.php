<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var \yii\web\View $this */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\modules\personnelDepartment\models\ProfileStatus[] $statuses */
/** @var array $filters */

$this->title = 'Анкеты сотрудников';

$this->registerCssFile('@web/css/QuestionnairesAdmin.css');

$items = $dataProvider->getModels();
?>

<div class="qa-page">
    <h1 class="qa-title">Анкеты сотрудников</h1>
    <p class="qa-subtitle">
        Все анкеты, переданные на рассмотрение. Вы можете отфильтровать сотрудников и изменить статус анкеты.
    </p>

    <!-- Фильтры -->
    <div class="ap-filters">
        <form method="get">
            <div class="ap-filters__grid">
                <div class="ap-filters__field">
                    <label class="ap-filters__label">Пол</label>
                    <select name="gender" class="ap-filters__control">
                        <option value="">Любой</option>
                        <option value="Мужской" <?= $filters['gender'] === 'Мужской' ? 'selected' : '' ?>>Мужской</option>
                        <option value="Женский" <?= $filters['gender'] === 'Женский' ? 'selected' : '' ?>>Женский</option>
                    </select>
                </div>

                <div class="ap-filters__field">
                    <label class="ap-filters__label">Гражданство</label>
                    <input type="text" name="citizenship"
                        value="<?= Html::encode($filters['citizenship']) ?>"
                        class="ap-filters__control" placeholder="Россия">
                </div>

                <div class="ap-filters__field">
                    <label class="ap-filters__label">Образование</label>
                    <select name="education_level" class="ap-filters__control">
                        <option value="">Любое</option>
                        <option value="Основное общее" <?= $filters['education_level'] === 'Основное общее' ? 'selected' : '' ?>>Основное общее</option>
                        <option value="Среднее общее" <?= $filters['education_level'] === 'Среднее общее' ? 'selected' : '' ?>>Среднее общее</option>
                        <option value="Среднее профессиональное" <?= $filters['education_level'] === 'Среднее профессиональное' ? 'selected' : '' ?>>Среднее профессиональное</option>
                        <option value="Высшее" <?= $filters['education_level'] === 'Высшее' ? 'selected' : '' ?>>Высшее</option>
                    </select>
                </div>

                <div class="ap-filters__field">
                    <label class="ap-filters__label">Должность</label>
                    <input type="text" name="position"
                        value="<?= Html::encode($filters['position']) ?>"
                        class="ap-filters__control" placeholder="Менеджер">
                </div>

                <div class="ap-filters__field">
                    <label class="ap-filters__label">Семейное положение</label>
                    <input type="text" name="marital_status"
                        value="<?= Html::encode($filters['marital_status']) ?>"
                        class="ap-filters__control" placeholder="Женат / Замужем">
                </div>

                <div class="ap-filters__actions">
                    <button type="submit" class="q-btn q-btn_primary">Фильтровать</button>
                    <a href="<?= Url::to(['index']) ?>" class="ap-filters__reset">Сбросить</a>
                </div>
            </div>
        </form>
    </div>

    <!-- Список анкет -->
    <div class="qa-list">
        <?php foreach ($items as $profile): ?>
            <?php
            $user = $profile->user;
            $status = $profile->status;
            $fullName = trim($user->last_name . ' ' . $user->first_name . ' ' . $user->patronymic);
            ?>
            <div class="qa-card">
                <div class="qa-card__header">
                    <div class="qa-card__title">
                        <div class="qa-card__avatar">
                            <?= Html::encode(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1)) ?>
                        </div>
                        <div>
                            <div class="qa-card__name"><?= Html::encode($fullName) ?></div>
                            <div class="qa-card__meta">
                                <?= Html::encode($profile->position ?: 'Должность не указана') ?>
                                ·
                                <?= Html::encode($profile->education_level ?: 'Образование не указано') ?>
                            </div>
                        </div>
                    </div>
                    <div class="qa-card__status">
                        <span class="qa-status qa-status--<?= Html::encode($status->code) ?>">
                            <?= Html::encode($status->title) ?>
                        </span>
                    </div>
                </div>

                <div class="qa-card__body">
                    <div class="qa-card__col">
                        <div class="qa-field"><span>Пол:</span> <?= Html::encode($profile->gender) ?></div>
                        <div class="qa-field"><span>Гражданство:</span> <?= Html::encode($profile->citizenship) ?></div>
                        <div class="qa-field"><span>Стаж:</span> <?= Html::encode($profile->experience_years) ?> лет</div>
                    </div>
                    <div class="qa-card__col">
                        <div class="qa-field"><span>Email:</span> <?= Html::encode($user->email) ?></div>
                        <div class="qa-field"><span>Телефон:</span> <?= Html::encode($user->phone) ?></div>
                        <div class="qa-field"><span>Семейное положение:</span> <?= Html::encode($profile->marital_status) ?></div>
                    </div>
                </div>

                <div class="qa-card__footer">
                    <div class="qa-card__actions">
                        <span>Статус:</span>
                        <a href="<?= Url::to(['set-status', 'id' => $profile->id, 'code' => 'checking']) ?>"
                           class="qa-btn-status qa-btn-status--checking">
                            Идет проверка данных
                        </a>
                        <a href="<?= Url::to(['set-status', 'id' => $profile->id, 'code' => 'approved']) ?>"
                           class="qa-btn-status qa-btn-status--approved">
                            Данные приняты
                        </a>
                    </div>
                    <div class="qa-card__date">
                        Обновлено: <?= Yii::$app->formatter->asDatetime($profile->updated_at) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($items)): ?>
            <p class="qa-empty">Анкет пока нет.</p>
        <?php endif; ?>
    </div>

    <?= LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
</div>
