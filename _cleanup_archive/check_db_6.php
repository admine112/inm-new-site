<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Content Inspection ===\n";

// Check videoperedachi content
$sql = "SELECT `text` FROM `content_articles` WHERE `articleID`=15";
$result = mysql_query($sql);
if ($row = mysql_fetch_assoc($result)) {
    echo "Videoperedachi Text Start:\n";
    echo substr($row['text'], 0, 500) . "\n";
    echo "...\n";
}

echo "\n=== get_callback_page Check ===\n";
// We can't easily check the function code from here, but we can check if the function exists
// and maybe what it relies on (e.g. other tables).
// But we can check if there are comments in the DB, as get_callback_page likely displays them.

$sql = "SELECT COUNT(*) as cnt FROM `comments`";
$result = mysql_query($sql);
if ($row = mysql_fetch_assoc($result)) {
    echo "Total Comments: " . $row['cnt'] . "\n";
}
?>
