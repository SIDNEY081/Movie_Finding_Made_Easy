<?php
// router.php - needed for static CSS/JS/images to work
if (php_sapi_name() == 'cli-server') {
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false; // serve static file directly
    }
}
require_once __DIR__ . '/index.php';
