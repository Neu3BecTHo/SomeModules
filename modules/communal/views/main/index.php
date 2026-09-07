<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
$this->title = 'Коммуналка';
?>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px; padding-top: 20px;">
    
    <div style="display: flex; flex-direction: column; justify-content: center;">
        <h1 style="font-size: 42px; font-weight: 800; line-height: 1.1; margin-bottom: 16px;">
            Портал <span style="color: var(--c-accent);">«Коммуналка»</span>
        </h1>
        <p style="font-size: 18px; color: var(--c-text-muted); margin-bottom: 32px;">
            Удобный сервис для передачи показаний счетчиков и оплаты услуг ЖКХ.
            Контролируйте расходы онлайн.
        </p>
        
        <div style="display: flex; gap: 16px;">
            <?php if (Yii::$app->userCommunal->isGuest): ?>
                <a href="<?= Url::to(['/communal/auth/login']) ?>" class="c-btn c-btn-primary" style="padding: 10px 24px;">Войти</a>
                <a href="<?= Url::to(['/communal/auth/register']) ?>" class="c-btn c-btn-outline" style="padding: 10px 24px;">Регистрация</a>
            <?php else: ?>
                <a href="<?= Url::to(['/communal/request/create']) ?>" class="c-btn c-btn-primary" style="padding: 10px 24px;">Передать показания</a>
            <?php endif; ?>
        </div>
    </div>

    <div style="position: relative; height: 320px; background: var(--c-surface); border-radius: var(--c-radius); overflow: hidden; border: 1px solid var(--c-border);">
        <div class="c-slider-track" style="height: 100%;">

            <div class="c-slide" style="display: flex; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1e293b, #0f172a);">
                <?= Html::img('@web/images/slide1.jpg', ['style' => 'max-width: 100%; max-height: 100%;', 'alt' => 'Слайд 1 - Передача показаний счетчиков']) ?>
            </div>
            <div class="c-slide" style="display: none; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #0f172a, #334155);">
                <?= Html::img('@web/images/slide2.jpg', ['style' => 'max-width: 100%; max-height: 100%;', 'alt' => 'Слайд 1 - Передача показаний счетчиков']) ?>
            </div>
            <div class="c-slide" style="display: none; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #334155, #1e293b);">
                <?= Html::img('@web/images/slide3.jpg', ['style' => 'max-width: 100%; max-height: 100%;', 'alt' => 'Слайд 1 - Передача показаний счетчиков']) ?>
            </div>
            <div class="c-slide" style="display: none; align-items: center; justify-content: center; height: 100%; background: linear-gradient(45deg, #1e293b, #0f172a);">
                <?= Html::img('@web/images/slide4.jpg', ['style' => 'max-width: 100%; max-height: 100%;', 'alt' => 'Слайд 1 - Передача показаний счетчиков']) ?>
            </div>
        </div>
        
        <button onclick="prevSlide()" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); border: none; color: white; cursor: pointer; padding: 10px; border-radius: 50%;">❮</button>
        <button onclick="nextSlide()" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.5); border: none; color: white; cursor: pointer; padding: 10px; border-radius: 50%;">❯</button>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; margin-bottom: 60px;">
    
    <div>
        <h3 style="font-size: 16px; text-transform: uppercase; color: var(--c-text-muted); margin-bottom: 20px;">Как передать показания</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div style="background: var(--c-surface); padding: 20px; border-radius: var(--c-radius); border: 1px solid var(--c-border);">
                <h4 style="margin: 0 0 10px 0;">1. Снимите данные</h4>
                <p style="font-size: 14px; color: var(--c-text-muted); margin: 0;">
                    Запишите целую часть цифр со счетчика. Не учитывайте цифры после запятой (красные).
                </p>
            </div>
            <div style="background: var(--c-surface); padding: 20px; border-radius: var(--c-radius); border: 1px solid var(--c-border);">
                <h4 style="margin: 0 0 10px 0;">2. Введите в форму</h4>
                <p style="font-size: 14px; color: var(--c-text-muted); margin: 0;">
                    Авторизуйтесь, выберите услугу и впишите текущие показания. Расход рассчитается автоматически.
                </p>
            </div>
        </div>
    </div>

    <div style="background: rgba(56, 189, 248, 0.1); padding: 24px; border-radius: var(--c-radius); border: 1px solid rgba(56, 189, 248, 0.2);">
        <h3 style="margin: 0 0 10px 0; color: var(--c-accent);">Сроки подачи</h3>
        <p style="font-size: 32px; font-weight: 700; margin: 0 0 10px 0;">до 25 числа</p>
        <p style="font-size: 14px; color: var(--c-text-muted); margin: 0;">
            Пожалуйста, не откладывайте передачу показаний на последний день месяца.
        </p>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 30px; margin-bottom: 40px;">
    
    <div>
        <h3 style="font-size: 16px; margin-bottom: 20px;">Актуальные тарифы</h3>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--c-border);">
            <span style="color: var(--c-text-muted);">Свет</span>
            <span style="font-weight: 500;">5,03 ₽</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--c-border);">
            <span style="color: var(--c-text-muted);">Газ</span>
            <span style="font-weight: 500;">7,39 ₽</span>
        </div>
        <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--c-border);">
            <span style="color: var(--c-text-muted);">Вода</span>
            <span style="font-weight: 500;">48,24 ₽</span>
        </div>
    </div>

    <div>
        <h3 style="font-size: 16px; margin-bottom: 20px;">Новости</h3>
        <div style="margin-bottom: 20px;">
            <div style="font-size: 12px; color: var(--c-accent); margin-bottom: 4px;">20.12.2025</div>
            <div style="font-weight: 500;">Работы на линии</div>
            <div style="font-size: 13px; color: var(--c-text-muted);">Возможны отключения света 22–23 числа.</div>
        </div>
        <div>
            <div style="font-size: 12px; color: var(--c-accent); margin-bottom: 4px;">15.12.2025</div>
            <div style="font-weight: 500;">Обновление системы</div>
            <div style="font-size: 13px; color: var(--c-text-muted);">Добавлен раздел FAQ и документы.</div>
        </div>
    </div>

    <div>
        <h3 style="font-size: 16px; margin-bottom: 20px;">Контакты</h3>
        <div style="margin-bottom: 16px;">
            <div style="font-size: 13px; color: var(--c-text-muted); margin-bottom: 4px;">Телефон поддержки</div>
            <a href="tel:80000000000" style="font-size: 18px; font-weight: 500;">8 (000) 000-00-00</a>
        </div>
        <div style="margin-bottom: 16px;">
            <div style="font-size: 13px; color: var(--c-text-muted); margin-bottom: 4px;">Email</div>
            <a href="mailto:support@kommunalka.ru">support@kommunalka.ru</a>
        </div>
        <div style="font-size: 13px; color: var(--c-text-muted);">
            Чат доступен в личном кабинете с 9:00 до 21:00.
        </div>
    </div>
</div>

<!-- Скрипт слайдера (простой, без библиотек) -->
<script>
    let slideIndex = 0;
    const slides = document.querySelectorAll('.c-slide');
    
    function showSlide(n) {
        slides.forEach(s => s.style.display = 'none'); // скрываем все
        slideIndex = (n + slides.length) % slides.length; // циклический индекс
        slides[slideIndex].style.display = 'flex'; // показываем нужный (flex для центровки)
    }
    
    function nextSlide() { showSlide(slideIndex + 1); }
    function prevSlide() { showSlide(slideIndex - 1); }
    
    // Автопереключение каждые 3 секунды (по ТЗ)
    setInterval(nextSlide, 3000);
</script>
