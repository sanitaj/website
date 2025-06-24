<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/db.php'; // Предполагается, что в db.php создается объект $conn для PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        die("Passwords do not match.");
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
            $_SESSION['username'] = $username; // сохраняем username нового пользователя
            header("Location: cards.php");
            exit();
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) { // Код ошибки для дублирующегося значения
            echo "A user with this username or email already exists.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>