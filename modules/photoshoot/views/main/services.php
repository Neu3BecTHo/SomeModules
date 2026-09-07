<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $services array */

$this->title = 'Услуги и цены';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <h3 class="mt-4">Аренда залов</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="service-card">
                <h4>Малый зал</h4>
                <p>Уютный зал для индивидуальных и небольших групповых съемок</p>
                <ul class="list-unstyled">
                    <li>25 минут — <strong>1 200 ₽</strong></li>
                    <li>55 минут — <strong>2 000 ₽</strong></li>
                    <li>2 часа — <strong>4 000 ₽</strong></li>
                    <li>3 часа — <strong>6 000 ₽</strong></li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="service-card">
                <h4>Большой зал</h4>
                <p>Просторный зал для групповых съемок и сложных постановок</p>
                <ul class="list-unstyled">
                    <li>25 минут — <strong>1 500 ₽</strong></li>
                    <li>55 минут — <strong>2 500 ₽</strong></li>
                    <li>2 часа — <strong>5 000 ₽</strong></li>
                    <li>3 часа — <strong>7 500 ₽</strong></li>
                </ul>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Фотосессии с фотографом</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="service-card">
                <h4>В большом зале</h4>
                <ul class="list-unstyled">
                    <li>25 минут — <strong>6 000 ₽</strong></li>
                    <li>55 минут — <strong>10 000 ₽</strong></li>
                </ul>
                <p><small>Включены: аренда зала, работа фотографа, 10 обработанных фото</small></p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="service-card">
                <h4>В малом зале</h4>
                <ul class="list-unstyled">
                    <li>25 минут — <strong>6 000 ₽</strong></li>
                    <li>55 минут — <strong>10 000 ₽</strong></li>
                </ul>
                <p><small>Включены: аренда зала, работа фотографа, 10 обработанных фото</small></p>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Дополнительные услуги</h3>
    <div class="row">
        <div class="col-md-4">
            <div class="service-card">
                <h5>Ретушь фотографий</h5>
                <p>от <strong>300 ₽</strong> за фото</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <h5>Фотокниги</h5>
                <p>от <strong>3 500 ₽</strong></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <h5>Печать фото</h5>
                <p>от <strong>50 ₽</strong></p>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <?php if (Yii::$app->userPhotoshoot->isGuest): ?>
            <?= Html::a('Забронировать', ['/photoshoot/auth/login'], ['class' => 'btn btn-primary-custom btn-lg']) ?>
        <?php else: ?>
            <?= Html::a('Забронировать', ['/photoshoot/booking/create'], ['class' => 'btn btn-primary-custom btn-lg']) ?>
        <?php endif; ?>
    </div>
</div>
