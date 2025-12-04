#!/bin/bash
# Завантаження через lftp (працює краще за ftp)

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "=== Завантаження файлів на сервер ==="

lftp -c "
set ftp:ssl-allow no
open ftp://$USER:$PASS@$HOST
cd /inmunoflam.com.ua/www

# Завантажити файли
lcd files_for_server
cd includes
put select_page.php

cd ../modules/content  
put -O . content_main.php -o main.php

cd site
put -O . content_functions.php -o functions.php

cd ../../..
put .htaccess

bye
"

if [ $? -eq 0 ]; then
    echo "✅ ФАЙЛИ ЗАВАНТАЖЕНО!"
else
    echo "❌ ПОМИЛКА!"
fi
