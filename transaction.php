<?php
session_start();
require 'db.php';

// Получаем текущий баланс пользователя
$user_id = $_SESSION['user_id'] ?? 0;
$balance = 0.0;
$message = '';

try {
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $balance = $stmt->fetchColumn();
    $balance = floatval(preg_replace('/[^\d.]/', '', $balance));
} catch (PDOException $e) {
    $message = "Ошибка: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    $phone = $_POST['phone'] ?? '';
    if ($amount <= 0) {
        $message = "Введите корректную сумму.";
    } else {
        if (isset($_POST['request'])) {
            // Запросить деньги (прибавить)
            $balance += $amount;
            try {
                $stmt = $conn->prepare("UPDATE users SET balance = :balance WHERE id = :id");
                $stmt->bindParam(':balance', $balance);
                $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                $stmt->execute();

                // Добавляем транзакцию (пополнение)
                $desc = "Пополнение через запрос";
                $stmt = $conn->prepare("INSERT INTO transactions (user_id, description, amount) VALUES (:user_id, :description, :amount)");
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                $stmt->bindParam(':description', $desc, PDO::PARAM_STR);
                $stmt->bindParam(':amount', $amount, PDO::PARAM_STR);
                $stmt->execute();

                $message = "Сумма успешно зачислена!";
            } catch (PDOException $e) {
                $message = "Ошибка: " . $e->getMessage();
            }
        } elseif (isset($_POST['send'])) {
            // Отправить деньги (вычесть)
            if ($balance >= $amount) {
                $balance -= $amount;
                try {
                    $stmt = $conn->prepare("UPDATE users SET balance = :balance WHERE id = :id");
                    $stmt->bindParam(':balance', $balance);
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                    $stmt->execute();

                    // Добавляем транзакцию (расход)
                    $desc = "Перевод пользователю " . htmlspecialchars($phone);
                    $negAmount = -$amount;
                    $stmt = $conn->prepare("INSERT INTO transactions (user_id, description, amount) VALUES (:user_id, :description, :amount)");
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':description', $desc, PDO::PARAM_STR);
                    $stmt->bindParam(':amount', $negAmount, PDO::PARAM_STR);
                    $stmt->execute();

                    $message = "Сумма успешно отправлена!";
                } catch (PDOException $e) {
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
        <input type="text" name="phone" placeholder="Номер телефона" required />
        <i class='bx bxs-phone'></i>
      </div>
      <div class="input-box">
        <input type="number" name="amount" placeholder="Сумма" min="1" step="0.01" required />
        <i class='bx bx-money'></i>
      </div>
      <div class="button-row">
        <button type="submit" name="request" class="btn request">Запросить</button>
        <button type="submit" name="send" class="btn">Отправить</button>
      </div>
      <div class="register-link">
        <p><a href="profile.php">Вернуться в профиль</a></p>
      </div>
    </form>
  </div>
</body>
</html>