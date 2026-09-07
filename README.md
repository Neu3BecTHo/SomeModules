# Belonogova

PHP-приложение на Yii2 Basic с поддержкой Docker, PostgreSQL/MySQL, Codeception-тестами и SMTP-почтой.

## Технологии

- **Backend:** PHP 8.1+, Yii 2.0.55, Bootstrap 5
- **База данных:** PostgreSQL 16, MySQL 8.0
- **Тестирование:** Codeception
- **Почта:** Symfony Mailer
- **Dev:** Docker Compose

## Требования

- PHP >= 8.1
- Composer
- Docker / Docker Compose
- Node.js / Bower (опционально)

## Локальный запуск

### Через Docker

```bash
docker-compose up -d
```

Приложение откроется на `http://127.0.0.1:8000`.

### Локально без Docker

```bash
composer install
cp .env.example .env
# Настройте подключение к БД в config/web.php
php yii serve
```

## Переменные окружения

| Переменная | Обязательная | Описание |
|---|---|---|
| `DB_HOST` | да | Хост базы данных |
| `DB_PORT` | да | Порт базы данных |
| `DB_NAME` | да | Имя базы данных |
| `DB_USER` | да | Пользователь БД |
| `DB_PASSWORD` | да | Пароль БД |
| `DB_CHARSET` | нет | Кодировка (по умолчанию `utf8`) |
| `COOKIE_VALIDATION_KEY` | да | Секретный ключ для cookie |
| `MAILER_TRANSPORT_SCHEME` | нет | SMTP схема (`smtps`) |
| `MAILER_HOST` | нет | SMTP хост |
| `MAILER_PORT` | нет | SMTP порт |
| `MAILER_USERNAME` | нет | SMTP пользователь |
| `MAILER_PASSWORD` | нет | SMTP пароль |
| `YII_ENV` | нет | Окружение (`dev`/`prod`) |
| `YII_DEBUG` | нет | Режим отладки |

## Тестирование

```bash
vendor/bin/codecept run
```

Доступные suites:
- `unit` — модульные тесты
- `functional` — функциональные тесты
- `acceptance` — acceptance тесты (требует Selenium)

## Структура проекта

```
app/           - приложение (config, контроллеры, модели)
commands/      - консольные команды
config/        - конфигурации
controllers/   - веб-контроллеры
mail/          - шаблоны писем
migrations/    - миграции БД
models/        - модели данных
tests/         - тесты
views/         - представления
web/           - веб-корень (entry script)
widgets/       - виджеты
```

## Безопасность

- Никогда не коммитьте `.env` в репозиторий
- Используйте разные пароли для dev/prod окружений
- Сгенерируйте уникальный `COOKIE_VALIDATION_KEY`
- Для Gmail используйте App Password
