<?php
session_start();
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve JSON data from the request
    $data = json_decode(file_get_contents("php://input"), true);

    if (!isset($data["email"]) || !isset($data["user_name"])) {
        http_response_code(400);
        echo json_encode(["error" => "Invalid data"]);
        exit();
    }

    $email = $data["email"];
    $user_name = $data["user_name"];

    // Check if the user already exists
    $sql = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Update user session if they already exist
        $_SESSION["user_data"] = $user;
    } else {
        // Insert new user into the database
        $sql = "INSERT INTO users (user_name, PASSWORD, Email, SecurityQ1, SecurityQ2, SecurityQ3, review_stars) 
                VALUES (?, '', ?, '', '', '', 0)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $user_name, $email);

        if ($stmt->execute()) {
            $newUserId = $stmt->insert_id;
            $_SESSION["user_data"] = [
                "id" => $newUserId,
                "user_name" => $user_name,
                "PASSWORD" => "",
                "Email" => $email,
                "SecurityQ1" => "",
                "SecurityQ2" => "",
                "SecurityQ3" => "",
                "review_stars" => 0,
                "review_text" => null,
            ];
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Database error"]);
            exit();
        }
    }

    // Respond with success
    http_response_code(200);
    echo json_encode(["message" => "User processed successfully"]);
    exit();
}
?>
