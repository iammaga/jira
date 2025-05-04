<p align="center">
    <img src="https://img2.storyblok.com/filters:format(webp)/f/84825/499x244/9266fa6ddf/__jira-unnamed.png" width="200" alt="Jira Logo">
</p>

## О проекте
___
Проект на Laravel для управления задачами и проектами наподобие Jira.

✔️ Поддержка ролей/разрешений через Laratrust<br>
✔️ Управление проектами, задачами, спринтами и релизами<br>
✔️ Админ-панель для управления ролями и правами<br>
✔️ REST API для взаимодействия с фронтендом

## Требования
___
Убедитесь, что у вас установлены следующие зависимости:

- **PHP** >= 8.1
- **Composer**
- **Node.js** и **npm**
- **MySQL**

## Установка проекта
___
Следуйте шагам ниже для локальной установки и запуска проекта.

### 1. Клонирование репозитория

```bash
git clone https://github.com/iammaga/jira.git
cd jira
```

### 2. Установка зависимостей

```bash
composer install
npm install && npm run dev
```

### 3. Настройка `.env`

```bash
cp .env.example .env
```

Откройте файл `.env` и укажите параметры подключения к базе данных:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jira
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Генерация ключа приложения

```bash
php artisan key:generate
```

### 5. Запуск миграций и сидеров

```bash
php artisan migrate --seed
```

### 6. Запуск локального сервера

```bash
php artisan serve
```

### 7. Данные для входа

Администратор

```bash
email => admin@admin.com
password => password
```

Обычный пользователь

```bash
email => admin@admin.com
password => password
```

Откройте браузер и перейдите по адресу [http://localhost:8000](http://localhost:8000).

## Контакты
___
Разработчик: **Muhammad Zikirzoda**  
GitHub: [iammaga](https://github.com/iammaga/)
