<?php
//файл соединения с базой данных mysql
$host   = 'localhost';
$dbname = 'u68676';
$user   = 'u68676';
$pass   = '8999741';
//Подключаемся к базе
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
?>
