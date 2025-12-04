<?php
// Тест БД
$db_host = "localhost";
$db_user = "is501201_inm";
$db_pass = "(!keSB72a5";
$db_name = "is501201_inm";

$conn = mysql_connect($db_host, $db_user, $db_pass);
if (!$conn) {
    die("Connection failed: " . mysql_error());
}

mysql_select_db($db_name, $conn);

$sql = "SELECT articleID, name, alias, visible FROM content_articles WHERE alias IN ('videoperedachi', 'otzivi', 'kontakti', 'apteki') LIMIT 10";
$result = mysql_query($sql);

echo "Знайдено рядків: " . mysql_num_rows($result) . "\n\n";

while ($row = mysql_fetch_assoc($result)) {
    echo "ID: {$row['articleID']}, Name: {$row['name']}, Alias: {$row['alias']}, Visible: {$row['visible']}\n";
}

mysql_close($conn);
?>
