<?php
session_start();
require_once "database.php";

if (!isset($_SESSION["user_data"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="CSS/Alkhamis.css">
    <style>
    .review-form {
        background: var(--foreground-color);
        padding: 2rem;
        border-radius: 12px;
        margin: 2rem 0;
    }

    .review-form h2 {
        margin-bottom: 24px;
        font-size: 24px;
        text-align: center;
    }

    .review-form form {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .review-form form div {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .review-form label {
        color: var(--text-primary-color);
        font-weight: 600;
        font-size: 16px;
    }

    .review-form select {
        padding: 16px;
        border-radius: 6px;
        background: var(--background-color);
        background-color: var(--background-color);
        color: var(--text-pr4imary-color);
        font-size: 16px;
        width: 120px;
    }

    .review-form textarea {
        padding: 16px;
        border-radius: 6px;
        background-color: var(--background-color);
        color: var(--text-primary-color);
        font-size: 16px;
        height: 120px;
        resize: vertical;
    }

    .review-form button {
        background-color: var(--primary-color);
        color: white;
        padding: 16px 32px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        align-self: flex-start;
    }

    .review-card {
        border-radius: 8px;
        padding: 20px;
    }

    .stars {
        color: var(--primary-color);
        font-size: 20px;
    }

    .star.filled {
        color: var(--primary-color);
    }

    .star {
        color: var(--primary-color);
    }

    .user_name {
        color: var(--text-primary-color);
        font-weight: bold;
        font-size: 24px;
    }

    .review-text {
        color: var(--text-primary-color);
        font-size: 16px;
    }

    .reaction-buttons {
        display: flex;
        gap: 16px;
        margin-top: 16px;
    }

    .reaction-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        background: var(--bg-color);
        color: var(--text-primary-color);
        cursor: pointer;
        transition: all 0.2s;
    }

    .reaction-btn:hover {
        background: var(--primary-color);
        color: white;
    }

    .reaction-btn.active {
        background: var(--primary-color);
        color: white;
    }

    .count {
        font-weight: bold;
    }
        
    </style>
</head>
<body class="body-general">
    <?php include 'header.php'; ?>

    <main class="main-general">
        <div class="main-item-background-general">
            <h1>About Us</h1>
            <p>
                This is a typing test website designed to help you improve your typing speed and accuracy. 
                Practice daily to boost your skills and become a more efficient typist. Our website is designed 
                to enhance your typing speed and accuracy through engaging and interactive exercises.
            </p>
            <p>
                Whether you're a beginner looking to improve your skills or an experienced typist aiming for 
                precision, our platform offers a variety of challenges tailored to your level. With real-time 
                feedback and progress tracking, you can see your improvement over time and stay motivated.
            </p>
            <p>
                Additionally, our user-friendly interface makes it easy to navigate through different typing 
                drills and lessons. Join us today and discover how our website can transform your typing 
                abilities, making you a faster and more efficient communicator!
            </p>
        </div>
        <div class="review-form">
            <h2>Write a Review</h2>
            <form method="POST" action="submit_review.php">
                <div>
                    <label>Rating:</label>
                    <select name="stars" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div>
                    <label>Review:</label>
                    <textarea name="review_text" maxlength="500" required></textarea>
                </div>
                <button type="submit">Submit Review</button>
            </form>
        </div>

        <?php
        $sql = "SELECT AVG(review_stars) as average
        FROM users 
        WHERE review_text IS NOT NULL";

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $result = $result->fetch_assoc();
        
        echo '<h1>All Review Average(';
        echo $result["average"];
        echo ')</h1>';

        $sql = "SELECT u.id as review_id, u.user_name, u.review_stars, u.review_text,
                (SELECT COUNT(*) FROM review_reactions WHERE review_id = u.id AND reaction_type = 'like') as likes_count,
                (SELECT COUNT(*) FROM review_reactions WHERE review_id = u.id AND reaction_type = 'dislike') as dislikes_count,
                (SELECT reaction_type FROM review_reactions WHERE review_id = u.id AND user_id = ?) as user_reaction
                FROM users u 
                WHERE review_text IS NOT NULL
                LIMIT 100";

        $stmt = $conn->prepare($sql);
        $current_user_id = $_SESSION["user_data"]["id"];
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $stars = intval($row['review_stars']);
                $review_text = htmlspecialchars($row['review_text']);
                $username = htmlspecialchars($row['user_name']);
                $review_id = $row['review_id'];
                $likes_count = $row['likes_count'];
                $dislikes_count = $row['dislikes_count'];
                $user_reaction = $row['user_reaction'];

                echo '<div class="main-item-background-general">';
                echo '<div class="review-card">';
                echo "<div class='user_name'>$username</div>";
                echo '<div class="stars">';
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $stars) {
                        echo '<span class="star filled">★</span>';
                    } else {
                        echo '<span class="star">☆</span>';
                    }
                }
                echo '</div>';
                echo "<p class='review-text'>$review_text</p>";
                echo '<div class="reaction-buttons">';
                echo "<button class='reaction-btn like-btn " . ($user_reaction === 'like' ? 'active' : '') . "'
                      data-review-id='$review_id' data-type='like'>
                      👍 <span class='count'>$likes_count</span></button>";
                echo "<button class='reaction-btn dislike-btn " . ($user_reaction === 'dislike' ? 'active' : '') . "'
                      data-review-id='$review_id' data-type='dislike'>
                      👎 <span class='count'>$dislikes_count</span></button>";
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '<br>';
            }
        }
        ?>
    </main>

    <?php include 'footer.php'; ?>
    <script src="Review.js"></script>
</body>
</html>