<?php
/**
 * Database connection configuration – production ready
 */

// Load optional .env file for production variables (if it exists)
if (file_exists(__DIR__ . '/.env.production')) {
    $envLines = file(__DIR__ . '/.env.production', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        if (strpos(trim($line), '#') === 0)
            continue; // skip comments
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            putenv(trim($parts[0]) . '=' . trim($parts[1]));
        }
    }
}

// ------------------------------------------------------------------
// Environment‑aware connection parameters (fallback to dev defaults)
// ------------------------------------------------------------------
$host = getenv('DB_HOST') ?: 'localhost';   // force TCP, works locally & prod
$user = getenv('DB_USER') ?: 'ssc94_demohost';
$pass = getenv('DB_PASS') ?: 'gpxaJXGRHG0EcYZbtAr@';
$db = getenv('DB_NAME') ?: 'ssc94_fashions_db';

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