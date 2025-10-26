<?php
$messageSent = false;
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = 'Please enter a valid email address.';
    } else {
        $to = 'info@mfme.com';
        $subject = 'New Contact Form Message from ' . $name;
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            $messageSent = true;
        } else {
            $errorMessage = 'Failed to send message. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us — Movie Finding Made Easy</title>
  <meta name="description" content="Contact the Movie Finding Made Easy team for inquiries or feedback." />
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
        <li><a href="index.php">Home</a></li>
        <li><a href="about.html">About</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="hero">
      <div class="hero-overlay">
        <h1>Contact Us</h1>
        <p>Get in touch with the Movie Finding Made Easy team.</p>
      </div>
    </section>

    <section class="contact-content">
      <div class="container">
        <div class="contact-intro">
          <p>We'd love to hear from you! Fill in the form below and we'll get back to you soon.</p>
        </div>

        <?php if ($messageSent): ?>
          <div class="success-message">
            <p>Thank you for your message! We'll get back to you soon.</p>
          </div>
        <?php elseif (!empty($errorMessage)): ?>
          <div class="error-message">
            <p><?php echo htmlspecialchars($errorMessage); ?></p>
          </div>
        <?php endif; ?>

        <form action="contact.php" method="POST" class="contact-form" id="contact-form">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required />
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" value="<?php echo htmlspecialchars($email ?? ''); ?>" required />
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="6" placeholder="Type your message here..." required><?php echo htmlspecialchars($message ?? ''); ?></textarea>
          </div>

          <button type="submit">Send Message</button>
        </form>

        <div class="contact-info">
          <h3>Our Contact Information</h3>
          <p><strong>Email:</strong> info@mfme.com</p>
          <p><strong>Phone:</strong> +27 71 234 5678</p>
          <p><strong>Address:</strong> 123 Movie Lane, Johannesburg, South Africa</p>
        </div>
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
