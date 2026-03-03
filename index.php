<?php
/**
 * Fashion E-commerce Home Page
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* ── Hero Section ───────────────────────────────── */
    .hp-hero {
        position: relative;
        height: 65vh;
        min-height: 420px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #111;
    }

    .hp-hero-slides {
        position: absolute;
        inset: 0;
    }

    .hp-hero-slide {
        position: absolute;
        inset: 0;
        opacity: 0;
        transition: opacity 1s ease;
        background-size: cover;
        background-position: center;
    }

    .hp-hero-slide.active {
        opacity: 1;
    }

    .hp-hero-slide::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(0, 0, 0, 0.75) 40%, rgba(0, 0, 0, 0.15) 100%);
    }

    .hp-hero-content {
        position: relative;
        z-index: 2;
        padding: 0 8%;
        max-width: 700px;
        animation: slideUp 0.9s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hp-hero-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .hp-hero-eyebrow::before {
        content: '';
        width: 35px;
        height: 1px;
        background: var(--accent);
    }

    .hp-hero-content h1 {
        font-size: 3.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fff;
        line-height: 1.05;
        margin-bottom: 1rem;
    }

    .hp-hero-content p {
        font-size: 1.05rem;
        color: rgba(255, 255, 255, 0.65);
        line-height: 1.8;
        margin-bottom: 2.2rem;
        max-width: 500px;
    }

    .hp-hero-btns {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .hp-btn-primary {
        padding: 1rem 2.5rem;
        background: var(--accent);
        color: var(--primary);
        border: 2px solid var(--accent);
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.3s;
    }

    .hp-btn-primary:hover {
        background: #fff;
        border-color: #fff;
    }

    .hp-btn-outline {
        padding: 1rem 2.5rem;
        background: transparent;
        color: #fff;
        border: 2px solid rgba(255, 255, 255, 0.4);
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        transition: all 0.3s;
    }

    .hp-btn-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #fff;
    }

    /* Dots */
    .hp-hero-dots {
        position: absolute;
        bottom: 2.5rem;
        left: 8%;
        display: flex;
        gap: 0.6rem;
        z-index: 3;
    }

    .hp-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        padding: 0;
    }

    .hp-dot.active {
        background: var(--accent);
        width: 24px;
        border-radius: 4px;
    }

    /* ── Trust Strip ─────────────────────────────────── */
    .hp-trust-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-bottom: 1px solid var(--border);
    }

    .hp-trust-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.8rem 2rem;
        border-right: 1px solid var(--border);
        transition: background 0.2s;
    }

    .hp-trust-item:last-child {
        border-right: none;
    }

    .hp-trust-item:hover {
        background: #fafafa;
    }

    .hp-trust-item i {
        font-size: 1.4rem;
        color: var(--accent);
        flex-shrink: 0;
    }

    .hp-trust-item h4 {
        font-size: 0.88rem;
        font-weight: 700;
        margin-bottom: 0.15rem;
    }

    .hp-trust-item p {
        font-size: 0.75rem;
        color: #999;
    }

    /* ── Shared Section Styles ───────────────────────── */
    .hp-section {
        padding: 5rem 5%;
    }

    .hp-section-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
    }

    .hp-section-head .left .eyebrow {
        font-size: 0.68rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .hp-section-head h2 {
        font-size: 1.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.1;
    }

    .hp-view-all {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--primary);
        border-bottom: 1px solid var(--primary);
        padding-bottom: 2px;
        transition: color 0.2s, border-color 0.2s;
    }

    .hp-view-all:hover {
        color: var(--accent);
        border-color: var(--accent);
    }

    /* ── FLASH SALE ──────────────────────────────────── */
    .hp-flash {
        background: var(--primary);
        padding: 4rem 5%;
    }

    .hp-flash .hp-section-head .left .eyebrow {
        color: var(--accent);
    }

    .hp-flash .hp-section-head h2 {
        color: #fff;
    }

    .hp-flash .hp-view-all {
        color: var(--accent);
        border-color: var(--accent);
    }

    /* countdown */
    .hp-countdown {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .hp-cd-unit {
        text-align: center;
    }

    .hp-cd-num {
        display: block;
        background: var(--accent);
        color: var(--primary);
        font-size: 1.4rem;
        font-weight: 900;
        min-width: 46px;
        padding: 0.3rem 0.5rem;
        line-height: 1;
        font-variant-numeric: tabular-nums;
        text-align: center;
    }

    .hp-cd-label {
        font-size: 0.55rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: rgba(255, 255, 255, 0.4);
        display: block;
        margin-top: 0.25rem;
        text-align: center;
    }

    .hp-cd-sep {
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.3);
        margin: 0 0.1rem;
        padding-bottom: 0.6rem;
    }

    /* Flash sale scroll strip */
    .hp-flash-scroll {
        display: flex;
        gap: 1.2rem;
        overflow-x: auto;
        scrollbar-width: none;
        padding-bottom: 0.5rem;
        -webkit-overflow-scrolling: touch;
    }

    .hp-flash-scroll::-webkit-scrollbar {
        display: none;
    }

    .hp-flash-card {
        flex-shrink: 0;
        width: 220px;
        background: #fff;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .hp-flash-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
    }

    .hp-flash-card img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s;
    }

    .hp-flash-card:hover img {
        transform: scale(1.05);
    }

    .hp-flash-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: #e74c3c;
        color: #fff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 0.3rem 0.7rem;
        letter-spacing: 1px;
    }

    .hp-flash-card-body {
        padding: 1rem;
    }

    .hp-flash-card-name {
        font-size: 0.85rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .hp-flash-prices {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 0.8rem;
    }

    .hp-flash-price {
        font-size: 1rem;
        font-weight: 900;
        color: #e74c3c;
    }

    .hp-flash-original {
        font-size: 0.8rem;
        color: #bbb;
        text-decoration: line-through;
    }

    .hp-flash-progress-label {
        font-size: 0.7rem;
        color: #999;
        margin-bottom: 0.3rem;
    }

    .hp-flash-bar {
        height: 4px;
        background: #eee;
        border-radius: 99px;
        overflow: hidden;
    }

    .hp-flash-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #e74c3c, #f39c12);
        border-radius: 99px;
    }

    /* ── CATEGORY CHIPS ──────────────────────────────── */
    .hp-cat-chips {
        padding: 1.5rem 5%;
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        scrollbar-width: none;
        border-bottom: 1px solid var(--border);
    }

    .hp-cat-chips::-webkit-scrollbar {
        display: none;
    }

    .hp-chip {
        flex-shrink: 0;
        padding: 0.55rem 1.4rem;
        border: 1.5px solid #ddd;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
        font-family: inherit;
        white-space: nowrap;
        border-radius: 99px;
    }

    .hp-chip:hover,
    .hp-chip.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* ── PRODUCT GRID (shared) ───────────────────────── */
    .hp-prod-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
    }

    /* ── RECOMMENDED / EDITORIAL BANNER ─────────────── */
    .hp-editorial {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        padding: 0 5% 5rem;
    }

    .hp-editorial-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        aspect-ratio: 16/9;
    }

    .hp-editorial-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }

    .hp-editorial-card:hover img {
        transform: scale(1.05);
    }

    .hp-editorial-card .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, transparent 60%);
    }

    .hp-editorial-card .body {
        position: absolute;
        bottom: 0;
        padding: 2rem;
        color: #fff;
    }

    .hp-editorial-card .body .tag {
        font-size: 0.65rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .hp-editorial-card .body h3 {
        font-size: 1.4rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 0.8rem;
    }

    .hp-editorial-card .body a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.4);
        padding-bottom: 2px;
        transition: border-color 0.2s;
    }

    .hp-editorial-card .body a:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    /* ── NEWSLETTER ──────────────────────────────────── */
    .hp-newsletter {
        background: #f5f3ef;
        padding: 5rem 5%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
    }

    .hp-newsletter .left .eyebrow {
        font-size: 0.7rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.8rem;
    }

    .hp-newsletter .left h2 {
        font-size: 2rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 0.8rem;
    }

    .hp-newsletter .left p {
        font-size: 0.9rem;
        color: #777;
        line-height: 1.8;
    }

    .hp-nl-form {
        display: flex;
        gap: 0;
    }

    .hp-nl-form input {
        flex: 1;
        padding: 1rem 1.2rem;
        border: 1.5px solid #ddd;
        border-right: none;
        font-family: inherit;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .hp-nl-form input:focus {
        border-color: var(--primary);
    }

    .hp-nl-form button {
        padding: 1rem 2rem;
        background: var(--primary);
        color: #fff;
        border: 1.5px solid var(--primary);
        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        transition: background 0.2s;
        white-space: nowrap;
    }

    .hp-nl-form button:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }

    /* ── Responsive ────────────────────────────────── */
    @media (max-width: 1100px) {
        .hp-prod-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .hp-hero-content h1 {
            font-size: 2.6rem;
        }

        .hp-trust-strip {
            grid-template-columns: 1fr 1fr;
        }

        .hp-trust-item:nth-child(2) {
            border-right: none;
        }

        .hp-trust-item:nth-child(3) {
            border-top: 1px solid var(--border);
        }

        .hp-prod-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .hp-editorial {
            grid-template-columns: 1fr;
        }

        .hp-newsletter {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .hp-section {
            padding: 3rem 4%;
        }

        .hp-section-head {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.8rem;
        }
    }

    @media (max-width: 480px) {
        .hp-hero-content {
            padding: 0 5%;
        }

        .hp-hero-content h1 {
            font-size: 2rem;
        }

        .hp-prod-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.6rem;
        }
    }
