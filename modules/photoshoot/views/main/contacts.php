<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */

$this->title = 'Контакты';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-6">
            <div class="service-card">
                <h4>Адрес</h4>
                <p>г. Москва, ул. Фотографов, 123</p>

                <h4>Телефон</h4>
                <p>+7 (XXX) XXX-XX-XX</p>

                <h4>Email</h4>
                <p>info@moistorii.ru</p>

                <h4>Часы работы</h4>
                <p>Ежедневно: 9:00 - 22:00</p>

                <h4>Мы в соцсетях</h4>
                <p>
                    <a href="#" class="btn btn-outline-primary btn-sm">Instagram</a>
                    <a href="#" class="btn btn-outline-primary btn-sm">VK</a>
                    <a href="#" class="btn btn-outline-primary btn-sm">Telegram</a>
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="service-card">
                <h4>Форма обратной связи</h4>
                <form>
                    <div class="mb-3">
                        <label class="form-label">Ваше имя</label>
                        <input type="text" class="form-control" placeholder="Введите имя">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="email@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Сообщение</label>
                        <textarea class="form-control" rows="4" placeholder="Ваш вопрос или предложение"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary-custom">Отправить</button>
                </form>
            </div>

            <div class="mt-4" style="background: #eee; height: 300px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                <span class="text-muted">Карта проезда</span>
            </div>
        </div>
    </div>
</div>
