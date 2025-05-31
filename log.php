<?php
session_start();
require 'db.php';
require_once __DIR__ . '/vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, password, ga_secret FROM users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    if (!empty($user['ga_secret'])) {
        $_SESSION['tmp_user_id'] = $user['id'];
        header('Location: 2fa.php');
        exit;
    } else {
        $_SESSION['user_id'] = $user['id'];
        header('Location: profile.php');
        exit;
    }
} else {
    header('Location: login.php?error=1');
    exit;
}
?>