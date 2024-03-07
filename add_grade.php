<?php
session_start();

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    echo "Доступ запрещен!";
    exit();
}

// Подключение к базе данных
$servername = "localhost";
$username = "kssskesa";
$password = "dariadb0347";
$dbname = "StudentPortal";

$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    echo "Connection failed: " . $conn->connect_error;
    exit();
}

// Получение данных из AJAX-запроса
$studentId = $_POST['studentId'];
$subject = $_POST['subject'];
$grade = $_POST['grade'];

// Добавление данных в базу данных
$sql = "INSERT INTO grades (student_id, subject, grade) VALUES ('$studentId', '$subject', '$grade')";
if ($conn->query($sql) === TRUE) {
    echo "Оценки успешно добавлены";
} else {
    echo "Ошибка: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>