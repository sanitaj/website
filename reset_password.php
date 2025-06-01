<?php
require 'db.php';

$token = $_GET['token'] ?? '';
if (!$token) {
    die('Invalid link.');
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    die('Invalid or expired token.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h2>Set a new password</h2>
    <form action="update_pass.php" method="post">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
        <input type="password" name="password" required placeholder="New password">
        <button type="submit">Update password</button>
    </form>
</body>
</html>