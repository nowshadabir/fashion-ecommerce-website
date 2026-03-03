<?php
/**
 * Admin Panel Dashboard
 */

// Load Configuration and Database
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/db.php';

// Include Admin Header (Placeholder)
// include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en" style="background: #f4f7f6; font-family: sans-serif;">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard |
        <?= SITE_NAME ?>
    </title>
</head>

<body
    style="padding: 3rem; background: #fff; max-width: 800px; margin: 3rem auto; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-radius: 8px;">
    <h1>Admin Panel Dashboard</h1>
    <p>Welcome to the admin panel. Manage products, categories, orders, and users here.</p>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;">
        <div style="background: #eef2f3; padding: 2rem; border-radius: 8px;">
            <h3>Products</h3>
            <p>15 Products Active</p>
            <a href="products.php" style="color: blue;">Manage Products</a>
        </div>
        <div style="background: #eef2f3; padding: 2rem; border-radius: 8px;">
            <h3>Orders</h3>
            <p>5 New Orders</p>
            <a href="orders.php" style="color: blue;">Manage Orders</a>
        </div>
    </div>

    <div style="margin-top: 2rem;">
        <a href="<?= base_url() ?>" style="color: blue;">&larr; Back to Shop</a>
    </div>
</body>

</html>