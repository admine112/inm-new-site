#!/bin/bash
# Fix select_page.php to not search for p{ID} as alias

cat > /tmp/select_page_final.php << 'EOF'
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
        
        // Check if it's a p{ID} format (don't search in url_page for these)
        if (preg_match('/^p\d+/', $first_part)) {
            log_debug("Detected p{ID} format, skipping url_page check", $first_part);
            // Don't set page_type, let it fall through to database check
        } elseif (isset($url_page[$first_part])) {
            $page_type = $first_part;
            log_info("Page type found in URL path", ['first_part' => $first_part, 'handler' => $url_page[$first_part]]);
        } else {
            log_debug("First URL part not in url_page, will check database", $first_part);
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
        // Fallback: check database for content page with this alias
        log_info("No page_type found, checking database for content alias");
        
        $alias = isset($url_parts[0]) ? $url_parts[0] : '';
        
        // Skip database check for p{ID} format - these should have been handled by url_page["p"]
        if ($alias != '' && !preg_match('/^p\d+/', $alias)) {
            log_debug("Searching for content article with alias", $alias);
            $sql = "SELECT `articleID` FROM `content_articles` 
                    WHERE `alias`='" . mysql_real_escape_string($alias) . "' 
                    AND `lng_id`='{$glb["sys_lng"]}' 
                    AND `visible`='1' 
                    LIMIT 1";
            log_debug("SQL query", $sql);
            $result = mysql_query($sql);
            
            if ($result && mysql_num_rows($result) > 0) {
                $row = mysql_fetch_assoc($result);
                $articleID = $row['articleID'];
                log_info("Content article found in database", ['alias' => $alias, 'articleID' => $articleID]);
                
                if (function_exists("show_article_full")) {
                    log_info("Calling show_article_full()", $articleID);
                    $center = show_article_full($articleID);
                    log_debug("show_article_full() returned content", ['length' => strlen($center)]);
                } else {
                    log_error("show_article_full() function not found");
                }
            } else {
                log_warning("No content article found with alias", $alias);
                log_info("Showing 404 or default page");
                $center = "";
            }
        } elseif (preg_match('/^p\d+/', $alias)) {
            log_error("p{ID} URL not handled by url_page - this should not happen!", $alias);
            $center = "";
        } else {
            log_info("Empty alias, showing homepage");
            $center = "";
        }
    }
}

log_info("=== ROUTING END ===", ['center_length' => strlen($center)]);
?>
EOF

sudo cp /tmp/select_page_final.php www/www/includes/select_page.php
sudo chmod 644 www/www/includes/select_page.php
echo "✅ Fixed select_page.php to properly handle p{ID} URLs"
