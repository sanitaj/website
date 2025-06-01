<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZXC Bank</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="wrapper">
        <header class="container">
            <span class="logo">ZXC Bank</span>
            <nav>
                <ul>
                    <li>
                        <a href="#">Individual clients</a>
                        <ul class="dropdown">
                            <li><a href="#">Personal Accounts</a></li>
                            <li><a href="#">Debit & Credit Cards</a></li>
                            <li><a href="#">Savings & Deposits</a></li>
                            <li><a href="#">Digital Banking</a></li>
                            <li><a href="#">Personal Loans</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Small business</a>
                        <ul class="dropdown">
                            <li><a href="#">Business Accounts</a></li>
                            <li><a href="#">Merchant Services</a></li>
                            <li><a href="#">Business Loans</a></li>
                            <li><a href="#">Payroll & HR</a></li>
                            <li><a href="#">POS Solutions</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Corporate & Investment</a>
                        <ul class="dropdown">
                            <li><a href="#">Corporate Banking</a></li>
                            <li><a href="#">Investment Solutions</a></li>
                            <li><a href="#">Treasury Management</a></li>
                            <li><a href="#">Trade Finance</a></li>
                            <li><a href="#">Asset Management</a></li>
                        </ul>
                    </li>
                    <li class="btn">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a id="accountButton" href="profile.php">Account</a>
                        <?php else: ?>
                            <a id="loginButton" href="login.php" class="btn-login">Login</a>
                            <a id="signupButton" href="reg.php" class="btn-signup">Sign up</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </nav>
        </header>

        <div style="margin-top: 50px;" class="hero container">
            <div class="hero--info">
                <h2>Welcome to ZXC Bank</h2>
                <h1>
                    Smart Banking<br>
                    For Your<br>
                    Everyday Life
                </h1>
                <p>
                    Manage your finances with ease and security. Open an account in minutes, access innovative digital services, and enjoy 24/7 support. 
                    ZXC Bank brings you seamless payments, instant transfers, and powerful tools for individuals and businesses.
                </p>
                <button style="margin-bottom: 400px;" class="btn">Open an Account</button>
            </div>
            <img src="img/19.png" alt="ZXC Bank" class="parallax-img">
        </div>

        <div class="container trending">
            <h3>Our Products</h3>
            <div class="cards">
                <img src="img/11.png" alt="Mobile Banking">
                <img src="img/12.png" alt="Business Solutions">
                <img src="img/13.png" alt="Premium Cards">
                <img src="img/14.png" alt="Investment Tools">
            </div>
        </div>

        <div class="container big-text">
            <p style="margin-bottom: 100px;">
                Experience the future of banking. Fast. Secure. Digital.<br>
                Join thousands of clients who trust ZXC Bank for their personal and business needs.
            </p>
        </div>
    </div>

    <script src="js/script.js"></script>
    <a href="support.php" class="floating-button">💬</a>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <p>&copy; 2025 ZXC Bank. All rights reserved.</p>
                <p>
                    License №123456 |
                    <a style="color: white;" href="privacy.php">Privacy Policy</a> |
                    <a style="color: white;" href="terms.php">Terms of Use</a>
                </p>
            </div>
            <div class="footer-links">
                <a href="#">About Us</a>
                <a style="margin-left: 30px;" href="#">Contact</a>
                <a style="margin-left: 30px;" href="#">Support</a>
            </div>
            <div class="social-links">
                <a href="#"><i class='bx bxl-facebook'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
                <a href="#"><i class='bx bxl-linkedin'></i></a>
            </div>
        </div>
    </footer>
</body>
</html>