</style>

<!-- ════════════════════════════════════════════
     HERO SLIDER
════════════════════════════════════════════ -->
<section class="hp-hero">
    <div class="hp-hero-slides">
        <div class="hp-hero-slide active"
            style="background-image: url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop');">
        </div>
        <div class="hp-hero-slide"
            style="background-image: url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1920&auto=format&fit=crop');">
        </div>
        <div class="hp-hero-slide"
            style="background-image: url('https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1920&auto=format&fit=crop');">
        </div>
    </div>

    <div class="hp-hero-content">
        <p class="hp-hero-eyebrow">SS 2026 Collection</p>
        <h1>Dress the Way You Want to Live</h1>
        <p>Curated premium fashion from the world's most iconic designers — delivered to your door.</p>
        <div class="hp-hero-btns">
            <a href="categories.php" class="hp-btn-primary"><i class="fas fa-shopping-bag"></i> Shop Collection</a>
            <!-- <a href="about.php" class="hp-btn-outline">Our Story</a> -->
        </div>
    </div>

    <div class="hp-hero-dots">
        <button class="hp-dot active" data-slide="0"></button>
        <button class="hp-dot" data-slide="1"></button>
        <button class="hp-dot" data-slide="2"></button>
    </div>
</section>

<!-- Trust Strip -->
<div class="hp-trust-strip">
    <div class="hp-trust-item">
        <i class="fas fa-shipping-fast"></i>
        <div>
            <h4>Free Shipping</h4>
            <p>On orders over $500</p>
        </div>
    </div>
    <div class="hp-trust-item">
        <i class="fas fa-undo-alt"></i>
        <div>
            <h4>Free Returns</h4>
            <p>30-day return policy</p>
        </div>
    </div>
    <div class="hp-trust-item">
        <i class="fas fa-lock"></i>
        <div>
            <h4>Secure Checkout</h4>
            <p>SSL encrypted payment</p>
        </div>
    </div>
    <div class="hp-trust-item">
        <i class="fas fa-headset"></i>
        <div>
            <h4>24/7 Support</h4>
            <p>Expert styling team</p>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     FLASH SALE
