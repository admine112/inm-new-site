<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Domain Check ===\n";
$sql = "SELECT * FROM `domens`";
$result = mysql_query($sql);
while ($row = mysql_fetch_assoc($result)) {
    echo "ID=" . $row['domenID'] . ", Domain='" . $row['domen'] . "', Lang=" . $row['lng_id'] . "\n";
}
?>
