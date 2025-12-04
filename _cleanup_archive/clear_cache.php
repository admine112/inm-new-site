<?php
/**
 * Clear Cache Script
 * This script clears all cache files and restarts PHP
 */

echo "<h1>Cache Clearing Script</h1>";

// Clear OPcache if available
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "<p>✅ OPcache cleared</p>";
} else {
    echo "<p>⚠️ OPcache not available</p>";
}

// Clear APCu cache if available
if (function_exists('apcu_clear_cache')) {
    apcu_clear_cache();
    echo "<p>✅ APCu cache cleared</p>";
} else {
    echo "<p>⚠️ APCu not available</p>";
}

// Find and delete cache files
$cache_dirs = [
    '/www/www/cache',
    '/www/www/tmp',
    '/www/www/temp',
    '/tmp/cache',
    '/var/tmp/cache'
];

$deleted_count = 0;

foreach ($cache_dirs as $dir) {
    if (is_dir($dir)) {
        echo "<p>Found cache directory: $dir</p>";
        $files = glob($dir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
                $deleted_count++;
            }
        }
    }
}

echo "<p>✅ Deleted $deleted_count cache files</p>";

// Force page reload
echo "<h2>Cache Cleared!</h2>";
echo "<p><a href='/sostav-inmunoflama'>Check the page now</a></p>";
echo "<p><strong>IMPORTANT:</strong> Delete this file after use!</p>";
?>
