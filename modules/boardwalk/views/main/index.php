    <?php
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\helpers\ArrayHelper;
    use yii\widgets\MaskedInput;

    /** @var yii\web\View $this */
    /** @var app\modules\boardwalk\models\Games[] $popularGames */
    /** @var app\modules\boardwalk\models\Games[] $catalogGames */
    /** @var app\modules\boardwalk\models\GameSessions[] $sessions */
    /** @var app\modules\boardwalk\models\Reviews[] $reviews */
    /** @var app\modules\boardwalk\models\Booking $bookingModel */
    /** @var app\modules\boardwalk\models\Subscriptions $subscriptionModel */

    $this->title = 'Boardwalk — Настольные игры для любой компании';
    ?>

    <main class="main-page">
        <!-- 1. ГЕРОЙ И ЛОГОТИП -->
        <section class="hero-section">
            <div class="container hero-content">
                <div class="hero-logo">🎲 Boardwalk</div>
                <h1 class="hero-title">Настольные игры для любой компании</h1>
                <p class="hero-subtitle">Найди свою игру, собери компанию и погрузись в мир приключений в самом сердце Кургана.</p>
                <div class="hero-btns">
                    <a href="#booking" class="btn btn-primary">Записаться на игру</a>
                    <a href="#catalog" class="btn btn-outline">Смотреть каталог</a>
                </div>
            </div>
        </section>

        <!-- 2. О НАС -->
        <section id="about" class="section">
            <div class="container">
                <h2 class="section-title">О нас</h2>
                <div class="about-card">
                    <p>Мы — крупнейшее сообщество любителей настолок. В нашей коллекции более 100 игр: от простых пати-геймов до сложных экономических стратегий. Проводим турниры, обучаем новичков и создаем уютную атмосферу для каждого гостя [web:335].</p>
                </div>
            </div>
        </section>

        <!-- 3. СЛАЙДЕР ПОПУЛЯРНЫХ ИГР -->
        <?php if ($popularGames): ?>
        <section class="section section--gray">
            <div class="container">
                <h2 class="section-title">Популярные игры</h2>
                <div class="slider-wrapper">
                    <div class="game-slider">
                        <?php foreach ($popularGames as $game): ?>
                            <div class="slider-item">
                                <div class="slider-img" style="background-image: url('<?= Html::encode($game->image ?: '/images/default.jpg') ?>')"></div>
                                <div class="slider-info">
                                    <h3><?= Html::encode($game->title) ?></h3>
                                    <p><?= Html::encode($game->short_description) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- 4. КАТАЛОГ -->
        <section id="catalog" class="section">
            <div class="container">
                <h2 class="section-title">Каталог настольных игр</h2>
                <div class="game-grid">
                    <?php foreach ($catalogGames as $game): ?>
                        <article class="game-card">
                            <span class="category-tag"><?= Html::encode($game->category ?? 'Игра') ?></span>
                            <h3><?= Html::encode($game->title) ?></h3>
                            <p><?= Html::encode($game->short_description) ?></p>
                            <div class="game-meta">👥 <?= $game->min_players ?>-<?= $game->max_players ?> чел.</div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- 5. ГРАФИК ИГР -->
        <section id="schedule" class="section section--gray">
            <div class="container">
                <h2 class="section-title">График игр на месяц</h2>
                <div class="table-container">
                    <table class="schedule-table">
                        <thead>
                            <tr>
                                <th>Дата и время</th>
                                <th>Игра / Вид</th>
                                <th>Свободно</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($sessions as $session): ?>
                            <tr>
                                <td><strong><?= Yii::$app->formatter->asDatetime($session->start_at, 'php:d M, H:i') ?></strong></td>
                                <td><?= Html::encode($session->game->title) ?> <br><small><?= Html::encode($session->game->category) ?></small></td>
                                <td><a href="#booking" class="btn btn-primary btn-sm">Выбрать</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- 6. ПРОФИЛЬ / ЛИЧНЫЙ КАБИНЕТ -->
        <section id="profile" class="section">
            <div class="container">
                <h2 class="section-title">Профиль</h2>
                <div class="profile-box">
                    <?php if (Yii::$app->userBoardwalk->isGuest): ?>
                        <div class="profile-content">
                            <p>Авторизуйтесь, чтобы управлять своими записями и получать бонусы клуба.</p>
                            <div class="btn-group">
                                <a href="<?= Url::to(['auth/login']) ?>" class="btn btn-outline">Войти</a>
                                <a href="<?= Url::to(['auth/signup']) ?>" class="btn btn-primary">Регистрация</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="profile-content">
                            <p>Вы вошли как <strong><?= Html::encode(Yii::$app->userBoardwalk->identity->fullName()) ?></strong></p>
                            <div class="btn-group">
                                <a href="<?= Url::to(['/boardwalk/booking/index']) ?>" class="btn btn-primary">Мои заявки</a>
                                <?= Html::beginForm(['auth/logout'], 'post') . Html::submitButton('Выйти', ['class' => 'btn btn-outline']) . Html::endForm() ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- 7. ЗАПИСЬ НА ИГРУ -->
        <section id="booking" class="section section--gray">
            <div class="container">
                <h2 class="section-title">Запись на игру</h2>
                <div class="booking-form-wrapper">
                    <?php $form = ActiveForm::begin(['action' => ['main/booking'], 'options' => ['class' => 'dark-form']]); ?>
                        <div class="form-grid">
                            <?= $form->field($bookingModel, 'name')->textInput(['placeholder' => 'Ваше ФИО']) ?>
                            <?= $form->field($bookingModel, 'phone')->widget(MaskedInput::class, [
                                'mask' => '8(999)999-99-99',
                            ]) ?>
                        </div>
                        <div class="form-grid">
                            <?= $form->field($bookingModel, 'game_type')->dropDownList([
                                'Стратегии' => 'Стратегии',
                                'Карточные' => 'Карточные',
                                'Для детей' => 'Для детей'
                            ], ['prompt' => 'Вид игры']) ?>
                            <?= $form->field($bookingModel, 'session_id')->dropDownList(
                                ArrayHelper::map($sessions, 'id', function($s) {
                                    return $s->game->title . ' (' . date('d.m H:i', strtotime($s->start_at)) . ')';
                                }),
                                ['prompt' => 'Название игры и время']
                            ) ?>
                        </div>
                        <?= $form->field($bookingModel, 'agree')->checkbox(['label' => 'Согласен на обработку персональных данных']) ?>
                        <button type="submit" class="btn btn-primary" style="width: 100%">Забронировать место</button>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </section>

        <!-- 8. ПОДПИСКА -->
        <section class="section">
            <div class="container">
                <div class="subscribe-banner">
                    <div class="subscribe-text">
                        <h2>Подписка на новости</h2>
                        <p>Анонсы новых игр и турниров прямо на почту [web:325].</p>
                    </div>
                    <?php $form = ActiveForm::begin(['action' => ['#'], 'options' => ['class' => 'subscribe-form-inline']]); ?>
                        <div class="input-group">
                            <?= $form->field($subscriptionModel, 'email')->input('email', ['placeholder' => 'Ваш E-mail'])->label(false) ?>
                            <button type="submit" class="btn btn-primary">Подписаться</button>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </section>

        <!-- 9. ОТЗЫВЫ -->
        <section id="reviews" class="section section--gray">
            <div class="container">
                <h2 class="section-title">Отзывы участников</h2>
                <div class="reviews-grid">
                    <?php foreach ($reviews as $review): ?>
                        <div class="review-card">
                            <div class="quote">«<?= Html::encode($review->text) ?>»</div>
                            <div class="author"><?= Html::encode($review->author_name) ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- 10. КОНТАКТЫ -->
        <section id="contacts" class="section">
            <div class="container">
                <h2 class="section-title">Контакты</h2>
                <div class="contacts-grid">
                    <div class="contacts-info">
                        <p>📍 <strong>Адрес:</strong> г. Курган, ул. Настольная, 42</p>
                        <p>📞 <strong>Телефон:</strong> 8(800)555-35-35</p>
                        <p>✉️ <strong>Email:</strong> play@boardwalk.ru</p>
                    </div>
                    <div class="contacts-map">
                        <div class="map-stub">Карта Кургана</div>
                    </div>
                </div>
            </div>
        </section>
    </main>
