<?php
/**
 * Application Settings and Constants
 */

// Load environment variables
require_once __DIR__ . '/env.php';

define('SITE_URL', getenv('SITE_URL') ?: 'http://localhost/ecommerce-website/fashion-ecommerce/');
define('SITE_NAME', getenv('SITE_NAME') ?: 'Fashion Brands');
define('ADMIN_PATH', SITE_URL . 'admin/');
define('UPLOAD_PATH', 'uploads/products/');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global functions (e.g., base_url helper)
function base_url($path = '')
{
    return SITE_URL . $path;
}

function admin_url($path = '')
{
    return ADMIN_PATH . $path;
}

function redirect($url)
{
    header("Location: " . $url);
    exit();
}
?>