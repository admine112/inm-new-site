<?php
// Скрипт для виправлення порожніх H1 в базі даних
error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

echo "Connecting to DB...\n";
$conn = mysql_connect($db_host, $db_user, $db_pass);
if (!$conn) {
    die("Connection failed: " . mysql_error() . "\n");
}

mysql_select_db($db_name, $conn);
mysql_query("SET NAMES UTF8");

// 1. Перевірити скільки порожніх H1
$check_sql = "SELECT count(*) as cnt FROM content_articles WHERE (h1 IS NULL OR h1='') AND visible='1'";
$res = mysql_query($check_sql);
$row = mysql_fetch_assoc($res);
echo "Found {$row['cnt']} pages with empty H1.\n";

// 2. Оновити H1 = name там де H1 порожній
if ($row['cnt'] > 0) {
    $update_sql = "UPDATE content_articles SET h1=name WHERE (h1 IS NULL OR h1='') AND visible='1'";
    $update_res = mysql_query($update_sql);
    
    if ($update_res) {
        echo "Successfully updated " . mysql_affected_rows() . " rows.\n";
    } else {
        echo "Update failed: " . mysql_error() . "\n";
    }
}

// 3. Перевірити результат для videoperedachi
$test_sql = "SELECT name, h1 FROM content_articles WHERE alias='videoperedachi'";
$test_res = mysql_query($test_sql);
$test_row = mysql_fetch_assoc($test_res);
echo "Check 'videoperedachi': Name='{$test_row['name']}', H1='{$test_row['h1']}'\n";

mysql_close($conn);
?>
