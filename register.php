<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Пароли не совпадают.");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("INSERT INTO users (name, username, phone, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $username, $phone, $email, $hashed_password);

    
    if ($stmt->execute()) {
        echo "Успешная регистрация!";
    } else {
        if ($stmt->errno == 1062) {
            echo "Пользователь с таким username или email уже существует.";
        } else {
            echo "Ошибка: " . $stmt->error;
    }
}

    $stmt->close();
    $conn->close();
}
?>
