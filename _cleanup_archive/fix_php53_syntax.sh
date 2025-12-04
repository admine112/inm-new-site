#!/bin/bash
# Виправлення синтаксису PHP 5.3 для select_page.php

FILE="extracted_www/www/includes/select_page.php"

echo "Виправлення короткого синтаксису масивів [] на array()..."

# Замінити всі ['key' => value] на array('key' => value)
perl -i -pe "s/\['([^']+)' => ([^\]]+)\]/array('\1' => \2)/g" "$FILE"

# Замінити всі ["key" => value] на array("key" => value)  
perl -i -pe 's/\["([^"]+)" => ([^\]]+)\]/array("\1" => \2)/g' "$FILE"

echo "✓ Готово!"
php -l "$FILE"
