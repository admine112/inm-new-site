#!/bin/bash
# Upload documentation

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua
mkdir docs
cd docs
put PROJECT_OVERVIEW.md
put TECHNICAL_REPORT.md
put VERIFICATION_LOG.md
bye
EOF
