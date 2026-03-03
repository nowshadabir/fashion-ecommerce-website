<?php
/**
 * Customer Dashboard
 */
require_once '../config/config.php';
require_once '../config/db.php';

// Guard: must be logged in
if (!isset($_SESSION['customer_logged_in']) || $_SESSION['customer_logged_in'] !== true) {
    redirect(base_url('login.php'));
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    redirect(base_url('login.php'));
}

// Handle profile save (demo)
$profile_saved = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_profile') {
    $_SESSION['customer_name'] = trim($_POST['full_name'] ?? $_SESSION['customer_name']);
    $_SESSION['customer_phone'] = trim($_POST['phone'] ?? '');
    $profile_saved = true;
}

// Logged-in customer data
$customer = [
    'name' => $_SESSION['customer_name'] ?? 'Guest',
    'email' => $_SESSION['customer_email'] ?? 'guest@example.com',
    'phone' => $_SESSION['customer_phone'] ?? '',
    'id' => $_SESSION['customer_id'] ?? 1001,
    'joined' => 'March 2024',
    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($_SESSION['customer_name'] ?? 'G') . '&background=111111&color=d4af37&size=200&bold=true&font-size=0.4',
];

// Demo order history
$orders = [
    ['id' => 'ORD-8821', 'date' => 'Feb 28, 2026', 'items' => 'Classic Heritage Trench + 1', 'total' => '$1,170.00', 'status' => 'delivered', 'status_label' => 'Delivered'],
    ['id' => 'ORD-8795', 'date' => 'Feb 14, 2026', 'items' => 'Artisan Chelsea Boots', 'total' => '$450.00', 'status' => 'shipped', 'status_label' => 'Shipped'],
    ['id' => 'ORD-8701', 'date' => 'Jan 22, 2026', 'items' => 'Minimalist Watch + Leather Bag', 'total' => '$870.00', 'status' => 'processing', 'status_label' => 'Processing'],
    ['id' => 'ORD-8603', 'date' => 'Dec 10, 2025', 'items' => 'Slim Fit Blazer', 'total' => '$620.00', 'status' => 'delivered', 'status_label' => 'Delivered'],
    ['id' => 'ORD-8512', 'date' => 'Nov 05, 2025', 'items' => 'Wool Overcoat', 'total' => '$750.00', 'status' => 'cancelled', 'status_label' => 'Cancelled'],
];

// Active tab (from GET)
$active_tab = $_GET['tab'] ?? 'dashboard';

include_once '../includes/header.php';
?>

