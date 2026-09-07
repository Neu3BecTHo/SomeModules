<?php

use app\modules\PersonnelDepartment\models\QuestionnairesForm;
use app\modules\personnelDepartment\models\User;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \yii\web\View $this */
/** @var QuestionnairesForm els\Questionnaires $model */
/** @var User $user */
/** @var string $fullName */

$this->title = 'Анкета сотрудника';

$educationLevels = [
    'Основное общее' => 'Основное общее',
    'Среднее общее' => 'Среднее общее',
    'Среднее профессиональное' => 'Среднее профессиональное',
    'Высшее' => 'Высшее',
];

$this->registerCssFile('@web/css/Questionnaires.css');

?>

<div class="q-page">
    <h1 class="q-page__title">Анкета сотрудника</h1>
    <p class="q-page__subtitle">
        Заполните форму личными данными. После отправки анкета будет направлена на рассмотрение администратору.
    </p>

    <div class="q-card">
        <?php $form = ActiveForm::begin([
            'id' => 'questionnaire-form',
            'options' => ['class' => 'q-form', 'enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'options' => ['class' => 'q-form__field'],
                'labelOptions' => ['class' => 'q-form__label'],
                'inputOptions' => ['class' => 'q-form__input'],
                'errorOptions' => ['class' => 'q-form__error'],
            ],
        ]); ?>

        <!-- Основные данные -->
        <div class="q-form__section">
            <div class="q-form__section-title">Основные данные</div>

            <div class="q-form__field">
                <label class="q-form__label">ФИО</label>
                <div class="q-form__input q-form__input--readonly">
                    <?= Html::encode($fullName) ?>
                </div>
            </div>

            <div class="q-form__row">
                <?= $form->field($model, 'birth_date')->input('date') ?>
                <?= $form->field($model, 'gender')->dropDownList([
                    'Мужской' => 'Мужской',
                    'Женский' => 'Женский',
                    'Не указан' => 'Не указан',
                ], ['prompt' => 'Выберите пол']) ?>
            </div>

            <?= $form->field($model, 'citizenship')->textInput() ?>
        </div>

        <!-- Фото и паспорт -->
        <div class="q-form__section">
            <div class="q-form__section-title">Фото и паспорт</div>

            <?= $form->field($model, 'photo_file')->fileInput([
                'class' => 'q-form__input q-form__file-input',
            ]) ?>

            <div class="q-form__row">
                <?= $form->field($model, 'passport_series')->textInput() ?>
                <?= $form->field($model, 'passport_number')->textInput() ?>
            </div>

            <?= $form->field($model, 'passport_issued_by')->textInput() ?>

            <div class="q-form__row">
                <?= $form->field($model, 'passport_issued_at')->input('date') ?>
                <?= $form->field($model, 'registration_address')->textInput() ?>
            </div>

            <?= $form->field($model, 'marital_status')->textInput() ?>

            <?= $form->field($model, 'passport_scan')->fileInput([
                'class' => 'q-form__input q-form__file-input',
            ]) ?>
        </div>

        <!-- Образование -->
        <div class="q-form__section">
            <div class="q-form__section-title">Образование</div>

            <?= $form->field($model, 'education_level')->dropDownList(
                $educationLevels,
                ['prompt' => 'Выберите уровень образования', 'class' => 'q-form__select']
            ) ?>

            <?= $form->field($model, 'education_org_name')->textInput() ?>
            <?= $form->field($model, 'education_specialty')->textInput() ?>

            <div class="q-form__row">
                <?= $form->field($model, 'education_diploma_series')->textInput() ?>
                <?= $form->field($model, 'education_diploma_number')->textInput() ?>
            </div>

            <?= $form->field($model, 'diploma_scan')->fileInput([
                'class' => 'q-form__input q-form__file-input',
            ]) ?>
        </div>

        <!-- СНИЛС -->
        <div class="q-form__section">
            <div class="q-form__section-title">СНИЛС</div>

            <div class="q-form__row">
                <?= $form->field($model, 'snils_number')->textInput() ?>
                <?= $form->field($model, 'snils_scan')->fileInput([
                    'class' => 'q-form__input q-form__file-input',
                ]) ?>
            </div>
        </div>

        <!-- Работа и здоровье -->
        <div class="q-form__section">
            <div class="q-form__section-title">Работа и здоровье</div>

            <?= $form->field($model, 'workplace')->textInput() ?>
            <?= $form->field($model, 'position')->textInput() ?>

            <div class="q-form__row">
                <?= $form->field($model, 'experience_years')->textInput([
                    'type' => 'number',
                    'min' => 0,
                ]) ?>
                <?= $form->field($model, 'health_state')->textInput() ?>
            </div>
        </div>

        <!-- Контакты -->
        <div class="q-form__section">
            <div class="q-form__section-title">Контактные данные</div>

            <div class="q-form__row">
                <div class="q-form__field">
                    <label class="q-form__label">Номер телефона</label>
                    <div class="q-form__input q-form__input--readonly">
                        <?= Html::encode($user->phone) ?>
                    </div>
                </div>

                <div class="q-form__field">
                    <label class="q-form__label">Адрес электронной почты</label>
                    <div class="q-form__input q-form__input--readonly">
                        <?= Html::encode($user->email) ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Дополнительная информация -->
        <div class="q-form__section">
            <div class="q-form__section-title">Дополнительная информация</div>
            <?= $form->field($model, 'extra_info')->textarea([
                'class' => 'q-form__textarea',
                'rows' => 3,
            ]) ?>
        </div>

        <!-- Кнопка -->
        <div class="q-form__actions">
            <button type="submit" class="q-btn q-btn_primary">
                Передать данные
            </button>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
