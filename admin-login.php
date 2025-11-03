<?php
session_start();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    //  authentication 
    $admin_username = 'admin';
    $admin_password = 'password123'; 
    
    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: admin-dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Movie Finding Made Easy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <a href="admin-login.php" class="admin-link" style="display: none;">Admin</a>
    
    <div class="admin-login-container">
        <form class="admin-login-form" method="POST">
            <h2>🔐 Admin Login</h2>
            
            <?php if ($error): ?>
                <div class="error-message" style="margin-bottom: 1rem;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       placeholder="Enter admin username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required 
                       placeholder="Enter admin password">
            </div>
            
            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>
</body>
</html>