# Быстрый старт: Диагностика проблем с отображением страниц

## Что сделано

✅ Установлена система комплексного логирования
✅ Логи записываются в `www/www/logs/debug.log`
✅ Создан скрипт `view_logs.sh` для просмотра логов

## Что делать дальше

### 1. Исправьте HTML-сущности (если еще не сделали)

```bash
cd "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)"
./fix_html_entities.sh
```

### 2. Запустите сайт

```bash
./start.sh
```

### 3. Откройте логи в отдельном терминале

```bash
# В новом терминале
cd "/home/linuxuser/Загрузки/Лидия/Сайт/ inmunoflam.com.ua(Резерв)"
./view_logs.sh follow
```

### 4. Откройте сайт в браузере

Перейдите на `http://localhost:8090`

### 5. Смотрите что происходит в логах

Логи покажут:
- Какие файлы загружаются
- Какой тип страницы определяется
- Какие обработчики вызываются
- Где возникают ошибки

### 6. Найдите ошибки

```bash
# Показать только ошибки
./view_logs.sh errors

# Поиск по ключевым словам
./view_logs.sh search "not found"
./view_logs.sh search "page_type"
```

## Пример успешного запроса

```
[INFO] ========== REQUEST START ==========
[INFO] === CONFIGURATION START ===
[DEBUG] Domain configuration loaded
[INFO] === ROUTING START ===
[DEBUG] Page type found: shop
[INFO] === PAGE GENERATION START ===
[INFO] Public page generated
[INFO] ========== REQUEST END ==========
```

## Если страница не отображается

Логи покажут где именно проблема:
- **Нет "ROUTING START"** → проблема в конфигурации
- **Нет "page_type"** → проблема с маршрутизацией
- **"Handler not found"** → отсутствует файл или функция
- **"output_length: 0"** → контент не генерируется

**Скопируйте логи проблемного запроса и покажите мне!**
