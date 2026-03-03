<?php
/**
 * Simple .env loader
 */
$envPath = dirname(__DIR__) . '/.env';

if (file_exists($envPath)) {
    $envLines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0)
            continue;

        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);

            // Remove quotes if present
            $value = trim($value, '"\'');

            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}
