#!/bin/bash
# Upload H1 hide changes

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading H1 hide changes..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/templates/shop1
put www/www/templates/shop1/main.center.tpl
put www/www/templates/shop1/css/style.css
bye
EOF

echo "✅ H1 скрыт от пользователей, но виден для Google!"
