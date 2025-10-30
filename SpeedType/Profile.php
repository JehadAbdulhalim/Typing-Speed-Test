<?php
session_start();
require_once "database.php";
if (!isset($_SESSION["user_data"]) ) {
    header("Location: login.php");
    exit();
}
$username = $_SESSION["user_data"]["user_name"];

$selectSql = "SELECT user_name, wpm, playtime, played_at 
                FROM games 
                WHERE user_name = ? 
                ORDER BY played_at DESC";

$selectStmt = mysqli_prepare($conn, $selectSql);
mysqli_stmt_bind_param($selectStmt, "s", $username);
mysqli_stmt_execute($selectStmt);
$result = mysqli_stmt_get_result($selectStmt);
$gameData = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_stmt_close($selectStmt);

$totalPlaytime = 0;
$totalGamesPlayed = 0;
$totalWordsWritten = 0;
$best15 = 0;
$best30 = 0;
$best60 = 0;
$best120 = 0;
foreach ($gameData as $game) {
    $totalPlaytime += $game['playtime'];
    $totalGamesPlayed += 1;
    $totalWordsWritten +=  $game['wpm'] * ($game['playtime'] / 60);

    if(($game['playtime'] == 15) && ($game['wpm'] > $best15)){
        $best15 = $game['wpm'];
    }
    elseif(($game['playtime'] == 30) && ($game['wpm'] > $best30)){
        $best30 = $game['wpm'];
    }
    elseif(($game['playtime'] == 60) && ($game['wpm'] > $best60)){
        $best60 = $game['wpm'];
    }
    elseif(($game['playtime'] == 120) && ($game['wpm'] > $best120)){
        $best120 = $game['wpm'];
    }
}


$hours = floor($totalPlaytime / 3600);
$minutes = floor(($totalPlaytime % 3600) / 60);
$seconds = $totalPlaytime % 60;

$formattedTime = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedType | Profile</title>
    <link rel="stylesheet" href="CSS/Alkhamis.css">
    <style>
    h4{
        color: var(--text-secondary-color);
    }
    
    h1{
        color: var(--text-primary-color);
    }
    .table-profile th,
    .table-profile td {
        padding: 16px;
        text-align: center;
    }
    .table-profile{
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-profile tr:nth-child(odd) {
        background: var(--foreground-color);
        border-radius: 16px;
    }
    </style>
</head>
<body class="body-general">

    <?php include 'header.php';?>

    <main class="main-general">
        <!-- <?php echo json_encode($gameData); ?>
        <?php echo json_encode($_SESSION["user_data"]); ?> -->
        
        <div class="main-item-background-general">
            <div class="profile-statistics">
                <div class="statistics-element">
                    <h4>Username</h4>
                    <?php echo "<h1>{$_SESSION['user_data']['user_name']}</h1>"; ?>
                </div>
                <div class="statistics-element">
                    <h4>Total Games Played</h4>
                    <?php echo "<h1>{$totalGamesPlayed}</h1>";?>
                </div>
                <div class="statistics-element">
                    <h4>Total Typed Words</h4>
                    <?php echo "<h1>{$totalWordsWritten}</h1>";?>
                </div>
                <div class="statistics-element">
                    <h4>Time Playing</h4>
                    <?php echo "<h1>{$formattedTime}</h1>";?>
                </div>
            </div>
        </div>
        <br>
        <div class="main-item-background-general">
            <div class="profile-statistics">
                <div class="statistics-element">
                    <h4>15 Seconds</h4>
                    <?php echo "<h1>{$best15}</h1>"; ?>
                </div>
                <div class="statistics-element">
                    <h4>30 Seconds</h4>
                    <?php echo "<h1>{$best30}</h1>";?>
                </div>
                <div class="statistics-element">
                    <h4>60 Seconds</h4>
                    <?php echo "<h1>{$best60}</h1>";?>
                </div>
                <div class="statistics-element">
                    <h4>120 Seconds</h4>
                    <?php echo "<h1>{$best120}</h1>";?>
                </div>
            </div>
        </div>
        <br>
        <?php
            echo "<table class='table-profile' style='table-layout: fixed; width: 100%;'>
                    <tr>
                        <th>WPM</th>
                        <th>Mode</th>
                        <th>Date</th>
                    </tr>";
            foreach ($gameData as $game) {
                echo "<tr>
                <td>{$game['wpm']}</td>
                <td>{$game['playtime']}</td>
                <td>" . htmlspecialchars($game['played_at']) . "</td>
                </tr>";
            }

            echo "</table>";
        ?>
    </main>

    <?php include 'footer.php';?>
</body>
</html>