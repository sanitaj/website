<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = htmlspecialchars($_POST["message"]);

    $to = "example-mail@gmail.com";
    $subject = "Новое сообщение с сайта";
    $body = "Имя: $name\nEmail: $email\nСообщение:\n$message";

    mail($to, $subject, $body);
    echo "Спасибо! Ваше сообщение отправлено.";
}
?>
