#!/bin/bash
# Upload SEO files

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading SEO files..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www
put www/www/sitemap.xml
put www/www/robots.txt
cd templates/shop1
put www/www/templates/shop1/main.tpl
put www/www/templates/shop1/main.center.tpl
bye
EOF

echo "✅ SEO files uploaded!"
