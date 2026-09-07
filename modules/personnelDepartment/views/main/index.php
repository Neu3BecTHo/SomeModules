<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */

$this->title = 'Отдел кадров';

$user = Yii::$app->userPersonnelDepartment->identity;
$isGuest = Yii::$app->userPersonnelDepartment->isGuest;

?>

<div class="hr-landing">
    <div class="hr-landing__panel">
        <div class="hr-landing__logo">
            <span class="hr-logo-mark">HR</span>
            <span class="hr-logo-text">Отдел кадров</span>
        </div>

        <?php if ($isGuest): ?>

            <h1 class="hr-landing__title">Единый портал кадровых данных</h1>
            <p class="hr-landing__subtitle">
                Сбор, проверка и актуализация анкет сотрудников в единой информационной системе.
            </p>

            <div class="hr-landing__actions">
                <a href="<?= Url::to(['auth/login']) ?>" class="hr-btn hr-btn_primary">Войти</a>
                <a href="<?= Url::to(['auth/register']) ?>" class="hr-btn hr-btn_ghost">Регистрация</a>
            </div>

            <div class="hr-landing__meta">
                <span>Для сотрудников организации</span>
                <span class="hr-dot"></span>
                <span>Анкеты, личный кабинет, проверка данных</span>
            </div>

        <?php else: ?>

            <h1 class="hr-landing__title">
                Добро пожаловать, <?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?>!
            </h1>
            <p class="hr-landing__subtitle">
                Вы вошли в систему «Отдел кадров». Здесь вы можете заполнить или обновить свою анкету
                и просмотреть данные личного кабинета.
            </p>

            <div class="hr-landing__actions">
                <a href="<?= Url::to(['questionnaires/index']) ?>" class="hr-btn hr-btn_primary">
                    Перейти к анкете
                </a>
                <?= Html::beginForm(Url::to(['auth/logout']), 'post') ?>
                    <?= Html::submitButton('Выйти', ['class' => 'hr-btn hr-btn_ghost']) ?>
                <?= Html::endForm() ?>
            </div>

            <div class="hr-landing__meta">
                <span>Личный кабинет сотрудника</span>
                <span class="hr-dot"></span>
                <span>Анкета, статус проверки данных</span>
            </div>

        <?php endif; ?>
    </div>
</div>
