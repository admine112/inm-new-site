#!/bin/bash
# Update select_page.php with detailed logging

cat > /tmp/select_page_new.php << 'EOF'
<?php
global $url_page, $url_admin, $center, $glb, $request_url;

log_info("=== ROUTING START ===");
log_debug("Request URL", $request_url);
log_debug("GET parameters", $_GET);
log_debug("Available url_page routes", array_keys($url_page));

$center = "";

if (isset($_GET["admin"]) && $_SESSION["status"] == "admin") {
    log_info("Admin route detected");
    $admin_page = $_GET["admin"];
    log_debug("Admin page requested", $admin_page);
    
    if (isset($url_admin[$admin_page]) && $url_admin[$admin_page] != "") {
        log_info("Loading admin handler", $url_admin[$admin_page]);
        require_once($url_admin[$admin_page]);
    } else {
        log_warning("Admin page not found in url_admin array", $admin_page);
    }
} else {
    log_info("Public route detected");
    $url_parts = explode("/", trim($request_url, "/"));
    log_debug("URL parts", $url_parts);
    
    $page_type = "";
    
    // Check GET parameters for page type
    foreach ($_GET as $key => $value) {
        if (isset($url_page[$key])) {
            $page_type = $key;
            log_info("Page type found in GET parameters", ['key' => $key, 'value' => $value, 'handler' => $url_page[$key]]);
            break;
        }
    }
    
    // Check URL path for page type
    if ($page_type == "" && count($url_parts) > 0 && $url_parts[0] != "") {
        $first_part = $url_parts[0];
        log_debug("Checking first URL part", $first_part);
        if (isset($url_page[$first_part])) {
            $page_type = $first_part;
            log_info("Page type found in URL path", ['first_part' => $first_part, 'handler' => $url_page[$first_part]]);
        } else {
            log_warning("First URL part not found in url_page routes", $first_part);
        }
    }
    
    if ($page_type != "" && isset($url_page[$page_type])) {
        $page_handler = $url_page[$page_type];
        log_info("Page handler selected", ['page_type' => $page_type, 'handler' => $page_handler]);
        
        if (strpos($page_handler, "/") !== false || strpos($page_handler, ".php") !== false) {
            // Handler is a file path
            if (file_exists($page_handler)) {
                log_info("Loading page handler file", $page_handler);
                require_once($page_handler);
            } else {
                log_error("Page handler file not found", $page_handler);
            }
        } else {
            // Handler is a function name
            if (function_exists($page_handler)) {
                log_info("Calling page handler function", $page_handler);
                $center = $page_handler();
                log_debug("Page handler returned content", ['length' => strlen($center)]);
            } else {
                log_error("Page handler function not found", $page_handler);
            }
        }
    } else {
        log_info("No specific page type found, showing main page");
        log_debug("page_type is empty or not in url_page", ['page_type' => $page_type]);
        if (function_exists("show_main_page")) {
            log_debug("Calling show_main_page()");
            $center = show_main_page();
            log_debug("show_main_page() returned content", ['length' => strlen($center)]);
        } else {
            log_error("show_main_page() function not found");
        }
    }
}

log_info("=== ROUTING END ===", ['center_length' => strlen($center)]);
?>
EOF

sudo cp /tmp/select_page_new.php www/www/includes/select_page.php
sudo chmod 644 www/www/includes/select_page.php
echo "✅ select_page.php updated with detailed logging"
