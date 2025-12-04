<?php
// Перевірка сторінки sostav-inmonuflama
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

echo "=== Пошук сторінки ===\n\n";

// Пошук за різними варіантами
$aliases = array('sostav-inmonuflama', 'sostav-inmunoflama', 'sostav');

foreach ($aliases as $alias) {
    $sql = "SELECT articleID, name, alias, visible FROM content_articles WHERE alias LIKE '%{$alias}%'";
    $res = mysql_query($sql);
    echo "Пошук '{$alias}':\n";
    if (mysql_num_rows($res) > 0) {
        while ($row = mysql_fetch_assoc($res)) {
            echo "  ID {$row['articleID']}: '{$row['name']}' -> alias='{$row['alias']}' (visible={$row['visible']})\n";
        }
    } else {
        echo "  Не знайдено\n";
    }
    echo "\n";
}

mysql_close($conn);
?>
