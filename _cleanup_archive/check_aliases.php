<?php
// Перевірка alias в базі даних
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

echo "=== Перевірка alias ===\n\n";

$pages = array(
    array('id' => 3, 'expected' => 'videoperedachi'),
    array('id' => 15, 'expected' => 'videoperedachi'),
    array('id' => 25, 'expected' => 'otzivi'),
    array('id' => 16, 'expected' => 'otzivi'),
    array('id' => 17, 'expected' => 'kontakti'),
    array('id' => 18, 'expected' => 'apteki')
);

foreach ($pages as $page) {
    $sql = "SELECT articleID, name, alias FROM content_articles WHERE articleID='{$page['id']}'";
    $res = mysql_query($sql);
    if ($row = mysql_fetch_assoc($res)) {
        echo "ID {$page['id']}: '{$row['name']}' -> alias='{$row['alias']}'\n";
    }
}

mysql_close($conn);
?>
