#!/bin/bash

# SSH connection script with custom config
# This bypasses the broken /etc/ssh/ssh_config

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

# Create temporary SSH config
TMP_CONFIG=$(mktemp)
cat > "$TMP_CONFIG" << 'EOF'
Host *
    StrictHostKeyChecking no
    UserKnownHostsFile /dev/null
    LogLevel ERROR
EOF

echo "=== Connecting to server ==="
echo "Host: $HOST"
echo "User: $USER"

# Upload clear_cache.php
echo ""
echo "=== Uploading clear_cache.php ==="
sshpass -p "$PASS" scp -F "$TMP_CONFIG" clear_cache.php "$USER@$HOST:/www/www/"

if [ $? -eq 0 ]; then
    echo "✅ File uploaded successfully!"
    echo ""
    echo "Now run in browser: https://inmunoflam.com.ua/clear_cache.php"
    echo ""
    echo "After that, delete the file:"
    sshpass -p "$PASS" ssh -F "$TMP_CONFIG" "$USER@$HOST" "rm /www/www/clear_cache.php"
else
    echo "❌ Upload failed"
fi

# Cleanup
rm -f "$TMP_CONFIG"
