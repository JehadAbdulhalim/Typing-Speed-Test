<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        $user_name = $email = $password = $passwordRepeat = $SecurityQ1 = $SecurityQ2 = $SecurityQ3 = "";


        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
            $user_name = $_POST["user_name"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];
            $SecurityQ1 = $_POST["SecurityQ1"];
            $SecurityQ2 = $_POST["SecurityQ2"];
            $SecurityQ3 = $_POST["SecurityQ3"];

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $errors = array();

            if (empty($user_name) || empty($email) || empty($password) || empty($passwordRepeat) || empty($SecurityQ1) || empty($SecurityQ2) || empty($SecurityQ3)) {
                array_push($errors, "All fields are required");
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }
            if (strlen($password) < 8) {
                array_push($errors, "Password must be at least 8 characters long");
            }
            if ($password !== $passwordRepeat) {
                array_push($errors, "Passwords do not match");
            }
            require_once "database.php";
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $rowCount = mysqli_num_rows($result);
            if ($rowCount > 0) {
                array_push($errors, "Email already exists!");
            }

            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            } else {

                $sql = "INSERT INTO users (user_name, email, password, SecurityQ1, SecurityQ2, SecurityQ3) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                if ($prepareStmt) {
                    mysqli_stmt_bind_param($stmt, "ssssss", $user_name, $email, $passwordHash, $SecurityQ1, $SecurityQ2, $SecurityQ3);
                    mysqli_stmt_execute($stmt);
                    echo "<div class='alert alert-success'>You are registered successfully.</div>";

                    $user_name = $email = $password = $passwordRepeat = $SecurityQ1 = $SecurityQ2 = $SecurityQ3 = "";
                } else {
                    die("Something went wrong");
                }
            }
        }
    ?>
        <h2>Register</h2>
        <form action="register.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="user_name" placeholder="Choose a username" value="<?php echo htmlspecialchars($user_name); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="repeat_password" placeholder="Re-enter your password" required>
            </div>
            <h3>Security questions</h3>
            <h5 style="color: var(--text-primary-color)">Note that those will be used to reset your password if needed.</h5>
            <div class="form-group">
                <label for="SecurityQ1">What is the name of your favorite teacher?</label>
                <input type="text" id="SecurityQ1" name="SecurityQ1" placeholder="Enter your favorite teacher's name" value="<?php echo htmlspecialchars($SecurityQ1); ?>" required>
            </div>
            <div class="form-group">
                <label for="SecurityQ2">What is the name of your eldest sibling?</label>
                <input type="text" id="SecurityQ2" name="SecurityQ2" placeholder="Enter your eldest sibling's name" value="<?php echo htmlspecialchars($SecurityQ2); ?>" required>
            </div>
            <div class="form-group">
                <label for="SecurityQ3">What is your favorite show?</label>
                <input type="text" id="SecurityQ3" name="SecurityQ3" placeholder="Enter your favorite show's name" value="<?php echo htmlspecialchars($SecurityQ3); ?>" required>
            </div>
            <button type="submit" name="submit">Register</button>
        </form>
        <div class="login-link">
            <p>Do you have an account? <a href="login.php">Log In</a></p>
        </div>
    </div>
</body>
</html>
