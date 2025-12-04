#!/bin/bash

# Скрипт для развертывания обновлений статьи "Состав Инмунофлама" на сервер
# Дата: 27 ноября 2025

set -e  # Остановка при ошибке

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"
REMOTE_PATH="/domains/inmunoflam.com.ua/public_html"

echo "🚀 Развертывание обновлений статьи 'Состав Инмунофлама'..."
echo ""

# Проверка SSH подключения
echo "🔍 Проверка SSH подключения..."
if ssh -o ConnectTimeout=10 "${USER}@${HOST}" "echo 'SSH OK'" 2>/dev/null; then
    echo "✅ SSH подключение работает"
else
    echo "❌ Ошибка SSH подключения!"
    echo "⚠️  Пожалуйста, сначала запустите: ./fix_ssh_config.sh"
    exit 1
fi

echo ""
echo "📤 Загрузка SQL скрипта на сервер..."

# Загрузка SQL файла через SFTP
sshpass -p "${PASS}" sftp -o StrictHostKeyChecking=no "${USER}@${HOST}" << EOF
cd ${REMOTE_PATH}
put SEO_Phase2_Complete/update_sostav_complete.sql
bye
EOF

if [ $? -eq 0 ]; then
    echo "✅ SQL файл загружен"
else
    echo "❌ Ошибка загрузки SQL файла"
    exit 1
fi

echo ""
echo "💾 Применение обновлений к базе данных на сервере..."

# Выполнение SQL на сервере
ssh "${USER}@${HOST}" << 'ENDSSH'
cd /domains/inmunoflam.com.ua/public_html
mysql -h mysql.ukraine.com.ua -u is501201_inm -p'(!keSB72a5' is501201_inm < update_sostav_complete.sql
if [ $? -eq 0 ]; then
    echo "✅ База данных обновлена"
    rm update_sostav_complete.sql
else
    echo "❌ Ошибка обновления базы данных"
    exit 1
fi
ENDSSH

echo ""
echo "🧹 Очистка кеша..."

# Создание и загрузка скрипта очистки кеша
cat > /tmp/clear_cache_remote.php << 'ENDPHP'
<?php
// Очистка кеша
$cache_dir = __DIR__ . '/cache';
if (is_dir($cache_dir)) {
    $files = glob($cache_dir . '/*');
    foreach($files as $file) {
        if(is_file($file)) {
            unlink($file);
        }
    }
    echo "Cache cleared successfully\n";
} else {
    echo "Cache directory not found\n";
}
?>
ENDPHP

sshpass -p "${PASS}" sftp -o StrictHostKeyChecking=no "${USER}@${HOST}" << EOF
cd ${REMOTE_PATH}
put /tmp/clear_cache_remote.php
bye
EOF

ssh "${USER}@${HOST}" << 'ENDSSH'
cd /domains/inmunoflam.com.ua/public_html
php clear_cache_remote.php
rm clear_cache_remote.php
ENDSSH

rm /tmp/clear_cache_remote.php

echo ""
echo "✅ Развертывание завершено успешно!"
echo ""
echo "📋 Что было обновлено:"
echo "   - Title: Инмунофлам: мощная природная поддержка Т-клеточного иммунитета..."
echo "   - Description: Инмунофлам — растительный иммуномодулятор с более чем 70..."
echo "   - H1: ЧТО СОБОЙ ПРЕДСТАВЛЯЕТ ИНМУНОФЛАМ"
echo "   - Полный HTML контент статьи"
echo ""
echo "🌐 Проверьте изменения на: https://inmunoflam.com.ua/sostav-inmunoflama"
