<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin-login.php');
    exit;
}

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $year = trim($_POST['year'] ?? '');
    $duration = trim($_POST['duration'] ?? '');
    $rating = trim($_POST['rating'] ?? '');
    $image = trim($_POST['image'] ?? '');
    $link = trim($_POST['link'] ?? '');
    
    // Basic validation
    if (empty($title) || empty($year) || empty($duration) || empty($rating) || empty($image) || empty($link)) {
        $error = 'All fields are required!';
    } elseif (!is_numeric($year) || $year < 1900 || $year > date('Y') + 5) {
        $error = 'Please enter a valid year (1900 - ' . (date('Y') + 5) . ')';
    } elseif (!is_numeric($rating) || $rating < 0 || $rating > 10) {
        $error = 'Please enter a valid rating (0-10)';
    } else {
        // Load existing movies
        $movies = [];
        $jsonFile = 'movies.json';
        
        if (file_exists($jsonFile)) {
            $jsonData = file_get_contents($jsonFile);
            $movies = json_decode($jsonData, true) ?: [];
        }
        
        // Add new movie
        $newMovie = [
            'title' => $title,
            'year' => $year,
            'duration' => $duration,
            'rating' => $rating,
            'image' => $image,
            'link' => $link
        ];
        
        $movies[] = $newMovie;
        
        // Save back to JSON file
        if (file_put_contents($jsonFile, json_encode($movies, JSON_PRETTY_PRINT))) {
            $success = 'Movie added successfully!';
            // Clear form fields
            $_POST = array();
        } else {
            $error = 'Failed to save movie. Please check file permissions.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Movie - Admin</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="admin-header">
        <div class="admin-nav">
            <h1>➕ Add New Movie</h1>
            <div>
                <a href="admin-dashboard.php" class="admin-btn">← Back to Dashboard</a>
            </div>
        </div>
    </header>

    <main class="container">
        <div class="contact-form" style="max-width: 800px;">
            <?php if ($error): ?>
                <div class="error-message" style="margin-bottom: 2rem;">
                    <div class="message-icon">❌</div>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message" style="margin-bottom: 2rem;">
                    <div class="message-icon">✅</div>
                    <p><?php echo htmlspecialchars($success); ?></p>
                    <a href="admin-dashboard.php" class="admin-btn">View All Movies</a>
                    <a href="add-movie.php" class="admin-btn" style="background: #2196F3;">Add Another Movie</a>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="title">Movie Title *</label>
                    <input type="text" id="title" name="title" required 
                           value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>" 
                           placeholder="Enter movie title">
                </div>
                
                <div class="form-group">
                    <label for="year">Release Year *</label>
                    <input type="number" id="year" name="year" required 
                           value="<?php echo htmlspecialchars($_POST['year'] ?? ''); ?>" 
                           placeholder="Enter release year" min="1900" max="<?php echo date('Y') + 5; ?>">
                </div>
                
                <div class="form-group">
                    <label for="duration">Duration *</label>
                    <input type="text" id="duration" name="duration" required 
                           value="<?php echo htmlspecialchars($_POST['duration'] ?? ''); ?>" 
                           placeholder="e.g., 2h 15min">
                </div>
                
                <div class="form-group">
                    <label for="rating">Rating *</label>
                    <input type="number" id="rating" name="rating" required 
                           value="<?php echo htmlspecialchars($_POST['rating'] ?? ''); ?>" 
                           placeholder="e.g., 8.5" step="0.1" min="0" max="10">
                </div>
                
                <div class="form-group">
                    <label for="image">Image URL *</label>
                    <input type="url" id="image" name="image" required 
                           value="<?php echo htmlspecialchars($_POST['image'] ?? ''); ?>" 
                           placeholder="Enter image URL">
                </div>
                
                <div class="form-group">
                    <label for="link">Movie Link *</label>
                    <input type="url" id="link" name="link" required 
                           value="<?php echo htmlspecialchars($_POST['link'] ?? ''); ?>" 
                           placeholder="Enter movie link">
                </div>
                
                <button type="submit" class="btn-submit">Add Movie</button>
            </form>
        </div>
    </main>
</body>
</html>