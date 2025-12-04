<?php
// Скрипт для обновления мета-тегов страницы "Состав Инмунофлама"
// Дата: 27 ноября 2025

// Подключение к базе данных
$host = 'is501201.mysql.ukraine.com.ua';
$user = 'is501201_admin';
$pass = 'Qm0yQn6qUq';
$db   = 'is501201_inmunoflam';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("❌ Ошибка подключения: " . mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8');

echo "✅ Подключение к базе данных успешно<br><br>";

// SQL-запрос для обновления
$sql = "UPDATE content 
SET 
    title = 'Инмунофлам: мощная природная поддержка Т-клеточного иммунитета и профилактика заболеваний',
    description = 'Инмунофлам — растительный иммуномодулятор с более чем 70 активными компонентами. Иммуномодулирующее, антиоксидантное и противовоспалительное действие, подтвержденное клиническими исследованиями.',
    h1 = 'ЧТО СОБОЙ ПРЕДСТАВЛЯЕТ ИНМУНОФЛАМ'
WHERE alias = 'sostav-inmunoflama'";

if (mysqli_query($conn, $sql)) {
    $affected = mysqli_affected_rows($conn);
    echo "✅ Запрос выполнен успешно!<br>";
    echo "📊 Обновлено строк: $affected<br><br>";
    
    // Проверка результата
    $check = "SELECT id, name, alias, title, description, h1 FROM content WHERE alias = 'sostav-inmunoflama'";
    $result = mysqli_query($conn, $check);
    
    if ($result && mysqli_num_rows($result) > 0) {
        echo "<h3>Результат обновления:</h3>";
        $row = mysqli_fetch_assoc($result);
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Поле</th><th>Значение</th></tr>";
        echo "<tr><td>ID</td><td>" . $row['id'] . "</td></tr>";
        echo "<tr><td>Name</td><td>" . $row['name'] . "</td></tr>";
        echo "<tr><td>Alias</td><td>" . $row['alias'] . "</td></tr>";
        echo "<tr><td>Title</td><td>" . htmlspecialchars($row['title']) . "</td></tr>";
        echo "<tr><td>Description</td><td>" . htmlspecialchars($row['description']) . "</td></tr>";
        echo "<tr><td>H1</td><td>" . htmlspecialchars($row['h1']) . "</td></tr>";
        echo "</table>";
    } else {
        echo "⚠️ Страница с alias 'sostav-inmunoflama' не найдена<br>";
    }
} else {
    echo "❌ Ошибка выполнения запроса: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);

echo "<br><br><strong>Готово! Можете удалить этот файл после проверки.</strong>";
?>
