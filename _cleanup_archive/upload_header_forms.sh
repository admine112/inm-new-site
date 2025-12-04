#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading header forms handler..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www
put www/www/send_header_form.php
cd templates/shop1
put www/www/templates/shop1/main.tpl
cd js
put www/www/templates/shop1/js/header_forms.js
bye
EOF

echo "✅ Формы в шапке подключены!"
