<?php
if(isset($_POST["Fio"]) && isset($_POST["Tel"]) && 
    isset($_POST["Email"]) && isset($_POST["Birth_date"]) && isset($_POST["Gender"]) && isset($_POST["Favlangs"]) && isset($_POST["Bio"])) 
{
    $fio = trim($_POST["Fio"]);
    $tel = trim($_POST["Tel"]);
    if(!isset($_POST["Familiar"])) die("Ознакомьтесь с контрактом");
    $email = trim($_POST["Email"]);
    $birth_date = trim($_POST["Birth_date"]);
    $gender = trim($_POST["Gender"]);
    $favlangs = $_POST["Favlangs"];
    $bio = trim($_POST["Bio"]);
    
    if (!preg_match("/^[a-zA-Zа-яА-ЯёЁ\s]+$/u", $fio)) {
        die("Ошибка: Имя может содержать только буквы и пробелы.");
    }
    if (strlen($fio) < 10 || strlen($fio) > 50) {
        die("Ошибка: ФИО должно содержать от 10 до 50 символов.");
    }
    

    if (!preg_match("/^\+[0-9]+$/u", $tel)) {
        die("Ошибка: Телефон должен начинаться с + и содержать цифры.");
    }
    if (strlen($tel) < 10 || strlen($tel) > 20) {
        die("Ошибка: Телефон должен содержать от 10 до 20 символов.");
    }
    

    if (!preg_match("/^[a-zA-Z0-9@.]+$/u", $email)) {
        die("Ошибка: Почта может содержать только латинские буквы, '@' и '.'");
    }
    if (strpos($email, '@') === false) {
        die("Ошибка: Некорректная почта");
    }
    

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

    echo "Данные добавлены в базу данных";



}
else
{   
    echo "Введенные данные некорректны";
}
?>