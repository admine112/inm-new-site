#!/bin/bash

echo "🔧 Виправлення functions.php..."

# Змінити власника
sudo chown $USER:$USER www/www/settings/functions.php

# Створити резервну копію
cp www/www/settings/functions.php www/www/settings/functions.php.backup

# Виправити лінію 743-744
sed -i '743,744d' www/www/settings/functions.php
sed -i '742a\\t\t\tglobal $$real_name;\n\t\t\t$aa = isset($$real_name[$real_name2]) ? $$real_name[$real_name2] : "";\n\t\t\t$temp=str_replace("{$".$real_name."[".$real_name2."]"."}", $aa, $temp);' www/www/settings/functions.php

echo "✅ Файл виправлено!"
echo ""
echo "Перезапуск веб-сервера..."
docker-compose restart web
sleep 3

echo ""
echo "Перевірка..."
curl -I http://localhost:8090/ 2>&1 | head -5

echo ""
echo "✅ Готово! Відкрийте http://localhost:8090"
