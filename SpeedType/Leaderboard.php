<?php
session_start();
require_once "database.php";
if (!isset($_SESSION["user_data"])) {
    header("Location: login.php");
    exit();
}

$playtime = isset($_GET['playtime']) ? (int)$_GET['playtime'] : 15;
$valid_playtimes = [15, 30, 60, 120];

$query = "SELECT user_name, 
                 MAX(wpm) as best_wpm,
                 AVG(wpm) as avg_wpm,
                 COUNT(*) as games_played,
                 SUM(playtime) as total_playtime
          FROM games 
          WHERE playtime = ?
          GROUP BY user_name 
          ORDER BY best_wpm DESC 
          LIMIT 100";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $playtime);
$stmt->execute();
$result = $stmt->get_result();
$players = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpeedType | Leaderboard</title>
    <link rel="stylesheet" href="CSS/Alkhamis.css">
    <style>
        .leaderboard-header {
            padding: 24px;
            text-align: center;
        }

        .leaderboard-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .leaderboard-table-header {
            background: var(--foreground-color);
            border-radius: 16px;
        }

        .leaderboard-table th,
        .leaderboard-table td {
            padding: 16px;
            text-align: center;
        }

        .leaderboard-table tr:nth-child(even) {
            background: var(--foreground-color);
            border-radius: 16px;
        }

        .rank {
            font-weight: bold;
            color: var(--text-primary-color);
        }

        .rank-1 {
            color: gold;
        }

        .rank-2 {
            color: silver;
        }

        .rank-3 {
            color: #cd7f32;
        }

        .playtime-buttons {
            display: flex;
            justify-content: center;
            gap: 16px;
            margin: 16px 0;
            padding: 0 16px;
        }

        .playtime-button {
            padding: 8px 24px;
            border-radius: 6px;
            background: var(--foreground-color);
            color: var(--text-primary-color);
            cursor: pointer;
        }

        .playtime-button:hover {
            background: var(--text-primary-color);
            color: var(--foreground-color);
        }

        .playtime-button.active {
            background: var(--primary-color);
            color: white;
        }

        .no-data {
            text-align: center;
            padding: 16px;
        }
    </style>
</head>
<body class="body-general">
    
    <?php include 'header.php';?>
    
    <main class="main-general">
        <div class="main-item-general">
            <div class="leaderboard-header">
                <h1>SpeedType Leaderboard</h1>
                <p>Top 100 Players - <?php echo $playtime; ?> Seconds Mode</p>
            </div>
            
            <div class="playtime-buttons">
                <?php foreach ($valid_playtimes as $pt): ?>
                    <a href="?playtime=<?php echo $pt; ?>" 
                       class="playtime-button <?php echo $playtime === $pt ? 'active' : ''; ?>">
                        <?php echo $pt; ?>s
                    </a>
                <?php endforeach; ?>
            </div>

            <table class="leaderboard-table">
                <thead class="leaderboard-table-header">
                    <tr>
                        <th>Rank</th>
                        <th>Player</th>
                        <th>Best WPM</th>
                        <th>Average WPM</th>
                        <th>Games Played</th>
                        <th>Total Playtime</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($players)): ?>
                        <tr>
                            <td colspan="6" class="no-data">No data available for this playtime.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($players as $index => $player): ?>
                            <tr>
                                <td class="rank rank-<?php echo $index + 1; ?>">
                                    #<?php echo $index + 1; ?>
                                </td>
                                <td><?php echo $player['user_name']; ?></td>
                                <td><?php echo round($player['best_wpm']); ?></td>
                                <td><?php echo round($player['avg_wpm'], 1); ?></td>
                                <td><?php echo $player['games_played']; ?></td>
                                <td><?php echo round($player['total_playtime'] / 60); ?> min</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    
    <?php include 'footer.php';?>
    
</body>
</html>