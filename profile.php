<?php
session_start();
require 'db.php';
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, username, email, phone, balance, card_img FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $username, $email, $phone, $balance, $card_img);
$stmt->fetch();
$stmt->close();
$conn->close();

$user = [
    'name' => $name,
    'username' => $username,
    'email' => $email,
    'phone' => $phone,
    'balance' => $balance ?? '0 ₽',
    'card_img' => $card_img ?: 'img/11.png'
];
$transactions = [
    ['date' => '2024-05-28', 'desc' => 'Перевод на карту', 'sum' => '-1 000 ₽'],
    ['date' => '2024-05-27', 'desc' => 'Пополнение', 'sum' => '+5 000 ₽'],
    ['date' => '2024-05-25', 'desc' => 'Оплата услуг', 'sum' => '-2 300 ₽'],
    ['date' => '2024-05-20', 'desc' => 'Зачисление зарплаты', 'sum' => '+50 000 ₽'],
];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
<div class="wrapper">
    <h1>Личный кабинет</h1>
    <div class="profile-grid">
        <!-- Окно 1: Информация о пользователе -->
        <div class="profile-box user-info">
            <h2>Профиль</h2>
            <div class="info-row"><i class='bx bxs-user'></i> <span><?php echo $user['username']; ?></span></div>
            <div class="info-row"><i class='bx bxs-envelope'></i> <span><?php echo $user['email']; ?></span></div>
            <div class="info-row"><i class='bx bxs-phone'></i> <span><?php echo $user['phone']; ?></span></div>
            <a href="account.php" class="btn">Изменить данные</a>
        </div>
        <!-- Окно 2: Состояние счета -->
        <div class="profile-box balance-info">
            <h2>Счет</h2>
            <div class="balance"><?php echo $user['balance']; ?></div>
            <a href="transaction.php" class="btn">Отправить деньги</a>
        </div>
        <!-- Окно 3: Банковская карта -->
        <div class="profile-box card-info">
            <h2>Ваша карта</h2>
            <img src="<?php echo $user['card_img']; ?>" alt="Банковская карта" class="bank-card">
        </div>
        <!-- Окно 4: История транзакций -->
        <div class="profile-box transactions-info">
            <h2>История транзакций</h2>
            <ul class="transactions-list">
                <?php foreach ($transactions as $tr): ?>
                    <li>
                        <span class="tr-date"><?php echo $tr['date']; ?></span>
                        <span class="tr-desc"><?php echo $tr['desc']; ?></span>
                        <span class="tr-sum <?php echo strpos($tr['sum'], '+') === 0 ? 'plus' : 'minus'; ?>">
                            <?php echo $tr['sum']; ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="register-link">
        <p><a href="index.php">Вернуться в меню</a></p>
    </div>
</div>
</body>
</html>