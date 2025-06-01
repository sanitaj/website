<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['tmp_user_id'])) { header('Location: login.php'); exit; }
require 'db.php';
require_once __DIR__ . '/vendor/autoload.php';
use RobThree\Auth\TwoFactorAuth;
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tfa = new TwoFactorAuth('MyWebsite');
    $stmt = $conn->prepare("SELECT ga_secret FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['tmp_user_id']);
    $stmt->execute();
    $secret = $stmt->fetchColumn();

    if ($tfa->verifyCode($secret, $_POST['code'])) {
        $_SESSION['user_id'] = $_SESSION['tmp_user_id'];
        unset($_SESSION['tmp_user_id']);
        header('Location: profile.php');
        exit;
    } else {
        $message = "Неверный код!";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Двухфакторная аутентификация</title>
  <link rel="stylesheet" href="css/2fa.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <form method="post">
      <h1>2FA: Введите код</h1>
      <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" name="code" placeholder="Код из приложения" required maxlength="6" pattern="\d{6}">
        <i class='bx bxs-key'></i>
      </div>
      <button type="submit" class="btn">Проверить</button>
      <div class="register-link">
        <p><a href="login.php">Вернуться к входу</a></p>
      </div>
    </form>
  </div>
</body>
</html>