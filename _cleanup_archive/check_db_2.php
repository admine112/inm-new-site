<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Page Status Check ===\n";

$ids = array(15, 25);
foreach ($ids as $id) {
    $sql = "SELECT * FROM `content_articles` WHERE `articleID`=$id";
    $result = mysql_query($sql);
    if ($row = mysql_fetch_assoc($result)) {
        echo "ID=$id, Alias='" . $row['alias'] . "', Visible=" . $row['visible'] . ", Lang=" . $row['lng_id'] . "\n";
    }
}

echo "\n=== Search for 'konsult' in ALL fields ===\n";
$sql = "SELECT * FROM `content_articles` WHERE `title` LIKE '%konsult%' OR `content` LIKE '%konsult%' OR `alias` LIKE '%konsult%'";
$result = mysql_query($sql);
if ($result && mysql_num_rows($result) > 0) {
    while ($row = mysql_fetch_assoc($result)) {
        echo "Found: ID=" . $row['articleID'] . ", Alias='" . $row['alias'] . "', Title='" . $row['title'] . "'\n";
    }
} else {
    echo "Not found in any field.\n";
}
?>
