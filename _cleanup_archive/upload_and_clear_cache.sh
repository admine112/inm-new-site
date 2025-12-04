#!/bin/bash

# Upload and run cache cleaner

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"
WEB_ROOT="/home/is501201/inmunoflam.com.ua/www"

# Create temporary SSH config
TMP_CONFIG=$(mktemp)
cat > "$TMP_CONFIG" << 'EOF'
Host *
    StrictHostKeyChecking no
    UserKnownHostsFile /dev/null
    LogLevel ERROR
EOF

echo "=== Uploading clear_cache.php to $WEB_ROOT ==="
sshpass -p "$PASS" scp -F "$TMP_CONFIG" clear_cache.php "$USER@$HOST:$WEB_ROOT/"

if [ $? -eq 0 ]; then
    echo "✅ File uploaded successfully!"
    echo ""
    echo "🌐 Now open in browser: https://inmunoflam.com.ua/clear_cache.php"
    echo ""
    echo "Press Enter after you opened it in browser to delete the file..."
    read
    
    echo "=== Deleting clear_cache.php from server ==="
    sshpass -p "$PASS" ssh -F "$TMP_CONFIG" "$USER@$HOST" "rm $WEB_ROOT/clear_cache.php"
    echo "✅ File deleted!"
else
    echo "❌ Upload failed"
fi

# Cleanup
rm -f "$TMP_CONFIG"
