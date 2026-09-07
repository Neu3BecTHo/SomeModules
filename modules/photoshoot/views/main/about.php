<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */

$this->title = 'О студии';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <h3>История и миссия</h3>
            <p>Фотостудия «Мои истории» — это место, где рождаются воспоминания. Мы создали пространство, где каждый может почувствовать себя звездой и сохранить самые важные моменты жизни в прекрасных фотографиях.</p>
            <p>Наша миссия — помогать людям создавать и сохранять их личные истории через искусство фотографии.</p>

            <h3 class="mt-4">Наша команда</h3>
            <p><strong>Профессиональные фотографы</strong> с многолетним опытом работы в разных жанрах — от портретной съемки до свадебной фотографии.</p>
            <p><strong>Администраторы</strong>, которые помогут подобрать идеальное время и зал для вашей съемки.</p>
        </div>
        <div class="col-md-6">
            <h3>Оборудование</h3>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Профессиональные камеры Canon и Sony</li>
                <li class="list-group-item">Студийный свет Profoto и Godox</li>
                <li class="list-group-item">Большой выбор реквизита</li>
                <li class="list-group-item">Коллекция платьев и костюмов</li>
                <li class="list-group-item">Гримерки с профессиональной косметикой</li>
            </ul>
        </div>
    </div>
</div>
