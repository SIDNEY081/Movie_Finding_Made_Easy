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
if (isset($_GET['id']) && isset($movies[$_GET['id']])) {
    // Remove the movie from the array
    array_splice($movies, $_GET['id'], 1);
    
    // Save back to JSON file
    file_put_contents($jsonFile, json_encode($movies, JSON_PRETTY_PRINT));
    
    // Redirect back to dashboard with success message
    header('Location: admin-dashboard.php?success=delete');
    exit;
} else {
    // If no valid ID, redirect to dashboard
    header('Location: admin-dashboard.php');
    exit;
}
?>