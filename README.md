# MilkShop

Інтернет-магазин молочної продукції.

## Розгортання на Render.com

### Варіант 1: Використання Blueprint

1. Форкніть цей репозиторій на GitHub
2. Увійдіть на [Render.com](https://render.com)
3. Натисніть "New" → "Blueprint"
4. Підключіть свій GitHub акаунт і виберіть форкнутий репозиторій
5. Натисніть "Apply Blueprint"

Render автоматично налаштує веб-сервіс та базу даних PostgreSQL, використовуючи конфігурацію з файлу `render.yaml`.

### Варіант 2: Ручне налаштування

#### Налаштування бази даних

1. На Render.com створіть нову PostgreSQL базу даних:
   - Перейдіть до "New" → "PostgreSQL"
   - Введіть ім'я: "milkshop-db"
   - Виберіть регіон та план відповідно до ваших потреб
   - Натисніть "Create Database"
   - Збережіть відображені параметри підключення (особливо внутрішню URL)

#### Налаштування веб-сервісу

1. На Render.com створіть новий веб-сервіс:
   - Перейдіть до "New" → "Web Service"
   - Підключіть свій GitHub репозиторій
   - Виберіть гілку для розгортання (зазвичай "main" або "master")
   - Вкажіть ім'я: "milkshop"
   - Виберіть тип: "Docker"
   - Виберіть регіон і план
   - Додайте змінні середовища:
     - `APP_ENV`: production
     - `APP_DEBUG`: false
     - `APP_KEY`: додайте вручну або натисніть "Generate"
     - `DB_CONNECTION`: pgsql
     - `DB_HOST`: [ваш database host з попереднього кроку]
     - `DB_PORT`: [ваш database port з попереднього кроку]
     - `DB_DATABASE`: [ваш database name з попереднього кроку]
     - `DB_USERNAME`: [ваш database username з попереднього кроку]
     - `DB_PASSWORD`: [ваш database password з попереднього кроку]
     - `LOG_CHANNEL`: stderr
   - Build Command: `./render-build.sh`
   - Start Command: `cd src && php artisan serve --host=0.0.0.0 --port=$PORT`

2. Натисніть "Create Web Service"

## Локальний розвиток

Для локального запуску проекту:

```bash
# Клонуємо репозиторій
git clone [url] milkshop
cd milkshop

# Запускаємо контейнери
docker-compose up -d

# Встановлюємо залежності
docker-compose exec app composer install

# Виконуємо міграції
docker-compose exec app php artisan migrate

# Доступ за адресою
http://localhost:8181
``` 