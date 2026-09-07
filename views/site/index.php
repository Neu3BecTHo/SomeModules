<?php

use yii\helpers\Url;

/** @var \yii\web\View $this */

$this->title = 'Панель модулей';

$this->registerCssFile('@web/css/DashboardModules.css');

?>

<div class="mods-page">
    <h1 class="mods-title">Проектные модули</h1>
    <p class="mods-subtitle">
        Выберите подсистему для перехода в пользовательский интерфейс или панель администратора.
    </p>

    <div class="mods-grid">
        <!-- Коммуналка -->
        <a href="<?= Url::to(['/communal/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--blue">К</div>
                <div>
                    <div class="mods-card__name">Коммунальные услуги</div>
                    <div class="mods-card__tag">Пользовательский портал</div>
                </div>
            </div>
            <div class="mods-card__body">
                Подача показаний, просмотр заявок, личный кабинет жильца.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Отдел кадров -->
        <a href="<?= Url::to(['/personnelDepartment/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--orange">HR</div>
                <div>
                    <div class="mods-card__name">Отдел кадров</div>
                    <div class="mods-card__tag">Сотрудники</div>
                </div>
            </div>
            <div class="mods-card__body">
                Регистрация, анкета сотрудника, личный кабинет.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Турфирма -->
        <a href="<?= Url::to(['/tours/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--green">T</div>
                <div>
                    <div class="mods-card__name">Туры</div>
                    <div class="mods-card__tag">Клиентский портал</div>
                </div>
            </div>
            <div class="mods-card__body">
                Каталог туров, заявки на бронирование, личный кабинет клиента.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Набережная / Boardwalk -->
        <a href="<?= Url::to(['/boardwalk/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--purple">B</div>
                <div>
                    <div class="mods-card__name">Boardwalk</div>
                    <div class="mods-card__tag">Городской портал</div>
                </div>
            </div>
            <div class="mods-card__body">
                Городской портал о набережной.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Химчистка -->
        <a href="<?= Url::to(['/cleaner/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--purple">Х</div>
                <div>
                    <div class="mods-card__name">Химчистка</div>
                    <div class="mods-card__tag">Услуги</div>
                </div>
            </div>
            <div class="mods-card__body">
                Городской портал о химчистке.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Хлебный дворик -->
        <a href="<?= Url::to(['/breadHouse/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--purple">Х</div>
                <div>
                    <div class="mods-card__name">Хлебный дворик</div>
                    <div class="mods-card__tag">Пекарня</div>
                </div>
            </div>
            <div class="mods-card__body">
                Городской портал о хлебном дворике.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Красота -->
        <a href="<?= Url::to(['/beauty/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--purple">К</div>
                <div>
                    <div class="mods-card__name">Красота</div>
                    <div class="mods-card__tag">Салон красоты</div>
                </div>
            </div>
            <div class="mods-card__body">
                Городской портал о салоне красоты.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>

        <!-- Фотостудия -->
        <a href="<?= Url::to(['/photoshoot/main/index']) ?>" class="mods-card">
            <div class="mods-card__header">
                <div class="mods-card__icon mods-card__icon--orange">Ф</div>
                <div>
                    <div class="mods-card__name">Мои истории</div>
                    <div class="mods-card__tag">Фотостудия</div>
                </div>
            </div>
            <div class="mods-card__body">
                Бронирование фотозалов, услуги фотографа, галерея работ.
            </div>
            <div class="mods-card__footer">
                <span>Перейти</span>
            </div>
        </a>
    </div>
</div>

<style>

.mods-page {
    max-width: 1100px;
    margin: 24px auto 24px;
    padding: 0 16px;
}

.mods-title {
    font-size: 24px;
    font-weight: 700;
    color: #f9fafb;
    margin: 0 0 6px;
}

.mods-subtitle {
    margin: 0 0 16px;
    font-size: 14px;
    color: #9ca3af;
}

.mods-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 14px;
}

.mods-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #020617;
    border-radius: 14px;
    padding: 14px 14px 10px;
    border: 1px solid #1f2937;
    text-decoration: none;
    color: #e5e7eb;
    box-shadow: 0 16px 36px rgba(0,0,0,0.55);
    transition: transform 0.12s ease, box-shadow 0.12s ease, border-color 0.12s ease, background-color 0.12s ease;
}

.mods-card--admin {
    border-style: dashed;
}

.mods-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 45px rgba(0,0,0,0.7);
    border-color: #f97316;
    background-color: #020617;
}

.mods-card__header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 8px;
}

.mods-card__icon {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    font-weight: 700;
    color: #020617;
}

.mods-card__icon--blue {
    background: #3b82f6;
}

.mods-card__icon--orange {
    background: #f97316;
}

.mods-card__icon--green {
    background: #22c55e;
}

.mods-card__icon--purple {
    background: #a855f7;
}

.mods-card__name {
    font-size: 15px;
    font-weight: 600;
    color: #f9fafb;
}

.mods-card__tag {
    font-size: 12px;
    color: #9ca3af;
}

.mods-card__body {
    font-size: 13px;
    color: #cbd5f5;
    margin-bottom: 10px;
}

.mods-card__footer {
    font-size: 12px;
    color: #9ca3af;
}
</style>