#!/bin/bash
# Temporary script to update index.php with sudo

cat > /tmp/index_new.php << 'EOF'
<?php
header("Content-Type: text/html; charset=utf-8");
$time1=microtime(1);

require_once("settings/logger.php");
log_request_start();

require_once("settings/conf.php");
log_debug("Loaded: settings/conf.php");

require_once("settings/connect.php");
log_debug("Loaded: settings/connect.php");

require_once("settings/functions.php");
log_debug("Loaded: settings/functions.php");

session_start();
log_debug("Session started", ['session_id' => session_id()]);

require_once("settings/main.php");
log_debug("Loaded: settings/main.php");

require_once("modules/modules.php");
log_debug("Loaded: modules/modules.php");

require_once("includes/select_page.php");
log_debug("Loaded: includes/select_page.php");

require_once("settings/generate_page.php");
log_debug("Loaded: settings/generate_page.php");

log_request_end(microtime(1)-$time1);
?>
EOF

sudo cp /tmp/index_new.php www/www/index.php
sudo chmod 644 www/www/index.php
echo "✅ index.php updated with logging"
