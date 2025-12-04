#!/bin/bash
# Upload check_db_3.php

HOST="is501201.ftp.tools"
USER="is501201"
PASS="aP9ypC9buY"

sshpass -p "$PASS" sftp -o StrictHostKeyChecking=no "$USER@$HOST" <<EOF
cd inmunoflam.com.ua/www
put check_db_3.php
bye
EOF
