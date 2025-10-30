<?php
session_start();
if (!isset($_SESSION["user_data"]) ) {
    header("Location: login.php");
exit();
} ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedType</title>
    <link rel="stylesheet" href="CSS/Alkhamis.css">
    <link rel="stylesheet" href="CSS/Khaled.css">
</head>
<?php require("header.php");?>
<body class="main-page-body">


    <div class="control-row">
        <button class="control-button">
            <svg width="12" height="12" viewBox="0 0 11 11" fill="currentcolor" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.04263 0C7.82768 0 10.0853 2.25759 10.0853 5.04263C10.0853 7.82768 7.82768 10.0853 5.04263 10.0853C2.25759 10.0853 0 7.82768 0 5.04263C0 2.25759 2.25759 0 5.04263 0ZM5.04263 2.01705C4.90889 2.01705 4.78063 2.07018 4.68606 2.16475C4.5915 2.25932 4.53837 2.38758 4.53837 2.52132V5.04263C4.5384 5.17636 4.59154 5.3046 4.68612 5.39915L6.19891 6.91194C6.29401 7.00379 6.42139 7.05462 6.55361 7.05347C6.68582 7.05232 6.8123 6.99929 6.90579 6.90579C6.99929 6.8123 7.05232 6.68582 7.05347 6.55361C7.05462 6.42139 7.00379 6.29401 6.91194 6.19891L5.5469 4.83387V2.52132C5.5469 2.38758 5.49377 2.25932 5.3992 2.16475C5.30463 2.07018 5.17637 2.01705 5.04263 2.01705Z"/>
            </svg>                
            Time
        </button>
             
        <button class="control-button choosable">
            15
        </button>
        <button class="control-button choosable">
            30
        </button>
        <button class="control-button choosable">
            60
        </button>
        <button class="control-button choosable">
            120
        </button>

    </div>

    <main class="">
        <p id="info">30</p>
        <br><br><br>
        <br><br>
        
        <div id="game" tabindex="0">
            <div id="words"></div>
            <div id="cursor"></div>
            <div id="focuserror">Click here to play</div>
        </div>
    </main>



    <script src="./script.js"></script>
    
    <?php include 'footer.php'; ?>
</body>
</html>
