<?php
require_once 'config/config.php';
$searchQuery = isset($_GET['q']) ? trim($_GET['q']) : '';
include_once 'includes/header.php';
?>

<!-- Page Header -->
<div class="page-header">
    <h1 id="search-heading">Search Results</h1>
    <div class="breadcrumb" id="search-sub">Searching...</div>
</div>

<!-- Results Section -->
<section class="section-padding" style="padding-top: 4rem;">
    <div id="search-results-grid" class="product-grid"
        style="padding: 0 5%; display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 2rem; min-height: 300px;">
        <!-- JS will populate this -->
    </div>
    <div id="no-results" style="display:none; text-align:center; padding: 6rem 5%; color: #888;">
        <i class="fas fa-search" style="font-size: 3rem; color: #ddd; margin-bottom: 1.5rem; display:block;"></i>
        <h2 style="font-size:1.5rem; color:#333; margin-bottom:1rem;">No results found</h2>
        <p id="no-results-text" style="font-size:0.95rem;">Try a different search term.</p>
    </div>
</section>

<style>
    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .product-card:hover .product-actions {
        bottom: 0 !important;
    }
</style>

<script>
    // ── Static product catalogue (mirrors index.php cards) ──────────────────────
    const ALL_PRODUCTS = [
        {
            name: 'Classic Heritage Trench',
            price: '$850.00',
            image: 'https://images.unsplash.com/photo-1548126032-079a0fb0099d?q=80&w=1974&auto=format&fit=crop',
            href: '<?= base_url("product-detail.php") ?>',
            badge: 'New',
            category: 'Menswear'
        },
        {
            name: 'Minimalist Signature Watch',
            price: '$320.00',
            image: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=1998&auto=format&fit=crop',
            href: '<?= base_url("product-detail.php") ?>',
            badge: '',
            category: 'Accessories'
        },
        {
            name: 'Artisan Leather Chelsea Boots',
            price: '$450.00',
            image: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=2070&auto=format&fit=crop',
            href: '<?= base_url("product-detail.php") ?>',
            badge: 'Sale',
            category: 'Menswear'
        },
        {
            name: 'Premium Linen Button-Down',
            price: '$120.00',
            image: 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=1976&auto=format&fit=crop',
            href: '<?= base_url("product-detail.php") ?>',
            badge: '',
            category: 'Menswear'
        },
        {
            name: 'Sunshine Summer Maxi',
            price: '$180.00',
            image: 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=1974&auto=format&fit=crop',
            href: '<?= base_url("product-detail.php") ?>',
            badge: '',
            category: 'Womenswear'
        },
        {
            name: 'Urban Oversized Hoodie',
            price: '$95.00',
            image: 'https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?q=80&w=1072&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            href: '<?= base_url("product-detail.php") ?>',
            badge: '',
            category: 'Menswear'
        }
    ];

    // ── Run search ───────────────────────────────────────────────────────────────
    const query = '<?= addslashes(htmlspecialchars($searchQuery)) ?>';
    const grid = document.getElementById('search-results-grid');
    const noRes = document.getElementById('no-results');
    const heading = document.getElementById('search-heading');
    const sub = document.getElementById('search-sub');

    function buildCard(p) {
        return `
        <div class="product-card" data-name="${p.name.toLowerCase()}">
            <a href="${p.href}">
                <div class="product-image" style="position:relative;height:380px;overflow:hidden;">
                    ${p.badge ? `<span class="product-badge">${p.badge}</span>` : ''}
                    <img src="${p.image}" alt="${p.name}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.6s;">
                    <div class="product-actions" style="position:absolute;bottom:-60px;left:0;right:0;background:rgba(255,255,255,0.92);display:flex;justify-content:center;gap:1rem;padding:1.2rem;transition:bottom 0.35s;backdrop-filter:blur(4px);">
                        <button class="action-btn" title="Add to Cart"><i class="fas fa-shopping-bag"></i></button>
                        <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                        <button class="action-btn" title="Quick View"><i class="fas fa-expand"></i></button>
                    </div>
                </div>
            </a>
            <div class="product-info" style="margin-top:1rem;text-align:center;">
                <p style="font-size:0.75rem;color:#aaa;text-transform:uppercase;letter-spacing:1px;margin-bottom:0.25rem;">${p.category}</p>
                <h3 style="font-size:1rem;font-weight:500;letter-spacing:1px;text-transform:uppercase;">
                    <a href="${p.href}" style="color:inherit;text-decoration:none;">${p.name}</a>
                </h3>
                <div class="product-price" style="margin-top:0.4rem;">${p.price}</div>
            </div>
        </div>`;
    }

    window.addEventListener('DOMContentLoaded', function () {
        if (!query) {
            heading.textContent = 'All Products';
            sub.textContent = 'Browse our full collection';
            grid.innerHTML = ALL_PRODUCTS.map(buildCard).join('');
            return;
        }

        const q = query.toLowerCase();
        const matches = ALL_PRODUCTS.filter(p =>
            p.name.toLowerCase().includes(q) ||
            p.category.toLowerCase().includes(q)
        );

        heading.textContent = `Results for "${query}"`;

        if (matches.length > 0) {
            sub.textContent = matches.length + ' product' + (matches.length > 1 ? 's' : '') + ' found';
            grid.innerHTML = matches.map(buildCard).join('');
        } else {
            grid.style.display = 'none';
            noRes.style.display = 'block';
            document.getElementById('no-results-text').textContent =
                'No products matched "' + query + '". Try another keyword.';
            sub.textContent = '0 results';
        }
    });
</script>

<?php include_once 'includes/footer.php'; ?>