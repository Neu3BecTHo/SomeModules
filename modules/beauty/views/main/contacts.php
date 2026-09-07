<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Контакты - Салон красоты Виктория';
?>
<div class="beauty-container">
    <section class="contacts-page">
        <div class="container">
            <div class="contacts-header">
                <h1>Контакты</h1>
                <p>Свяжитесь с нами любым удобным способом</p>
            </div>

            <div class="contacts-content">
                <div class="contact-info-section">
                    <h2>Контактная информация</h2>
                    <div class="contact-cards">
                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="icon-phone"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Телефон</h3>
                                <p><a href="tel:+71234567890">+7 (123) 456-78-90</a></p>
                                <p>Прием заказов с 9:00 до 20:00</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="icon-envelope"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Email</h3>
                                <p><a href="mailto:info@victoria-beauty.ru">info@victoria-beauty.ru</a></p>
                                <p>Для вопросов и консультаций</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="icon-map-marker"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Адрес</h3>
                                <p>г. Москва, ул. Красная, д. 1</p>
                                <p>Вход со двора, 2 этаж</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="icon-clock"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Время работы</h3>
                                <p><strong>Понедельник - Суббота:</strong> 9:00 - 20:00</p>
                                <p><strong>Воскресенье:</strong> 10:00 - 18:00</p>
                            </div>
                        </div>

                        <div class="contact-card">
                            <div class="contact-icon">
                                <i class="icon-social"></i>
                            </div>
                            <div class="contact-details">
                                <h3>Социальные сети</h3>
                                <div class="social-links">
                                    <a href="#" class="social-link vk">VK</a>
                                    <a href="#" class="social-link instagram">Instagram</a>
                                    <a href="#" class="social-link telegram">Telegram</a>
                                    <a href="#" class="social-link whatsapp">WhatsApp</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="contact-form-section">
                    <h2>Обратная связь</h2>
                    <p>Оставьте заявку и мы свяжемся с вами в ближайшее время</p>
                    
                    <?php $form = \yii\widgets\ActiveForm::begin([
                        'id' => 'contact-form',
                        'options' => ['class' => 'contact-form'],
                        'action' => '#', // Placeholder - would need a controller action
                    ]); ?>

                        <div class="form-row">
                            <div class="form-group">
                                <?= $form->field($model ?? new \yii\base\DynamicModel(['name' => '', 'phone' => '', 'email' => '']), 'name', [
                                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Ваше имя'],
                                ])->textInput()->label('Имя') ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model ?? new \yii\base\DynamicModel(['name' => '', 'phone' => '', 'email' => '']), 'phone', [
                                    'inputOptions' => ['class' => 'form-control', 'placeholder' => '+7(XXX)XXX-XX-XX'],
                                ])->textInput()->label('Телефон') ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <?= $form->field($model ?? new \yii\base\DynamicModel(['name' => '', 'phone' => '', 'email' => '']), 'email', [
                                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'email@example.com'],
                                ])->textInput()->label('Email') ?>
                            </div>
                            <div class="form-group">
                                <?= $form->field($model ?? new \yii\base\DynamicModel(['name' => '', 'phone' => '', 'email' => '', 'subject' => '']), 'subject', [
                                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Тема сообщения'],
                                ])->textInput()->label('Тема') ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= $form->field($model ?? new \yii\base\DynamicModel(['name' => '', 'phone' => '', 'email' => '', 'subject' => '', 'message' => '']), 'message', [
                                'inputOptions' => ['class' => 'form-control', 'rows' => 6, 'placeholder' => 'Ваше сообщение...'],
                            ])->textarea()->label('Сообщение') ?>
                        </div>

                        <div class="form-actions">
                            <?= Html::submitButton('Отправить сообщение', ['class' => 'btn btn-primary']) ?>
                        </div>

                    <?php \yii\widgets\ActiveForm::end(); ?>
                </div>

                <div class="map-section">
                    <h2>Как нас найти</h2>
                    <div class="map-container">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.1234567890!2d37.617494!3d55.755826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDM2JzE3LjEiTiA3MMKwMzcnMTIuOCJF!5e0!3m2!1sru!2sru!4v1234567890" 
                            width="100%" 
                            height="450" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy"
                            class="map-iframe">
                        </iframe>
                    </div>
                    
                    <div class="directions">
                        <h3>Проезд</h3>
                        <div class="transport-options">
                            <div class="transport-item">
                                <div class="transport-icon">
                                    <i class="icon-subway"></i>
                                </div>
                                <div class="transport-info">
                                    <h4>Метро</h4>
                                    <p>Станция "Красная площадь", выход 3, 5 минут пешком</p>
                                </div>
                            </div>
                            <div class="transport-item">
                                <div class="transport-icon">
                                    <i class="icon-bus"></i>
                                </div>
                                <div class="transport-info">
                                    <h4>Автобус</h4>
                                    <p>Остановка "Красная площадь", маршруты: м5, м8, м53</p>
                                </div>
                            </div>
                            <div class="transport-item">
                                <div class="transport-icon">
                                    <i class="icon-car"></i>
                                </div>
                                <div class="transport-info">
                                    <h4>Личный транспорт</h4>
                                    <p>Парковка на улице, платная с 9:00 до 21:00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="faq-section">
                    <h2>Частые вопросы</h2>
                    <div class="faq-list">
                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Нужно ли записываться заранее?</h3>
                                <i class="icon-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Да, рекомендуем записываться за 1-2 дня, чтобы гарантировать свободное время у мастера.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Есть ли у вас скидки и акции?</h3>
                                <i class="icon-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Да, у нас действует программа лояльности и регулярные акции. Следите за новостями в наших социальных сетях.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Можно ли отменить запись?</h3>
                                <i class="icon-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Да, можно отменить запись не позднее чем за 2 часа до назначенного времени.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <div class="faq-question">
                                <h3>Принимаете ли вы подарочные сертификаты?</h3>
                                <i class="icon-chevron-down"></i>
                            </div>
                            <div class="faq-answer">
                                <p>Да, у нас есть подарочные сертификаты на любые услуги. Можно приобрести онлайн или в салоне.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
