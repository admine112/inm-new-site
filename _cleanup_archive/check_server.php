<?php
header("Content-Type: text/html; charset=utf-8");
echo "<h1>Диагностика сервера (Картинки)</h1>";

// 1. Проверка GD Library
echo "<h2>1. Библиотека GD (обработка картинок)</h2>";
if (extension_loaded('gd') && function_exists('gd_info')) {
    echo "<p style='color:green'>✅ GD Library установлена.</p>";
    $gd = gd_info();
    echo "<pre>";
    print_r($gd);
    echo "</pre>";
} else {
    echo "<p style='color:red'>❌ GD Library НЕ установлена! Картинки не будут обрабатываться.</p>";
}

// 2. Проверка папок на запись
echo "<h2>2. Права на запись</h2>";
$dirs = array(
    'images',
    'images/commodities',
    'uploads'
);

foreach ($dirs as $dir) {
    $path = __DIR__ . '/' . $dir;
    if (!file_exists($path)) {
        echo "<p style='color:red'>❌ Папка <b>$dir</b> не существует!</p>";
        // Пытаемся создать
        if (@mkdir($path, 0777, true)) {
            echo "<p style='color:green'>✅ Папка <b>$dir</b> была успешно создана.</p>";
        }
    }
    
    if (file_exists($path)) {
        if (is_writable($path)) {
            echo "<p style='color:green'>✅ Папка <b>$dir</b> доступна для записи.</p>";
        } else {
            echo "<p style='color:red'>❌ Папка <b>$dir</b> НЕ доступна для записи! (Нужны права 777)</p>";
        }
    }
}

// 3. Настройки PHP
echo "<h2>3. Настройки PHP</h2>";
echo "file_uploads: " . ini_get('file_uploads') . "<br>";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "<br>";
echo "post_max_size: " . ini_get('post_max_size') . "<br>";
echo "memory_limit: " . ini_get('memory_limit') . "<br>";

?>
