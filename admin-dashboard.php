<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: admin-login.php');
    exit;
}

// movies data
$movies = [];
$jsonFile = 'movies.json';

if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $movies = json_decode($jsonData, true);
}

// Handle form submissions (edit and delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Edit movie
    if (isset($_POST['edit_movie'])) {
        $movieId = $_POST['movie_id'];
        if (isset($movies[$movieId])) {
            $movies[$movieId] = [
                'title' => $_POST['title'],
                'year' => $_POST['year'],
                'duration' => $_POST['duration'],
                'rating' => $_POST['rating'],
                'image' => $_POST['image'],
                'link' => $_POST['link']
            ];
            
            file_put_contents($jsonFile, json_encode($movies, JSON_PRETTY_PRINT));
            $success = "Movie updated successfully!";
        }
    }
    
    // Delete movie
    if (isset($_POST['delete_movie'])) {
        $movieId = $_POST['movie_id'];
        if (isset($movies[$movieId])) {
            array_splice($movies, $movieId, 1);
            file_put_contents($jsonFile, json_encode($movies, JSON_PRETTY_PRINT));
            $success = "Movie deleted successfully!";
            
            // Refresh movies array after deletion
            $jsonData = file_get_contents($jsonFile);
            $movies = json_decode($jsonData, true);
        }
    }
}

// Check for success message from add movie
$add_success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Movie Finding Made Easy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="admin-dashboard">
    <header class="admin-header">
        <div class="admin-nav">
            <h1>🎬 Admin Dashboard</h1>
            <div>
                <a href="admin-logout.php" class="admin-btn">🚪 Logout</a>
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1 class="welcome-title">Welcome to Admin Dashboard</h1>
            <p class="welcome-subtitle">Manage your movie collection with ease</p>
            <div class="admin-username">
                👋 Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="success-message">
                ✅ <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($add_success): ?>
            <div class="success-message">
                ✅ Movie added successfully!
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($movies); ?></div>
                <div class="stat-label">Total Movies</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo date('M d, Y'); ?></div>
                <div class="stat-label">Last Updated</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?php 
                    if (count($movies) > 0) {
                        $ratings = array_column($movies, 'rating');
                        $average = array_sum($ratings) / count($ratings);
                        echo number_format($average, 1);
                    } else {
                        echo '0.0';
                    }
                    ?>
                </div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="admin-actions">
            <a href="add-movie.php" class="admin-btn">➕ Add New Movie</a>
            <a href="home.php" class="admin-btn">👀 View Website</a>
            <a href="#" class="admin-btn" onclick="location.reload()">🔄 Refresh</a>
        </div>

        <!-- Movie Management -->
        <div class="movie-management">
            <h2 class="section-title">Movie Management</h2>
            <div class="movie-grid">
                <?php if (!empty($movies)): ?>
                    <?php foreach ($movies as $index => $movie): ?>
                    <div class="movie-card admin-movie-card">
                        <img src="<?php echo htmlspecialchars($movie['image']); ?>" 
                             alt="<?php echo htmlspecialchars($movie['title']); ?>">
                        <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                        <div class="meta">
                            <span class="duration-year">
                                <?php echo htmlspecialchars($movie['year']); ?> • 
                                <?php echo htmlspecialchars($movie['duration']); ?>
                            </span>
                            <div class="rating">
                                <span class="star">★</span>
                                <span class="avg"><?php echo htmlspecialchars($movie['rating']); ?></span>
                            </div>
                        </div>
                        
                        <div class="admin-movie-actions">
                            <button class="admin-btn edit-btn toggle-edit" 
                                    data-target="edit-form-<?php echo $index; ?>">
                                ✏️ Edit
                            </button>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="movie_id" value="<?php echo $index; ?>">
                                <button type="submit" name="delete_movie" class="admin-btn delete-btn" 
                                        onclick="return confirm('Are you sure you want to delete <?php echo htmlspecialchars(addslashes($movie['title'])); ?>?')">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                        
                        <!-- Edit Form -->
                        <div id="edit-form-<?php echo $index; ?>" class="edit-form">
                            <form method="POST">
                                <input type="hidden" name="movie_id" value="<?php echo $index; ?>">
                                
                                <div class="form-group">
                                    <label>🎬 Movie Title</label>
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($movie['title']); ?>" required>
                                </div>
                                
                                <div class="form-row">
                                    <div class="form-group">
                                        <label>📅 Release Year</label>
                                        <input type="number" name="year" value="<?php echo htmlspecialchars($movie['year']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>⭐ Rating</label>
                                        <input type="number" step="0.1" name="rating" value="<?php echo htmlspecialchars($movie['rating']); ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>⏱️ Duration</label>
                                    <input type="text" name="duration" value="<?php echo htmlspecialchars($movie['duration']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>🖼️ Poster Image URL</label>
                                    <input type="url" name="image" value="<?php echo htmlspecialchars($movie['image']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>🔗 Movie Link</label>
                                    <input type="url" name="link" value="<?php echo htmlspecialchars($movie['link']); ?>" required>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" name="edit_movie" class="admin-btn save-btn">
                                        💾 Save Changes
                                    </button>
                                    <button type="button" class="admin-btn cancel-btn toggle-edit" 
                                            data-target="edit-form-<?php echo $index; ?>">
                                        ❌ Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-results">
                        <p>🎬 No movies found in your collection</p>
                        <a href="add-movie.php" class="admin-btn">➕ Add Your First Movie</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>


  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button>

    <script src="js/script.js"></script>
</body>
</html>