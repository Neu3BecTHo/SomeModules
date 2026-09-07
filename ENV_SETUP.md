# Настройка переменных окружения (.env)

## Обзор

Проект использует файл `.env` для хранения конфиденциальной информации, такой как учетные данные базы данных, пароли почты и другие настройки.

## Установка

1. **Скопируйте пример файла .env.example:**
   ```bash
   cp .env.example .env
   ```

2. **Отредактируйте .env файл:**
   ```bash
   nano .env
   # или
   vim .env
   ```

3. **Настройте переменные окружения:**

### Database Configuration
```bash
DB_HOST=localhost
DB_PORT=3306
DB_NAME=belonogova
DB_USER=your_db_user
DB_PASSWORD=your_db_password
DB_CHARSET=utf8
```

### Cookie Validation Key
```bash
COOKIE_VALIDATION_KEY=ваш-случайный-секретный-ключ
```
**Важно:** Сгенерируйте уникальный ключ для production!

### Mailer Configuration
```bash
MAILER_TRANSPORT_SCHEME=smtps
MAILER_HOST=smtp.gmail.com
MAILER_PORT=465
MAILER_USERNAME=your-email@gmail.com
MAILER_PASSWORD="your-app-password"
MAILER_USE_FILE_TRANSPORT=false
```

**Примечание:** Для Gmail используйте App Password, а не обычный пароль аккаунта!

### SSL Configuration for Mailer
```bash
MAILER_SSL_ALLOW_SELF_SIGNED=false
MAILER_SSL_VERIFY_PEER=true
MAILER_SSL_VERIFY_PEER_NAME=true
```

### Application Environment
```bash
YII_ENV=prod
YII_DEBUG=false
```

### Admin Email
```bash
ADMIN_EMAIL=admin@yourdomain.com
SENDER_EMAIL=noreply@yourdomain.com
SENDER_NAME=Your App Name
```

## Безопасность

### ⚠️ КРИТИЧЕСКИ ВАЖНО:

1. **Никогда не коммитить .env файл в репозиторий!**
   - Файл `.env` уже добавлен в `.gitignore`
   - Используйте только `.env.example` в репозитории

2. **Используйте разные пароли для разных окружений:**
   - Development: `.env`
   - Production: `.env.production`

3. **Сгенерируйте уникальный COOKIE_VALIDATION_KEY:**
   ```bash
   # Генерация случайного ключа
   openssl rand -base64 32
   ```

4. **Используйте App Password для Gmail:**
   - Не используйте обычный пароль Gmail
   - Создайте App Password в настройках Google Account

## Проверка конфигурации

После настройки .env файла, проверьте, что переменные загружаются:

```bash
php -r "require __DIR__ . '/vendor/autoload.php'; \$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); \$dotenv->load(); echo 'DB_HOST: ' . \$_ENV['DB_HOST'] . PHP_EOL; echo 'COOKIE_VALIDATION_KEY: ' . substr(\$_ENV['COOKIE_VALIDATION_KEY'], 0, 10) . '...' . PHP_EOL;"
```

## Разные окружения

### Development (.env)
```bash
YII_ENV=dev
YII_DEBUG=true
```

### Production (.env.production)
```bash
YII_ENV=prod
YII_DEBUG=false
```

## Troubleshooting

### Переменные не загружаются
- Убедитесь, что файл .env существует в корне проекта
- Проверьте права доступа к файлу
- Убедитесь, что vlucas/phpdotenv установлен

### Ошибка синтаксиса в .env
- Значения с пробелами должны быть в кавычках: `MAILER_PASSWORD="my password"`
- Комментарии начинаются с `#`
- Пустые строки игнорируются

## Дополнительные ресурсы

- [vlucas/phpdotenv документация](https://github.com/vlucas/phpdotenv)
- [Yii2 Environment Variables](https://www.yiiframework.com/doc/guide/2.0/en/concept-configurations#environment-variables)
