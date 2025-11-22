<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'brngydb');

// Site configuration
define('SITE_NAME', 'Barangay Management System');
define('SITE_URL', 'http://localhost/MyWebApp');

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>