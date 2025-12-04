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
        echo "ID=$id, Alias='" . $row['alias'] . "', Visible=" . $row['visible'] . ", Lang=" . $row['lng_id'] . ", TypeID=" . $row['type_id'] . "\n";
    }
}
?>
