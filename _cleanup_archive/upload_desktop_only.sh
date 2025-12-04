#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading CSS with desktop-only mode..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/templates/shop1/css
put www/www/templates/shop1/css/style.css
bye
EOF

echo "✅ Desktop-only mode enabled!"
