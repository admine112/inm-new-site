#!/bin/bash

# Find correct path and upload cache cleaner

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

echo "=== Finding web root directory ==="
sshpass -p "$PASS" ssh -F "$TMP_CONFIG" "$USER@$HOST" "pwd && ls -la" 2>&1

echo ""
echo "=== Trying to find www directory ==="
sshpass -p "$PASS" ssh -F "$TMP_CONFIG" "$USER@$HOST" "find ~ -maxdepth 3 -type d -name 'www' 2>/dev/null" 2>&1

# Cleanup
rm -f "$TMP_CONFIG"
