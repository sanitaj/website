<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/db.php';
require_once __DIR__ . '/../vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, username, password, ga_secret FROM users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    if (!empty($user['ga_secret'])) {
        $_SESSION['tmp_user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        if (!empty($_POST['remember'])) {
            $token = bin2hex(random_bytes(32));
            setcookie('rememberme', $token, time() + 60*60*24*30, "/");
            $stmt = $conn->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();
        }
        header('Location: 2fa.php');
        exit;
    } else {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        if (!empty($_POST['remember'])) {
            $token = bin2hex(random_bytes(32));
            setcookie('rememberme', $token, time() + 60*60*24*30, "/");
            $stmt = $conn->prepare("UPDATE users SET remember_token = :token WHERE id = :id");
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id', $user['id']);
            $stmt->execute();
        }
        header('Location: profile.php');
        exit;
    }
} else {
    header('Location: login.php?error=1');
    exit;
}
?>