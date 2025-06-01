<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$card_img = $_POST['card_img'] ?? '';

if ($card_img) {
    try {
        // Подготовка запроса для обновления изображения карты
        $stmt = $conn->prepare("UPDATE users SET card_img = :card_img WHERE id = :id");
        $stmt->bindParam(':card_img', $card_img, PDO::PARAM_STR);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        // Выполнение запроса
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'update_failed']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'no_card']);
}
?>