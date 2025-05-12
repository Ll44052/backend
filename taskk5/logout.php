<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION = array();
    setcookie(session_name(), '', 10000);
    session_destroy();
    header('Location: login.php');
    exit();
}
?>