<?php
// Debug script
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== DEBUG ===\n\n";

// Test URL
$url = isset($_GET['url']) ? $_GET['url'] : 'videoperedachi';
echo "URL: $url\n\n";

// DB connection
$db_host = "is501201.mysql.ukraine.com.ua";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = @mysql_connect($db_host, $db_user, $db_pass);
if (!$conn) {
    die("DB Connection failed\n");
}

mysql_select_db($db_name, $conn);

// Check if page exists
$sql = "SELECT articleID, name, alias, visible FROM content_articles WHERE alias='$url' LIMIT 1";
$result = mysql_query($sql);

echo "Query: $sql\n";
echo "Rows found: " . mysql_num_rows($result) . "\n\n";

if (mysql_num_rows($result) > 0) {
    $row = mysql_fetch_assoc($result);
    echo "FOUND:\n";
    echo "  ID: {$row['articleID']}\n";
    echo "  Name: {$row['name']}\n";
    echo "  Alias: {$row['alias']}\n";
    echo "  Visible: {$row['visible']}\n";
} else {
    echo "NOT FOUND!\n";
}

mysql_close($conn);
?>
