#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading desktop-only files..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/templates/shop1
put www/www/templates/shop1/main.tpl
cd css
put www/www/templates/shop1/css/mobile-disable.css
bye
EOF

echo "✅ Desktop-only mode fully enabled!"
