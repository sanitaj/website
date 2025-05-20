<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $stmt->bind_result($hashedPassword);
    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        echo "Успешный вход!";
        // можно создать сессию или перенаправить
    } else {
        echo "Неверный логин или пароль.";
    }

    $stmt->close();
    $conn->close();
}
?>
