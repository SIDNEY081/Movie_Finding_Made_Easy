<?php
$messageSent = false;
$errorMessage = '';
$name = $email = $message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid email address.';
    } elseif (strlen($name) < 2) {
        $errorMessage = 'Name must be at least 2 characters long.';
    } elseif (strlen($message) < 10) {
        $errorMessage = 'Message must be at least 10 characters long.';
    } else {
        // Sanitize inputs
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $message = htmlspecialchars($message);
        
        // Simulate email sending 
        $to = 'info@mfme.com';
        $subject = 'New Contact Form Message from ' . $name;
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        
        // For demonstration
        $messageSent = true;
        
        // Clear form fields
        $name = $email = $message = '';
    }
}

// Dynamic greeting
$hour = date('H');
if ($hour < 12) {
    $greeting = 'Good morning!';
} elseif ($hour < 18) {
    $greeting = 'Good afternoon!';
} else {
    $greeting = 'Good evening!';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us — Movie Finding Made Easy</title>
  <meta name="description" content="Contact the Movie Finding Made Easy team for inquiries or feedback." />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css" />
  <link rel="icon" href="images/favicon.ico" type="image/x-icon" />

</head>

<body>

  <!-- Header -->
  <header>
    <a href="index.php">
      <img src="images/logo.png" alt="Site Logo" class="logo" />
    </a>
    <button id="menu-toggle" aria-label="Toggle navigation">☰</button>
    <nav>
      <ul class="nav-menu">
        <li><a href="index.php">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    
    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-overlay">
        <h1>Contact Us</h1>
        <p><?php echo $greeting; ?> Get in touch with the Movie Finding Made Easy team.</p>
      </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content">
      <div class="container">
        <div class="contact-intro" data-aos="fade-up">
          <p>We'd love to hear from you! Fill in the form below and we'll get back to you soon.</p>
        </div>

        <!-- Messages -->
        <?php if ($messageSent): ?>
          <div class="success-message" data-aos="fade-up">
            <div class="message-icon">✓</div>
            <h3>Thank You!</h3>
            <p>Your message has been sent successfully. We'll get back to you within 24 hours.</p>
            <a href="index.php" class="btn-primary">Back to Home</a>
          </div>
        <?php elseif (!empty($errorMessage)): ?>
          <div class="error-message" data-aos="fade-up">
            <div class="message-icon">⚠</div>
            <h3>Error</h3>
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
          </div>
        <?php endif; ?>

        <!-- Contact Form -->
        <form action="contact.php" method="POST" class="contact-form" id="contact-form" data-aos="fade-up" data-aos-delay="100" <?php echo $messageSent ? 'style="display:none;"' : ''; ?>>
          <div class="form-group">
            <label for="name">Full Name *</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name); ?>" required minlength="2" />
            <span class="form-hint">Minimum 2 characters</span>
          </div>

          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($email); ?>" required />
            <span class="form-hint">We'll never share your email</span>
          </div>

          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" rows="6" placeholder="Type your message here..." required minlength="10"><?php echo htmlspecialchars($message); ?></textarea>
            <span class="form-hint">Minimum 10 characters</span>
          </div>

          <button type="submit" class="btn-submit">
            <span class="btn-text">Send Message</span>
            <span class="btn-loading" style="display: none;">Sending...</span>
          </button>
        </form>

        <!-- Contact Information -->
        <div class="contact-info" data-aos="fade-up" data-aos-delay="200">
          <h3>Our Contact Information</h3>
          <div class="contact-details">
            <div class="contact-item">
              <div class="contact-icon">📧</div>
              <div class="contact-text">
                <h4>Email</h4>
                <a href="mailto:info@mfme.com">info@mfme.com</a>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📞</div>
              <div class="contact-text">
                <h4>Phone</h4>
                <a href="tel:+27712345678">+27 81 056 5675/a>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">📍</div>
              <div class="contact-text">
                <h4>Address</h4>
                <p>123 Movie Lane, Johannesburg, South Africa</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">⏱</div>
              <div class="contact-text">
                <h4>Response Time</h4>
                <p>We typically respond within 24 hours</p>
              </div>
            </div>
            <div class="contact-item">
              <div class="contact-icon">🕒</div>
              <div class="contact-text">
                <h4>Office Hours</h4>
                <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                <p>Saturday: 10:00 AM - 2:00 PM</p>
                <p>Sunday: Closed</p>
              </div>
            </div>
          </div>
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
          </ul>.
        </div>
        <div class="footer-section">
          <h4>Contact Info</h4>
          <p>Email: info@mfme.com</p>
          <p>Phone: +27 81 056 5675/p>
          <p>Address: 123 Movie Lane, Johannesburg, South Africa</p>
        </div>
        <div class="footer-section">
          <h4>Follow Us</h4>
          <div class="social-links" aria-label="Social links">

        <a href="https://facebook.com" target="_blank" rel="https://facebook.com">Facebook</a> |
        <a href="https://twitter.com" target="_blank" rel="https://twitter.com">Twitter</a> |
        <a href="https://github.com" target="_blank" rel="https://github.com/SIDNEY081/Movie_Finding_Made_Easy">GitHub</a>
            
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
    AOS.init({
      duration: 800,
      once: true,
      offset: 100
    });

    // Contact form enhancement
    document.addEventListener('DOMContentLoaded', function() {
      const contactForm = document.getElementById('contact-form');
      if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
          const submitBtn = this.querySelector('.btn-submit');
          const btnText = submitBtn.querySelector('.btn-text');
          const btnLoading = submitBtn.querySelector('.btn-loading');
          
          btnText.style.display = 'none';
          btnLoading.style.display = 'inline';
          submitBtn.disabled = true;
        });
      }
    });
  </script>
</body>
</html>
