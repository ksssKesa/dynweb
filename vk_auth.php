<?php
// Подключение к базе данных
$servername = "localhost";
$username = "kssskesa";
$password = "dariadb0347";
$dbname = "StudentPortal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$id = $_POST["id"];

// Проверка наличия студента в базе данных
$result = $conn->query("SELECT * FROM users WHERE id = '{$id}'");

if ($result->num_rows == 0) {
    // Студента нет в базе данных, добавляем его данные
    $conn->query("INSERT INTO users (id, last_name, first_name) VALUES ('{$id}', '{$last_name}', '{$first_name}')");

    // Установка данных в сессию
    session_start();
    $_SESSION['user_id'] = $id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;

    // Перенаправляем на страницу student_dashboard.php с данными студента
    header("Location: student_dashboard.php?id={$id}");
} else {
    // Студент уже есть в базе данных, устанавливаем данные в сессию
    session_start();
    $_SESSION['user_id'] = $id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    
    // Студент уже есть в базе данных, перенаправляем на страницу student_dashboard.php
    header("Location: student_dashboard.php?id={$id}");
}

$conn->close();
?>