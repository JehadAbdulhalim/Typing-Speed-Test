<?php
function submitReview($pdo, $userId, $stars, $text) {
    $stmt = $pdo->prepare("UPDATE users SET review_stars = ?, review_text = ? WHERE id = ?");
    return $stmt->execute([$stars, $text, $userId]);
}

session_start();
require_once "database.php";

if (!isset($_SESSION['user_data'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stars = (int)$_POST['stars'];
    $text = $_POST['review_text'];
    
    if ($stars >= 1 && $stars <= 5 && strlen($text) <= 500) {
        if (submitReview($conn, $_SESSION['user_data']['id'], $stars, $text)) {
            header('Location: about.php?success=1');
            exit;
        }
    }
}

header('Location: index.php?error=submission_failed');
exit;
?>