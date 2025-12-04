# Локальний запуск inmunoflam.com.ua

## Варіант 1: Docker (рекомендовано)

### Вимоги:
- Docker
- Docker Compose

### Запуск:

```bash
cd "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)"

# Запустити всі сервіси
docker-compose up -d

# Перевірити статус
docker-compose ps

# Переглянути логи
docker-compose logs -f web
```

### Доступ:
- **Сайт**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081 (користувач: root, пароль: root)

### Зупинка:
```bash
docker-compose down
```

### Видалення всього (включно з БД):
```bash
docker-compose down -v
```

---

## Варіант 2: XAMPP/LAMP (вручну)

### Вимоги:
- PHP 7.4
- MySQL 5.7+
- Apache

### Кроки:

1. **Встановити XAMPP** (або LAMP):
   ```bash
   # Для Ubuntu/Debian
   sudo apt install php7.4 php7.4-mysql mysql-server apache2
   ```

2. **Розпакувати дамп БД**:
   ```bash
   gunzip -c is501201_inm.2025-11-20.sql.gz > dump.sql
   ```

3. **Імпортувати БД**:
   ```bash
   mysql -u root -p
   CREATE DATABASE is501201_inm CHARACTER SET utf8 COLLATE utf8_general_ci;
   exit
   
   mysql -u root -p is501201_inm < dump.sql
   ```

4. **Налаштувати Apache**:
   
   Створити файл `/etc/apache2/sites-available/inmunoflam.conf`:
   ```apache
   <VirtualHost *:80>
       ServerName localhost
       DocumentRoot "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)/www/www"
       
       <Directory "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)/www/www">
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
   
   Активувати:
   ```bash
   sudo a2ensite inmunoflam
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```

5. **Оновити конфігурацію БД** у файлі `www/www/settings/conf.php`:
   ```php
   $glb["db_host"]="localhost";
   $glb["db_basename"]="is501201_inm";
   $glb["db_user"]="root";
   $glb["db_password"]="ваш_пароль";
   ```

6. **Відкрити**: http://localhost

---

## Варіант 3: Вбудований PHP-сервер (тільки для тестування)

⚠️ **Увага**: Не підтримує `.htaccess`, SEO-адреси не працюватимуть!

```bash
cd "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)/www/www"

# Потрібен PHP 7.4
php -S localhost:8080
```

Відкрити: http://localhost:8080

---

## Проблеми та рішення

### Помилка: "mysql_connect() deprecated"
Сайт використовує старі функції MySQL. Потрібен PHP 7.4 або нижче.

### Помилка підключення до БД
Перевірте:
1. MySQL запущений: `sudo systemctl status mysql`
2. Правильні дані в `settings/conf.php`
3. База даних створена: `mysql -u root -p -e "SHOW DATABASES;"`

### Не працюють SEO-адреси
1. Перевірте `.htaccess` у кореневій директорії
2. Увімкніть mod_rewrite: `sudo a2enmod rewrite`
3. Перезапустіть Apache: `sudo systemctl restart apache2`

### Не застосовуються стилі
✅ Вже виправлено! Файл `style.css` відновлено.

---

## Структура проекту

```
inmunoflam.com.ua(Резерв)/
├── www/www/                    # Корінь сайту
│   ├── index.php              # Головний файл
│   ├── .htaccess              # Правила Apache
│   ├── settings/              # Налаштування
│   │   ├── conf.php          # Конфігурація БД
│   │   └── connect.php       # Підключення до БД
│   ├── templates/shop1/       # Шаблони
│   │   ├── css/style.css     # ✅ Відновлено
│   │   └── main.tpl          # Головний шаблон
│   └── modules/               # Модулі CMS
├── is501201_inm.2025-11-20.sql.gz  # Дамп БД
└── docker-compose.yml         # Docker конфігурація
```

---

## Корисні команди

### Docker:
```bash
# Перезапустити контейнер
docker-compose restart web

# Зайти в контейнер
docker exec -it inmunoflam_web bash

# Переглянути логи MySQL
docker-compose logs -f db
```

### MySQL:
```bash
# Підключитися до БД
mysql -h localhost -u is501201_inm -p is501201_inm

# Експортувати БД
mysqldump -u root -p is501201_inm > backup.sql
```
