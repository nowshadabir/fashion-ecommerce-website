<?php
/**
 * Categories Page
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* =====================================================
   CATEGORIES PAGE STYLES
   ===================================================== */

    .cat-hero {
        position: relative;
        height: 340px;
        background: linear-gradient(135deg, #111 0%, #2c2c2c 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        text-align: center;
    }

    .cat-hero::before {
        content: 'COLLECTIONS';
        position: absolute;
        font-size: 12rem;
        font-weight: 900;
        letter-spacing: 20px;
        color: rgba(255, 255, 255, 0.03);
        white-space: nowrap;
        user-select: none;
    }

    .cat-hero-content {
        position: relative;
        z-index: 2;
        color: #fff;
    }

    .cat-hero-content .eyebrow {
        font-size: 0.75rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.8rem;
    }

    .cat-hero-content h1 {
        font-size: 3.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 6px;
        margin-bottom: 1rem;
        line-height: 1.1;
    }

    .cat-hero-content p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.6);
        max-width: 500px;
        margin: 0 auto;
        line-height: 1.7;
    }

    /* Grid of category cards */
    .cat-grid-section {
        padding: 5rem 5%;
    }

    .cat-grid-section .section-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 4px;
        color: var(--accent);
        font-weight: 700;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .cat-grid-section h2 {
        font-size: 2rem;
        font-weight: 800;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 3rem;
    }

    .cat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    /* First large card spans 2 rows */
    .cat-card {
        position: relative;
        overflow: hidden;
        cursor: pointer;
        background: #1a1a1a;
    }

    .cat-card.large {
        grid-row: span 2;
    }

    .cat-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        min-height: 280px;
    }

    .cat-card.large img {
        min-height: 100%;
    }

    .cat-card:hover img {
        transform: scale(1.06);
    }

    .cat-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.72) 0%, rgba(0, 0, 0, 0.1) 55%, transparent 100%);
        transition: background 0.4s;
    }

    .cat-card:hover .cat-card-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.82) 0%, rgba(0, 0, 0, 0.25) 65%, transparent 100%);
    }

    .cat-card-body {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 2rem;
        color: #fff;
        transform: translateY(10px);
        transition: transform 0.35s ease;
    }

    .cat-card:hover .cat-card-body {
        transform: translateY(0);
    }

    .cat-card-tag {
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.4rem;
    }

    .cat-card-title {
        font-size: 1.5rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .cat-card.large .cat-card-title {
        font-size: 2.2rem;
    }

    .cat-card-count {
        font-size: 0.82rem;
        color: rgba(255, 255, 255, 0.65);
        margin-bottom: 1.2rem;
    }

    .cat-card-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #fff;
        border-bottom: 1px solid var(--accent);
        padding-bottom: 2px;
        opacity: 0;
        transform: translateY(8px);
        transition: opacity 0.3s ease 0.05s, transform 0.3s ease 0.05s;
    }

    .cat-card:hover .cat-card-btn {
        opacity: 1;
        transform: translateY(0);
    }

    /* Mini browse strip */
    .cat-browse-strip {
        background: var(--primary);
        padding: 2rem 5%;
        display: flex;
        align-items: center;
        gap: 2rem;
        overflow-x: auto;
        scrollbar-width: none;
    }

    .cat-browse-strip::-webkit-scrollbar {
        display: none;
    }

    .cat-strip-label {
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.4);
        flex-shrink: 0;
        margin-right: 1rem;
    }

    .cat-strip-item {
        flex-shrink: 0;
        padding: 0.6rem 1.4rem;
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.25s;
        white-space: nowrap;
        text-decoration: none;
    }

    .cat-strip-item:hover,
    .cat-strip-item.active {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }

    /* Featured banner */
    .cat-featured {
        margin: 5rem 5%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        background: #f6f3ef;
        overflow: hidden;
        min-height: 420px;
    }

    .cat-featured-img {
        overflow: hidden;
    }

    .cat-featured-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.6s ease;
    }

    .cat-featured:hover .cat-featured-img img {
        transform: scale(1.04);
    }

    .cat-featured-body {
        padding: 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .cat-featured-body .eyebrow {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cat-featured-body h3 {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.15;
        margin-bottom: 1.2rem;
    }

    .cat-featured-body p {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .cat-featured-body .btn {
        align-self: flex-start;
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        padding: 0.9rem 2.2rem;
    }

    .cat-featured-body .btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
        transform: none;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cat-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cat-card.large {
            grid-row: span 1;
        }

        .cat-featured {
            grid-template-columns: 1fr;
        }

        .cat-featured-img {
            height: 280px;
        }

        .cat-hero-content h1 {
            font-size: 2.2rem;
            letter-spacing: 3px;
        }
    }

    @media (max-width: 600px) {
        .cat-grid {
            grid-template-columns: 1fr;
        }

        .cat-hero {
            height: 260px;
        }

        .cat-hero-content h1 {
            font-size: 1.8rem;
        }

        .cat-featured-body {
            padding: 2.5rem;
        }

        .cat-featured-body h3 {
            font-size: 1.6rem;
        }
    }
</style>

<!-- Hero -->
<section class="cat-hero">
    <div class="cat-hero-content">
        <p class="eyebrow">Explore Our World</p>
        <h1>Categories</h1>
        <p>Discover curated collections for every style, season, and occasion.</p>
    </div>
</section>

<!-- Quick Browse Strip -->
<div class="cat-browse-strip">
    <span class="cat-strip-label">Browse by:</span>
    <a href="#" class="cat-strip-item active">All</a>
    <a href="#" class="cat-strip-item">Menswear</a>
    <a href="#" class="cat-strip-item">Womenswear</a>
    <a href="#" class="cat-strip-item">Accessories</a>
    <a href="#" class="cat-strip-item">Footwear</a>
    <a href="#" class="cat-strip-item">Bags</a>
    <a href="#" class="cat-strip-item">Watches</a>
    <a href="#" class="cat-strip-item">Outerwear</a>
    <a href="#" class="cat-strip-item">Sale</a>
</div>

<!-- Main Category Grid -->
<section class="cat-grid-section">
    <p class="section-title">Shop by Category</p>
    <h2>Find Your Style</h2>

    <div class="cat-grid">

        <!-- Large card (spans 2 rows) -->
        <div class="cat-card large">
            <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1000&auto=format&fit=crop"
                alt="Womenswear">
            <div class="cat-card-overlay"></div>
            <div class="cat-card-body">
                <p class="cat-card-tag">New Season</p>
                <h3 class="cat-card-title">Women's Edit</h3>
                <p class="cat-card-count">22 pieces</p>
                <a href="index.php" class="cat-card-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <!-- Regular cards -->
        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=800&auto=format&fit=crop"
                alt="Menswear">
            <div class="cat-card-overlay"></div>
            <div class="cat-card-body">
                <p class="cat-card-tag">Essentials</p>
                <h3 class="cat-card-title">Menswear</h3>
                <p class="cat-card-count">15 pieces</p>
                <a href="index.php" class="cat-card-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1543076447-215ad9ba6923?q=80&w=800&auto=format&fit=crop"
                alt="Accessories">
            <div class="cat-card-overlay"></div>
            <div class="cat-card-body">
                <p class="cat-card-tag">Curated</p>
                <h3 class="cat-card-title">Accessories</h3>
                <p class="cat-card-count">11 pieces</p>
                <a href="index.php" class="cat-card-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=800&auto=format&fit=crop"
                alt="Footwear">
            <div class="cat-card-overlay"></div>
            <div class="cat-card-body">
                <p class="cat-card-tag">Premium</p>
                <h3 class="cat-card-title">Footwear</h3>
                <p class="cat-card-count">18 pieces</p>
                <a href="index.php" class="cat-card-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

        <div class="cat-card">
            <img src="https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=800&auto=format&fit=crop"
                alt="Bags">
            <div class="cat-card-overlay"></div>
            <div class="cat-card-body">
                <p class="cat-card-tag">Iconic</p>
                <h3 class="cat-card-title">Bags & Luggage</h3>
                <p class="cat-card-count">9 pieces</p>
                <a href="index.php" class="cat-card-btn">Shop Now <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>

    </div>
</section>

<!-- Featured Collection Banner -->
<div class="cat-featured">
    <div class="cat-featured-img">
        <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=1200&auto=format&fit=crop"
            alt="Summer Collection">
    </div>
    <div class="cat-featured-body">
        <span class="eyebrow">Featured Collection</span>
        <h3>The Summer Luxe Edit</h3>
        <p>
            Step into warmth and elegance. Our Summer Luxe Edit brings together breezy silhouettes, sun-kissed
            palettes, and premium natural fabrics for the season's most refined looks.
        </p>
        <a href="index.php" class="btn">Explore Collection</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Quick browse strip active toggle
        const stripItems = document.querySelectorAll('.cat-strip-item');
        stripItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                stripItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>