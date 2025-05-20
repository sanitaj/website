<?php
$host = 'localhost';
$dbname = 'users_db';
$username = 'root'; // стандартный логин в XAMPP
$password = '';     // по умолчанию пароль пустой

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}
?>
