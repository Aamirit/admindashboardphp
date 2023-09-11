<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit();
}

// Database connection
require_once('db.php');

// Handle actions (hide, delete, show, etc.)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $action = $_GET['action'];
    $reviewId = $_GET['id'];

    if ($action === 'hide') {
        // Update the 'hidden' status in the database
        $query = "UPDATE reviews SET hidden = 1 WHERE id = $reviewId";
        mysqli_query($connection, $query);
    } elseif ($action === 'show') {
        // Update the 'hidden' status in the database to show the review
        $query = "UPDATE reviews SET hidden = 0 WHERE id = $reviewId";
        mysqli_query($connection, $query);
    } elseif ($action === 'delete') {
        // Delete the review from the database
        $query = "DELETE FROM reviews WHERE id = $reviewId";
        mysqli_query($connection, $query);
    }

    // Redirect back to the same page
    header("Location: reviews.php");
    exit();
}

// Fetch reviews from the database
$query = "SELECT * FROM reviews";
$result = mysqli_query($connection, $query);

$reviews = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews</title>
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
        <h2>Reviews</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Review</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($reviews as $review) : ?>
                <tr>
                    <td><?php echo $review['name']; ?></td>
                    <td><?php echo $review['email']; ?></td>
                    <td><?php echo $review['review']; ?></td>
                    <td>
                        <?php if ($review['hidden'] == 1) : ?>
                            <a href="?action=show&id=<?php echo $review['id']; ?>">Show</a>
                        <?php else : ?>
                            <a href="?action=hide&id=<?php echo $review['id']; ?>">Hide</a>
                        <?php endif; ?>
                        <a href="?action=delete&id=<?php echo $review['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
