<?php
header("Content-Type: text/plain; charset=utf-8");
require_once("settings/conf.php");
require_once("settings/connect.php");

echo "=== Email Configuration Check ===\n\n";

// Check global email from conf.php
echo "Email из conf.php: " . $global_meil . "\n\n";

// Check email from database
$sql = "SELECT `email` FROM `domens` WHERE `name`='inmunoflam.com.ua' LIMIT 1";
$result = mysql_query($sql);
if ($row = mysql_fetch_assoc($result)) {
    echo "Email из БД (domens): " . ($row['email'] != "" ? $row['email'] : "не указан") . "\n";
} else {
    echo "Домен не найден в БД\n";
}

echo "\n=== Итоговый email для заявок ===\n";
echo "Заявки с сайта отправляются на: " . ($row['email'] != "" ? $row['email'] : $global_meil) . "\n";
?>
