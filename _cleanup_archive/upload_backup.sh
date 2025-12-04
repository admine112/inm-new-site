#!/bin/bash
# Upload backup

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua
put WORKING_VERSION_2025_11_24.zip
bye
EOF
