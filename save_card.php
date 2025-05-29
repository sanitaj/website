<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$card_img = $_POST['card_img'] ?? '';

if ($card_img) {
    $stmt = $conn->prepare("UPDATE users SET card_img=? WHERE id=?");
    $stmt->bind_param("si", $card_img, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'no_card']);
}
?>