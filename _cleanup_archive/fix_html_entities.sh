#!/bin/bash
# Скрипт для исправления HTML-сущностей в PHP файлах

echo "Исправление HTML-сущностей в PHP файлах..."

# Файл 1: select_page.php
echo "Обработка select_page.php..."
sudo sed -i 's/&lt;/</g; s/&gt;/>/g; s/&amp;/\&/g' www/www/includes/select_page.php

# Файл 2: simplehtmldom/app/index.php
echo "Обработка simplehtmldom/app/index.php..."
sudo sed -i 's/&lt;/</g; s/&gt;/>/g; s/&amp;/\&/g' www/www/includes/simplehtmldom/app/index.php

# Проверка синтаксиса
echo ""
echo "Проверка синтаксиса PHP..."
php -l www/www/includes/select_page.php
php -l www/www/includes/simplehtmldom/app/index.php
php -l www/www/index.php

echo ""
echo "✅ Готово! Все файлы исправлены."
