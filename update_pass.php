<?php
require 'db.php';

if (!empty($_POST['token']) && !empty($_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if ($user) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $stmt->execute([$hash, $user['id']]);
        echo "Password updated! You can now <a href='login.php'>login</a>.";
    } else {
        echo "Invalid or expired token.";
    }
} else {
    echo "Invalid request.";
}
?>