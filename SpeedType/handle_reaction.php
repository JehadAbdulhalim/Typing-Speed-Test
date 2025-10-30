<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_data"]) || !isset($_POST['review_id']) || !isset($_POST['reaction_type'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$user_id = $_SESSION["user_data"]["id"];
$review_id = intval($_POST['review_id']);
$reaction_type = $_POST['reaction_type'];

if (!in_array($reaction_type, ['like', 'dislike'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid reaction type']);
    exit();
}

$check_sql = "SELECT id, reaction_type FROM review_reactions 
              WHERE user_id = ? AND review_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $review_id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $existing_reaction = $result->fetch_assoc();
    
    if ($existing_reaction['reaction_type'] === $reaction_type) {
        $delete_sql = "DELETE FROM review_reactions WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $existing_reaction['id']);
        $success = $delete_stmt->execute();
        
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Reaction removed' : 'Error removing reaction',
            'action' => 'removed'
        ]);
    } else {
        $update_sql = "UPDATE review_reactions SET reaction_type = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $reaction_type, $existing_reaction['id']);
        $success = $update_stmt->execute();
        
        echo json_encode([
            'success' => $success,
            'message' => $success ? 'Reaction updated' : 'Error updating reaction',
            'action' => 'updated'
        ]);
    }
} else {
    $insert_sql = "INSERT INTO review_reactions (user_id, review_id, reaction_type) VALUES (?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("iis", $user_id, $review_id, $reaction_type);
    $success = $insert_stmt->execute();
    
    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Reaction added' : 'Error adding reaction',
        'action' => 'added'
    ]);
}