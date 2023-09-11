<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard</h2>
        <ul>
            <li><a href="dashboard.php">Home</a></li>
            
            <li><a href="reviews.php">Reviews</a></li>
        </ul>
    </div>

    <div class="topnav">
        <div class="left">
            <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>
        </div>
        <div class="right">
            <a href="logout.php">Logout</a>
        </div>
    </div>

    <div class="content">
        <!-- Display different content based on selected tab -->
        <?php
        if (isset($_GET['tab']) && $_GET['tab'] === 'reviews') {
            echo '<h2>Reviews</h2>';
            echo '<form action="#" method="POST">';
            echo '    <label for="review">Add a Review:</label>';
            echo '    <textarea name="review" id="review" rows="4" cols="50"></textarea>';
            echo '    <button type="submit">Submit Review</button>';
            echo '</form>';
        }
        ?>
    </div>
</body>
</html>
