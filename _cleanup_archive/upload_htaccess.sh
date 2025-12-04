#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading .htaccess with caching rules..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www
put www/www/.htaccess
bye
EOF

echo "✅ Caching rules uploaded!"
