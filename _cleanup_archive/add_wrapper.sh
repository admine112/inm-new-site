#!/bin/bash
# Add wrapper function to extract article ID from URL

cat > /tmp/content_functions_wrapper.php << 'EOF'
<?php
// Wrapper function to handle p{ID} URLs
function show_article_by_url() {
    global $glb, $request_url;
    
    log_debug("show_article_by_url() called");
    log_debug("request_url", $request_url);
    log_debug("GET parameters", $_GET);
    
    // Extract article ID from URL
    // URL can be: /p171 or /p171-2 (with page number)
    $articleID = null;
    $page_id = 1;
    
    // Check $_GET["p"] first
    if (isset($_GET["p"])) {
        $p_value = $_GET["p"];
        log_debug("Found p in GET", $p_value);
        
        // Check if it contains page number: p171-2
        if (strpos($p_value, '-') !== false) {
            $parts = explode('-', $p_value);
            $articleID = intval($parts[0]);
            $page_id = isset($parts[1]) ? intval($parts[1]) : 1;
            log_debug("Extracted from p with page", ['articleID' => $articleID, 'page_id' => $page_id]);
        } else {
            $articleID = intval($p_value);
            log_debug("Extracted from p", ['articleID' => $articleID]);
        }
    }
    
    // Fallback: parse from request_url
    if ($articleID === null) {
        log_debug("Parsing from request_url");
        // URL format: /p171 or /p171-2
        if (preg_match('/\/p(\d+)(?:-(\d+))?/', $request_url, $matches)) {
            $articleID = intval($matches[1]);
            $page_id = isset($matches[2]) ? intval($matches[2]) : 1;
            log_debug("Extracted from URL regex", ['articleID' => $articleID, 'page_id' => $page_id]);
        }
    }
    
    if ($articleID && $articleID > 0) {
        log_info("Calling show_article_full()", ['articleID' => $articleID, 'page_id' => $page_id]);
        if (function_exists('show_article_full')) {
            $result = show_article_full($articleID, $page_id);
            log_debug("show_article_full() returned", ['length' => strlen($result)]);
            return $result;
        } else {
            log_error("show_article_full() function not found");
            return "";
        }
    } else {
        log_error("Could not extract article ID from URL", ['request_url' => $request_url, 'GET' => $_GET]);
        return "";
    }
}
?>
EOF

# Add this wrapper to the beginning of functions.php
sudo bash -c "cat /tmp/content_functions_wrapper.php www/www/modules/content/site/functions.php > /tmp/functions_combined.php && mv /tmp/functions_combined.php www/www/modules/content/site/functions.php"
sudo chmod 644 www/www/modules/content/site/functions.php

echo "✅ Added show_article_by_url() wrapper function"
