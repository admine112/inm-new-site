#!/bin/bash
# Завантаження файлів на сервер через SFTP

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "=== Завантаження файлів на сервер через SFTP ==="

# Завантаження select_page.php
echo "Завантаження select_page.php..."
sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd /inmunoflam.com.ua/www/includes
put www/www/includes/select_page.php
bye
EOF

if [ $? -eq 0 ]; then
    echo "✅ select_page.php завантажено!"
else
    echo "❌ Помилка завантаження select_page.php"
fi

# Завантаження style.css
echo "Завантаження style.css..."
sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd /inmunoflam.com.ua/www/templates/shop1/css
put www/www/templates/shop1/css/style.css
bye
EOF

if [ $? -eq 0 ]; then
    echo "✅ style.css завантажено!"
else
    echo "❌ Помилка завантаження style.css"
fi

echo ""
echo "=== ЗАВЕРШЕНО ==="
echo "Очистіть кеш браузера (Ctrl+F5) і перевірте:"
echo "  https://inmunoflam.com.ua/"
echo "  https://inmunoflam.com.ua/videoperedachi"
echo "  https://inmunoflam.com.ua/otzivi"
echo "  https://inmunoflam.com.ua/pr1-inmunoflam/"
