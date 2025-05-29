<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "users_db";
    $conn = new mysqli($host, $user, $password, $dbname);

    if (!$conn->connect_error) {
        $stmt = $conn->prepare("UPDATE users SET name=?, username=?, email=?, phone=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $username, $email, $phone, $_SESSION['user_id']);
        $stmt->execute();
        $stmt->close();
        $conn->close();
        header("Location: account.php");
        exit();
    } else {
        echo "Ошибка подключения к базе данных.";
    }
}
?>