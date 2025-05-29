<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];

    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "users_db";
    $conn = new mysqli($host, $user, $password, $dbname);

    if (!$conn->connect_error) {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $stmt->bind_result($db_password);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($old_password, $db_password)) {
            $new_hashed = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
            $stmt->bind_param("si", $new_hashed, $_SESSION['user_id']);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            header("Location: account.php");
            exit();
        } else {
            $conn->close();
            echo "Старый пароль неверен.";
        }
    } else {
        echo "Ошибка подключения к базе данных.";
    }
}
?>