<?php
/**
 * Database connection configuration – production ready
 */

// Load environment variables
require_once __DIR__ . '/env.php';

// Database parameters
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$db = getenv('DB_NAME');

$dsn = "mysql:host={$host};dbname={$db};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log the real error for developers, show a generic message to users
    error_log('Database connection error: ' . $e->getMessage());
    die('Database connection failed. Please try again later.');
}
?>