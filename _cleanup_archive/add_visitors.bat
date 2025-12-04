@echo off
chcp 65001 >nul
REM Скрипт для добавления посетителей на сайт (Windows версия)
REM Требует установленного MySQL Client

setlocal enabledelayedexpansion

set DB_HOST=is501201.mysql.ukraine.com.ua
set DB_USER=is501201_inm
set DB_PASS=(!keSB72a5
set DB_NAME=is501201_inm
set DOMEN_ID=0

REM Количество посетителей (по умолчанию 50)
set COUNT=%1
if "%COUNT%"=="" set COUNT=50

echo =========================================
echo Добавление посетителей в базу данных
echo Дата: %date% %time%
echo Количество: %COUNT%
echo =========================================
echo.

REM Проверка наличия mysql
where mysql >nul 2>&1
if %errorlevel% neq 0 (
    echo ОШИБКА: MySQL Client не установлен!
    echo.
    echo Установите MySQL Client:
    echo https://dev.mysql.com/downloads/mysql/
    echo.
    pause
    exit /b 1
)

for /L %%i in (1,1,%COUNT%) do (
    call :add_visitor %%i
    timeout /t 1 /nobreak >nul
)

echo.
echo =========================================
echo Готово! Добавлено %COUNT% посетителей
echo =========================================
echo.
pause
exit /b 0

:add_visitor
    REM Генерация случайного IP
    set /a IP1=%RANDOM% %% 256
    set /a IP2=%RANDOM% %% 256
    set /a IP3=%RANDOM% %% 256
    set /a IP4=%RANDOM% %% 256
    set IP=%IP1%.%IP2%.%IP3%.%IP4%
    
    REM Случайный User-Agent
    set /a UA_NUM=%RANDOM% %% 5
    if %UA_NUM%==0 set UA=Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0.0.0
    if %UA_NUM%==1 set UA=Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) Safari/537.36
    if %UA_NUM%==2 set UA=Mozilla/5.0 (X11; Linux x86_64) Firefox/121.0
    if %UA_NUM%==3 set UA=Mozilla/5.0 (iPhone; CPU iPhone OS 17_1) Safari/604.1
    if %UA_NUM%==4 set UA=Mozilla/5.0 (Linux; Android 13) Chrome/120.0.0.0
    
    REM Случайный referer
    set /a REF_NUM=%RANDOM% %% 4
    if %REF_NUM%==0 set REFERER=https://www.google.com/search?q=инмунофлам
    if %REF_NUM%==1 set REFERER=https://www.google.com.ua/search?q=иммуномодулятор
    if %REF_NUM%==2 set REFERER=https://www.facebook.com/
    if %REF_NUM%==3 set REFERER=
    
    REM Генерация session ID
    set SESSION=%RANDOM%%RANDOM%%RANDOM%%RANDOM%
    
    REM Текущая дата и время
    for /f "tokens=1-3 delims=." %%a in ("%date%") do (
        set CURR_DATE=%%c-%%b-%%a
    )
    for /f "tokens=1-2 delims=:" %%a in ("%time%") do (
        set CURR_TIME=%%a:%%b:00
    )
    
    REM SQL запрос
    set SQL=INSERT INTO `counter` SET `domenID`='%DOMEN_ID%', `referrer`='!REFERER!', `date`='%CURR_DATE%', `ip`='%IP%', `brouser`='!UA!', `session`='%SESSION%', `atime`='%CURR_TIME%', `full_url`='inmunoflam.com.ua/';
    
    REM Выполнение SQL
    echo !SQL! | mysql -h %DB_HOST% -u %DB_USER% -p%DB_PASS% %DB_NAME% 2>nul
    
    if !errorlevel! equ 0 (
        echo [OK] Посетитель #%1 добавлен ^(IP: %IP%^)
    ) else (
        echo [ERR] Ошибка добавления посетителя #%1
    )
    
    exit /b 0
