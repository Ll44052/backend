<?php
header('Content-Type: text/html; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Массив для временного хранения сообщений пользователю.
    $messages = array();
  

    if (!empty($_COOKIE['save'])) {
      setcookie('save', '', 100000);
      $messages[] = 'Спасибо, результаты сохранены.';
    }
  
    // Складываем признак ошибок в массив.
    $errors = array();
    $errors['fio'] = !empty($_COOKIE['fio_error']);
    $errors['fio_f'] = !empty($_COOKIE['fio_error_f']);
    $errors['fio_s'] = !empty($_COOKIE['fio_error_s']);
    $errors['tel'] = !empty($_COOKIE['tel_error']);
    $errors['tel_f'] = !empty($_COOKIE['tel_error_f']);
    $errors['tel_s'] = !empty($_COOKIE['tel_error_s']);
    $errors['familiar'] = !empty($_COOKIE['familiar_error']);
    $errors['email'] = !empty($_COOKIE['email_error']);
    $errors['email_f'] = !empty($_COOKIE['email_error_f']);
    $errors['email_s'] = !empty($_COOKIE['email_error_s']);
    $errors['birth_date'] = !empty($_COOKIE['birth_date_error']);
    $errors['gender'] = !empty($_COOKIE['gender_error']);
    $errors['favlangs'] = !empty($_COOKIE['favlangs_error']);
    $errors['bio'] = !empty($_COOKIE['bio_error']);

    if ($errors['fio']) {
      setcookie('fio_error', '', 100000);
      setcookie('fio_value', '', 100000);
      $messages[] = '<div class="error">Заполните имя.</div>';
    }
    if ($errors['fio_f']) {
        setcookie('fio_error_f', '', 100000);
        setcookie('fio_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: Имя может содержать только буквы и пробелы.</div>';
    }
    if ($errors['fio_s']) {
        setcookie('fio_error_s', '', 100000);
        setcookie('fio_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: ФИО должно содержать от 10 до 50 символов.</div>';
    }
    if ($errors['tel']) {
        setcookie('tel_error', '', 100000);
        setcookie('tel_value', '', 100000);
        $messages[] = '<div class="error">Заполните телефон.</div>';
    }
    if ($errors['tel_f']) {
        setcookie('tel_error_f', '', 100000);
        setcookie('tel_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: Телефон должен начинаться с + и содержать цифры.</div>';
    }
    if ($errors['tel_s']) {
        setcookie('tel_error_s', '', 100000);
        setcookie('tel_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: Телефон должен содержать от 10 до 20 символов.</div>';
    }
    if ($errors['familiar']) {
        setcookie('familiar_error', '', 100000);
        setcookie('familiar_value', '', 100000);
        $messages[] = '<div class="error">Ознакомьтесь с контрактом.</div>';
    }
    if ($errors['email']) {
        setcookie('email_error', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Заполните почту.</div>';
    }
    if ($errors['email_f']) {
        setcookie('email_error_f', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: Почта может содержать только латинские буквы, "@" и "."</div>';
    }
    if ($errors['email_s']) {
        setcookie('email_error_s', '', 100000);
        setcookie('email_value', '', 100000);
        $messages[] = '<div class="error">Ошибка: Некорректная почта</div>';
    }
    if ($errors['birth_date']) {
        setcookie('birth_date_error', '', 100000);
        setcookie('birth_date_value', '', 100000);
        $messages[] = '<div class="error">Заполните дату рождения.</div>';
    }
    if ($errors['gender']) {
        setcookie('gender_error', '', 100000);
        setcookie('gender_value', '', 100000);
        $messages[] = '<div class="error">Укажите пол.</div>';
    }
    if ($errors['favlangs']) {
        setcookie('favlangs_error', '', 100000);
        setcookie('favlangs_value', '', 100000);
        $messages[] = '<div class="error">Выберите любимые языки.</div>';
    }
    if ($errors['bio']) {
        setcookie('bio_error', '', 100000);
        setcookie('bio_value', '', 100000);
        $messages[] = '<div class="error">Заполните биографию.</div>';
    }
    
  
    // Складываем предыдущие значения полей в массив, если есть.
    $values = array();
    $values['fio'] = empty($_COOKIE['fio_value']) ? '' : $_COOKIE['fio_value'];
    $values['tel'] = empty($_COOKIE['tel_value']) ? '' : $_COOKIE['tel_value'];
    $values['familiar'] = empty($_COOKIE['familiar_value']) ? '' : $_COOKIE['familiar_value'];
    $values['email'] = empty($_COOKIE['email_value']) ? '' : $_COOKIE['email_value'];
    $values['birth_date'] = empty($_COOKIE['birth_date_value']) ? '' : $_COOKIE['birth_date_value'];
    $values['gender'] = empty($_COOKIE['gender_value']) ? '' : $_COOKIE['gender_value'];
    $values['favlangs'] = empty($_COOKIE['favlangs_value']) ? '' : $_COOKIE['favlangs_value'];
    $values['bio'] = empty($_COOKIE['bio_value']) ? 'Впишите свою биографию.' : $_COOKIE['bio_value'];
    
  
    // Включаем содержимое файла form.php.
    // В нем будут доступны переменные $messages, $errors и $values для вывода 
    include('index.php');
  }
else {
    $errors = FALSE;

    if (empty($_POST['Fio'])) {
      setcookie('fio_error', '1');
      $errors = TRUE;
    }
    else {
      $fio = trim($_POST["Fio"]);
      if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s]+$/u", $fio)) {
        setcookie('fio_error_f', '1');
        $errors = TRUE;
      }
      if (strlen($fio) < 10 || strlen($fio) > 50) {
        setcookie('fio_error_s', '1');
        $errors = TRUE;
      }
    }

    if (empty($_POST['Tel'])) {
        setcookie('tel_error', '1');
        $errors = TRUE;
    }
    else {
        $tel = trim($_POST["Tel"]);
        if (!preg_match("/^\+[0-9]+$/u", $tel)) {
          setcookie('tel_error_f', '1');
          $errors = TRUE;
        }
        if (strlen($tel) < 10 || strlen($tel) > 20) {
          setcookie('tel_error_s', '1');
          $errors = TRUE;
        }
    }

    if (empty($_POST['Familiar'])) {
        setcookie('familiar_error', '1');
        $errors = TRUE;
    }

    if (empty($_POST['Email'])) {
        setcookie('email_error', '1');
        $errors = TRUE;
    }
    else {
        $email = trim($_POST["Email"]);
        if (!preg_match("/^[a-zA-Z0-9@.]+$/u", $email)) {
          setcookie('email_error_f', '1');
          $errors = TRUE;
        }
        if (strpos($email, '@') === false) {
          setcookie('email_error_s', '1');
          $errors = TRUE;
        }
    }

    if (empty($_POST['Birth_date'])) {
        setcookie('birth_date_error', '1');
        $errors = TRUE;
    }

    if (empty($_POST['Gender'])) {
        setcookie('gender_error', '1');
        $errors = TRUE;
    }

    if (empty($_POST['Favlangs'])) {
        setcookie('favlangs_error', '1');
        $errors = TRUE;
    }

    if (empty($_POST['Bio'])) {
        setcookie('bio_error', '1');
        $errors = TRUE;
    } 
    $v = time() + 365 * 24 * 60 * 60;
    setcookie('fio_value', $_POST['Fio'], $v);
    setcookie('tel_value', $_POST['Tel'], $v);
    setcookie('familiar_value', $_POST['Familiar'], $v);
    setcookie('email_value', $_POST['Email'], $v);
    setcookie('birth_date_value', $_POST['Birth_date'], $v);
    setcookie('gender_value', $_POST['Gender'], $v);
    $favlangs = $_POST["Favlangs"];
    $result = '';
    foreach($favlangs as $item){
        $result .= $item.' ';
    }
    setcookie('favlangs_value', $result, $v);
    setcookie('bio_value', $_POST['Bio'], $v);
    
  

    if ($errors) {
      header('Location: input.php');
      exit();
    }
    else {
      setcookie('fio_error', '', 100000);
      setcookie('fio_error_f', '', 100000);
      setcookie('fio_error_s', '', 100000);
      setcookie('tel_error', '', 100000);
      setcookie('tel_error_f', '', 100000);
      setcookie('tel_error_s', '', 100000);
      setcookie('familiar_error', '', 100000);
      setcookie('email_error', '', 100000);
      setcookie('email_error_f', '', 100000);
      setcookie('email_error_s', '', 100000);
      setcookie('birth_date_error', '', 100000);
      setcookie('gender_error', '', 100000);
      setcookie('favlangs_error', '', 100000);
      setcookie('bio_error', '', 100000);
      
    }
  
    $fio = trim($_POST["Fio"]);
    $tel = trim($_POST["Tel"]);
    if(!isset($_POST["Familiar"])) die("Ознакомьтесь с контрактом");
    $email = trim($_POST["Email"]);
    $birth_date = trim($_POST["Birth_date"]);
    $gender = trim($_POST["Gender"]);
    $favlangs = $_POST["Favlangs"];
    $bio = trim($_POST["Bio"]);


    $conn = new mysqli("localhost", "u68676", "8999741", "u68676");
    if($conn->connect_error){
        die("Ошибка: " . $conn->connect_error);
    }
    $stmt = $conn->prepare("INSERT INTO forms (fio, tel, email, gender, birth_date, bio) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $fio, $tel, $email, $gender, $birth_date, $bio);
    if ($stmt->execute()) {
        $last_id = $conn->insert_id;
        foreach($favlangs as $item) {
            $stmt = $conn->prepare("INSERT INTO favlangs (id, id_lang) VALUES (?, ?)");
            if (!$stmt) {
                die("Ошибка подготовки запроса: " . $conn->error);
            }
            $stmt->bind_param("ii", $last_id, $item);
            if (!$stmt->execute()) {
                die("Ошибка при добавлении данных: " . $stmt->error);
            }
        }

    } else {
        die("Ошибка при добавлении данных: " . $stmt->error);
    }
  
    setcookie('save', '1');
  
    header('Location: input.php');
  }
?>