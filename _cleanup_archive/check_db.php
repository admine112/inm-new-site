<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== DB Check ===\n";
echo "Connected to DB: " . $dbname . "\n";

// Check for konsultacii
$alias = "konsultacii";
$sql = "SELECT * FROM `content_articles` WHERE `alias` LIKE '%konsult%'";
$result = mysql_query($sql);

echo "Searching for '%konsult%':\n";
if ($result && mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "Found: ID=" . $row['articleID'] . ", Alias='" . $row['alias'] . "', Visible=" . $row['visible'] . ", Lang=" . $row['lng_id'] . "\n";
    }
} else {
    echo "Not found.\n";
}

echo "\n=== All Aliases (Limit 50) ===\n";
$sql = "SELECT `articleID`, `alias`, `visible`, `lng_id` FROM `content_articles` LIMIT 50";
$result = mysql_query($sql);
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "ID=" . $row['articleID'] . ", Alias='" . $row['alias'] . "'\n";
    }
}

echo "\n=== Check specific exact match ===\n";
$sql = "SELECT * FROM `content_articles` WHERE `alias`='konsultacii'";
$result = mysql_query($sql);
if ($result && mysql_num_rows($result) > 0) {
    echo "Exact match FOUND!\n";
} else {
    echo "Exact match NOT found.\n";
}
?>
