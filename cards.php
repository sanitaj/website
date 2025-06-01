<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// var_dump($_SESSION);
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
        <a href="index.php" class="circle-back-button">⟵</a>
        <div class="cards">
    <a href="#" class="block sticky card-link" data-card="img/11.png" style="margin-bottom: 300px;">
        <img src="img/11.png" alt="">
        <h3>Regular</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="#" class="block sticky card-link" data-card="img/12.png">
        <img src="img/12.png" alt="">
        <h3>Junior</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="#" class="block sticky card-link" data-card="img/13.png">
        <img src="img/13.png" alt="">
        <h3>Silver</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
    <a href="#" class="block sticky card-link" data-card="img/14.png">
        <img src="img/14.png" alt="">
        <h3>Business</h3>
        <div class="list">
            <p class="dot-before">Credit limit up to 200 thousand and up to 55 days without interest</p>
            <p class="dot-before">Personal cashbacks in the loyalty program</p>
            <p class="dot-before">Payment by installments" and "Instant installments": buy now - pay later</p>
        </div>
    </a>
</div>
    </div>
    <!-- Модальное окно -->
<div id="cardModal" class="modal" style="display:none;">
  <div class="modal-content">
    <div class="modal-icon">
      <i class='bx bx-help-circle'></i>
    </div>
    <h2>Подтвердите выбор карты</h2>
    <p>Вы уверены, что хотите выбрать эту карту?</p>
    <div class="modal-actions">
      <button id="confirmCardBtn" class="btn">Да, выбрать</button>
      <button id="cancelCardBtn" class="btn btn-cancel">Отмена</button>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  let selectedCard = '';
  document.querySelectorAll('.card-link').forEach(link => {
    link.addEventListener('click', function(e) {
      // Только если есть data-card (чтобы не срабатывало на "Learn about us")
      if (!this.getAttribute('data-card')) return;
      e.preventDefault();
      selectedCard = this.getAttribute('data-card');
      document.getElementById('cardModal').style.display = 'flex';
    });
  });
  document.getElementById('cancelCardBtn').onclick = function() {
    document.getElementById('cardModal').style.display = 'none';
  };
  document.getElementById('confirmCardBtn').onclick = function() {
    // Отправляем выбранную карту на сервер
    fetch('save_card.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/x-www-form-urlencoded'},
      body: 'card_img=' + encodeURIComponent(selectedCard)
    }).then(res => res.json()).then(data => {
      if(data.success) {
        window.location.href = 'profile.php';
      } else {
        alert('Ошибка сохранения карты');
      }
    });
  };
});
</script>
</body>
</html>
