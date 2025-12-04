<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Restoring Pages ===\n";

$sql_file = file_get_contents("restore_pages.sql");
$queries = explode(";", $sql_file);

foreach ($queries as $query) {
    $query = trim($query);
    if (!empty($query)) {
        echo "Executing: " . substr($query, 0, 50) . "...\n";
        if (mysql_query($query)) {
            echo "Success.\n";
        } else {
            echo "Error: " . mysql_error() . "\n";
        }
    }
}
?>
