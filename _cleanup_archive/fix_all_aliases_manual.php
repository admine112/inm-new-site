<?php
// РУЧНА перевірка та виправлення КОЖНОГО alias
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

echo "=== РУЧНА ПЕРЕВІРКА ВСІХ ALIAS ===\n\n";

// Отримати ВСІ статті
$sql = "SELECT articleID, name, alias, visible FROM content_articles WHERE visible=1 ORDER BY articleID";
$res = mysql_query($sql);

$fixed = 0;
$total = 0;

while ($row = mysql_fetch_assoc($res)) {
    $total++;
    $id = $row['articleID'];
    $name = $row['name'];
    $old_alias = $row['alias'];
    
    // Очистити alias
    $new_alias = trim($old_alias); // Видалити пробіли на початку/кінці
    $new_alias = preg_replace('/\s+/', '-', $new_alias); // Замінити всі пробіли на дефіс
    $new_alias = preg_replace('/-+/', '-', $new_alias); // Замінити подвійні дефіси на одинарні
    
    if ($old_alias !== $new_alias) {
        echo "ID {$id}: {$name}\n";
        echo "  БУЛО: '{$old_alias}'\n";
        echo "  СТАЛО: '{$new_alias}'\n";
        
        $update_sql = "UPDATE content_articles SET alias='" . mysql_real_escape_string($new_alias) . "' WHERE articleID='{$id}'";
        mysql_query($update_sql);
        echo "  ✓ ВИПРАВЛЕНО\n\n";
        $fixed++;
    }
}

echo "\n=== РЕЗУЛЬТАТ ===\n";
echo "Перевірено: {$total}\n";
echo "Виправлено: {$fixed}\n";

mysql_close($conn);
?>