<style>
    /* =====================================================
   CUSTOMER DASHBOARD — FULL PAGE STYLES
   ===================================================== */

    .cd-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        min-height: calc(100vh - 130px);
        background: #f5f6f8;
    }

    /* ── SIDEBAR ───────────────────────────────────────── */
    .cd-sidebar {
        background: var(--primary);
        display: flex;
        flex-direction: column;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .cd-sidebar-top {
        padding: 2.5rem 2rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        text-align: center;
    }

    .cd-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--accent);
        margin: 0 auto 1rem;
        display: block;
    }

    .cd-sidebar-name {
        font-size: 1.05rem;
        font-weight: 800;
        color: #fff;
        text-transform: capitalize;
        margin-bottom: 0.2rem;
    }

    .cd-sidebar-email {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.4);
        margin-bottom: 0.8rem;
        word-break: break-all;
    }

    .cd-member-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(212, 175, 55, 0.15);
        border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--accent);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        padding: 0.3rem 0.9rem;
        border-radius: 99px;
    }

    /* Nav */
    .cd-nav {
        flex: 1;
        padding: 1.5rem 0;
    }

    .cd-nav-group {
        padding: 0 1.5rem 0.5rem;
        margin-bottom: 0.25rem;
    }

    .cd-nav-group-label {
        font-size: 0.62rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.25);
        font-weight: 700;
        padding: 1rem 0.5rem 0.5rem;
        display: block;
    }

    .cd-nav-link {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        padding: 0.85rem 1rem;
        color: rgba(255, 255, 255, 0.55);
        font-size: 0.88rem;
        font-weight: 600;
        border-radius: 6px;
        transition: all 0.2s;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        cursor: pointer;
        font-family: inherit;
        position: relative;
    }

    .cd-nav-link i {
        width: 20px;
        text-align: center;
        font-size: 0.95rem;
    }

    .cd-nav-link:hover {
        background: rgba(255, 255, 255, 0.07);
        color: rgba(255, 255, 255, 0.85);
    }

    .cd-nav-link.active {
        background: rgba(212, 175, 55, 0.15);
        color: var(--accent);
        font-weight: 700;
    }

    .cd-nav-link .nav-badge {
        margin-left: auto;
        background: var(--accent);
        color: var(--primary);
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.15rem 0.5rem;
        border-radius: 99px;
    }

    .cd-sidebar-footer {
        padding: 1.5rem 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.07);
    }

    .cd-logout-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .cd-logout-btn:hover {
        color: #e74c3c;
    }

    /* ── MAIN CONTENT ──────────────────────────────────── */
    .cd-main {
        padding: 2.5rem 3rem;
        overflow-y: auto;
    }

    .cd-page {
        display: none;
    }

    .cd-page.active {
        display: block;
    }

    /* Page header */
    .cd-page-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e5e5;
    }

    .cd-page-head h1 {
        font-size: 1.5rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .cd-page-head p {
        font-size: 0.85rem;
        color: #999;
        margin-top: 0.25rem;
    }

    /* ── Overview cards ── */
    .cd-stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.2rem;
        margin-bottom: 2.5rem;
    }

    .cd-stat-card {
        background: #fff;
        padding: 1.8rem;
        border-radius: 8px;
        border: 1px solid #eee;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
        overflow: hidden;
    }

    .cd-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    }

    .cd-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--accent);
    }

    .cd-stat-icon {
        width: 42px;
        height: 42px;
        background: #f5f6f8;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        color: var(--primary);
        margin-bottom: 1.2rem;
    }

    .cd-stat-num {
        font-size: 2rem;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 0.3rem;
    }

    .cd-stat-label {
        font-size: 0.75rem;
        color: #999;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    /* Recent activity (dashboard home) */
    .cd-section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #aaa;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cd-recent-orders {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
    }

    /* ── Orders Table ── */
    .cd-orders-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cd-orders-table th {
        text-align: left;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #aaa;
        padding: 1rem 1.5rem;
        background: #f9f9f9;
        border-bottom: 1px solid #eee;
        font-weight: 700;
    }

    .cd-orders-table td {
        padding: 1.1rem 1.5rem;
        font-size: 0.88rem;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }

    .cd-orders-table tr:last-child td {
        border-bottom: none;
    }

    .cd-orders-table tr:hover td {
        background: #fafafa;
    }

    .cd-order-id {
        font-weight: 800;
        color: var(--primary);
    }

    .cd-order-items {
        color: #666;
    }

    .cd-order-total {
        font-weight: 700;
    }

    .cd-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.35rem 0.85rem;
        border-radius: 99px;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .status-delivered {
        background: #d4edda;
        color: #155724;
    }

    .status-shipped {
        background: #cce5ff;
        color: #004085;
    }

    .status-processing {
        background: #fff3cd;
        color: #856404;
    }

    .status-cancelled {
        background: #f8d7da;
        color: #721c24;
    }

    .cd-order-action {
        background: none;
        border: 1px solid #ddd;
        padding: 0.4rem 0.9rem;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 4px;
    }

    .cd-order-action:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* ── Order Tracking ── */
    .cd-tracking-select {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .cd-tracking-select h3 {
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 1rem;
    }

    .cd-tracking-select select {
        width: 100%;
        padding: 0.9rem 1rem;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
        margin-bottom: 1rem;
    }

    .cd-tracking-select select:focus {
        border-color: var(--primary);
    }

    .cd-track-btn {
        padding: 0.85rem 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .cd-track-btn:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .cd-progress-panel {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 2.5rem;
    }

    .cd-progress-panel .order-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .cd-meta-item small {
        display: block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #aaa;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .cd-meta-item span {
        font-size: 0.92rem;
        font-weight: 700;
    }

    /* Stepper */
    .cd-stepper {
        display: flex;
        align-items: flex-start;
        gap: 0;
        margin-bottom: 2rem;
        position: relative;
    }

    .cd-stepper::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 24px;
        right: 24px;
        height: 2px;
        background: #e5e5e5;
        z-index: 0;
    }

    .cd-step {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .cd-step-circle {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #e5e5e5;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        font-size: 1rem;
        color: #bbb;
        border: 3px solid #e5e5e5;
        transition: all 0.3s;
    }

    .cd-step.done .cd-step-circle {
        background: #2ecc71;
        border-color: #2ecc71;
        color: #fff;
    }

    .cd-step.active .cd-step-circle {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.2);
    }

    .cd-step-label {
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #aaa;
        margin-bottom: 0.2rem;
    }

    .cd-step.done .cd-step-label,
    .cd-step.active .cd-step-label {
        color: var(--primary);
    }

    .cd-step-date {
        font-size: 0.7rem;
        color: #bbb;
    }

    /* ── Profile ── */
    .cd-profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
    }

    .cd-profile-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 2rem;
    }

    .cd-profile-card h3 {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #aaa;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #f5f5f5;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .cd-profile-card h3 i {
        color: var(--accent);
    }

    .cd-profile-avatar-section {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .cd-profile-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--accent);
        flex-shrink: 0;
    }

    .cd-field {
        margin-bottom: 1.2rem;
    }

    .cd-field label {
        display: block;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        color: #555;
        margin-bottom: 0.4rem;
    }

    .cd-field input,
    .cd-field select {
        width: 100%;
        padding: 0.9rem 1rem;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
        background: #fafafa;
    }

    .cd-field input:focus {
        border-color: var(--primary);
        background: #fff;
    }

    .cd-field input[readonly] {
        background: #f5f5f5;
        color: #aaa;
    }

    .cd-save-btn {
        padding: 0.9rem 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .cd-save-btn:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .cd-success-flash {
        background: #d4edda;
        border-left: 3px solid #2ecc71;
        padding: 0.8rem 1.2rem;
        font-size: 0.85rem;
        color: #155724;
        margin-bottom: 1.5rem;
        border-radius: 4px;
    }

    /* ── Wishlist ── */
    .cd-wishlist-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .cd-wish-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .cd-wish-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    }

    .cd-wish-card img {
        width: 100%;
        aspect-ratio: 4/5;
        object-fit: cover;
        display: block;
    }

    .cd-wish-body {
        padding: 1.2rem;
    }

    .cd-wish-name {
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .cd-wish-price {
        font-size: 1rem;
        font-weight: 800;
        color: var(--accent);
        margin-bottom: 1rem;
    }

    .cd-wish-actions {
        display: flex;
        gap: 0.6rem;
    }

    .cd-wish-add-btn {
        flex: 1;
        padding: 0.65rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .cd-wish-add-btn:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .cd-wish-remove-btn {
        width: 38px;
        border: 1.5px solid #eee;
        background: none;
        color: #e74c3c;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .cd-wish-remove-btn:hover {
        background: #e74c3c;
        color: #fff;
        border-color: #e74c3c;
    }

    /* ── Settings ── */
    .cd-settings-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .cd-setting-row {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .cd-setting-info h4 {
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
    }

    .cd-setting-info p {
        font-size: 0.82rem;
        color: #999;
    }

    /* Toggle switch */
    .cd-toggle {
        position: relative;
        width: 50px;
        height: 26px;
        flex-shrink: 0;
    }

    .cd-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .cd-slider {
        position: absolute;
        inset: 0;
        background: #ddd;
        border-radius: 99px;
        cursor: pointer;
        transition: 0.3s;
    }

    .cd-slider::before {
        content: '';
        position: absolute;
        height: 20px;
        width: 20px;
        left: 3px;
        top: 3px;
        background: #fff;
        border-radius: 50%;
        transition: 0.3s;
    }

    .cd-toggle input:checked+.cd-slider {
        background: var(--primary);
    }

    .cd-toggle input:checked+.cd-slider::before {
        transform: translateX(24px);
    }

    /* ── Responsive ── */
    @media (max-width: 1100px) {
        .cd-layout {
            grid-template-columns: 240px 1fr;
        }

        .cd-stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .cd-profile-grid {
            grid-template-columns: 1fr;
        }

        .cd-wishlist-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cd-layout {
            grid-template-columns: 1fr;
        }

        .cd-sidebar {
            position: fixed;
            left: -100%;
            top: 0;
            z-index: 2000;
            width: 280px;
            height: 100vh;
            transition: left 0.35s ease;
        }

        .cd-sidebar.open {
            left: 0;
        }

        .cd-main {
            padding: 1.5rem;
        }

        .cd-stats-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cd-wishlist-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cd-mobile-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: var(--primary);
            padding: 1rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .cd-mobile-menu-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 1.4rem;
            cursor: pointer;
        }

        .cd-mobile-title {
            color: #fff;
            font-weight: 800;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .cd-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1999;
        }

        .cd-overlay.show {
            display: block;
        }
    }

    @media (min-width: 769px) {
        .cd-mobile-header {
            display: none;
        }

        .cd-overlay {
            display: none !important;
        }
    }
</style>

<!-- Mobile Header -->
<div class="cd-mobile-header">
    <button class="cd-mobile-menu-btn" id="cd-menu-btn"><i class="fas fa-bars"></i></button>
    <span class="cd-mobile-title">My Account</span>
</div>

<!-- Overlay for mobile sidebar -->
<div class="cd-overlay" id="cd-overlay"></div>

<div class="cd-layout">

    <!-- ═══════════ SIDEBAR ═══════════ -->
    <aside class="cd-sidebar" id="cd-sidebar">

        <div class="cd-sidebar-top">
            <img class="cd-avatar" src="<?= htmlspecialchars($customer['avatar']) ?>" alt="Avatar">
            <p class="cd-sidebar-name">
                <?= htmlspecialchars(ucwords($customer['name'])) ?>
            </p>
            <p class="cd-sidebar-email">
                <?= htmlspecialchars($customer['email']) ?>
            </p>
            <span class="cd-member-badge"><i class="fas fa-star"></i> Gold Member</span>
        </div>

        <nav class="cd-nav">
            <div class="cd-nav-group">
                <span class="cd-nav-group-label">Overview</span>
                <a href="#" class="cd-nav-link <?= $active_tab === 'dashboard' ? 'active' : '' ?>"
                    data-page="page-dashboard">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>

            <div class="cd-nav-group">
                <span class="cd-nav-group-label">Shopping</span>
                <a href="#" class="cd-nav-link <?= $active_tab === 'orders' ? 'active' : '' ?>" data-page="page-orders">
                    <i class="fas fa-box"></i> My Orders
                    <span class="nav-badge">5</span>
                </a>
                <a href="#" class="cd-nav-link <?= $active_tab === 'tracking' ? 'active' : '' ?>"
                    data-page="page-tracking">
                    <i class="fas fa-shipping-fast"></i> Order Tracking
                </a>
                <a href="#" class="cd-nav-link <?= $active_tab === 'wishlist' ? 'active' : '' ?>"
                    data-page="page-wishlist">
                    <i class="far fa-heart"></i> Wishlist
                    <span class="nav-badge" id="dash-wish-badge">0</span>
                </a>
            </div>

            <div class="cd-nav-group">
                <span class="cd-nav-group-label">Account</span>
                <a href="#" class="cd-nav-link <?= $active_tab === 'profile' ? 'active' : '' ?>"
                    data-page="page-profile">
                    <i class="fas fa-user"></i> Profile
                </a>
                <a href="#" class="cd-nav-link <?= $active_tab === 'addresses' ? 'active' : '' ?>"
                    data-page="page-addresses">
                    <i class="fas fa-map-marker-alt"></i> Addresses
                </a>
                <a href="#" class="cd-nav-link <?= $active_tab === 'settings' ? 'active' : '' ?>"
                    data-page="page-settings">
                    <i class="fas fa-cog"></i> Settings
                </a>
            </div>

            <div class="cd-nav-group">
                <span class="cd-nav-group-label">Discover</span>
                <a href="<?= base_url('index.php') ?>" class="cd-nav-link">
                    <i class="fas fa-store"></i> Shop Now
                </a>
                <a href="<?= base_url('coupons.php') ?>" class="cd-nav-link">
                    <i class="fas fa-tags"></i> My Coupons
                </a>
            </div>
        </nav>

        <div class="cd-sidebar-footer">
            <a href="?logout=1" class="cd-logout-btn">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </a>
        </div>
    </aside>

    <!-- ═══════════ MAIN CONTENT ═══════════ -->
    <main class="cd-main">

        <!-- ── DASHBOARD HOME ── -->
        <div class="cd-page active" id="page-dashboard">
            <div class="cd-page-head">
                <div>
                    <h1>Welcome back,
                        <?= htmlspecialchars(ucfirst($customer['name'])) ?>! 👋
                    </h1>
                    <p>Here's a quick overview of your account</p>
                </div>
                <p style="font-size:0.8rem; color:#bbb;"><i class="fas fa-clock"></i>
                    <?= date('D, d M Y') ?>
                </p>
            </div>

            <!-- Stats -->
            <div class="cd-stats-grid">
                <div class="cd-stat-card">
                    <div class="cd-stat-icon"><i class="fas fa-box"></i></div>
                    <div class="cd-stat-num">5</div>
                    <div class="cd-stat-label">Total Orders</div>
                </div>
                <div class="cd-stat-card">
                    <div class="cd-stat-icon"><i class="fas fa-shipping-fast"></i></div>
                    <div class="cd-stat-num">1</div>
                    <div class="cd-stat-label">In Transit</div>
                </div>
                <div class="cd-stat-card">
                    <div class="cd-stat-icon"><i class="far fa-heart"></i></div>
                    <div class="cd-stat-num" id="dash-wish-count">0</div>
                    <div class="cd-stat-label">Wishlist Items</div>
                </div>
                <div class="cd-stat-card">
                    <div class="cd-stat-icon"><i class="fas fa-dollar-sign"></i></div>
                    <div class="cd-stat-num">$3,860</div>
                    <div class="cd-stat-label">Total Spent</div>
                </div>
            </div>

            <!-- Active Order Banner -->
            <div
                style="background: linear-gradient(135deg, var(--primary), #2c2c2c); border-radius:8px; padding:2rem; margin-bottom:2rem; display:flex; align-items:center; gap:2rem; color:#fff;">
                <div style="flex:1;">
                    <p
                        style="color:var(--accent); font-size:0.72rem; font-weight:700; letter-spacing:2px; text-transform:uppercase; margin-bottom:0.4rem;">
                        Live Order Update</p>
                    <p style="font-size:1.1rem; font-weight:800; margin-bottom:0.4rem;">ORD-8795 — Artisan Chelsea Boots
                    </p>
                    <p style="color:rgba(255,255,255,0.55); font-size:0.85rem;">Out for delivery — Expected today by
                        6:00 PM</p>
                </div>
                <button onclick="showPage('page-tracking')"
                    style="padding:0.8rem 1.8rem; background:var(--accent); color:var(--primary); border:none; font-family:inherit; font-weight:700; font-size:0.8rem; text-transform:uppercase; letter-spacing:1px; cursor:pointer; flex-shrink:0;">Track
                    Order</button>
            </div>

            <!-- Recent Orders -->
            <p class="cd-section-title">Recent Orders</p>
            <div class="cd-recent-orders">
                <table class="cd-orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_slice($orders, 0, 3) as $ord): ?>
                            <tr>
                                <td class="cd-order-id">
                                    <?= $ord['id'] ?>
                                </td>
                                <td>
                                    <?= $ord['date'] ?>
                                </td>
                                <td class="cd-order-items">
                                    <?= $ord['items'] ?>
                                </td>
                                <td class="cd-order-total">
                                    <?= $ord['total'] ?>
                                </td>
                                <td>
                                    <span class="cd-status-badge status-<?= $ord['status'] ?>">
                                        <?= $ord['status_label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="cd-order-action" onclick="showPage('page-orders')">View</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── MY ORDERS ── -->
        <div class="cd-page" id="page-orders">
            <div class="cd-page-head">
                <div>
                    <h1>My Orders</h1>
                    <p>View and manage all your purchases</p>
                </div>
            </div>
            <div class="cd-recent-orders">
                <table class="cd-orders-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $ord): ?>
                            <tr>
                                <td class="cd-order-id">
                                    <?= $ord['id'] ?>
                                </td>
                                <td>
                                    <?= $ord['date'] ?>
                                </td>
                                <td class="cd-order-items">
                                    <?= $ord['items'] ?>
                                </td>
                                <td class="cd-order-total">
                                    <?= $ord['total'] ?>
                                </td>
                                <td>
                                    <span class="cd-status-badge status-<?= $ord['status'] ?>">
                                        <?= $ord['status_label'] ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="cd-order-action" onclick="showPage('page-tracking')">Track</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ── ORDER TRACKING ── -->
        <div class="cd-page" id="page-tracking">
            <div class="cd-page-head">
                <div>
                    <h1>Order Tracking</h1>
                    <p>Real-time status of your shipments</p>
                </div>
            </div>

            <div class="cd-tracking-select">
                <h3>Select an Order</h3>
                <select id="track-order-select">
                    <option value="ORD-8795">ORD-8795 — Artisan Chelsea Boots (Shipped)</option>
                    <option value="ORD-8701">ORD-8701 — Minimalist Watch + Bag (Processing)</option>
                    <option value="ORD-8821">ORD-8821 — Heritage Trench (Delivered)</option>
                </select>
                <button class="cd-track-btn" onclick="updateTracking()">
                    <i class="fas fa-search"></i> Track Now
                </button>
            </div>

            <div class="cd-progress-panel" id="tracking-panel">
                <div class="order-meta">
                    <div class="cd-meta-item">
                        <small>Order ID</small>
                        <span id="track-oid">ORD-8795</span>
                    </div>
                    <div class="cd-meta-item">
                        <small>Estimated Delivery</small>
                        <span id="track-eta">Today by 6:00 PM</span>
                    </div>
                    <div class="cd-meta-item">
                        <small>Carrier</small>
                        <span>Pathao Logistics</span>
                    </div>
                </div>

                <!-- Stepper -->
                <div class="cd-stepper" id="track-stepper">
                    <div class="cd-step done">
                        <div class="cd-step-circle"><i class="fas fa-check"></i></div>
                        <p class="cd-step-label">Ordered</p>
                        <p class="cd-step-date">Feb 14</p>
                    </div>
                    <div class="cd-step done">
                        <div class="cd-step-circle"><i class="fas fa-check"></i></div>
                        <p class="cd-step-label">Confirmed</p>
                        <p class="cd-step-date">Feb 14</p>
                    </div>
                    <div class="cd-step done">
                        <div class="cd-step-circle"><i class="fas fa-check"></i></div>
                        <p class="cd-step-label">Dispatched</p>
                        <p class="cd-step-date">Feb 15</p>
                    </div>
                    <div class="cd-step active">
                        <div class="cd-step-circle"><i class="fas fa-truck"></i></div>
                        <p class="cd-step-label">Out for Delivery</p>
                        <p class="cd-step-date">Today</p>
                    </div>
                    <div class="cd-step">
                        <div class="cd-step-circle"><i class="fas fa-home"></i></div>
                        <p class="cd-step-label">Delivered</p>
                        <p class="cd-step-date">Pending</p>
                    </div>
                </div>

                <div style="background:#f5f6f8; border-radius:6px; padding:1.2rem 1.5rem;">
                    <p style="font-size:0.82rem; font-weight:700; margin-bottom:0.5rem;">
                        <i class="fas fa-circle" style="color:#2ecc71; font-size:0.5rem; vertical-align:2px;"></i>
                        &nbsp;Latest Update
                    </p>
                    <p id="track-update-text" style="font-size:0.88rem; color:#666;">
                        Your package is out for delivery and will arrive by 6:00 PM today. Our driver is on the way!
                    </p>
                </div>
            </div>
        </div>

        <!-- ── WISHLIST ── -->
        <div class="cd-page" id="page-wishlist">
            <div class="cd-page-head">
                <div>
                    <h1>My Wishlist</h1>
                    <p>Items you've saved for later</p>
                </div>
            </div>
            <div class="cd-wishlist-grid" id="dash-wishlist-grid">
                <!-- Rendered by JS -->
                <p style="grid-column:1/-1; color:#aaa; text-align:center; padding:3rem;" id="wish-empty-msg">
                    <i class="far fa-heart" style="font-size:2.5rem; display:block; margin-bottom:1rem;"></i>
                    Your wishlist is empty. <a href="<?= base_url('index.php') ?>"
                        style="color:var(--primary); font-weight:700;">Browse the shop</a>
                </p>
            </div>
        </div>

        <!-- ── PROFILE ── -->
        <div class="cd-page" id="page-profile">
            <div class="cd-page-head">
                <div>
                    <h1>My Profile</h1>
                    <p>Manage your personal information</p>
                </div>
            </div>

            <?php if ($profile_saved): ?>
                <div class="cd-success-flash"><i class="fas fa-check-circle"></i> Profile updated successfully.</div>
            <?php endif; ?>

            <div class="cd-profile-grid">
                <!-- Personal Info -->
                <div class="cd-profile-card" style="grid-column: 1 / -1;">
                    <div class="cd-profile-avatar-section">
                        <img class="cd-profile-avatar" src="<?= htmlspecialchars($customer['avatar']) ?>" alt="Avatar">
                        <div>
                            <p style="font-size:1.1rem; font-weight:800; margin-bottom:0.3rem;">
                                <?= htmlspecialchars(ucwords($customer['name'])) ?>
                            </p>
                            <p style="font-size:0.85rem; color:#999; margin-bottom:0.8rem;">Member since
                                <?= $customer['joined'] ?> &nbsp;•&nbsp; ID #
                                <?= $customer['id'] ?>
                            </p>
                            <span class="cd-member-badge" style="display:inline-flex;"><i class="fas fa-star"></i> Gold
                                Member</span>
                        </div>
                    </div>

                    <h3><i class="fas fa-user"></i> Personal Information</h3>

                    <form method="POST" id="profile-form">
                        <input type="hidden" name="action" value="save_profile">
                        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.2rem;">
                            <div class="cd-field">
                                <label>Full Name</label>
                                <input type="text" name="full_name"
                                    value="<?= htmlspecialchars(ucwords($customer['name'])) ?>" required>
                            </div>
                            <div class="cd-field">
                                <label>Email (read-only)</label>
                                <input type="email" value="<?= htmlspecialchars($customer['email']) ?>" readonly>
                            </div>
                            <div class="cd-field">
                                <label>Phone Number</label>
                                <input type="tel" name="phone" value="<?= htmlspecialchars($customer['phone'] ?? '') ?>"
                                    placeholder="+880 1XX-XXXXXXX">
                            </div>
                            <div class="cd-field">
                                <label>Date of Birth</label>
                                <input type="date" name="dob">
                            </div>
                        </div>
                        <button type="submit" class="cd-save-btn" style="margin-top:1rem;">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="cd-profile-card">
                    <h3><i class="fas fa-lock"></i> Change Password</h3>
                    <div class="cd-field">
                        <label>Current Password</label>
                        <input type="password" placeholder="Enter current password">
                    </div>
                    <div class="cd-field">
                        <label>New Password</label>
                        <input type="password" placeholder="Min. 8 characters">
                    </div>
                    <div class="cd-field">
                        <label>Confirm New Password</label>
                        <input type="password" placeholder="Repeat new password">
                    </div>
                    <button class="cd-save-btn"
                        onclick="if(typeof showToast!='undefined') showToast('Password updated (demo)')">Update
                        Password</button>
                </div>

                <!-- Preferences -->
                <div class="cd-profile-card">
                    <h3><i class="fas fa-palette"></i> Preferences</h3>
                    <div class="cd-field">
                        <label>Preferred Style</label>
                        <select>
                            <option>Classic / Formal</option>
                            <option>Casual / Streetwear</option>
                            <option>Minimalist</option>
                            <option>Luxury / High-fashion</option>
                        </select>
                    </div>
                    <div class="cd-field">
                        <label>Sizing (Tops)</label>
                        <select>
                            <option>XS</option>
                            <option>S</option>
                            <option selected>M</option>
                            <option>L</option>
                            <option>XL</option>
                        </select>
                    </div>
                    <div class="cd-field">
                        <label>Currency</label>
                        <select>
                            <option>BDT — Bangladeshi Taka</option>
                            <option>USD — US Dollar</option>
                            <option>GBP — British Pound</option>
                        </select>
                    </div>
                    <button class="cd-save-btn"
                        onclick="if(typeof showToast!='undefined') showToast('Preferences saved (demo)')">Save
                        Preferences</button>
                </div>
            </div>
        </div>

        <!-- ── ADDRESSES ── -->
        <div class="cd-page" id="page-addresses">
            <div class="cd-page-head">
                <div>
                    <h1>Saved Addresses</h1>
                    <p>Manage shipping and billing addresses</p>
                </div>
                <button class="cd-save-btn"
                    onclick="if(typeof showToast!='undefined') showToast('Add address feature coming soon!')">
                    <i class="fas fa-plus"></i> Add Address
                </button>
            </div>
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">
                <div class="cd-profile-card">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.8rem;">
                        <h3 style="border:none; margin-bottom:0; padding-bottom:0;"><i class="fas fa-home"></i> Home
                            Address</h3>
                        <span
                            style="background:#d4edda; color:#155724; font-size:0.68rem; font-weight:700; padding:0.2rem 0.6rem; border-radius:3px; text-transform:uppercase;">Default</span>
                    </div>
                    <p style="font-size:0.9rem; color:#444; line-height:1.8;">
                        <?= htmlspecialchars(ucwords($customer['name'])) ?><br>
                        House 24, Road 11, Block C<br>
                        Banani, Dhaka 1213<br>
                        Bangladesh<br>
                        +880 170-000-0000
                    </p>
                    <div style="display:flex; gap:0.8rem; margin-top:1.2rem;">
                        <button class="cd-order-action">Edit</button>
                        <button class="cd-order-action" style="color:#e74c3c;">Delete</button>
                    </div>
                </div>
                <div class="cd-profile-card"
                    style="border:2px dashed #ddd; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; min-height:200px; cursor:pointer;"
                    onclick="if(typeof showToast!='undefined') showToast('Add address coming soon!')">
                    <i class="fas fa-plus-circle" style="font-size:2rem; color:#ddd; margin-bottom:0.8rem;"></i>
                    <p style="color:#bbb; font-size:0.88rem; font-weight:600;">Add New Address</p>
                </div>
            </div>
        </div>

        <!-- ── SETTINGS ── -->
        <div class="cd-page" id="page-settings">
            <div class="cd-page-head">
                <div>
                    <h1>Account Settings</h1>
                    <p>Manage notifications and preferences</p>
                </div>
            </div>
            <div class="cd-settings-list">
                <div class="cd-setting-row">
                    <div class="cd-setting-info">
                        <h4>Email Notifications</h4>
                        <p>Receive order updates, promotions, and newsletters by email.</p>
                    </div>
                    <label class="cd-toggle">
                        <input type="checkbox" checked>
                        <span class="cd-slider"></span>
                    </label>
                </div>
                <div class="cd-setting-row">
                    <div class="cd-setting-info">
                        <h4>SMS Order Alerts</h4>
                        <p>Get text messages when your order status changes.</p>
                    </div>
                    <label class="cd-toggle">
                        <input type="checkbox" checked>
                        <span class="cd-slider"></span>
                    </label>
                </div>
                <div class="cd-setting-row">
                    <div class="cd-setting-info">
                        <h4>Promotional Offers</h4>
                        <p>Be the first to hear about exclusive deals, flash sales, and new arrivals.</p>
                    </div>
                    <label class="cd-toggle">
                        <input type="checkbox">
                        <span class="cd-slider"></span>
                    </label>
                </div>
                <div class="cd-setting-row">
                    <div class="cd-setting-info">
                        <h4>Wishlist Reminders</h4>
                        <p>Get notified when items in your wishlist go on sale or are running low.</p>
                    </div>
                    <label class="cd-toggle">
                        <input type="checkbox" checked>
                        <span class="cd-slider"></span>
                    </label>
                </div>
                <div class="cd-setting-row" style="border-color:#fdecea;">
                    <div class="cd-setting-info">
                        <h4 style="color:#e74c3c;">Delete Account</h4>
                        <p>Permanently delete your account and all associated data. This cannot be undone.</p>
                    </div>
                    <button class="cd-order-action" style="color:#e74c3c; border-color:#e74c3c; white-space:nowrap;"
                        onclick="if(confirm('Are you sure? This cannot be undone.')) window.location.href='?logout=1'">
                        Delete Account
                    </button>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Page Navigation ── */
        const navLinks = document.querySelectorAll('.cd-nav-link[data-page]');
        const pages = document.querySelectorAll('.cd-page');

        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                showPage(this.dataset.page);
                // Close mobile sidebar
                document.getElementById('cd-sidebar').classList.remove('open');
                document.getElementById('cd-overlay').classList.remove('show');
            });
        });

        /* ── Mobile Sidebar Toggle ── */
        document.getElementById('cd-menu-btn').addEventListener('click', function () {
            document.getElementById('cd-sidebar').classList.add('open');
            document.getElementById('cd-overlay').classList.add('show');
        });

        document.getElementById('cd-overlay').addEventListener('click', function () {
            document.getElementById('cd-sidebar').classList.remove('open');
            this.classList.remove('show');
        });

        /* ── Load Wishlist from localStorage ── */
        loadWishlist();

        /* ── Tracking ── */
        updateTracking();
    });

    function showPage(pageId) {
        const pages = document.querySelectorAll('.cd-page');
        const navLinks = document.querySelectorAll('.cd-nav-link[data-page]');
        pages.forEach(p => p.classList.remove('active'));
        navLinks.forEach(l => l.classList.remove('active'));
        const target = document.getElementById(pageId);
        if (target) target.classList.add('active');
        const matchLink = document.querySelector(`.cd-nav-link[data-page="${pageId}"]`);
        if (matchLink) matchLink.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        if (pageId === 'page-wishlist') loadWishlist();
    }

    function loadWishlist() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const grid = document.getElementById('dash-wishlist-grid');
        const emptyMsg = document.getElementById('wish-empty-msg');
        const countEl = document.getElementById('dash-wish-count');
        const badgeEl = document.getElementById('dash-wish-badge');

        if (countEl) countEl.textContent = wishlist.length;
        if (badgeEl) badgeEl.textContent = wishlist.length;

        if (!grid) return;

        // Remove previous cards
        grid.querySelectorAll('.cd-wish-card').forEach(c => c.remove());

        if (wishlist.length === 0) {
            if (emptyMsg) emptyMsg.style.display = 'block';
            return;
        }

        if (emptyMsg) emptyMsg.style.display = 'none';

        wishlist.forEach((item, index) => {
            const card = document.createElement('div');
            card.className = 'cd-wish-card';
            card.innerHTML = `
            <img src="${item.image || 'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=400'}" alt="${item.name}">
            <div class="cd-wish-body">
                <p class="cd-wish-name">${item.name}</p>
                <p class="cd-wish-price">$${parseFloat(item.price || 0).toFixed(2)}</p>
                <div class="cd-wish-actions">
                    <button class="cd-wish-add-btn" onclick="moveToCart(${index})">
                        <i class="fas fa-shopping-bag"></i> Add to Bag
                    </button>
                    <button class="cd-wish-remove-btn" onclick="removeFromWishlist(${index})" title="Remove">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </div>
            </div>
        `;
            grid.insertBefore(card, grid.querySelector('.cd-wish-card') ? grid.lastChild : null);
            grid.appendChild(card);
        });
    }

    function removeFromWishlist(index) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        wishlist.splice(index, 1);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        loadWishlist();
        if (typeof showToast === 'function') showToast('Removed from wishlist');
    }

    function moveToCart(index) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const item = wishlist[index];
        if (!item) return;
        item.size = item.size || '';
        item.color = item.color || 'Default';
        const exists = cart.find(c => c.id === item.id);
        if (exists) { exists.qty += 1; }
        else { item.qty = 1; cart.push(item); }
        localStorage.setItem('cart', JSON.stringify(cart));
        if (typeof showToast === 'function') showToast(item.name + ' added to bag!');
        if (typeof updateBadges === 'function') updateBadges(cart.length, wishlist.length);
    }

    // Order tracking demo data
    const trackingData = {
        'ORD-8795': {
            eta: 'Today by 6:00 PM',
            steps: ['done', 'done', 'done', 'active', ''],
            update: 'Your package is out for delivery and will arrive by 6:00 PM today. Our driver is on the way!'
        },
        'ORD-8701': {
            eta: 'Mar 05, 2026',
            steps: ['done', 'done', '', '', ''],
            update: 'Your order has been confirmed and is currently being prepared at our fulfilment centre.'
        },
        'ORD-8821': {
            eta: 'Delivered Feb 28',
            steps: ['done', 'done', 'done', 'done', 'done'],
            update: 'Your order was delivered successfully on Feb 28, 2026. Enjoy your purchase!'
        }
    };

    function updateTracking() {
        const sel = document.getElementById('track-order-select');
        if (!sel) return;
        const ordId = sel.value;
        const data = trackingData[ordId];
        if (!data) return;

        document.getElementById('track-oid').textContent = ordId;
        document.getElementById('track-eta').textContent = data.eta;
        document.getElementById('track-update-text').textContent = data.update;

        const steps = document.querySelectorAll('.cd-step');
        steps.forEach((step, i) => {
            step.classList.remove('done', 'active');
            if (data.steps[i] === 'done') step.classList.add('done');
            if (data.steps[i] === 'active') step.classList.add('active');
        });
    }
</script>

<?php include_once '../includes/footer.php'; ?>