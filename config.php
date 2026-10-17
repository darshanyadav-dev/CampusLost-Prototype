<?php
// Update these values only if your local MySQL setup differs.
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'campuslost');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die('Database connection failed. Import database.sql and verify config.php.');
}
$conn->set_charset('utf8mb4');
session_start();
?>
