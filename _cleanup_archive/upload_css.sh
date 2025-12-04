#!/bin/bash
# Завантаження CSS файлу на сервер через FTP

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "=== Завантаження style.css на сервер ==="

ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASS
binary
cd /inmunoflam.com.ua/www/templates/shop1/css
lcd www/www/templates/shop1/css
put style.css
bye
END_SCRIPT

if [ $? -eq 0 ]; then
    echo "✅ ФАЙЛ style.css ЗАВАНТАЖЕНО!"
    echo "Очистіть кеш браузера (Ctrl+F5) і перевірте:"
    echo "  https://inmunoflam.com.ua/pr1-inmunoflam/"
else
    echo "❌ ПОМИЛКА ЗАВАНТАЖЕННЯ!"
fi