════════════════════════════════════════════ -->
<section class="hp-flash">
    <div class="hp-section-head">
        <div class="left">
            <p class="eyebrow"><i class="fas fa-bolt"></i> Limited Time</p>
            <h2>Flash Sale</h2>
            <div class="hp-countdown" style="margin-top:0.8rem;">
                <div class="hp-cd-unit">
                    <span class="hp-cd-num" id="fs-h">08</span>
                    <span class="hp-cd-label">Hours</span>
                </div>
                <span class="hp-cd-sep">:</span>
                <div class="hp-cd-unit">
                    <span class="hp-cd-num" id="fs-m">00</span>
                    <span class="hp-cd-label">Mins</span>
                </div>
                <span class="hp-cd-sep">:</span>
                <div class="hp-cd-unit">
                    <span class="hp-cd-num" id="fs-s">00</span>
                    <span class="hp-cd-label">Secs</span>
                </div>
            </div>
        </div>
        <a href="shop.php" class="hp-view-all" style="color:var(--accent); border-color:var(--accent);">
            View All Products <i class="fas fa-arrow-right"></i>
        </a>
    </div>

    <div class="hp-flash-scroll">
        <?php
        $flashItems = [
            [
                'name' => 'Heritage Trench Coat',
                'price' => '৳680',
                'orig' => '৳850',
                'pct' => 20,
                'sold' => 72,
                'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Leather Chelsea Boots',
                'price' => '৳315',
                'orig' => '৳450',
                'pct' => 30,
                'sold' => 58,
                'img' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Minimalist Signature Watch',
                'price' => '৳240',
                'orig' => '৳320',
                'pct' => 25,
                'sold' => 85,
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Slim Fit Wool Blazer',
                'price' => '৳434',
                'orig' => '৳620',
                'pct' => 30,
                'sold' => 41,
                'img' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Sunshine Maxi Dress',
                'price' => '৳126',
                'orig' => '৳180',
                'pct' => 30,
                'sold' => 90,
                'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Urban Oversized Hoodie',
                'price' => '৳67',
                'orig' => '৳95',
                'pct' => 30,
                'sold' => 66,
                'img' => 'https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?q=80&w=600&auto=format&fit=crop'
            ],
        ];
        foreach ($flashItems as $fi): ?>
            <div class="hp-flash-card" onclick="location.href='product-detail.php'">
                <img src="<?= $fi['img'] ?>" alt="<?= $fi['name'] ?>">
                <span class="hp-flash-badge">-<?= $fi['pct'] ?>%</span>
                <div class="hp-flash-card-body">
                    <p class="hp-flash-card-name"><?= $fi['name'] ?></p>
                    <div class="hp-flash-prices">
                        <span class="hp-flash-price"><?= $fi['price'] ?></span>
                        <span class="hp-flash-original"><?= $fi['orig'] ?></span>
                    </div>
                    <p class="hp-flash-progress-label">Sold: <?= $fi['sold'] ?>%</p>
                    <div class="hp-flash-bar">
                        <div class="hp-flash-bar-fill" style="width:<?= $fi['sold'] ?>%"></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ════════════════════════════════════════════
     CATEGORY CHIPS
