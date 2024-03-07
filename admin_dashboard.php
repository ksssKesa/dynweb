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
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

// Запрос к базе данных для получения данных админа
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// Запрос к базе данных для получения списка студентов
$sqlStudents = "SELECT id, first_name, last_name FROM users WHERE is_admin=0";
$resultStudents = $conn->query($sqlStudents);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администраторский кабинет</title>
    <link rel="stylesheet" href="admin_styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Добро пожаловать, <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>!</h2>
        <br>
        <!-- Форма для внесения оценок -->
        <h3>Внесите оценки студентам:</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Студент</th>
                    <th>Предмет</th>
                    <th>Оценка</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($student = $resultStudents->fetch_assoc()) { ?>
                    <tr>
                        <td class="student-cell"><?php echo $student['first_name'] . ' ' . $student['last_name']; ?></td>
                        <td class="subject-cell">
                            <select id="subject" name="subject">
                                <option value="1">Мат анализ</option>
                                <option value="2">Комбинаторные алгоритмы</option>
                                <option value="3">Язык Python</option>
                                <option value="4">Компьютерные сети</option>
                                <option value="5">Операционные системы</option>
                                <option value="6">Базы данных</option>
                            </select>
                        </td>
                        <td class="grade-cell">
                            <input type="number" id="grade">
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <br>
        <button id="addDataBtn" onclick="addData()">ВНЕСТИ ДАННЫЕ</button>
        <br>
        <a href="logout.php" class="button_out">Выйти</a>
    </div>

    <!-- Обработка добавления оценок в БД -->
    <script>
        function handleSubjectChange(studentId) {
            const selectElement = $(`#subject_${studentId}`);
            const gradeInput = $(`#grade_${studentId}`);
            const selectedSubject = selectElement.val();
            const grade = gradeInput.val();

            // Отправка данных на сервер с использованием AJAX
            $.ajax({
                type: "POST",
                url: "add_grade.php", // Замените на путь к вашему скрипту для обработки данных
                data: {
                    studentId: studentId,
                    subject: selectedSubject,
                    grade: grade
                },
                success: function(response) {
                    // Обработка успешного ответа (если нужно)
                    alert('Оценка успешно добавлена в базу данных!');
                },
                error: function(error) {
                    // Обработка ошибки (если нужно)
                    alert('Произошла ошибка при добавлении оценки в базу данных.');
                }
            });
        }

        function addData() {
        // Перебираем все строки таблицы с данными студентов
        $('.table tbody tr').each(function () {
            // Получаем ID студента из атрибута data-student-id
            var studentId = $(this).data('student-id');

            // Получаем выбранный предмет и введенную оценку для данного студента
            var selectedSubject = $(`#subject_${studentId}`).val();
            var grade = $(`#grade_${studentId}`).val();

            // Отправляем данные на сервер с использованием AJAX
            $.ajax({
                type: "POST",
                url: "add_grade.php", // Замените на путь к вашему скрипту для обработки данных
                data: {
                    studentId: studentId,
                    subject: selectedSubject,
                    grade: grade
                },
                success: function(response) {
                    // Обработка успешного ответа (если нужно)
                    console.log('Оценка успешно добавлена в базу данных для студента с ID ' + studentId);
                },
                error: function(error) {
                    // Обработка ошибки (если нужно)
                    console.error('Произошла ошибка при добавлении оценки в базу данных для студента с ID ' + studentId);
                }
            });
        });
    }
    </script>
</body>
</html>