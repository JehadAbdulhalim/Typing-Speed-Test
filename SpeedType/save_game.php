<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_data"])) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit();
}

$response = ["success" => false];


if (isset($_POST["wpm"], $_POST["playTime"])) {
    $user_data = $_SESSION["user_data"];
    $wpm = intval($_POST["wpm"]);
    $playTime = intval($_POST["playTime"]);
    $username = $user_data["user_name"]; 

    $sql = "SELECT id FROM users WHERE user_name = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    if (!mysqli_stmt_execute($stmt)) {
        $response["message"] = "Failed to execute statement.";
        echo json_encode($response);
        exit();
    }

    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    
    if ($user) {
        $userId = $user["id"];
        

        $insertSql = "INSERT INTO games (user_name, wpm, playtime, played_at) VALUES (?, ?, ?, NOW())";
        $insertStmt = mysqli_prepare($conn, $insertSql);
        mysqli_stmt_bind_param($insertStmt, "sii", $username, $wpm, $playTime);

        if (mysqli_stmt_execute($insertStmt)) {
            $response["success"] = true;
            $response["message"] = "Game data saved successfully.";
            header("Location: index.php");
        } else {
            $response["message"] = "Failed to save game data.";
        }
    } else {
        $response["message"] = "User not found.";
    }
} else {
    $response["message"] = "Invalid game data.";
}

echo json_encode($response);
?>