════════════════════════════════════════════ -->
<div class="hp-cat-chips">
    <button class="hp-chip active" data-filter="all">All</button>
    <button class="hp-chip" data-filter="menswear">Menswear</button>
    <button class="hp-chip" data-filter="womenswear">Womenswear</button>
    <button class="hp-chip" data-filter="accessories">Accessories</button>
    <button class="hp-chip" data-filter="footwear">Footwear</button>
    <button class="hp-chip" data-filter="outerwear">Outerwear</button>
</div>

<!-- ════════════════════════════════════════════
     RECOMMENDED FOR YOU
════════════════════════════════════════════ -->
<section class="hp-section">
    <div class="hp-section-head">
        <div class="left">
            <p class="eyebrow">Handpicked for You</p>
            <h2>Recommended</h2>
        </div>
        <a href="categories.php" class="hp-view-all">Browse All <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="hp-prod-grid">
        <?php
        $recommended = [
            [
                'name' => 'Classic Heritage Trench',
                'price' => '৳850',
                'orig' => '৳1,100',
                'badge' => 'New',
                'cat' => 'outerwear',
                'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop',
                'rating' => 4,
                'reviews' => 12
            ],
            [
                'name' => 'Sunshine Maxi Dress',
                'price' => '৳180',
                'orig' => '',
                'badge' => '',
                'cat' => 'womenswear',
                'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop',
                'rating' => 5,
                'reviews' => 28
            ],
            [
                'name' => 'Minimalist Watch',
                'price' => '৳320',
                'orig' => '',
                'badge' => 'Bestseller',
                'cat' => 'accessories',
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop',
                'rating' => 5,
                'reviews' => 45
            ],
            [
                'name' => 'Artisan Chelsea Boots',
                'price' => '৳450',
                'orig' => '',
                'badge' => 'Sale',
                'cat' => 'footwear',
                'img' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop',
                'rating' => 4,
                'reviews' => 19
            ],
        ];
        foreach ($recommended as $p): ?>
            <div class="product-card" data-category="<?= $p['cat'] ?>">
                <a href="product-detail.php">
                    <div class="product-image">
                        <?php if ($p['badge']): ?>
                            <span class="product-badge"><?= $p['badge'] ?></span>
                        <?php endif; ?>
                        <img src="<?= $p['img'] ?>" alt="<?= $p['name'] ?>">
                        <div class="product-actions">
                            <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                            <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                            <button class="action-btn" title="Quick View"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                </a>
                <div class="product-info">
                    <h3><?= $p['name'] ?></h3>
                    <div style="display:flex; align-items:center; gap:0.4rem; margin-bottom:0.4rem;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="<?= $i <= $p['rating'] ? 'fas' : 'far' ?> fa-star"
                                style="font-size:0.7rem; color:var(--accent);"></i>
                        <?php endfor; ?>
                        <span style="font-size:0.72rem; color:#aaa;">(<?= $p['reviews'] ?>)</span>
                    </div>
                    <div class="product-price">
                        <?= $p['price'] ?>
                        <?php if ($p['orig']): ?>
                            <span
                                style="font-size:0.8rem; color:#bbb; text-decoration:line-through; font-weight:400; margin-left:0.4rem;"><?= $p['orig'] ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- ════════════════════════════════════════════
     EDITORIAL BANNERS
