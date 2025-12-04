#!/bin/bash

echo "🔧 Виправлення connect.php для роботи з PHP 7.4..."

# Змінити власника файлу
sudo chown $USER:$USER www/www/settings/connect.php

# Створити новий файл
cat > www/www/settings/connect.php << 'EOFPHP'
<?php
  $mysqli = mysqli_connect($glb["db_host"], $glb["db_user"], $glb["db_password"], $glb["db_basename"]);
  if (!$mysqli) {
      die("Ошибка соединения с базой, проверьте настройки: " . mysqli_connect_error());
  }
  mysqli_set_charset($mysqli, "utf8");
  
  // Для обратной совместимости со старым кодом
  function mysql_query($query) {
      global $mysqli;
      return mysqli_query($mysqli, $query);
  }
  
  function mysql_fetch_assoc($result) {
      return mysqli_fetch_assoc($result);
  }
  
  function mysql_num_rows($result) {
      return mysqli_num_rows($result);
  }
  
  function mysql_insert_id() {
      global $mysqli;
      return mysqli_insert_id($mysqli);
  }
  
  function mysql_error() {
      global $mysqli;
      return mysqli_error($mysqli);
  }
  
  function mysql_real_escape_string($string) {
      global $mysqli;
      return mysqli_real_escape_string($mysqli, $string);
  }
  
  function mysql_fetch_array($result) {
      return mysqli_fetch_array($result);
  }
  
  function mysql_fetch_row($result) {
      return mysqli_fetch_row($result);
  }
?>
EOFPHP

echo "✅ Файл оновлено!"
echo ""
echo "Перевірка сайту..."
sleep 2
curl -I http://localhost:8090/ 2>&1 | head -5
echo ""
echo "Відкрийте http://localhost:8090/ у браузері"
