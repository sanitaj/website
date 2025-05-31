<?php
session_start();
require 'db.php'; // Предполагается, что в db.php создается объект $conn для PDO

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

    try {
        $stmt = $conn->prepare("INSERT INTO users (name, username, phone, email, password) VALUES (:name, :username, :phone, :email, :password)");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['user_id'] = $conn->lastInsertId(); // сохраняем id нового пользователя
            header("Location: cards.php");
            exit();
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Код ошибки для дублирующегося значения
            echo "Пользователь с таким username или email уже существует.";
        } else {
            echo "Ошибка: " . $e->getMessage();
        }
    }
}
?>