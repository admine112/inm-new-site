<?php
// Виправлення конкретних сторінок хедера
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

echo "=== Виправлення сторінок хедера ===\n\n";

// Виправити конкретні сторінки
$fixes = array(
    3 => 'sostav-inmunoflama',
    15 => 'videoperedachi',
    25 => 'otzivi'
);

foreach ($fixes as $id => $correct_alias) {
    $sql = "SELECT name, alias FROM content_articles WHERE articleID='{$id}'";
    $res = mysql_query($sql);
    $row = mysql_fetch_assoc($res);
    
    echo "ID {$id}: {$row['name']}\n";
    echo "  Старий alias: '{$row['alias']}'\n";
    echo "  Новий alias:  '{$correct_alias}'\n";
    
    $update = "UPDATE content_articles SET alias='{$correct_alias}' WHERE articleID='{$id}'";
    mysql_query($update);
    echo "  ✓ ОНОВЛЕНО\n\n";
}

echo "=== ГОТОВО ===\n";
mysql_close($conn);
?>
