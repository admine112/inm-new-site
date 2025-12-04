#!/bin/bash
HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

echo "Uploading SEO Phase 2 files..."

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www/templates/shop1
put modified_files/templates/shop1/shop.commodity.full.tpl
put modified_files/templates/shop1/content.full_page.1.tpl
put modified_files/templates/shop1/content.full_page.2.tpl
put modified_files/templates/shop1/content.full_page.3.tpl
put modified_files/templates/shop1/content.full_page.4.tpl
cd ../..
put modified_files/.htaccess
bye
EOF

echo "✅ SEO Phase 2 implementation complete!"
