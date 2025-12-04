<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Page Content Check ===\n";

$ids = array(15, 25);
foreach ($ids as $id) {
    $sql = "SELECT * FROM `content_articles` WHERE `articleID`=$id";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_assoc($result)) {
        echo "ID=$id\n";
        echo "Alias: " . $row['alias'] . "\n";
        echo "Name: " . $row['name'] . "\n";
        echo "Title: " . $row['title'] . "\n";
        echo "H1: " . $row['h1'] . "\n";
        echo "Content Length: " . strlen($row['content']) . "\n";
        echo "Text Length: " . strlen($row['text']) . "\n";
        echo "Content Preview: " . substr(strip_tags($row['content']), 0, 100) . "\n";
        echo "-------------------\n";
    }
}
?>
