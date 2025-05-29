<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Name</title>
    <link rel="stylesheet" href="css/cards.css">
    <script src="js/script.js" defer></script>
</head>

<body>
    <div class="wrapper">
        <!-- Кнопка "Вернуться в меню" -->
        <a href="index.php" class="circle-back-button">⟵</a>


        <!-- Карточки -->
        <div class="cards">
    <a href="card_regular.php" class="block sticky card-link" style="margin-bottom: 300px;">
        <img src="img/11.png" alt="">
        <h3>Regular</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="card_junior.php" class="block sticky card-link">
        <img src="img/12.png" alt="">
        <h3>Junior</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="card_silver.php" class="block sticky card-link">
        <img src="img/13.png" alt="">
        <h3>Silver</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="card_business.php" class="block sticky card-link">
        <img src="img/14.png" alt="">
        <h3>Business</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="index.php" class="block sticky card-link" style="margin-bottom: 45vh;">
        <img src="" alt="">
        <h3>Learn about us</h3>
    </a>
</div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
