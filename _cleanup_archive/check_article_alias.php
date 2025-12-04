<?php
require_once("settings/conf.php");
require_once("settings/connect.php");
require_once("settings/functions.php");
bd_session_start(); 

$search = "Хотите жить дольше";
$query = "SELECT articleID, name, alias FROM content_articles WHERE name LIKE '%$search%'";
$res = mysql_query($query);

if ($res) {
    while ($row = mysql_fetch_assoc($res)) {
        echo "ID: " . $row['articleID'] . "\n";
        echo "Name: " . $row['name'] . "\n";
        echo "Alias: " . $row['alias'] . "\n";
        echo "-------------------\n";
    }
} else {
    echo "Query failed: " . mysql_error();
}
?>
