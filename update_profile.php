<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    require 'db.php'; // Подключение к базе данных через PDO

    try {
        // Подготовка запроса для обновления данных пользователя
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, phone = :phone WHERE id = :id");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':id', $_SESSION['user_id'], PDO::PARAM_INT);

        // Выполнение запроса
        $stmt->execute();

        // Перенаправление на страницу аккаунта после успешного обновления
        header("Location: account.php");
        exit();
    } catch (PDOException $e) {
        // Обработка ошибок
        echo "Ошибка: " . $e->getMessage();
    }
}
?>