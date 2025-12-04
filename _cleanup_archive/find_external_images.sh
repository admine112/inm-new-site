#!/bin/bash

# Скрипт для поиска внешних изображений в базе данных

echo "Поиск внешних изображений в статьях..."

mysql -h 127.0.0.1 -u root -p << 'EOF'
USE inmunoflam;

-- Поиск статей с внешними изображениями
SELECT 
    id,
    name,
    text,
    SUBSTRING(text, LOCATE('http', text), 200) as image_url
FROM content
WHERE text LIKE '%http%'
  AND text LIKE '%img%'
  AND text NOT LIKE '%inmunoflam.com.ua%';

EOF

echo "Готово! Проверьте результаты."