════════════════════════════════════════════ -->
<div class="hp-editorial">
    <div class="hp-editorial-card">
        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=1200&auto=format&fit=crop"
            alt="Womenswear">
        <div class="overlay"></div>
        <div class="body">
            <p class="tag">New Season</p>
            <h3>Women's Edit</h3>
            <a href="women.php">Shop Now <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
    <div class="hp-editorial-card">
        <img src="https://images.unsplash.com/photo-1549037173-e3b717902c57?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="Menswear">
        <div class="overlay"></div>
        <div class="body">
            <p class="tag">Essentials</p>
            <h3>Men's Collection</h3>
            <a href="men.php">Shop Now <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</div>

<!-- ════════════════════════════════════════════
     ALL PRODUCTS
════════════════════════════════════════════ -->
<section class="hp-section" style="background:#fafafa; border-top:1px solid var(--border);">
    <div class="hp-section-head">
        <div class="left">
            <p class="eyebrow">Explore Everything</p>
            <h2>All Products</h2>
        </div>
        <div style="display:flex; gap:0.8rem; align-items:center;">
            <select id="hp-sort"
                style="padding:0.6rem 1rem; border:1.5px solid #ddd; font-family:inherit; font-size:0.82rem; outline:none; background:#fff;">
                <option value="default">Default</option>
                <option value="price-low">Price: Low to High</option>
                <option value="price-high">Price: High to Low</option>
                <option value="name">Name: A–Z</option>
            </select>
        </div>
    </div>

    <div class="hp-prod-grid" id="hp-all-grid">
        <?php
        $allProducts = [
            [
                'name' => 'Classic Heritage Trench',
                'price' => 850,
                'badge' => 'New',
                'cat' => 'outerwear',
                'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Minimalist Watch',
                'price' => 320,
                'badge' => '',
                'cat' => 'accessories',
                'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Artisan Chelsea Boots',
                'price' => 450,
                'badge' => 'Sale',
                'cat' => 'footwear',
                'img' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Premium Linen Shirt',
                'price' => 120,
                'badge' => '',
                'cat' => 'menswear',
                'img' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Sunshine Maxi Dress',
                'price' => 180,
                'badge' => '',
                'cat' => 'womenswear',
                'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Urban Oversized Hoodie',
                'price' => 95,
                'badge' => '',
                'cat' => 'menswear',
                'img' => 'https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Slim Fit Wool Blazer',
                'price' => 620,
                'badge' => 'New',
                'cat' => 'menswear',
                'img' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Floral Midi Skirt',
                'price' => 145,
                'badge' => '',
                'cat' => 'womenswear',
                'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Leather Tote Bag',
                'price' => 380,
                'badge' => '',
                'cat' => 'accessories',
                'img' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Canvas Sneakers',
                'price' => 110,
                'badge' => '',
                'cat' => 'footwear',
                'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop'
            ],
            [
                'name' => 'Cashmere Sweater',
                'price' => 290,
                'badge' => 'New',
                'cat' => 'womenswear',
                'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=400&auto=format&fit=crop'
            ],
            [
                'name' => 'Structured Polo Shirt',
                'price' => 85,
                'badge' => '',
                'cat' => 'menswear',
                'img' => 'https://images.unsplash.com/photo-1622445275992-4b4e9f432e4e?q=80&w=600&auto=format&fit=crop'
            ],
        ];
        foreach ($allProducts as $idx => $p): ?>
            <div class="product-card" data-category="<?= $p['cat'] ?>" data-price="<?= $p['price'] ?>"
                data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>">
                <a href="product-detail.php">
                    <div class="product-image">
                        <?php if ($p['badge']): ?>
                            <span class="product-badge"><?= $p['badge'] ?></span>
                        <?php endif; ?>
                        <img src="<?= $p['img'] ?>" alt="<?= $p['name'] ?>" loading="lazy">
                        <div class="product-actions">
                            <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                            <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                            <button class="action-btn" title="Quick View"><i class="fas fa-expand"></i></button>
                        </div>
                    </div>
                </a>
                <div class="product-info">
                    <h3><?= $p['name'] ?></h3>
                    <div class="product-price">$<?= number_format($p['price'], 2) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div style="text-align:center; margin-top:3rem;">
        <a href="shop.php"
            style="display:inline-flex; align-items:center; gap:0.6rem; padding:1rem 3rem; border:2px solid var(--primary); font-weight:700; text-transform:uppercase; letter-spacing:1.5px; font-size:0.85rem; transition:all 0.3s;"
            onmouseover="this.style.background='var(--primary)';this.style.color='#fff';"
            onmouseout="this.style.background='';this.style.color='';">
            View All Products <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</section>

