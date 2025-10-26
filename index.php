<?php
$movies = [];
$jsonFile = 'movies.json';

if (file_exists($jsonFile)) {
    $jsonData = file_get_contents($jsonFile);
    $movies = json_decode($jsonData, true);
}

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$filteredMovies = $movies;

if (!empty($searchQuery)) {
    $filteredMovies = array_filter($movies, function($movie) use ($searchQuery) {
        return stripos($movie['title'], $searchQuery) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Finding Made Easy</title>
  <meta name="description" content="Discover movies and series effortlessly with Movie Finding Made Easy." />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" />
</head>
<body>
  <header>
    <a href="index.php">
      <img src="images/logo.png" alt="Site Logo" class="logo" />
    </a>
    <button id="menu-toggle">☰</button>
    <nav>
      <ul class="nav-menu">
        <li><a href="index.php" class="active">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.php">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div class="hero-overlay">
        <h1>Movie Finding Made Easy</h1>
        <p>Skip the scroll. Start the show.</p>
        <form id="search-form" method="GET" action="">
          <input type="text" name="search" placeholder="Search for a movie or series..." value="<?php echo htmlspecialchars($searchQuery); ?>" />
          <button type="submit">Search</button>
        </form>
      </div>
    </section>

    <section class="featured">
      <h2>Featured Picks</h2>
      <div class="movie-grid">
        <?php if (!empty($filteredMovies)): ?>
          <?php foreach ($filteredMovies as $movie): ?>
            <a href="<?php echo htmlspecialchars($movie['link']); ?>" target="_blank" class="movie-card">
              <img src="<?php echo htmlspecialchars($movie['image']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
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
            </a>
          <?php endforeach; ?>
        <?php else: ?>
          <?php if (!empty($searchQuery)): ?>
            <p style="text-align:center; color:#ccc;">No movies found matching "<?php echo htmlspecialchars($searchQuery); ?>".</p>
          <?php else: ?>
            <p style="text-align:center; color:#ccc;">No movies found. Please check your JSON file.</p>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <footer>
    <p>&copy; 2025 Movie Finding Made Easy</p>
    <p>Created by MFME Team</p>
    <div class="social-links">
      <a href="#">Facebook</a> |
      <a href="#">Twitter</a> |
      <a href="#">GitHub</a>
    </div>
  </footer>

  <button id="scrollTopBtn">↑</button>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
