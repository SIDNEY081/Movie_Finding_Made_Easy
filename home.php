<?php
// Enable full error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();

// Check if coming from landing page
if (isset($_GET['from_landing']) && $_GET['from_landing'] == 1) {
    $_SESSION['landing_seen'] = true;
}

// If haven't seen landing page, redirect to landing
if (!isset($_SESSION['landing_seen'])) {
    header('Location: index.html');
    exit;
}

// Check if admin is logged in (to bypass landing in future)
$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

// IP RESTRICTION - List of allowed IPs that can see admin links
$allowed_ips = [
    '102.64.40.141',    // 
    
];

// Get user's IP address
$user_ip = $_SERVER['REMOTE_ADDR'];

// Check if user's IP is allowed to see admin links
$isAllowedIP = in_array($user_ip, $allowed_ips);

// Movie data 
$movies = [];
$jsonFile = 'movies.json';

if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $movies = json_decode($jsonData, true);
    
    // Check if JSON decoding was successful
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('JSON decode error: ' . json_last_error_msg());
        $movies = [];
    }
}

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$selectedGenre = isset($_GET['genre']) ? trim($_GET['genre']) : '';
$filteredMovies = $movies;

// Predefined list of movie genres
$allGenres = [
    'Action', 'Adventure', 'Animation', 'Comedy', 'Crime', 
    'Documentary', 'Drama', 'Fantasy', 'Horror', 'Mystery', 
    'Romance', 'Sci-Fi', 'Thriller', 'Western', 'Family',
    'Musical', 'War', 'Biography', 'History', 'Sport'
];

// Filter movies based on search and genre
if ((!empty($searchQuery) || !empty($selectedGenre)) && !empty($movies)) {
    $filteredMovies = array_filter($movies, function($movie) use ($searchQuery, $selectedGenre) {
        $matchesSearch = true;
        $matchesGenre = true;
        
        if (!empty($searchQuery)) {
            $matchesSearch = stripos($movie['title'], $searchQuery) !== false;
        }
        
        if (!empty($selectedGenre)) {
            $matchesGenre = false;
            if (isset($movie['genre']) && !empty($movie['genre'])) {
                $movieGenres = array_map('trim', explode(',', $movie['genre']));
                $matchesGenre = in_array($selectedGenre, $movieGenres);
            }
        }
        
        return $matchesSearch && $matchesGenre;
    });
}

// Set correct timezone
date_default_timezone_set('Africa/Johannesburg');

$hour = date('H');

if ($hour < 12) {
    $time_of_day = 'morning';
} elseif ($hour < 18) {
    $time_of_day = 'afternoon';
} else {
    $time_of_day = 'evening';
}

$greeting = "Good $time_of_day, welcome to Movie Finding Made Easy!";



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Finding Made Easy</title>
  <meta name="description" content="Discover movies and series effortlessly with Movie Finding Made Easy." />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>
