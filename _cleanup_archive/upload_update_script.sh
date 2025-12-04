#!/bin/bash

echo "Загрузка PHP-скрипта на сервер..."

# Загрузка через FTP
ftp -inv is501201.ftp.tools <<EOF
user is501201 aP9ypC9buY
cd inmunoflam.com.ua/www
put update_sostav.php
bye
EOF

echo ""
echo "✅ Файл загружен на сервер!"
echo ""
echo "Теперь откройте в браузере:"
echo "https://inmunoflam.com.ua/update_sostav.php"
echo ""
echo "После проверки результата удалите файл с сервера!"
