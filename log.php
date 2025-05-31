<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "users_db";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();

if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id']; 
        header("Location: profile.php");
        exit();
    } else {
        echo "Неверный пароль.";
    }
} else {
    echo "Пользователь не найден.";
}
?>