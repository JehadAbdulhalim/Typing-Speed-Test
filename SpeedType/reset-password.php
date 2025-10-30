<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: radial-gradient(circle, #f0f4f8, #b0c4de);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            color: #4a90e2;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            transition: border 0.3s;
        }
        input:focus {
            border-color: #4a90e2;
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: #4a90e2;
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #357ab8;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: left;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        a {
            color: #4a90e2;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
<?php
session_start();


if (!isset($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $password = $_POST["password"];
    $passwordRepeat = $_POST["repeat_password"];
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $errors = array();


    if (empty($password) || empty($passwordRepeat)) {
        array_push($errors, "All fields are required");
    }
    if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long");
    }
    if ($password !== $passwordRepeat) {
        array_push($errors, "Passwords do not match");
    }


    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {

        $sql = "UPDATE users SET password = ? WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);

        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $_SESSION["email"]);

            if (mysqli_stmt_execute($stmt)) {

                session_unset();
                session_destroy();

                echo "<div class='alert alert-success'>Password reset successfully!</div>";
                echo "<div class='alert alert-info'>Click <a href='login.php'>here</a> to go to the login page.</div>";
                exit();
            } else {
                echo "<div class='alert alert-danger'>Something went wrong. Please try again.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Failed to prepare the statement.</div>";
        }
    }
}
?>

        <h2>Reset Password</h2>
        <form action="reset-password.php" method="post">
            <div class="form-group">
                <label for="new-password">New Password</label>
                <input type="password" id="new-password" name="password" placeholder="Enter your new password" required>
            </div>
            <div class="form-group">
                <label for="confirm-new-password">Confirm New Password</label>
                <input type="password" id="confirm-new-password" name="repeat_password" placeholder="Re-enter your new password" required>
            </div>
            <button type="submit" name="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
