<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Article Dates Check ===\n\n";

$article_ids = array(166, 120, 118, 111, 110, 108, 104, 73, 14, 13, 10, 9, 8, 7, 6);

foreach ($article_ids as $id) {
    $sql = "SELECT `articleID`, `name`, `add_date` FROM `content_articles` WHERE `articleID`=$id";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_assoc($result)) {
        echo "ID: " . $row['articleID'] . "\n";
        echo "Название: " . $row['name'] . "\n";
        echo "Дата в БД: " . $row['add_date'] . "\n";
        echo "---\n";
    }
}
?>
