<?php
// Виправлення alias з пробілами
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

echo "=== Пошук alias з пробілами ===\n\n";

// Знайти всі alias з пробілами
$sql = "SELECT articleID, name, alias FROM content_articles WHERE alias LIKE '%  %' OR alias LIKE '% %'";
$res = mysql_query($sql);

echo "Знайдено записів з пробілами: " . mysql_num_rows($res) . "\n\n";

while ($row = mysql_fetch_assoc($res)) {
    $old_alias = $row['alias'];
    $new_alias = trim(str_replace('  ', '', $old_alias)); // Видалити подвійні пробіли
    $new_alias = str_replace(' ', '-', $new_alias); // Замінити пробіли на дефіси
    
    echo "ID {$row['articleID']}: '{$row['name']}'\n";
    echo "  Старий: '{$old_alias}'\n";
    echo "  Новий:  '{$new_alias}'\n";
    
    // Оновити
    $update_sql = "UPDATE content_articles SET alias='{$new_alias}' WHERE articleID='{$row['articleID']}'";
    mysql_query($update_sql);
    echo "  ✓ Оновлено\n\n";
}

echo "=== Готово ===\n";
mysql_close($conn);
?>
