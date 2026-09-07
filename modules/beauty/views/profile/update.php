<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Редактирование профиля - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="profile-container">
        <div class="profile-header">
            <h1>Редактирование профиля</h1>
            <p>Измените свои персональные данные</p>
        </div>

        <div class="profile-content">
            <div class="profile-sidebar">
                <div class="sidebar-menu">
                    <ul class="menu-list">
                        <li><a href="<?= Url::to(['/beauty/profile/index']) ?>" class="menu-link">Профиль</a></li>
                        <li><a href="<?= Url::to(['/beauty/orders/index']) ?>" class="menu-link">Мои заказы</a></li>
                        <?php if ($user->role === 'master'): ?>
                            <li><a href="<?= Url::to(['/beauty/admin/master-cabinet']) ?>" class="menu-link">Панель мастера</a></li>
                        <?php endif; ?>
                        <?php if ($user->role === 'admin'): ?>
                            <li><a href="<?= Url::to(['/beauty/admin']) ?>" class="menu-link">Админ панель</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <div class="profile-main">
                <div class="profile-form">
                    <?php $form = ActiveForm::begin([
                        'id' => 'profile-form',
                        'options' => ['class' => 'edit-form'],
                        'enableAjaxValidation' => false,
                    ]); ?>

                        <div class="form-section">
                            <h3>Основная информация</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <?= $form->field($user, 'full_name', [
                                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Иванов Иван Иванович'],
                                    ])->textInput(['maxlength' => true])->label('ФИО') ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($user, 'phone', [
                                        'inputOptions' => ['class' => 'form-control', 'placeholder' => '+7(XXX)XXX-XX-XX'],
                                    ])->textInput(['maxlength' => true, 'readonly' => true])->label('Телефон') ?>
                                    <small class="form-hint">Телефон нельзя изменить</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <h3>Изменение пароля</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <?= $form->field($user, 'currentPassword', [
                                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите текущий пароль'],
                                    ])->passwordInput()->label('Текущий пароль') ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($user, 'newPassword', [
                                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите новый пароль'],
                                    ])->passwordInput()->label('Новый пароль') ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($user, 'confirmPassword', [
                                        'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Повторите новый пароль'],
                                    ])->passwordInput()->label('Подтверждение пароля') ?>
                                </div>
                            </div>
                            <small class="form-hint">Оставьте поля пароля пустыми, если не хотите его менять</small>
                        </div>

                        <div class="form-actions">
                            <?= Html::a('Отмена', ['/beauty/profile/index'], ['class' => 'btn btn-secondary']) ?>
                            <?= Html::submitButton('Сохранить изменения', ['class' => 'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <div class="account-actions">
                    <h3>Действия с аккаунтом</h3>
                    <div class="actions-list">
                        <?php if ($user->role === 'master'): ?>
                            <div class="action-item">
                                <h4>Настройки мастера</h4>
                                <p>Управление услугами, расписанием и работами</p>
                                <?= Html::a('Панель мастера', ['/beauty/admin/master-cabinet'], ['class' => 'btn btn-outline']) ?>
                            </div>
                        <?php endif; ?>

                        <div class="action-item">
                            <h4>История заказов</h4>
                            <p>Просмотр всех ваших записей на услуги</p>
                            <?= Html::a('Мои заказы', ['/beauty/orders/index'], ['class' => 'btn btn-outline']) ?>
                        </div>

                        <div class="action-item danger">
                            <h4>Удаление аккаунта</h4>
                            <p>Полное удаление всех данных и истории</p>
                            <?= Html::a('Удалить аккаунт', '#', [
                                'class' => 'btn btn-danger',
                                'data' => [
                                    'confirm' => 'Вы уверены, что хотите удалить аккаунт? Это действие нельзя отменить.',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
