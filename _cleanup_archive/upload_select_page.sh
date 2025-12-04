#!/bin/bash
# Завантаження select_page.php на сервер через FTP

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "=== Завантаження select_page.php на сервер ==="

ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PASS
binary
cd /inmunoflam.com.ua/www/includes
lcd www/www/includes
put select_page.php
bye
END_SCRIPT

if [ $? -eq 0 ]; then
    echo "✅ ФАЙЛ select_page.php ЗАВАНТАЖЕНО!"
    echo "Очистіть кеш браузера (Ctrl+F5) і перевірте:"
    echo "  https://inmunoflam.com.ua/videoperedachi"
    echo "  https://inmunoflam.com.ua/otzivi"
    echo "  https://inmunoflam.com.ua/konsultacii"
else
    echo "❌ ПОМИЛКА ЗАВАНТАЖЕННЯ!"
fi
