# Инструкция по использованию скриптов для Windows

## Версии скриптов:

### 1. add_visitors.bat - Batch файл
**Для:** Windows CMD
**Использование:**
```cmd
add_visitors.bat 100
```

### 2. add_visitors.ps1 - PowerShell
**Для:** Windows PowerShell
**Использование:**
```powershell
.\add_visitors.ps1 -Count 100
```

---

## Установка MySQL Client для Windows:

Скрипты требуют установленного MySQL Client.

### Вариант 1: MySQL Installer (Рекомендуется)
1. Скачайте: https://dev.mysql.com/downloads/installer/
2. Выберите "mysql-installer-community"
3. Установите только "MySQL Command Line Client"

### Вариант 2: Portable версия
1. Скачайте: https://dev.mysql.com/downloads/mysql/
2. Выберите "Windows (x86, 64-bit), ZIP Archive"
3. Распакуйте в C:\mysql
4. Добавьте C:\mysql\bin в PATH

### Проверка установки:
```cmd
mysql --version
```

---

## Использование:

### Batch (.bat):
1. Двойной клик на `add_visitors.bat`
2. Или через CMD:
   ```cmd
   add_visitors.bat 50
   ```

### PowerShell (.ps1):
1. Правой кнопкой → "Выполнить с помощью PowerShell"
2. Или через PowerShell:
   ```powershell
   .\add_visitors.ps1 -Count 50
   ```

**ВАЖНО для PowerShell:**
Если появляется ошибка "выполнение сценариев отключено", выполните:
```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

---

## Примеры:

```cmd
REM Добавить 10 посетителей
add_visitors.bat 10

REM Добавить 100 посетителей
add_visitors.bat 100

REM Добавить 500 посетителей
add_visitors.bat 500
```

```powershell
# Добавить 10 посетителей
.\add_visitors.ps1 -Count 10

# Добавить 100 посетителей
.\add_visitors.ps1 -Count 100

# Добавить 500 посетителей
.\add_visitors.ps1 -Count 500
```

---

## Что делают скрипты:

✅ Генерируют случайные IP-адреса
✅ Используют разные User-Agent (браузеры)
✅ Добавляют разные источники (Google, Facebook)
✅ Создают уникальные сессии
✅ Записывают в базу данных сайта

**Результат:** Счетчик "Посетители" в админке увеличится!

---

## Безопасность:

⚠️ Пароль от базы данных находится в скрипте в открытом виде!

**Рекомендации:**
- Не передавайте эти файлы другим людям
- Не загружайте в публичные репозитории
- Храните в безопасном месте

---

## Поддержка:

Если возникли проблемы:
1. Проверьте установку MySQL Client
2. Проверьте подключение к интернету
3. Убедитесь, что пароль от БД правильный