<!-- ════════════════════════════════════════════
     NEWSLETTER
════════════════════════════════════════════ -->
<section class="hp-newsletter">
    <div class="left">
        <p class="eyebrow">Stay in the Loop</p>
        <h2>Join the MODERN CLOSET Community</h2>
        <p>Subscribe for early access to new arrivals, exclusive member-only discounts, and styling tips from our
            experts.</p>
    </div>
    <div class="right">
        <p style="font-size:0.88rem; color:#666; margin-bottom:1.2rem;">Enter your email — we promise no spam, ever.</p>
        <div class="hp-nl-form">
            <input type="email" id="nl-email" placeholder="your@email.com">
            <button onclick="subscribeNewsletter()">Subscribe</button>
        </div>
        <p style="font-size:0.72rem; color:#bbb; margin-top:0.8rem;"><i class="fas fa-lock"></i> Your data is safe.
            Unsubscribe anytime.</p>
    </div>
</section>

<!-- Brand Features (keep existing) -->
<section class="brand-identity">
    <div class="feature-item">
        <i class="fas fa-gem"></i>
        <h3>Premium Quality</h3>
        <p>Curated collections from the world's most prestigious designers and luxury houses.</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-leaf"></i>
        <h3>Sustainable Fashion</h3>
        <p>Committed to ethical sourcing and eco-friendly practices for a better tomorrow.</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-shipping-fast"></i>
        <h3>Express Delivery</h3>
        <p>Fast and secure worldwide shipping, ensuring your style arrives on time, every time.</p>
    </div>
    <div class="feature-item">
        <i class="fas fa-headset"></i>
        <h3>24/7 Concierge</h3>
        <p>Our dedicated support team is available around the clock for all your fashion needs.</p>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Hero Slider ─── */
        const slides = document.querySelectorAll('.hp-hero-slide');
        const dots = document.querySelectorAll('.hp-dot');
        let current = 0;
        let timer;

        function goToSlide(n) {
            slides[current].classList.remove('active');
            dots[current].classList.remove('active');
            current = (n + slides.length) % slides.length;
            slides[current].classList.add('active');
            dots[current].classList.add('active');
        }

        function autoSlide() { timer = setInterval(() => goToSlide(current + 1), 5000); }

        dots.forEach(dot => {
            dot.addEventListener('click', function () {
                clearInterval(timer);
                goToSlide(parseInt(this.dataset.slide));
                autoSlide();
            });
        });

        autoSlide();

        /* ── Flash Sale Countdown (count to next midnight) ─── */
        function updateFlash() {
            const now = new Date();
            const end = new Date(now); end.setDate(end.getDate() + 1); end.setHours(0, 0, 0, 0);
            const diff = end - now;
            const h = Math.floor(diff / 3600000);
            const m = Math.floor((diff % 3600000) / 60000);
            const s = Math.floor((diff % 60000) / 1000);
            document.getElementById('fs-h').textContent = String(h).padStart(2, '0');
            document.getElementById('fs-m').textContent = String(m).padStart(2, '0');
            document.getElementById('fs-s').textContent = String(s).padStart(2, '0');
        }
        updateFlash(); setInterval(updateFlash, 1000);

        /* ── Category Chips Filter ─── */
        const chips = document.querySelectorAll('.hp-chip');
        const allCards = document.querySelectorAll('#hp-all-grid .product-card');

        chips.forEach(chip => {
            chip.addEventListener('click', function () {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                allCards.forEach(card => {
                    const match = filter === 'all' || card.dataset.category === filter;
                    card.style.display = match ? '' : 'none';
                });
            });
        });

        /* ── Sort ─── */
        document.getElementById('hp-sort').addEventListener('change', function () {
            const grid = document.getElementById('hp-all-grid');
            const cards = Array.from(grid.querySelectorAll('.product-card'));
            cards.sort((a, b) => {
                const pA = parseFloat(a.dataset.price);
                const pB = parseFloat(b.dataset.price);
                const nA = a.dataset.name;
                const nB = b.dataset.name;
                if (this.value === 'price-low') return pA - pB;
                if (this.value === 'price-high') return pB - pA;
                if (this.value === 'name') return nA.localeCompare(nB);
                return 0;
            });
            cards.forEach(c => grid.appendChild(c));
        });

        /* ── Newsletter ─── */
        window.subscribeNewsletter = function () {
            const input = document.getElementById('nl-email');
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!re.test(input.value.trim())) {
                if (typeof showToast === 'function') showToast('Please enter a valid email address.');
                return;
            }
            if (typeof showToast === 'function') showToast('🎉 Thanks for subscribing! Check your inbox.');
            input.value = '';
        };
    });
</script>

<?php include_once 'includes/footer.php'; ?>