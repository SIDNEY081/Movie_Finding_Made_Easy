<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin-login.php');
    exit;
}

// Include movies data
$movies = [];
$jsonFile = 'movies.json';

if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $movies = json_decode($jsonData, true);
}

// Check if movie ID is provided and valid
if (!isset($_GET['id']) || !isset($movies[$_GET['id']])) {
    header('Location: admin-dashboard.php');
    exit;
}

$movieId = $_GET['id'];
$movie = $movies[$movieId];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Update movie data
    $movies[$movieId] = [
        'title' => $_POST['title'],
        'year' => $_POST['year'],
        'duration' => $_POST['duration'],
        'rating' => $_POST['rating'],
        'image' => $_POST['image'],
        'link' => $_POST['link']
    ];

    // Save back to JSON file
    file_put_contents($jsonFile, json_encode($movies, JSON_PRETTY_PRINT));

    // Redirect back to dashboard with success message
    header('Location: admin-dashboard.php?success=edit');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Movie - Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="admin-nav">
            <h1>🎬 Edit Movie</h1>
            <div>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
                <a href="admin-dashboard.php" class="admin-btn">Back to Dashboard</a>
            </div>
        </div>
    </header>

    <main class="container">
        <form method="post" class="movie-form">
            <div class="form-group">
                <label for="title">Movie Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($movie['year']); ?>" required>
            </div>

            <div class="form-group">
                <label for="duration">Duration</label>
                <input type="text" id="duration" name="duration" value="<?php echo htmlspecialchars($movie['duration']); ?>" required>
            </div>

            <div class="form-group">
                <label for="rating">Rating</label>
                <input type="number" step="0.1" id="rating" name="rating" value="<?php echo htmlspecialchars($movie['rating']); ?>" required>
            </div>

            <div class="form-group">
                <label for="image">Image URL</label>
                <input type="url" id="image" name="image" value="<?php echo htmlspecialchars($movie['image']); ?>" required>
            </div>

            <div class="form-group">
                <label for="link">Movie Link</label>
                <input type="url" id="link" name="link" value="<?php echo htmlspecialchars($movie['link']); ?>" required>
            </div>

            <button type="submit" class="admin-btn">Update Movie</button>
            <a href="admin-dashboard.php" class="admin-btn">Cancel</a>
        </form>
    </main>
</body>
</html>