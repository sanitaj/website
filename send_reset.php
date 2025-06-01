<?php
require 'db.php'; // Подключение к базе

if (!empty($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
        $stmt->execute([$token, $expires, $email]);

        $reset_link = "http://yourdomain.com/reset_password.php?token=$token";
        $subject = "Password Reset for ZXC Bank";
        $message = "Click the link to reset your password: $reset_link";
        $headers = "From: no-reply@yourdomain.com\r\n";

        mail($email, $subject, $message, $headers);
    }
    // Не раскрываем, есть ли email в базе
    echo "If this email is registered, a reset link has been sent.";
} else {
    echo "Please enter your email.";
}
?>