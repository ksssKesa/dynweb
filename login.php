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

// Обработка формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Запрос к базе данных для проверки логина и пароля
    $sql = "SELECT * FROM users WHERE login='$login' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Пользователь найден, создаем сессию и устанавливаем куки
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['login'] = $row['login'];
        $_SESSION['is_admin'] = $row['is_admin'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];

        // Установка куки авторизации (время действия - 1 час)
        $cookie_name = "user_auth";
        $cookie_value = base64_encode(json_encode($_SESSION));
        setcookie($cookie_name, $cookie_value, time() + 3600, "/");

        // Перенаправление на страницу админа
        if ($_SESSION['is_admin']) {
            header("Location: admin_dashboard.php");
        }
    } else {
        // Неверный логин или пароль
        echo "Неверный логин или пароль";
    }
}

$conn->close();
?>