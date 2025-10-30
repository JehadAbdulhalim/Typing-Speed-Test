<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Account</title>
    <style>
        :root{
            --bg-color: #323437;
            --primary-color: #E2B714;
            --text-primary-color: #D1D0C5;
            --text-secondary-color: #646669;
            --foreground-color: #2C2E31;
            --hover-color: #959698;
        }
            body {
            font-family: 'Arial', sans-serif;
            background: var(--bg-color);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: var(--primary-color);
        }
        .container {
            background-color: var(--foreground-color);
            padding: 40px;
            border-radius: 20px;
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
            color: var(--primary-color);
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
            color: var(--text-primary-color);
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
            outline: none;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.5);
        }
        button {
            width: 100%;
            padding: 14px;
            background-color: var(--bg-color);
            border: none;
            border-radius: 10px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: var(--primary-color);
        }
        .register-link, .reset-password-link {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .register-link a, .reset-password-link a {
            color: var(--text-primary-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .register-link a:hover, .reset-password-link a:hover {
            color: #357ab8;
            text-decoration: underline;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            color: white;
            border-radius: 5px;
            text-align: left;
        }
        .alert-danger {
            background-color: #e74c3c;
        }
        
        .login-link {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .login-link a {
            color: var(--text-primary-color);
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s;
        }
        .login-link a:hover {
            color: #357ab8;
            text-decoration: underline;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="container">
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $email = trim($_POST["email"]);
    $SecurityQ1 = trim($_POST["SecurityQ1"]);
    $SecurityQ2 = trim($_POST["SecurityQ2"]);
    $SecurityQ3 = trim($_POST["SecurityQ3"]);

    require_once "database.php";

    $errors = [];


    if (empty($email) || empty($SecurityQ1) || empty($SecurityQ2) || empty($SecurityQ3)) {
        array_push($errors, "All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format.");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {

        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if (
                strcasecmp($SecurityQ1, $user["SecurityQ1"]) === 0 &&
                strcasecmp($SecurityQ2, $user["SecurityQ2"]) === 0 &&
                strcasecmp($SecurityQ3, $user["SecurityQ3"]) === 0
            ) {

                session_start();
                $_SESSION["email"] = $email;
                echo "<div class='alert alert-success'>Security questions verified successfully. Redirecting...</div>";
                header("refresh:2;url=reset-password.php");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Security questions do not match our records.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Email does not exist in our database.</div>";
        }
    }
}
?>
        <h2>Recover your account</h2>
        <form action="security-questions.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="SecurityQ1">What is the name of your favorite teacher?</label>
                <input type="text" id="SecurityQ1" name="SecurityQ1" placeholder="Enter your favorite teacher's name" required>
            </div>
            <div class="form-group">
                <label for="SecurityQ2">What is the name of your eldest sibling?</label>
                <input type="text" id="SecurityQ2" name="SecurityQ2" placeholder="Enter your eldest sibling's name" required>
            </div>
            <div class="form-group">
                <label for="SecurityQ3">What is your favorite show?</label>
                <input type="text" id="SecurityQ3" name="SecurityQ3" placeholder="Enter your favorite show's name" required>
            </div>
            <button type="submit" name="submit">Recover my account</button>
        </form>
        <div class="login-link">
            <p>Back to <a href="login.php">Log In</a></p>
        </div>
    </div>
</body>
</html>
