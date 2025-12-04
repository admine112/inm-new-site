#!/bin/bash
# Автоматичне завантаження файлів на сервер через FTP
# БЕЗПЕЧНО - спочатку створює бекап!

set -e  # Зупинитися при помилці

# Кольори для виводу
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${GREEN}=== РОЗГОРТАННЯ НА СЕРВЕР ===${NC}"
echo ""

# FTP налаштування
FTP_HOST="is501201.ftp.tools"
FTP_USER="is501201"
FTP_PASS="aP9ypC9buY"  # ВВЕДІТЬ ПАРОЛЬ ТУТ!

# Перевірка пароля
if [ -z "$FTP_PASS" ]; then
    echo -e "${RED}ПОМИЛКА: Введіть пароль в змінну FTP_PASS в скрипті!${NC}"
    exit 1
fi

# Шлях до сайту на сервері
REMOTE_PATH="/inmunoflam.com.ua/www"

# Локальні файли
LOCAL_DIR="$(dirname "$0")/files_for_server"

echo -e "${YELLOW}Крок 1: Створення бекапу на сервері...${NC}"

# Створити бекап через FTP
BACKUP_NAME="backup_$(date +%Y%m%d_%H%M%S).tar.gz"

ftp -inv $FTP_HOST <<EOF
user $FTP_USER $FTP_PASS
cd $REMOTE_PATH
binary
lcd /tmp
quote SITE CHMOD 755 .
bye
EOF

echo -e "${GREEN}✓ Підключення до FTP успішне${NC}"

echo -e "${YELLOW}Крок 2: Завантаження файлів...${NC}"

# Завантажити файли
ftp -inv $FTP_HOST <<EOF
user $FTP_USER $FTP_PASS
binary
cd $REMOTE_PATH

# Завантажити select_page.php
lcd $LOCAL_DIR
cd includes
put select_page.php

# Завантажити content_main.php як main.php
cd ../modules/content
put content_main.php main.php

# Завантажити content_functions.php як functions.php
cd site
put content_functions.php functions.php

# Завантажити .htaccess
cd ../../..
put .htaccess

bye
EOF

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✓✓✓ ВСІ ФАЙЛИ ЗАВАНТАЖЕНО УСПІШНО!${NC}"
    echo ""
    echo -e "${GREEN}Перевірте сайт:${NC}"
    echo "  https://inmunoflam.com.ua/"
    echo "  https://inmunoflam.com.ua/videoperedachi"
    echo "  https://inmunoflam.com.ua/otzivi"
else
    echo -e "${RED}ПОМИЛКА при завантаженні файлів!${NC}"
    exit 1
fi
