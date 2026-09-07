<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'О нас - Салон красоты Виктория';
?>
<div class="beauty-container">
    <section class="about-page">
        <div class="container">
            <div class="about-header">
                <h1>О салоне красоты "Виктория"</h1>
                <p>История, философия и ценности нашего салона</p>
            </div>

            <div class="about-content">
                <div class="about-story">
                    <h2>Наша история</h2>
                    <div class="story-content">
                        <p>Салон красоты "Виктория" был основан в 2015 году с мечтой создать место, где каждая женщина сможет раскрыть свою индивидуальность и почувствовать себя по-настоящему красивой.</p>
                        <p>За годы работы мы стали одним из ведущих салонов в центре Москвы, завоевав доверие тысяч клиенток благодаря нашему профессионализму, вниманию к деталям и индивидуальному подходу.</p>
                        <p>Название "Виктория" символизирует победу - победу над несовершенствами, победу над плохим настроением, победу в поиске своей уникальности.</p>
                    </div>
                </div>

                <div class="about-mission">
                    <h2>Наша миссия</h2>
                    <div class="mission-content">
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="icon-heart"></i>
                            </div>
                            <div class="mission-text">
                                <h3>Красота для всех</h3>
                                <p>Мы верим, что красота доступна каждой женщине, независимо от возраста, типа внешности или стиля жизни.</p>
                            </div>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="icon-star"></i>
                            </div>
                            <div class="mission-text">
                                <h3>Профессионализм</h3>
                                <p>Наши мастера постоянно совершенствуют свое мастерство, следят за трендами и используют только качественные материалы.</p>
                            </div>
                        </div>
                        <div class="mission-item">
                            <div class="mission-icon">
                                <i class="icon-shield"></i>
                            </div>
                            <div class="mission-text">
                                <h3>Безопасность</h3>
                                <p>Мы гарантируем стерильность, безопасность процедур и использование сертифицированной косметики.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="about-team">
                    <h2>Наша команда</h2>
                    <div class="team-content">
                        <p>В команде "Виктории" работают только высококвалифицированные специалисты с многолетним опытом работы:</p>
                        <ul class="team-list">
                            <li><strong>Парикмахеры-стилисты</strong> - специалисты по стрижкам, окрашиванию и укладкам</li>
                            <li><strong>Мастера маникюра и педикюра</strong> - эксперты по ногтевому сервису</li>
                            <li><strong>Косметологи</strong> - специалисты по уходу за кожей лица и тела</li>
                            <li><strong>Массажисты</strong> - мастера расслабляющего и лечебного массажа</li>
                        </ul>
                        <p>Каждый мастер проходит регулярное обучение и аттестацию, чтобы соответствовать высоким стандартам качества.</p>
                    </div>
                </div>

                <div class="about-features">
                    <h2>Наши преимущества</h2>
                    <div class="features-grid">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="icon-clock"></i>
                            </div>
                            <h3>Удобное время работы</h3>
                            <p>Ежедневно с 9:00 до 20:00, без выходных</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="icon-map-marker"></i>
                            </div>
                            <h3>Центральное расположение</h3>
                            <p>Удобно добраться общественным транспортом</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="icon-award"></i>
                            </div>
                            <h3>Качественные материалы</h3>
                            <p>Используем только проверенные бренды косметики</p>
                        </div>
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="icon-gift"></i>
                            </div>
                            <h3>Программа лояльности</h3>
                            <p>Скидки и бонусы для постоянных клиентов</p>
                        </div>
                    </div>
                </div>

                <div class="about-services">
                    <h2>Наши услуги</h2>
                    <div class="services-overview">
                        <div class="service-category">
                            <h3>Парикмахерские услуги</h3>
                            <ul>
                                <li>Стрижки и укладки</li>
                                <li>Окрашивание и мелирование</li>
                                <li>Лечение волос</li>
                                <li>Свадебные и вечерние прически</li>
                            </ul>
                        </div>
                        <div class="service-category">
                            <h3>Ногтевой сервис</h3>
                            <ul>
                                <li>Маникюр с покрытием</li>
                                <li>Педикюр</li>
                                <li>Наращивание ногтей</li>
                                <li>Дизайн ногтей</li>
                            </ul>
                        </div>
                        <div class="service-category">
                            <h3>Косметология</h3>
                            <ul>
                                <li>Чистки и пилинги</li>
                                <li>Массаж лица</li>
                                <li>Уходовые процедуры</li>
                                <li>Депиляция</li>
                            </ul>
                        </div>
                        <div class="service-category">
                            <h3>Массаж</h3>
                            <ul>
                                <li>Расслабляющий массаж</li>
                                <li>Лечебный массаж</li>
                                <li>Антицеллюлитный</li>
                                <li>Стоун-терапия</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="about-cta">
                    <div class="cta-content">
                        <h2>Готовы раскрыть свою красоту?</h2>
                        <p>Запишитесь на консультацию или услугу уже сегодня!</p>
                        <div class="cta-buttons">
                            <?= Html::a('Записаться на услугу', ['/beauty/main/catalog'], ['class' => 'btn btn-primary btn-large']) ?>
                            <?= Html::a('Консультация', ['/beauty/main/contacts'], ['class' => 'btn btn-outline btn-large']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
