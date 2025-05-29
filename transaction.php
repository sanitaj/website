
<?php
session_start();
require 'db.php';

// Получаем текущий баланс пользователя
$user_id = $_SESSION['user_id'] ?? 0;
$stmt = $conn->prepare("SELECT balance FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($balance);
$stmt->fetch();
$stmt->close();

// Преобразуем баланс к числу (убираем все, кроме цифр и точки)
$balance = floatval(preg_replace('/[^\d.]/', '', $balance));

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount'] ?? 0);
    if ($amount <= 0) {
        $message = "Введите корректную сумму.";
    } else {
        if (isset($_POST['request'])) {
            // Запросить деньги (прибавить)
            $balance += $amount;
            $stmt = $conn->prepare("UPDATE users SET balance=? WHERE id=?");
            $stmt->bind_param("di", $balance, $user_id);
            $stmt->execute();
            $stmt->close();
            $message = "Сумма успешно зачислена!";
        } elseif (isset($_POST['send'])) {
            // Отправить деньги (вычесть)
            if ($balance >= $amount) {
                $balance -= $amount;
                $stmt = $conn->prepare("UPDATE users SET balance=? WHERE id=?");
                $stmt->bind_param("di", $balance, $user_id);
                $stmt->execute();
                $stmt->close();
                $message = "Сумма успешно отправлена!";
            } else {
                $message = "Недостаточно средств!";
            }
        }
    }
}
$conn->close();
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