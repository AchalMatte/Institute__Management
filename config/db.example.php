<?php
// Copy this file to db.php and fill in your credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'your_db_username');
define('DB_PASS', 'your_db_password');
define('DB_NAME', 'acetech_db');
define('SITE_NAME', 'Acetech Institute');
define('SITE_URL', 'http://localhost/Intitute_Management');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);
$conn->set_charset("utf8");

function sanitize($conn, $data) {
    return $conn->real_escape_string(htmlspecialchars(trim($data)));
}
function redirect($url) { header("Location: $url"); exit(); }
function isLoggedIn() { return isset($_SESSION['admin_id']); }
function requireLogin() {
    if (!isLoggedIn()) redirect(SITE_URL . '/admin/login.php');
}
?>
