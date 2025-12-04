#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading main.tpl without mobile support..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/templates/shop1
put www/www/templates/shop1/main.tpl
bye
EOF

echo "✅ Mobile version disabled!"
