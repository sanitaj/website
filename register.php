<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем поля из формы
    $name = $_POST['name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        die("Пароли не совпадают.");
    }

    // Хешируем пароль
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL запрос
    $stmt = $conn->prepare("INSERT INTO users (name, username, phone, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $phone, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Успешная регистрация!";
    } else {
        echo "Ошибка: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
