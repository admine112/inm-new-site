<?php
// Simple wrapper function for PHP 5.3 compatibility
// Handles p{ID} URLs without logging or modern syntax
function show_article_by_url() {
    global $glb, $request_url;
    
    $articleID = null;
    $page_id = 1;
    
    // Check $_GET["p"] first
    if (isset($_GET["p"])) {
        $p_value = $_GET["p"];
        
        // Check if it contains page number: p171-2
        if (strpos($p_value, '-') !== false) {
            $parts = explode('-', $p_value);
            $articleID = intval($parts[0]);
            $page_id = isset($parts[1]) ? intval($parts[1]) : 1;
        } else {
            $articleID = intval($p_value);
        }
    }
    
    // Fallback: parse from request_url
    if ($articleID === null && isset($request_url)) {
        // URL format: /p171 or /p171-2
        if (preg_match('/\/p(\d+)(?:-(\d+))?/', $request_url, $matches)) {
            $articleID = intval($matches[1]);
            $page_id = isset($matches[2]) ? intval($matches[2]) : 1;
        }
    }
    
    if ($articleID && $articleID > 0) {
        if (function_exists('show_article_full')) {
            return show_article_full($articleID, $page_id);
        }
    }
    
    return "";
}
?>
