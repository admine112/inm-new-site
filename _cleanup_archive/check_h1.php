<?php
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = @mysql_connect($db_host, $db_user, $db_pass);
if (!$conn) die("DB failed\n");
mysql_select_db($db_name, $conn);

$sql = "SELECT articleID, name, alias, h1 FROM content_articles WHERE alias='videoperedachi' LIMIT 1";
$result = mysql_query($sql);

if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    echo "ID: {$row['articleID']}\n";
    echo "Name: {$row['name']}\n";
    echo "Alias: {$row['alias']}\n";
    echo "H1: '{$row['h1']}'\n";
    echo "H1 empty: " . (empty($row['h1']) ? "YES" : "NO") . "\n";
}
mysql_close($conn);
?>
