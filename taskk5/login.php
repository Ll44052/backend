<?php
// Запуск сессии в начале скрипта
session_start();

// Устанавливаем заголовок для кодировки
header('Content-Type: text/html; charset=UTF-8');

// Проверка, если сессия уже началась и пользователь авторизован
if (!empty($_SESSION['login'])) {
    // Если пользователь уже авторизован, перенаправляем на другую страницу
    header('Location: input.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Подключаемся к базе данных
    $conn = new mysqli("localhost", "u68676", "8999741", "u68676");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }

    // Подготавливаем SQL запрос для поиска пользователя по логину
    $stmt = $conn->prepare("SELECT * FROM forms WHERE logi = ?");
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("s", $_POST["login"]);
    if ($stmt->execute()) {
        // Получаем результат из базы данных
        $result = $stmt->get_result()->fetch_assoc();
        $p = md5($_POST["pass"]); // Хешируем пароль
        mysqli_close($conn);

        // Проверка логина и пароля
        if ($result && $result["pass"] === $p) {
            // Если все в порядке, авторизуем пользователя
            $_SESSION['login'] = $_POST['login']; // Сохраняем логин в сессии
            $_SESSION['uid'] = $result["id"]; // Сохраняем ID пользователя в сессии

            // Удаляем ошибку авторизации, если она была
            setcookie('error_aut', '', time() - 3600); // Удаляем cookie

            // Перенаправляем на страницу входа
            header('Location: input.php');
            exit();
        } else {
            // Если логин или пароль неверны, устанавливаем ошибку в cookie
            setcookie('error_aut', '1');
        }
    } else {
        die("Ошибка при добавлении данных: " . $stmt->error);
    }

    // Перенаправляем обратно на страницу входа
    header('Location: login.php');
    exit();
}
?>

<!-- HTML форма для входа -->
<form action="login.php" method="post">
    <?php
    // Если есть ошибка авторизации, показываем сообщение
    if (!empty($_COOKIE['error_aut'])) {
        print '<div>Неправильный логин или пароль</div><br/>';
    }
    ?>
    <label>
        логин:
        <br/>
        <input name="login" />
    </label>
    <br/>
    <label>
        пароль:
        <br/>
        <input name="pass" type="password"/>
    </label>
    <br/>
    <input type="submit" value="Войти" />
</form>