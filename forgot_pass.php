<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/login_style.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <form action="send_reset.php" method="post">
            <h1>Forgot Password</h1>
            <div class="input-box">
                <input type="email" name="email" required placeholder="Enter your email">
                <i class='bx bxs-envelope'></i>
            </div>
            <button type="submit" class="btn">Send reset link</button>
            <div class="register-link">
                <p><a href="login.php">Back to login</a></p>
            </div>
        </form>
    </div>
</body>
</html>