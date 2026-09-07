<?php

/* @var $this yii\web\View */
/* @var $exception yii\web\HttpException|null */

use yii\helpers\Html;

$statusCode = $exception ? $exception->statusCode : 500;
$messages = [
    404 => ['Страница не найдена', 'Кажется, вы заблудились. Страница, которую вы ищете, не существует или была перемещена.'],
    403 => ['Доступ запрещен', 'У вас нет прав для доступа к этой странице.'],
    500 => ['Ошибка сервера', 'Что-то пошло не так на нашей стороне. Мы уже работаем над исправлением.'],
    503 => ['Сервис недоступен', 'Сервис временно недоступен. Попробуйте позже.'],
];

$message = $messages[$statusCode] ?? ['Ошибка', $exception ? Html::encode($exception->getMessage()) : 'Произошла неизвестная ошибка.'];

$this->title = $message[0] . ' — ' . $statusCode;
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= Html::encode($this->title) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
            width: 100%;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 1rem;
        }
        .error-icon {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            display: block;
        }
        .error-title {
            font-size: 2rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1rem;
        }
        .error-description {
            font-size: 1.1rem;
            color: #718096;
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .error-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .error-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }
        .error-btn--primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }
        .error-btn--primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }
        .error-btn--secondary {
            background: white;
            color: #4a5568;
            border: 2px solid #e2e8f0;
        }
        .error-btn--secondary:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
        }
        .error-modules {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(0,0,0,0.1);
        }
        .error-modules-title {
            font-size: 0.9rem;
            color: #a0aec0;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .error-modules-list {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .error-module-link {
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 20px;
            font-size: 0.85rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .error-module-link:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        @media (max-width: 480px) {
            .error-code { font-size: 5rem; }
            .error-icon { font-size: 3.5rem; }
            .error-title { font-size: 1.5rem; }
            .error-actions { flex-direction: column; }
            .error-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon"><?= ['404' => '🕳️', '403' => '🚫', '500' => '💥', '503' => '🔧'][$statusCode] ?? '⚠️' ?></div>
        <div class="error-code"><?= $statusCode ?></div>
        <h1 class="error-title"><?= $message[0] ?></h1>
        <p class="error-description"><?= $message[1] ?></p>
        <div class="error-actions">
            <a href="/" class="error-btn error-btn--primary"><span>🏠</span><span>На главную</span></a>
            <a href="javascript:history.back()" class="error-btn error-btn--secondary"><span>←</span><span>Назад</span></a>
        </div>
        <div class="error-modules">
            <div class="error-modules-title">Перейти к модулю</div>
            <div class="error-modules-list">
                <a href="/communal" class="error-module-link">Коммуналка</a>
                <a href="/breadHouse" class="error-module-link">Хлебный дворик</a>
                <a href="/beauty" class="error-module-link">Beauty</a>
                <a href="/boardwalk" class="error-module-link">Набережная</a>
                <a href="/tours" class="error-module-link">Туры</a>
                <a href="/cleaner" class="error-module-link">Клинер</a>
            </div>
        </div>
    </div>
</body>
</html>
