<?php
// Start the session at the top of the page
session_start();

$email = ""; 
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    require_once "database.php";
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    $user_data = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if ($user_data) {
        if (password_verify($password, $user_data["Password"])) {
            $_SESSION["user_data"] = $user_data;
            header("Location: index.php");
            die();
        } else {
            $error_message = "Password does not match";
        }
    } else {
        $error_message = "Email does not match";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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
        .google-btn-container {
            margin-top: 20px;
        }
        .g-sign-in-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50px;
            background-color: var(--bg-color);
            color: white;
            border-radius: 5px;
            transition: background-color .218s, border-color .218s, box-shadow .218s;
            cursor: pointer;
        }
        .g-sign-in-button:hover {
            background-color: var(--primary-color);
        }
        .g-sign-in-button .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
        }
        .g-sign-in-button .logo-wrapper {
            padding: 5px;
            background: #fff;
            border-radius: 5px;
            margin-right: 10px;
            display: flex;
            align-items: center;
        }
        .g-sign-in-button img {
            width: 18px;
            height: 18px;
        }
        .g-sign-in-button .text-container {
            font-family: "Roboto", Arial, sans-serif;
            font-weight: 500;
            font-size: 16px;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
	<?php 
	if (isset($error_message)) {
 	   echo '<div class="alert alert-danger">' . $error_message . '</div>';
	}
	?>

        <h2>Log In</h2>
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="email">Email</label>
                <input 
                    type="email" 
                    id="email"
                    name="email" 
                    placeholder="Enter your email" 
                    value="<?php echo htmlspecialchars($email); ?>" 
                    required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Enter your password" 
                    required>
            </div>
            <button type="submit" name="submit">Log In</button>
        </form>

       <div class="google-btn-container">
            <button id="googleSignInButton" class="g-sign-in-button">
                <div class="content-wrapper">
                    <div class="logo-wrapper">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo">
                    </div>
                    <span class="text-container">Sign in with Google</span>
                </div>
            </button>
        </div>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </div>
        <div class="reset-password-link">
            <p>Forgot your password? <a href="security-questions.php">Click here</a></p>
        </div>
    </div>
    <script type="module">
        // Firebase authentication and Google login setup
        import { initializeApp } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-app.js";
        import { getAuth, GoogleAuthProvider, signInWithPopup,onAuthStateChanged } from "https://www.gstatic.com/firebasejs/11.1.0/firebase-auth.js";

        // Firebase configuration
        const firebaseConfig = {
            apiKey: "AIzaSyCm7BWEGwfLq3839pxbrWDMd_2A2ZIJWi0",
            authDomain: "login-685e8.firebaseapp.com",
            projectId: "login-685e8",
            storageBucket: "login-685e8.firebasestorage.app",
            messagingSenderId: "1042199249942",
            appId: "1:1042199249942:web:6131faed62fe2eb3f1a137"
        };

        // Initialize Firebase
        const app = initializeApp(firebaseConfig);
        const auth = getAuth(app);
        auth.languageCode = 'en';

        const provider = new GoogleAuthProvider();

        const googleLogin = document.getElementById("googleSignInButton");
googleLogin.addEventListener("click", function () {
    signInWithPopup(auth, provider)
        .then((result) => {
            const user = result.user;
            // Send user details to your server for account creation/updating
            fetch("google_login_handler.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    email: user.email,
                    user_name: user.displayName,
                }),
            })
                .then((response) => {
                    if (response.ok) {
                        // Redirect the user to the main page
                        window.location.href = "index.php";
                    } else {
                        console.error("Failed to process user on the server");
                    }
                })
                .catch((error) => {
                    console.error("Error sending user details to server:", error);
                });
        })
        .catch((error) => {
            console.error("Error during Google Sign-In:", error);
        });
});
    </script>
</body>
</html>
