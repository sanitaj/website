<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) && isset($_COOKIE['rememberme'])) {
    $token = $_COOKIE['rememberme'];
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE remember_token = :token");
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
    }
}

$user_id = $_SESSION['user_id'] ?? 0;

$user = [
    'name' => '',
    'username' => '',
    'email' => '',
    'phone' => '',
    'balance' => 0,
    'card_img' => 'img/11.png'
];

try {
    $stmt = $conn->prepare("SELECT name, username, email, phone, balance, card_img FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($data) {
        $user = [
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'balance' => $data['balance'],
            'card_img' => $data['card_img'] ?: 'img/11.png'
        ];
    }
} catch (PDOException $e) {
    // Можно добавить обработку ошибок или логирование
}

$transactions = [];
try {
    $stmt = $conn->prepare("SELECT date, description, amount FROM transactions WHERE user_id = :user_id ORDER BY date DESC LIMIT 4");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Можно добавить обработку ошибок или логирование
}
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
            <div class="info-row"><i class='bx bxs-user'></i> <span><?php echo htmlspecialchars($user['username']); ?></span></div>
            <div class="info-row"><i class='bx bxs-envelope'></i> <span><?php echo htmlspecialchars($user['email']); ?></span></div>
            <div class="info-row"><i class='bx bxs-phone'></i> <span><?php echo htmlspecialchars($user['phone']); ?></span></div>
            <a href="account.php" class="btn">Настройки профиля</a>
        </div>
        <!-- Окно 2: Состояние счета -->
        <div class="profile-box balance-info">
            <h2>Счет</h2>
            <div class="balance"><?php echo number_format($user['balance'], 2, '.', ' ') . ' zł'; ?></div>
            <a href="transaction.php" class="btn">Отправить деньги</a>
        </div>
        <!-- Окно 3: Банковская карта -->
        <div class="profile-box card-info">
            <h2>Ваша карта</h2>
            <img src="<?php echo htmlspecialchars($user['card_img']); ?>" alt="Банковская карта" class="bank-card">
        </div>
        <!-- Окно 4: История транзакций -->
        <div class="profile-box transactions-info">
    <h2>История транзакций</h2>
    <ul class="transactions-list">
        <?php if (count($transactions) === 0): ?>
            <li><span>Нет транзакций</span></li>
        <?php else: ?>
            <?php foreach ($transactions as $tr): ?>
                <li>
                    <span class="tr-date"><?= htmlspecialchars(date('Y-m-d', strtotime($tr['date']))) ?></span>
                    <span class="tr-desc"><?= htmlspecialchars($tr['description']) ?></span>
                    <span class="tr-sum <?= $tr['amount'] >= 0 ? 'plus' : 'minus' ?>">
                        <?= ($tr['amount'] >= 0 ? '+' : '') . number_format($tr['amount'], 2, '.', ' ') . ' zł' ?>
                    </span>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
    </div>
    <div class="register-link">
        <p><a href="index.php">Вернуться в меню</a></p>
    </div>
</div>
</body>
</html>