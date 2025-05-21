<?php


header('Content-Type: text/html; charset=UTF-8');


$session_started = false;
if ($_COOKIE[session_name()] && session_start()) {
  $session_started = true;
  if (!empty($_SESSION['login'])) {
    // Если есть логин в сессии, то пользователь уже авторизован.
    // TODO: Сделать выход (окончание сессии вызовом session_destroy()
    //при нажатии на кнопку Выход).
    
    // Делаем перенаправление на форму.
    header('Location: ./');
    exit();
  }
}

// В суперглобальном массиве $_SERVER PHP сохраняет некторые заголовки запроса HTTP
// и другие сведения о клиненте и сервере, например метод текущего запроса $_SERVER['REQUEST_METHOD'].
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  if (!empty($_COOKIE["error_aut"])) {
    print "<div>Неправильный логин или пароль</div><br/>";
  }
  print '<form action="login.php" method="post"> 
        <label>
            логин:
            <br/>
            <input name="login" />
        </label>
        <br/>
        <label>
            пароль:
            <br/>
            <input name="pass"/>
        </label>
        <br/>
        <input type="submit" value="Войти" />
    </form>';
}
// Иначе, если запрос был методом POST, т.е. нужно сделать авторизацию с записью логина в сессию.
else {
  // TODO: Проверть есть ли такой логин и пароль в базе данных.
  // Выдать сообщение об ошибках.
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
            if (!$session_started) {
              session_start();
            }
            $_SESSION['login'] = $_POST['login']; // Сохраняем логин в сессии
            $_SESSION['uid'] = $result["id"]; // Сохраняем ID пользователя в сессии

            // Удаляем ошибку авторизации, если она была
            setcookie('error_aut', '', time() - 3600); // Удаляем cookie

            
        } else {
            // Если логин или пароль неверны, устанавливаем ошибку в cookie
            setcookie('error_aut', '1');
        }
    } else {
        die("Ошибка при добавлении данных: " . $stmt->error);
    }
  


  // Делаем перенаправление.
  header('Location: ./');
}
?>