<body>
  
  <!-- Header -->
  <header>
    <a href="home.php">
      <img src="images/logo.png" alt="Site Logo" class="logo" />
    </a>
    <button id="menu-toggle" aria-label="Toggle navigation">☰</button>
    <nav>
      <ul class="nav-menu">
        <li><a href="home.php" class="active">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if ($isAdmin): ?>
          <li><a href="admin-dashboard.php" class="admin-nav-link">Admin Dashboard</a></li>
        <?php elseif ($isAllowedIP): ?>
          <li><a href="admin-login.php" class="admin-nav-link">Admin Login</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>

  <main>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-overlay">
        <h1>Movie Finding Made Easy</h1>
        <p>Skip the scroll. Start the show.</p>
        <div id="greeting" class="greeting-message"><?php echo $greeting; ?></div>
        <form id="search-form" method="GET" action="">
          <div class="search-filters">
            <input type="text" name="search" placeholder="Search for a movie or series..." value="<?php echo htmlspecialchars($searchQuery); ?>" />
            <select name="genre" class="genre-filter" id="genre-filter">
              <option value="">All Genres</option>
              <?php foreach ($allGenres as $genre): ?>
                <option value="<?php echo htmlspecialchars($genre); ?>" <?php echo $selectedGenre === $genre ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($genre); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button type="submit">Search</button>
          </div>
        </form>
      </div>
    </section>

    <!-- Featured Movies Section -->
    <section class="featured">
      <div class="container">
        <h2>Featured Picks</h2>
        <?php if (!empty($selectedGenre)): ?>
          <div class="filter-info">
            <p>Showing results for genre: <strong><?php echo htmlspecialchars($selectedGenre); ?></strong></p>
            <a href="home.php" class="clear-filter">Clear Filter</a>
          </div>
        <?php endif; ?>
        <div class="movie-grid">
          <?php if (!empty($filteredMovies)): ?>
            <?php foreach ($filteredMovies as $movie): ?>
              <a href="<?php echo htmlspecialchars($movie['link']); ?>" target="_blank" class="movie-card" data-aos="fade-up">
                <img src="<?php echo htmlspecialchars($movie['image']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>" loading="lazy">
                <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                <div class="meta">
                  <span class="duration-year">
                    <?php echo htmlspecialchars($movie['year']); ?> • <?php echo htmlspecialchars($movie['duration']); ?>
                  </span>
                  <div class="rating">
                    <span class="star">★</span>
                    <span class="avg"><?php echo htmlspecialchars($movie['rating']); ?></span>
                  </div>
                </div>
                <?php if (isset($movie['genre']) && !empty($movie['genre'])): ?>
                  <div class="genre-tags">
                    <?php 
                    $genres = explode(',', $movie['genre']);
                    $displayGenres = array_slice($genres, 0, 2); // Show only first 2 genres
                    foreach ($displayGenres as $genre): 
                    ?>
                      <span class="genre-tag"><?php echo htmlspecialchars(trim($genre)); ?></span>
                    <?php endforeach; ?>
                    <?php if (count($genres) > 2): ?>
                      <span class="genre-tag">+<?php echo count($genres) - 2; ?> more</span>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
              </a>
            <?php endforeach; ?>
          <?php else: ?>
            <?php if (!empty($searchQuery) || !empty($selectedGenre)): ?>
              <div class="no-results">
                <p>No movies found matching your criteria.</p>
                <?php if (!empty($searchQuery)): ?>
                  <p>Search: "<?php echo htmlspecialchars($searchQuery); ?>"</p>
                <?php endif; ?>
                <?php if (!empty($selectedGenre)): ?>
                  <p>Genre: "<?php echo htmlspecialchars($selectedGenre); ?>"</p>
                <?php endif; ?>
                <a href="home.php" class="btn-primary">View All Movies</a>
              </div>
            <?php else: ?>
              <div class="no-results">
                <p>No movies found. Please check your JSON file.</p>
              </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>  
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>Movie Finding Made Easy</h3>
          <p>Your ultimate destination for discovering great movies and series.</p>
        </div>
        <div class="footer-section">
          <h4>Quick Links</h4>
          <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="contact.php">Contact</a></li>
            <?php if ($isAllowedIP): ?>
              <li><a href="admin-login.php">Admin</a></li>
            <?php endif; ?>
          </ul>
        </div>
        <div class="footer-section">
          <h4>Contact Info</h4>
          <p>Email: info@mfme.com</p>
          <p>Phone: +27 81 056 5675</p>
          <p>Address: 123 Movie Lane, Johannesburg, South Africa</p>
        </div>
        <div class="footer-section">
          <h4>Follow Us</h4>
          <div class="social-links" aria-label="Social links">
            <a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a> |
            <a href="https://twitter.com" target="_blank" rel="noopener">Twitter</a> |
            <a href="https://github.com/SIDNEY081/Movie_Finding_Made_Easy" target="_blank" rel="noopener">GitHub</a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 Movie Finding Made Easy. All rights reserved.</p>
        <p>Created by MFME Team | VUT Web Development 3.2 Final Project</p>
      </div>
    </div>
  </footer>

  <!-- Scroll to Top Button -->
  <button id="scrollTopBtn" aria-label="Scroll to top">↑</button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="js/script.js"></script>
  <script>

    // Initialize AOS animations
    AOS.init({
      duration: 800,
      once: true,
      offset: 100
    });

    // Auto-submit form when genre is selected
    document.getElementById('genre-filter').addEventListener('change', function() {
      document.getElementById('search-form').submit();
    });
  </script>
</body>
</html>