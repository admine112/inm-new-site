#!/bin/bash
# Script to fix permissions for logs directory

LOG_DIR="www/www/logs"

if [ ! -d "$LOG_DIR" ]; then
    echo "Creating logs directory..."
    sudo mkdir -p "$LOG_DIR"
fi

echo "Setting permissions for logs directory..."
sudo chmod 777 "$LOG_DIR"
sudo chown www-data:www-data "$LOG_DIR"

if [ -f "$LOG_DIR/debug.log" ]; then
    sudo chmod 666 "$LOG_DIR/debug.log"
fi

echo "Setting permissions for settings directory..."
SETTINGS_DIR="www/www/settings"
if [ -d "$SETTINGS_DIR" ]; then
    sudo chmod 777 "$SETTINGS_DIR"
    # Fix conf.php if it exists
    if [ -f "$SETTINGS_DIR/conf.php" ]; then
        sudo chmod 666 "$SETTINGS_DIR/conf.php"
    fi
fi

echo "Permissions fixed. You can now access the website to generate logs."
