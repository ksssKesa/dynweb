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

// Проверка сессии
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: vk_auth.php");
    exit();
}

// Проверка куки авторизации и восстановление сессии из куки, если она существует
if(isset($_COOKIE['user_auth'])) {
    $user_data = json_decode(base64_decode($_COOKIE['user_auth']), true);
    if(isset($user_data['user_id']) && isset($user_data['login']) && isset($user_data['is_admin'])) {
        $_SESSION['user_id'] = $user_data['user_id'];
        $_SESSION['first_name'] = $user_data['first_name'];
        $_SESSION['last_name'] = $user_data['last_name'];
    }
}

// Запрос к базе данных для получения данных студента
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM grades WHERE student_id='$user_id'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабинет студента</title>
    <link rel="stylesheet" href="student_styles.css">
</head>
<body>
    <div class="container">
        <h2>Добро пожаловать, <?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?>!</h2>
        <h3>Ваши оценки:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Предмет</th>
                    <th>Оценка</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Мат анализ</td>
                </tr>
                <tr>
                    <td>Комбинаторные алгоритмы</td>
                </tr>
                <tr>
                    <td>Язык Python</td>
                </tr>
                <tr>
                    <td>Компьютерные сети</td>
                </tr>
                <tr>
                    <td>Операционные системы</td>
                </tr>
                <tr>
                    <td>Базы данных</td>
                </tr>
            </tbody>
        </table>
        <br>
        <a href="logout.php" class="button_vk">Выйти</a>
    </div>
</body>
</html>