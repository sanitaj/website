
<?php
session_start();

$host = "localhost";
$user = "root";
$password = "";
$dbname = "users_db";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
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

$stmt->close();
$conn->close();
?>