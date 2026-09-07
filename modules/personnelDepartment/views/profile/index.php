<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\modules\personnelDepartment\models\User $user */
/** @var \app\modules\personnelDepartment\models\Questionnaires $profile */
/** @var array $filesByType */

$this->title = 'Личный кабинет сотрудника';

$this->registerCssFile('@web/css/Questionnaires.css');

$fullName = trim($user->last_name . ' ' . $user->first_name . ' ' . $user->patronymic);

?>

<div class="q-page">
    <h1 class="q-page__title">Личный кабинет</h1>
    <p class="q-page__subtitle">
        Здесь отображаются данные, заполненные в анкете сотрудника. При необходимости вы можете изменить информацию.
    </p>

    <div class="q-card q-card--cabinet">
        <div class="q-cabinet">
            <!-- Левая колонка: «аватар» и контакты -->
            <div class="q-cabinet__side">
                <div class="q-cabinet__avatar">
                    <div class="q-cabinet__avatar-circle">
                        <?= Html::encode(mb_substr($user->first_name, 0, 1) . mb_substr($user->last_name, 0, 1)) ?>
                    </div>
                </div>
                <div class="q-cabinet__name"><?= Html::encode($fullName) ?></div>
                <div class="q-cabinet__role">Сотрудник организации</div>

                <div class="q-cabinet__contacts">
                    <div class="q-cabinet__contact">
                        <span class="q-cabinet__contact-label">Email</span>
                        <span class="q-cabinet__contact-value"><?= Html::encode($user->email) ?></span>
                    </div>
                    <div class="q-cabinet__contact">
                        <span class="q-cabinet__contact-label">Телефон</span>
                        <span class="q-cabinet__contact-value"><?= Html::encode($user->phone) ?></span>
                    </div>
                </div>

                <a href="<?= Url::to(['questionnaires/index']) ?>"
                   class="q-btn q-btn_primary q-cabinet__edit">
                    Изменить данные
                </a>
            </div>

            <!-- Правая колонка: блоки с данными -->
            <div class="q-cabinet__content">
                <div class="q-cabinet__block">
                    <div class="q-form__section-title">Основные данные</div>
                    <dl class="q-cabinet__list">
                        <div class="q-cabinet__row">
                            <dt>Дата рождения</dt><dd><?= Html::encode($profile->birth_date) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Пол</dt><dd><?= Html::encode($profile->gender) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Гражданство</dt><dd><?= Html::encode($profile->citizenship) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Семейное положение</dt><dd><?= Html::encode($profile->marital_status) ?></dd>
                        </div>
                    </dl>
                </div>

                <div class="q-cabinet__block">
                    <div class="q-form__section-title">Паспорт</div>
                    <dl class="q-cabinet__list">
                        <div class="q-cabinet__row">
                            <dt>Серия и номер</dt>
                            <dd><?= Html::encode($profile->passport_series . ' ' . $profile->passport_number) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Кем выдан</dt><dd><?= Html::encode($profile->passport_issued_by) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Когда выдан</dt><dd><?= Html::encode($profile->passport_issued_at) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Адрес регистрации</dt><dd><?= Html::encode($profile->registration_address) ?></dd>
                        </div>
                    </dl>

                    <?php if (!empty($filesByType['passport_scan'][0]['file_path'])): ?>
                        <div class="q-cabinet__file">
                            Скан паспорта:
                            <a href="<?= Html::encode($filesByType['passport_scan'][0]['file_path']) ?>"
                               target="_blank">Открыть файл</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="q-cabinet__block">
                    <div class="q-form__section-title">Образование</div>
                    <dl class="q-cabinet__list">
                        <div class="q-cabinet__row">
                            <dt>Уровень</dt><dd><?= Html::encode($profile->education_level) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Организация</dt><dd><?= Html::encode($profile->education_org_name) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Специальность</dt><dd><?= Html::encode($profile->education_specialty) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Диплом</dt>
                            <dd><?= Html::encode($profile->education_diploma_series . ' ' . $profile->education_diploma_number) ?></dd>
                        </div>
                    </dl>

                    <?php if (!empty($filesByType['diploma_scan'][0]['file_path'])): ?>
                        <div class="q-cabinet__file">
                            Скан диплома:
                            <a href="<?= Html::encode($filesByType['diploma_scan'][0]['file_path']) ?>"
                               target="_blank">Открыть файл</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="q-cabinet__block">
                    <div class="q-form__section-title">СНИЛС</div>
                    <dl class="q-cabinet__list">
                        <div class="q-cabinet__row">
                            <dt>Номер СНИЛС</dt><dd><?= Html::encode($profile->snils_number) ?></dd>
                        </div>
                    </dl>

                    <?php if (!empty($filesByType['snils_scan'][0]['file_path'])): ?>
                        <div class="q-cabinet__file">
                            Скан СНИЛС:
                            <a href="<?= Html::encode($filesByType['snils_scan'][0]['file_path']) ?>"
                               target="_blank">Открыть файл</a>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="q-cabinet__block">
                    <div class="q-form__section-title">Работа и здоровье</div>
                    <dl class="q-cabinet__list">
                        <div class="q-cabinet__row">
                            <dt>Место работы</dt><dd><?= Html::encode($profile->workplace) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Должность</dt><dd><?= Html::encode($profile->position) ?></dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Стаж работы</dt><dd><?= Html::encode($profile->experience_years) ?> лет</dd>
                        </div>
                        <div class="q-cabinet__row">
                            <dt>Состояние здоровья</dt><dd><?= Html::encode($profile->health_state) ?></dd>
                        </div>
                    </dl>
                </div>

                <div class="q-cabinet__block">
                    <div class="q-form__section-title">Дополнительно</div>
                    <div class="q-cabinet__row q-cabinet__row--full">
                        <dt>Дополнительная информация</dt>
                        <dd><?= nl2br(Html::encode($profile->extra_info)) ?></dd>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
