<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'db.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];
    $stmt = $pdo->prepare("SELECT id, username FROM users WHERE remember_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }
}

// Получаем текущий баланс пользователя
$user_id = $_SESSION['user_id'] ?? 0;
$balance = 0.0;
$message = '';

try {
    $stmt = $pdo->prepare("SELECT balance FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $balance = $stmt->fetchColumn();
    $balance = floatval(preg_replace('/[^\d.]/', '', $balance));
} catch (PDOException $e) {
    $message = "Ошибка: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $username = trim($_POST['username'] ?? '');

    if ($amount <= 0) {
        $message = "Введите корректную сумму.";
    } else {
        // Проверяем, существует ли получатель
        $stmt = $pdo->prepare("SELECT id, balance FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $recipient = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$recipient) {
            $message = "Пользователь с таким именем не найден.";
        } elseif ($recipient['id'] == $user_id) {
            $message = "Нельзя отправить деньги самому себе.";
        } elseif (isset($_POST['send'])) {
            // Отправить деньги
            if ($balance >= $amount) {
                try {
                    $pdo->beginTransaction();

                    // Списываем у отправителя
                    $newSenderBalance = $balance - $amount;
                    $stmt = $pdo->prepare("UPDATE users SET balance = :balance WHERE id = :id");
                    $stmt->bindParam(':balance', $newSenderBalance);
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Зачисляем получателю
                    $newRecipientBalance = floatval($recipient['balance']) + $amount;
                    $stmt = $pdo->prepare("UPDATE users SET balance = :balance WHERE id = :id");
                    $stmt->bindParam(':balance', $newRecipientBalance);
                    $stmt->bindParam(':id', $recipient['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    // Транзакция для отправителя (расход)
                    $descSender = "Перевод пользователю " . htmlspecialchars($username);
                    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, description, amount) VALUES (:user_id, :description, :amount)");
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':description', $descSender, PDO::PARAM_STR);
                    $negAmount = -$amount;
                    $stmt->bindParam(':amount', $negAmount, PDO::PARAM_STR);
                    $stmt->execute();

                    // Транзакция для получателя (пополнение)
                    $descRecipient = "Получено от пользователя " . htmlspecialchars($_SESSION['username'] ?? $user_id);
                    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, description, amount) VALUES (:user_id, :description, :amount)");
                    $stmt->bindParam(':user_id', $recipient['id'], PDO::PARAM_INT);
                    $stmt->bindParam(':description', $descRecipient, PDO::PARAM_STR);
                    $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
                    $stmt->execute();

                    $pdo->commit();
                    $balance = $newSenderBalance;
                    $message = "Сумма успешно отправлена!";
                } catch (PDOException $e) {
                    $pdo->rollBack();
                    $message = "Ошибка: " . $e->getMessage();
                }
            } else {
                $message = "Недостаточно средств!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Перевод денег</title>
  <link rel="stylesheet" href="css/transaction.css">
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <form method="post">
      <h1>Перевод денег</h1>
      <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" name="username" placeholder="Имя пользователя получателя" required />
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="number" name="amount" placeholder="Сумма" min="1" step="0.01" required />
        <i class='bx bx-money'></i>
      </div>
      <div class="button-row">
        <button type="submit" name="send" class="btn">Отправить</button>
      </div>
      <div class="register-link">
        <p><a href="profile.php">Вернуться в профиль</a></p>
      </div>
    </form>
  </div>
</body>
</html>