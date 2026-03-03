<?php
/**
 * Fashion E-commerce - Product Detail Page
 */
require_once 'config/config.php';
require_once 'config/db.php';
include_once 'includes/header.php';
?>

<style>
    /* =====================================================
   PRODUCT DETAIL PAGE — DEDICATED STYLES
   ===================================================== */

    /* Breadcrumb navigation */
    .pdp-breadcrumb {
        padding: 1.2rem 5%;
        font-size: 0.8rem;
        color: #aaa;
        letter-spacing: 1px;
        text-transform: uppercase;
        border-bottom: 1px solid var(--border);
    }

    .pdp-breadcrumb a {
        color: #aaa;
    }

    .pdp-breadcrumb a:hover {
        color: var(--primary);
    }

    .pdp-breadcrumb span {
        color: var(--primary);
        font-weight: 600;
    }

    /* Two-column layout */
    .pdp-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 5%;
        align-items: start;
    }

    /* === GALLERY === */
    .pdp-gallery {
        position: sticky;
        top: 100px;
        display: flex;
        flex-direction: row-reverse;
        gap: 1rem;
    }

    .pdp-thumbnails {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        width: 80px;
        flex-shrink: 0;
    }

    .pdp-thumb {
        width: 80px;
        height: 100px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid transparent;
        transition: border-color 0.2s;
        opacity: 0.65;
        transition: all 0.25s;
    }

    .pdp-thumb.active,
    .pdp-thumb:hover {
        border-color: var(--primary);
        opacity: 1;
    }

    .pdp-main-img-wrap {
        flex: 1;
        position: relative;
        overflow: hidden;
        background: #f9f7f5;
        aspect-ratio: 3/4;
    }

    .pdp-main-img-wrap img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }

    .pdp-main-img-wrap:hover img {
        transform: scale(1.04);
    }

    .pdp-badge {
        position: absolute;
        top: 1.5rem;
        left: 1.5rem;
        background: var(--primary);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 0.4rem 0.9rem;
    }

    .pdp-wishlist-btn {
        position: absolute;
        top: 1.5rem;
        right: 1.5rem;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        border: none;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 1.1rem;
        color: #888;
        transition: all 0.25s;
        z-index: 2;
    }

    .pdp-wishlist-btn:hover,
    .pdp-wishlist-btn.active {
        color: #e74c3c;
        transform: scale(1.1);
    }

    /* === DETAILS PANEL === */
    .pdp-details {
        padding-left: 3.5rem;
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    .pdp-brand {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.6rem;
    }

    .pdp-title {
        font-size: 2rem;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
        margin-bottom: 1rem;
    }

    .pdp-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.2rem;
    }

    .pdp-rating .stars {
        color: var(--accent);
        font-size: 0.85rem;
    }

    .pdp-rating .count {
        font-size: 0.85rem;
        color: #888;
        text-decoration: underline;
        cursor: pointer;
    }

    .pdp-price-row {
        display: flex;
        align-items: baseline;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border);
    }

    .pdp-price {
        font-size: 1.9rem;
        font-weight: 800;
        color: var(--primary);
    }

    .pdp-price-original {
        font-size: 1.2rem;
        color: #bbb;
        text-decoration: line-through;
    }

    .pdp-discount-badge {
        background: #fef3cd;
        color: #9a6500;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.3rem 0.6rem;
        border-radius: 3px;
    }

    .pdp-short-desc {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    /* Variation Sections */
    .pdp-variation {
        margin-bottom: 1.8rem;
    }

    .pdp-var-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .pdp-var-label h4 {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 700;
        color: #111;
    }

    .pdp-var-label .pdp-selected-val {
        font-size: 0.85rem;
        color: #666;
        font-weight: 500;
    }

    /* Color Swatches */
    .pdp-colors {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pdp-color-swatch {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        cursor: pointer;
        position: relative;
        transition: transform 0.2s;
    }

    .pdp-color-swatch:hover {
        transform: scale(1.12);
    }

    .pdp-color-swatch::after {
        content: '';
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid transparent;
        transition: border-color 0.2s;
    }

    .pdp-color-swatch.active::after {
        border-color: var(--primary);
    }

    /* Size Buttons */
    .pdp-sizes {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pdp-size-btn {
        min-width: 52px;
        height: 48px;
        padding: 0 1rem;
        border: 1.5px solid #ddd;
        background: #fff;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .pdp-size-btn:hover {
        border-color: var(--primary);
    }

    .pdp-size-btn.active {
        border-color: var(--primary);
        background: var(--primary);
        color: #fff;
    }

    .pdp-size-btn.out-of-stock {
        color: #ccc;
        border-color: #eee;
        cursor: not-allowed;
        text-decoration: line-through;
        pointer-events: none;
    }

    /* Qty + CTA Row */
    .pdp-cta-row {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .pdp-qty {
        display: flex;
        align-items: center;
        border: 1.5px solid #ddd;
        height: 54px;
        flex-shrink: 0;
    }

    .pdp-qty button {
        width: 44px;
        height: 100%;
        background: none;
        border: none;
        font-size: 1rem;
        cursor: pointer;
        color: #555;
        transition: background 0.2s;
    }

    .pdp-qty button:hover {
        background: #f5f5f5;
    }

    .pdp-qty input {
        width: 44px;
        text-align: center;
        border: none;
        border-left: 1.5px solid #ddd;
        border-right: 1.5px solid #ddd;
        font-size: 1rem;
        font-weight: 700;
        font-family: inherit;
        background: transparent;
        height: 100%;
    }

    .pdp-add-btn {
        flex: 1;
        height: 54px;
        background: var(--primary);
        color: #fff;
        border: 2px solid var(--primary);
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: all 0.25s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
    }

    .pdp-add-btn:hover {
        background: var(--accent);
        border-color: var(--accent);
    }

    .pdp-add-btn.added {
        background: #2ecc71;
        border-color: #2ecc71;
    }

    /* Trust Badges */
    .pdp-trust {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        padding: 1.5rem;
        background: #f9f9f9;
        border: 1px solid var(--border);
        border-radius: 4px;
        margin-bottom: 2rem;
    }

    .pdp-trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.88rem;
        color: #444;
    }

    .pdp-trust-item i {
        font-size: 1rem;
        color: var(--accent);
        width: 20px;
        text-align: center;
    }

    /* Share row */
    .pdp-share {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.82rem;
        color: #aaa;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .pdp-share-icons {
        display: flex;
        gap: 0.6rem;
    }

    .pdp-share-icons a {
        width: 34px;
        height: 34px;
        border: 1px solid #ddd;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: #555;
        transition: all 0.2s;
    }

    .pdp-share-icons a:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    /* =====================================================
   TABS SECTION
   ===================================================== */
    .pdp-tabs-section {
        max-width: 1400px;
        margin: 0 auto;
        padding: 3rem 5% 4rem;
        border-top: 1px solid var(--border);
    }

    .pdp-tab-nav {
        display: flex;
        gap: 0;
        border-bottom: 2px solid var(--border);
        margin-bottom: 2.5rem;
    }

    .pdp-tab-btn {
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        padding: 1rem 2rem;
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #aaa;
        cursor: pointer;
        transition: all 0.25s;
    }

    .pdp-tab-btn:hover {
        color: var(--primary);
    }

    .pdp-tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .pdp-tab-pane {
        display: none;
        animation: fadeIn 0.3s ease;
    }

    .pdp-tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Description tab */
    .pdp-desc-text {
        font-size: 1rem;
        color: #555;
        line-height: 1.9;
        max-width: 800px;
        margin-bottom: 2rem;
    }

    .pdp-features {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .pdp-feature-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        color: #444;
        background: #f9f9f9;
        padding: 1rem;
        border-left: 3px solid var(--accent);
    }

    .pdp-feature-item i {
        color: var(--accent);
    }

    /* Size guide tab */
    .pdp-size-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    .pdp-size-table th {
        text-align: left;
        padding: 1rem;
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 1px;
        background: var(--primary);
        color: #fff;
    }

    .pdp-size-table td {
        padding: 0.9rem 1rem;
        border-bottom: 1px solid var(--border);
        color: #555;
    }

    .pdp-size-table tr:hover td {
        background: #fafafa;
    }

    /* Reviews tab */
    .pdp-review-summary {
        display: flex;
        gap: 3rem;
        align-items: center;
        padding-bottom: 2rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }

    .pdp-overall-score {
        text-align: center;
    }

    .pdp-overall-score .score-num {
        font-size: 4.5rem;
        font-weight: 800;
        line-height: 1;
        color: var(--primary);
    }

    .pdp-overall-score .score-stars {
        color: var(--accent);
        font-size: 1.2rem;
        margin: 0.4rem 0;
    }

    .pdp-overall-score .score-count {
        font-size: 0.85rem;
        color: #888;
    }

    .pdp-rating-bars {
        flex: 1;
    }

    .pdp-rating-bar {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        color: #666;
    }

    .pdp-rating-bar .bar-track {
        flex: 1;
        height: 6px;
        background: #eee;
        border-radius: 99px;
        overflow: hidden;
    }

    .pdp-rating-bar .bar-fill {
        height: 100%;
        background: var(--accent);
        border-radius: 99px;
    }

    .pdp-review-card {
        padding: 1.5rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .pdp-review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.6rem;
    }

    .pdp-reviewer-name {
        font-weight: 700;
        font-size: 0.95rem;
    }

    .pdp-reviewer-verified {
        font-size: 0.78rem;
        color: #2ecc71;
        margin-top: 2px;
    }

    .pdp-review-stars {
        color: var(--accent);
        font-size: 0.85rem;
    }

    .pdp-review-title {
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .pdp-review-body {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.7;
    }

    /* Related Products */
    .pdp-related {
        padding: 4rem 5%;
        border-top: 1px solid var(--border);
        background: #fafafa;
    }

    .pdp-related h2 {
        font-size: 1.5rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        margin-bottom: 2.5rem;
    }

    /* Mobile sticky bar */
    .pdp-sticky-cta {
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        z-index: 500;
        background: #fff;
        border-top: 1px solid var(--border);
        padding: 1rem 5%;
        box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
        align-items: center;
        gap: 1rem;
    }

    .pdp-sticky-cta .sticky-price {
        font-size: 1.2rem;
        font-weight: 800;
        flex: 1;
    }

    .pdp-sticky-cta .sticky-add-btn {
        height: 48px;
        padding: 0 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.25s;
    }

    .pdp-sticky-cta .sticky-add-btn:hover {
        background: var(--accent);
    }

    /* =====================================================
   RESPONSIVE
   ===================================================== */
    @media (max-width: 992px) {
        .pdp-wrapper {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 4%;
        }

        .pdp-gallery {
            position: static;
            flex-direction: column;
            gap: 0.75rem;
        }

        .pdp-thumbnails {
            flex-direction: row;
            width: 100%;
            overflow-x: auto;
        }

        .pdp-thumb {
            width: 70px;
            height: 90px;
            flex-shrink: 0;
        }

        .pdp-main-img-wrap {
            aspect-ratio: 3/2.5;
        }

        .pdp-details {
            padding-left: 0;
        }

        .pdp-title {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 768px) {
        .pdp-sticky-cta {
            display: flex;
        }

        .pdp-cta-row {
            display: none;
        }

        .pdp-tab-btn {
            padding: 0.75rem 1rem;
            font-size: 0.78rem;
        }

        .pdp-review-summary {
            flex-direction: column;
            gap: 1.5rem;
            align-items: flex-start;
        }

        .pdp-features {
            grid-template-columns: 1fr 1fr;
        }

        .pdp-size-table {
            font-size: 0.8rem;
        }

        .pdp-size-table th,
        .pdp-size-table td {
            padding: 0.7rem;
        }
    }
</style>

<!-- Breadcrumb -->
<nav class="pdp-breadcrumb">
    <a href="<?= base_url() ?>">Home</a> &nbsp;/&nbsp;
    <a href="#">Menswear</a> &nbsp;/&nbsp;
    <span>Classic Heritage Trench</span>
</nav>

<!-- Main Product Layout -->
<div class="pdp-wrapper">

    <!-- LEFT: Gallery -->
    <div class="pdp-gallery">
        <!-- Thumbnails -->
        <div class="pdp-thumbnails">
            <img class="pdp-thumb active"
                src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=400&auto=format&fit=crop"
                alt="View 1"
                data-full="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop">
            <img class="pdp-thumb"
                src="https://images.unsplash.com/photo-1591048508537-0f66d446122f?q=80&w=400&auto=format&fit=crop"
                alt="View 2"
                data-full="https://images.unsplash.com/photo-1591048508537-0f66d446122f?q=80&w=1936&auto=format&fit=crop">
            <img class="pdp-thumb"
                src="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=400&auto=format&fit=crop"
                alt="View 3"
                data-full="https://images.unsplash.com/photo-1539109136881-3be0616acf4b?q=80&w=1936&auto=format&fit=crop">
            <img class="pdp-thumb"
                src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=400&auto=format&fit=crop"
                alt="View 4"
                data-full="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=1936&auto=format&fit=crop">
        </div>

        <!-- Main Image -->
        <div class="pdp-main-img-wrap">
            <span class="pdp-badge">New Arrival</span>
            <button class="pdp-wishlist-btn" id="pdp-wishlist-btn" title="Save to Wishlist">
                <i class="far fa-heart"></i>
            </button>
            <img id="pdp-main-img"
                src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=1936&auto=format&fit=crop"
                alt="Classic Heritage Trench">
        </div>
    </div>

    <!-- RIGHT: Product Details -->
    <div class="pdp-details product-detail-container" id="pdp-detail-panel">
        <p class="pdp-brand">ModernCloset &nbsp;•&nbsp; Outerwear</p>
        <h1 class="pdp-title">Classic Heritage Trench</h1>

        <!-- Rating -->
        <div class="pdp-rating">
            <div class="stars">
                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
            </div>
            <span class="count"
                onclick="document.getElementById('pdp-tab-reviews-btn').click(); document.getElementById('pdp-tabs-section').scrollIntoView({behavior:'smooth'})">4.8
                (12 Reviews)</span>
        </div>

        <!-- Price -->
        <div class="pdp-price-row">
            <div class="pdp-price" id="pdp-price">৳850.00</div>
            <div class="pdp-price-original">৳1,100.00</div>
            <div class="pdp-discount-badge">23% OFF</div>
        </div>

        <!-- Short Description -->
        <p class="pdp-short-desc">
            Meticulously crafted from high-density gabardine with heritage-inspired gun flaps, storm shields, and a
            signature waist belt. A timeless silhouette reimagined for the modern wardrobe.
        </p>

        <!-- Color Selector -->
        <div class="pdp-variation">
            <div class="pdp-var-label">
                <h4>Colour</h4>
                <span class="pdp-selected-val" id="pdp-selected-color">Original</span>
            </div>
            <div class="pdp-colors">
                <div class="pdp-color-swatch active" data-color="Original" style="background:#d1c8c1;" title="Original">
                </div>
                <div class="pdp-color-swatch" data-color="Black" style="background:#111;" title="Black"></div>
                <div class="pdp-color-swatch" data-color="Navy" style="background:#0a192f;" title="Navy"></div>
                <div class="pdp-color-swatch" data-color="Camel" style="background:#c19a6b;" title="Camel"></div>
            </div>
        </div>

        <!-- Size Selector -->
        <div class="pdp-variation">
            <div class="pdp-var-label">
                <h4>Size</h4>
                <span class="pdp-selected-val" id="pdp-selected-size">M</span>
            </div>
            <div class="pdp-sizes">
                <button class="pdp-size-btn" data-size="XS">XS</button>
                <button class="pdp-size-btn" data-size="S">S</button>
                <button class="pdp-size-btn active" data-size="M">M</button>
                <button class="pdp-size-btn" data-size="L">L</button>
                <button class="pdp-size-btn" data-size="XL">XL</button>
                <button class="pdp-size-btn out-of-stock" data-size="XXL" disabled>XXL</button>
            </div>
        </div>

        <!-- Qty + Add to Bag -->
        <div class="pdp-cta-row">
            <div class="pdp-qty">
                <button id="pdp-qty-minus"><i class="fas fa-minus"></i></button>
                <input type="text" id="pdp-qty-input" value="1" readonly>
                <button id="pdp-qty-plus"><i class="fas fa-plus"></i></button>
            </div>
            <button class="pdp-add-btn" id="pdp-add-btn">
                <i class="fas fa-shopping-bag"></i>
                Add to Bag
            </button>
        </div>

        <!-- Trust Badges -->
        <div class="pdp-trust">
            <div class="pdp-trust-item">
                <i class="fas fa-shipping-fast"></i>
                <span>Free worldwide shipping on orders over ৳500</span>
            </div>
            <div class="pdp-trust-item">
                <i class="fas fa-undo-alt"></i>
                <span>Free 30-day returns &amp; exchanges</span>
            </div>
            <div class="pdp-trust-item">
                <i class="fas fa-lock"></i>
                <span>Secure checkout with SSL encryption</span>
            </div>
            <div class="pdp-trust-item">
                <i class="fas fa-certificate"></i>
                <span>100% authentic — guaranteed</span>
            </div>
        </div>

        <!-- Share -->
        <div class="pdp-share">
            <span>Share:</span>
            <div class="pdp-share-icons">
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                <a href="#" title="Copy Link" id="pdp-copy-link"><i class="fas fa-link"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- ===================================================
     TABS SECTION  
     =================================================== -->
<section class="pdp-tabs-section" id="pdp-tabs-section">
    <div class="pdp-tab-nav">
        <button class="pdp-tab-btn active" data-tab="pdp-desc">Description</button>
        <button class="pdp-tab-btn" id="pdp-tab-size-btn" data-tab="pdp-sizeguide">Size Guide</button>
        <button class="pdp-tab-btn" id="pdp-tab-reviews-btn" data-tab="pdp-reviews">Reviews (12)</button>
    </div>

    <!-- Description -->
    <div class="pdp-tab-pane active" id="pdp-desc">
        <p class="pdp-desc-text">
            The Heritage Trench is our most iconic silhouette, reimagined for the modern connoisseur. Every detail,
            from the D-ring belt to the storm shield, is a nod to its utilitarian roots while maintaining a contemporary
            luxe feel. The fabric is water-repellent, ensuring style without compromise regardless of the weather.
        </p>
        <div class="pdp-features">
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> 100% Cotton Gabardine</div>
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> Double-breasted closure</div>
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> Signature check lining</div>
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> Buffalo horn buttons</div>
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> Water-repellent finish</div>
            <div class="pdp-feature-item"><i class="fas fa-circle-check"></i> Dry clean only</div>
        </div>
    </div>

    <!-- Size Guide -->
    <div class="pdp-tab-pane" id="pdp-sizeguide">
        <p style="color:#666; margin-bottom:1.5rem; font-size:0.9rem;">All measurements are in inches. If you are
            between sizes, we recommend sizing up for a more relaxed fit.</p>
        <table class="pdp-size-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Chest</th>
                    <th>Waist</th>
                    <th>Hips</th>
                    <th>Arm Length</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>XS</b></td>
                    <td>33–35</td>
                    <td>26–28</td>
                    <td>34–36</td>
                    <td>31.5</td>
                </tr>
                <tr>
                    <td><b>S</b></td>
                    <td>36–38</td>
                    <td>29–31</td>
                    <td>37–39</td>
                    <td>32.5</td>
                </tr>
                <tr>
                    <td><b>M</b></td>
                    <td>39–41</td>
                    <td>32–34</td>
                    <td>40–42</td>
                    <td>33.5</td>
                </tr>
                <tr>
                    <td><b>L</b></td>
                    <td>42–44</td>
                    <td>35–37</td>
                    <td>43–45</td>
                    <td>34.5</td>
                </tr>
                <tr>
                    <td><b>XL</b></td>
                    <td>45–47</td>
                    <td>38–40</td>
                    <td>46–48</td>
                    <td>35.5</td>
                </tr>
            </tbody>
        </table>
        <p style="color:#aaa; font-size:0.82rem; margin-top:1.5rem;"><i class="fas fa-info-circle"></i> Still unsure?
            Email our stylists at <a href="mailto:style@moderncloset.com"
                style="color:var(--primary);text-decoration:underline;">style@moderncloset.com</a></p>
    </div>

    <!-- Reviews -->
    <div class="pdp-tab-pane" id="pdp-reviews">
        <div class="pdp-review-summary">
            <div class="pdp-overall-score">
                <div class="score-num">4.8</div>
                <div class="score-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star"></i><i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <div class="score-count">Based on 12 reviews</div>
            </div>
            <div class="pdp-rating-bars">
                <div class="pdp-rating-bar">
                    <span>5★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:75%"></div>
                    </div>
                    <span>9</span>
                </div>
                <div class="pdp-rating-bar">
                    <span>4★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:17%"></div>
                    </div>
                    <span>2</span>
                </div>
                <div class="pdp-rating-bar">
                    <span>3★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:8%"></div>
                    </div>
                    <span>1</span>
                </div>
                <div class="pdp-rating-bar">
                    <span>2★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:0%"></div>
                    </div>
                    <span>0</span>
                </div>
                <div class="pdp-rating-bar">
                    <span>1★</span>
                    <div class="bar-track">
                        <div class="bar-fill" style="width:0%"></div>
                    </div>
                    <span>0</span>
                </div>
            </div>
        </div>

        <div class="pdp-review-card">
            <div class="pdp-review-header">
                <div>
                    <div class="pdp-reviewer-name">James W.</div>
                    <div class="pdp-reviewer-verified"><i class="fas fa-check-circle"></i> Verified Buyer</div>
                </div>
                <div class="pdp-review-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
            </div>
            <div class="pdp-review-title">A genuine masterpiece.</div>
            <div class="pdp-review-body">The material is exceptional and the fit is perfect. Easily the best trench coat
                I've ever owned. Worth every single penny — I get compliments every time I wear it.</div>
        </div>

        <div class="pdp-review-card">
            <div class="pdp-review-header">
                <div>
                    <div class="pdp-reviewer-name">Oliver T.</div>
                    <div class="pdp-reviewer-verified"><i class="fas fa-check-circle"></i> Verified Buyer</div>
                </div>
                <div class="pdp-review-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                        class="fas fa-star"></i><i class="far fa-star"></i>
                </div>
            </div>
            <div class="pdp-review-title">Great quality — runs slightly large.</div>
            <div class="pdp-review-body">Beautiful coat with incredible stitching. I normally wear a Large but had to
                exchange for a Medium. Besides that, it is amazing. Highly recommend sizing down.</div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="pdp-related">
    <h2>You May Also Like</h2>
    <div class="product-grid" style="padding: 0;">
        <div class="product-card">
            <div class="product-image">
                <img src="https://images.unsplash.com/photo-1543076447-215ad9ba6923?q=80&w=600&auto=format&fit=crop"
                    alt="Minimalist Watch">
                <div class="product-actions">
                    <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                    <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                </div>
            </div>
            <div class="product-info">
                <h3>Minimalist Signature Watch</h3>
                <div class="product-price">৳320.00</div>
            </div>
        </div>
        <div class="product-card">
            <div class="product-image">
                <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop"
                    alt="Chelsea Boots">
                <div class="product-actions">
                    <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                    <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                </div>
            </div>
            <div class="product-info">
                <h3>Artisan Leather Chelsea Boots</h3>
                <div class="product-price">৳450.00</div>
            </div>
        </div>
        <div class="product-card">
            <div class="product-image">
                <img src="https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?q=80&w=600&auto=format&fit=crop"
                    alt="Wool Blazer">
                <div class="product-actions">
                    <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                    <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                </div>
            </div>
            <div class="product-info">
                <h3>Slim Fit Wool Blazer</h3>
                <div class="product-price">৳620.00</div>
            </div>
        </div>
    </div>
</section>

<!-- Mobile Sticky CTA bar -->
<div class="pdp-sticky-cta">
    <div class="sticky-price">৳850.00</div>
    <button class="sticky-add-btn" id="pdp-sticky-add-btn">
        <i class="fas fa-shopping-bag"></i> Add to Bag
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── State ─────────────────────────────── */
        let selectedColor = 'Original';
        let selectedSize = 'M';
        let qty = 1;

        /* ── Gallery ───────────────────────────── */
        const mainImg = document.getElementById('pdp-main-img');
        const thumbs = document.querySelectorAll('.pdp-thumb');

        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function () {
                mainImg.src = this.getAttribute('data-full');
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        /* ── Color Swatches ─────────────────────── */
        const colorSwatches = document.querySelectorAll('.pdp-color-swatch');
        const selectedColorEl = document.getElementById('pdp-selected-color');

        colorSwatches.forEach(sw => {
            sw.addEventListener('click', function () {
                colorSwatches.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                selectedColor = this.getAttribute('data-color');
                selectedColorEl.textContent = selectedColor;
            });
        });

        /* ── Size Buttons ───────────────────────── */
        const sizeBtns = document.querySelectorAll('.pdp-size-btn:not(.out-of-stock)');
        const selectedSizeEl = document.getElementById('pdp-selected-size');

        sizeBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                sizeBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                selectedSize = this.getAttribute('data-size');
                selectedSizeEl.textContent = selectedSize;
            });
        });

        /* ── Qty Controls ───────────────────────── */
        const qtyInput = document.getElementById('pdp-qty-input');
        const qtyMinus = document.getElementById('pdp-qty-minus');
        const qtyPlus = document.getElementById('pdp-qty-plus');

        qtyMinus.addEventListener('click', () => {
            if (qty > 1) { qty--; qtyInput.value = qty; }
        });

        qtyPlus.addEventListener('click', () => {
            if (qty < 10) { qty++; qtyInput.value = qty; }
        });

        /* ── Add to Bag ─────────────────────────── */
        function addToBag() {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

            const productId = 'classic-heritage-trench';
            const product = {
                id: productId + '-' + selectedSize + '-' + selectedColor.toLowerCase(),
                name: 'Classic Heritage Trench',
                price: 850,
                image: mainImg.src,
                size: selectedSize,
                color: selectedColor
            };

            const existing = cart.find(i => i.id === product.id);
            if (existing) {
                existing.qty += qty;
            } else {
                product.qty = qty;
                cart.push(product);
            }

            localStorage.setItem('cart', JSON.stringify(cart));

            // Animate button
            const addBtn = document.getElementById('pdp-add-btn');
            addBtn.classList.add('added');
            addBtn.innerHTML = '<i class="fas fa-check"></i> Added!';
            setTimeout(() => {
                addBtn.classList.remove('added');
                addBtn.innerHTML = '<i class="fas fa-shopping-bag"></i> Add to Bag';
            }, 2000);

            // Open drawer
            if (typeof openCartDrawer === 'function') openCartDrawer();
        }

        document.getElementById('pdp-add-btn')?.addEventListener('click', addToBag);
        document.getElementById('pdp-sticky-add-btn')?.addEventListener('click', addToBag);

        /* ── Wishlist Button ─────────────────────── */
        const wishlistBtn = document.getElementById('pdp-wishlist-btn');
        wishlistBtn.addEventListener('click', function () {
            let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
            const productId = 'classic-heritage-trench';
            const already = wishlist.find(i => i.id === productId);

            if (!already) {
                wishlist.push({
                    id: productId,
                    name: 'Classic Heritage Trench',
                    price: 850,
                    image: mainImg.src
                });
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                this.querySelector('i').classList.replace('far', 'fas');
                this.classList.add('active');
                showToast('Saved to wishlist');
            } else {
                wishlist = wishlist.filter(i => i.id !== productId);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                this.querySelector('i').classList.replace('fas', 'far');
                this.classList.remove('active');
                showToast('Removed from wishlist');
            }

            if (typeof updateBadges === 'function') {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                updateBadges(cart.length, wishlist.length);
            }
        });

        /* ── Tabs ───────────────────────────────── */
        const tabBtns = document.querySelectorAll('.pdp-tab-btn');
        const tabPanes = document.querySelectorAll('.pdp-tab-pane');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                tabBtns.forEach(b => b.classList.remove('active'));
                tabPanes.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.getAttribute('data-tab')).classList.add('active');
            });
        });

        /* ── Copy Link ──────────────────────────── */
        document.getElementById('pdp-copy-link')?.addEventListener('click', function (e) {
            e.preventDefault();
            navigator.clipboard.writeText(window.location.href).then(() => {
                if (typeof showToast === 'function') showToast('Link copied to clipboard!');
            });
        });

        /* ── Scroll: show/hide sticky bar ───────── */
        const addBtnDesktop = document.querySelector('.pdp-cta-row');
        const stickyCta = document.querySelector('.pdp-sticky-cta');

        if (addBtnDesktop && stickyCta) {
            const observer = new IntersectionObserver(entries => {
                // The sticky bar shows only if the desktop CTA is out of view (mobile)
                stickyCta.style.display = window.innerWidth <= 768 ? 'flex' : 'none';
            }, { threshold: 0 });
            observer.observe(addBtnDesktop);
        }
    });
</script>

<?php include_once 'includes/footer.php'; ?>