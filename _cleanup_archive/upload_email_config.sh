#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading email configuration..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/settings
put www/www/settings/conf.php
bye
EOF

echo "✅ Email изменен на internet.in.ua@gmail.com"
