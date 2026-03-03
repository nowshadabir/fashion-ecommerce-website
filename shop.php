<?php
/**
 * Shop Page — All Products with Filters & Sort
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* ── Shop Hero ──────────────────────────────────── */
    .sp-hero {
        background: linear-gradient(135deg, #111 0%, #1c1c1c 100%);
        padding: 3.5rem 5%;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        position: relative;
        overflow: hidden;
    }

    .sp-hero::before {
        content: 'SHOP';
        position: absolute;
        bottom: -30px;
        right: 5%;
        font-size: 10rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.03);
        letter-spacing: 10px;
        line-height: 1;
        pointer-events: none;
    }

    .sp-hero-left .eyebrow {
        font-size: 0.68rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.6rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }

    .sp-hero-left .eyebrow::before {
        content: '';
        width: 30px;
        height: 1px;
        background: var(--accent);
    }

    .sp-hero-left h1 {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 0.4rem;
    }

    .sp-hero-left p {
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.4);
    }

    .sp-hero-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sp-view-btn {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid rgba(255, 255, 255, 0.2);
        background: none;
        color: rgba(255, 255, 255, 0.4);
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .sp-view-btn.active,
    .sp-view-btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }

    /* ── Layout ─────────────────────────────────────── */
    .sp-layout {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 0;
        min-height: 80vh;
    }

    /* ── Sidebar ────────────────────────────────────── */
    .sp-sidebar {
        background: #fff;
        border-right: 1px solid var(--border);
        padding: 2rem 1.5rem;
        position: sticky;
        top: 0;
        height: fit-content;
        max-height: 100vh;
        overflow-y: auto;
    }

    .sp-filter-group {
        margin-bottom: 2rem;
    }

    .sp-filter-group h3 {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        font-weight: 800;
        color: #333;
        margin-bottom: 1rem;
        padding-bottom: 0.8rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sp-filter-group h3 i {
        color: var(--accent);
        font-size: 0.75rem;
    }

    .sp-filter-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sp-filter-list li {
        margin-bottom: 0.15rem;
    }

    .sp-filter-list li a,
    .sp-filter-list li button {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0.6rem 0.8rem;
        font-size: 0.85rem;
        color: #555;
        background: none;
        border: none;
        cursor: pointer;
        border-radius: 4px;
        transition: all 0.2s;
        font-family: inherit;
        text-align: left;
        text-decoration: none;
    }

    .sp-filter-list li a:hover,
    .sp-filter-list li button:hover {
        background: #f8f8f8;
        color: var(--primary);
    }

    .sp-filter-list li a.active,
    .sp-filter-list li button.active {
        background: var(--primary);
        color: #fff;
        font-weight: 700;
    }

    .sp-filter-list li a .count,
    .sp-filter-list li button .count {
        font-size: 0.72rem;
        color: #bbb;
        font-weight: 600;
    }

    .sp-filter-list li a.active .count,
    .sp-filter-list li button.active .count {
        color: rgba(255, 255, 255, 0.5);
    }

    /* Price range */
    .sp-price-range {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.6rem;
        margin-top: 0.5rem;
    }

    .sp-price-range input {
        width: 100%;
        padding: 0.6rem 0.8rem;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.82rem;
        outline: none;
        transition: border-color 0.2s;
    }

    .sp-price-range input:focus {
        border-color: var(--primary);
    }

    .sp-apply-price {
        grid-column: 1/-1;
        padding: 0.65rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .sp-apply-price:hover {
        background: var(--accent);
        color: var(--primary);
    }

    /* Color swatches */
    .sp-color-swatches {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .sp-color-sw {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: 2px solid #eee;
        cursor: pointer;
        transition: all 0.2s;
        padding: 0;
    }

    .sp-color-sw:hover,
    .sp-color-sw.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(17, 17, 17, 0.15);
    }

    .sp-clear-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 1rem;
        background: none;
        border: 1.5px solid #ddd;
        font-family: inherit;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 0.5rem;
        color: #999;
        border-radius: 4px;
        width: 100%;
        justify-content: center;
    }

    .sp-clear-btn:hover {
        border-color: #e74c3c;
        color: #e74c3c;
    }

    /* ── Main Content ───────────────────────────────── */
    .sp-main {
        padding: 1.5rem 2rem 5rem;
        background: #fafafa;
    }

    /* Toolbar */
    .sp-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding: 0.8rem 1.2rem;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 6px;
    }

    .sp-result-count {
        font-size: 0.82rem;
        color: #999;
    }

    .sp-result-count strong {
        color: var(--primary);
    }

    .sp-toolbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .sp-sort-select {
        padding: 0.55rem 0.9rem;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.82rem;
        outline: none;
        background: #fff;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .sp-sort-select:focus {
        border-color: var(--primary);
    }

    /* ── Search Box ─────────────────────────────────── */
    .sp-search-wrapper {
        position: relative;
        flex: 0 1 340px;
        min-width: 180px;
    }

    .sp-search-inner {
        position: relative;
        display: flex;
        align-items: center;
    }

    .sp-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 0.82rem;
        transition: color 0.3s;
        pointer-events: none;
        z-index: 2;
    }

    .sp-search-box {
        width: 100%;
        padding: 0.7rem 2.6rem 0.7rem 2.6rem;
        border: 1.5px solid #e8e8e8;
        border-radius: 50px;
        font-family: inherit;
        font-size: 0.85rem;
        color: var(--primary);
        background: #f9f9f9;
        outline: none;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        letter-spacing: 0.3px;
    }

    .sp-search-box::placeholder {
        color: #bbb;
        font-weight: 400;
        letter-spacing: 0.5px;
    }

    .sp-search-box:hover {
        border-color: #ccc;
        background: #fff;
    }

    .sp-search-box:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.06);
    }

    .sp-search-inner:focus-within .sp-search-icon {
        color: var(--primary);
    }

    .sp-search-clear {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%) scale(0);
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #eee;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        font-size: 0.65rem;
        color: #888;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 2;
        opacity: 0;
    }

    .sp-search-clear.visible {
        transform: translateY(-50%) scale(1);
        opacity: 1;
    }

    .sp-search-clear:hover {
        background: var(--primary);
        color: #fff;
    }

    /* ── Search Dropdown ───────────────────────────── */
    .sp-search-dropdown {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 12px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12),
            0 4px 12px rgba(0, 0, 0, 0.06);
        z-index: 1000;
        max-height: 380px;
        overflow-y: auto;
        opacity: 0;
        transform: translateY(-6px);
        visibility: hidden;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        scrollbar-width: thin;
        scrollbar-color: #ddd transparent;
    }

    .sp-search-dropdown.open {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
    }

    .sp-search-dropdown-header {
        padding: 0.7rem 1rem;
        font-size: 0.68rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #aaa;
        font-weight: 700;
        border-bottom: 1px solid #f0f0f0;
        background: #fafafa;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .sp-search-dropdown-header span {
        font-weight: 600;
        color: var(--primary);
    }

    .sp-search-item {
        display: flex;
        align-items: center;
        gap: 0.9rem;
        padding: 0.7rem 1rem;
        cursor: pointer;
        transition: background 0.2s;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f5f5f5;
    }

    .sp-search-item:last-child {
        border-bottom: none;
    }

    .sp-search-item:hover,
    .sp-search-item.highlighted {
        background: #f7f7f7;
    }

    .sp-search-item.highlighted {
        background: #f0efe9;
    }

    .sp-search-item-img {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        object-fit: cover;
        flex-shrink: 0;
        border: 1px solid #f0f0f0;
    }

    .sp-search-item-info {
        flex: 1;
        min-width: 0;
    }

    .sp-search-item-name {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }

    .sp-search-item-name mark {
        background: rgba(212, 175, 55, 0.25);
        color: inherit;
        padding: 0 2px;
        border-radius: 2px;
    }

    .sp-search-item-meta {
        font-size: 0.72rem;
        color: #aaa;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .sp-search-item-price {
        font-weight: 700;
        color: var(--primary);
    }

    .sp-search-item-brand {
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.65rem;
    }

    .sp-search-item-arrow {
        color: #ddd;
        font-size: 0.7rem;
        transition: transform 0.2s;
        flex-shrink: 0;
    }

    .sp-search-item:hover .sp-search-item-arrow {
        transform: translateX(3px);
        color: var(--accent);
    }

    .sp-search-no-result {
        padding: 2rem 1rem;
        text-align: center;
        color: #bbb;
    }

    .sp-search-no-result i {
        font-size: 1.8rem;
        color: #e0e0e0;
        margin-bottom: 0.5rem;
        display: block;
    }

    .sp-search-no-result p {
        font-size: 0.85rem;
        margin: 0;
    }

    .sp-search-footer {
        padding: 0.6rem 1rem;
        text-align: center;
        border-top: 1px solid #f0f0f0;
        background: #fafafa;
        border-radius: 0 0 12px 12px;
    }

    .sp-search-footer small {
        font-size: 0.68rem;
        color: #ccc;
        letter-spacing: 0.5px;
    }

    .sp-search-footer kbd {
        display: inline-block;
        padding: 1px 5px;
        font-size: 0.62rem;
        background: #eee;
        border-radius: 3px;
        border: 1px solid #ddd;
        font-family: inherit;
        margin: 0 1px;
    }

    /* Search loading spinner */
    .sp-search-spinner {
        position: absolute;
        right: 44px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        border: 2px solid #eee;
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: sp-spin 0.6s linear infinite;
        opacity: 0;
        transition: opacity 0.2s;
        z-index: 2;
    }

    .sp-search-spinner.active {
        opacity: 1;
    }

    @keyframes sp-spin {
        to {
            transform: translateY(-50%) rotate(360deg);
        }
    }

    /* Responsive search */
    @media (max-width: 768px) {
        .sp-toolbar {
            flex-direction: column;
            gap: 0.8rem;
            align-items: stretch;
        }

        .sp-search-wrapper {
            flex: 1 1 100%;
            max-width: 100%;
        }

        .sp-toolbar-right {
            justify-content: flex-end;
        }
    }

    /* ── Product Grid ───────────────────────────────── */
    .sp-product-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .sp-product-grid.list-view {
        grid-template-columns: 1fr;
    }

    .sp-product-grid.list-view .product-card {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 0;
        border: 1px solid #eee;
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
    }

    .sp-product-grid.list-view .product-card .product-image {
        aspect-ratio: auto;
        height: 100%;
        min-height: 200px;
    }

    .sp-product-grid.list-view .product-card .product-image img {
        height: 100%;
    }

    .sp-product-grid.list-view .product-card .product-info {
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Mobile filter button */
    .sp-mobile-filter-btn {
        display: none;
        position: fixed;
        bottom: 1.5rem;
        left: 50%;
        transform: translateX(-50%);
        padding: 0.8rem 2rem;
        background: var(--primary);
        color: #fff;
        border: none;
        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        cursor: pointer;
        z-index: 100;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        border-radius: 99px;
        gap: 0.5rem;
        align-items: center;
    }

    /* Pagination */
    .sp-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.4rem;
        margin-top: 3rem;
    }

    .sp-page-btn {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s;
        border-radius: 4px;
        color: #555;
    }

    .sp-page-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .sp-page-btn.active {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* ── No Results ─────────────────────────────────── */
    .sp-no-results {
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
        display: none;
        grid-column: 1/-1;
    }

    .sp-no-results i {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 1rem;
        display: block;
    }

    .sp-no-results p {
        font-size: 1rem;
        margin-bottom: 0.5rem;
    }

    /* ── Responsive ─────────────────────────────────── */
    @media (max-width: 1024px) {
        .sp-product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .sp-hero-left h1 {
            font-size: 2rem;
        }

        .sp-layout {
            grid-template-columns: 1fr;
        }

        .sp-sidebar {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100vh;
            z-index: 2000;
            box-shadow: 5px 0 25px rgba(0, 0, 0, 0.15);
            padding-top: 3rem;
        }

        .sp-sidebar.open {
            display: block;
        }

        .sp-mobile-filter-btn {
            display: inline-flex;
        }

        .sp-sidebar-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            color: #333;
        }

        .sp-product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
        }

        .sp-main {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .sp-hero-left h1 {
            font-size: 1.6rem;
        }

        .sp-hero {
            padding: 2.5rem 5%;
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .sp-product-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.6rem;
        }
    }

    /* Card pulse animation for search highlight */
    @keyframes sp-card-pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0.5);
        }

        50% {
            box-shadow: 0 0 0 8px rgba(212, 175, 55, 0.15);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(212, 175, 55, 0);
        }
    }
</style>

<!-- ══════ HERO ══════ -->
<section class="sp-hero">
    <div class="sp-hero-left">
        <p class="eyebrow">Browse Collection</p>
        <h1>The Shop</h1>
    </div>
    <div class="sp-hero-right">
        <button class="sp-view-btn active" id="grid-view-btn" title="Grid View"><i class="fas fa-th"></i></button>
        <button class="sp-view-btn" id="list-view-btn" title="List View"><i class="fas fa-list"></i></button>
    </div>
</section>

<div class="sp-layout">

    <!-- ══════ SIDEBAR ══════ -->
    <aside class="sp-sidebar" id="sp-sidebar">
        <button class="sp-sidebar-close" id="sp-sidebar-close" style="display:none;">
            <i class="fas fa-times"></i>
        </button>

        <!-- Categories -->
        <div class="sp-filter-group">
            <h3><i class="fas fa-tag"></i> Category</h3>
            <ul class="sp-filter-list" id="sp-cat-filters">
                <li><button class="active" data-cat="all">All <span class="count">(18)</span></button></li>
                <li><button data-cat="menswear">Menswear <span class="count">(6)</span></button></li>
                <li><button data-cat="womenswear">Womenswear <span class="count">(5)</span></button></li>
                <li><button data-cat="accessories">Accessories <span class="count">(3)</span></button></li>
                <li><button data-cat="footwear">Footwear <span class="count">(2)</span></button></li>
                <li><button data-cat="outerwear">Outerwear <span class="count">(2)</span></button></li>
            </ul>
        </div>

        <!-- Price -->
        <div class="sp-filter-group">
            <h3><i class="fas fa-dollar-sign"></i> Price Range</h3>
            <ul class="sp-filter-list" id="sp-price-filters">
                <li><button class="active" data-min="0" data-max="99999">All Prices</button></li>
                <li><button data-min="0" data-max="100">Under $100</button></li>
                <li><button data-min="100" data-max="300">$100 — $300</button></li>
                <li><button data-min="300" data-max="600">$300 — $600</button></li>
                <li><button data-min="600" data-max="99999">$600+</button></li>
            </ul>
            <div class="sp-price-range" style="margin-top:0.8rem;">
                <input type="number" id="sp-price-min" placeholder="Min $">
                <input type="number" id="sp-price-max" placeholder="Max $">
                <button class="sp-apply-price" id="sp-apply-price">Apply</button>
            </div>
        </div>

        <!-- Brand -->
        <div class="sp-filter-group">
            <h3><i class="fas fa-crown"></i> Brand</h3>
            <ul class="sp-filter-list" id="sp-brand-filters">
                <li><button class="active" data-brand="all">All Brands</button></li>
                <li><button data-brand="Gucci">Gucci</button></li>
                <li><button data-brand="Prada">Prada</button></li>
                <li><button data-brand="Versace">Versace</button></li>
                <li><button data-brand="Balenciaga">Balenciaga</button></li>
                <li><button data-brand="Dior">Dior</button></li>
            </ul>
        </div>

        <!-- Color -->
        <div class="sp-filter-group">
            <h3><i class="fas fa-palette"></i> Color</h3>
            <div class="sp-color-swatches" id="sp-color-filters">
                <button class="sp-color-sw active" data-color="all" style="background:#ccc; position:relative;"
                    title="All">
                    <i class="fas fa-check"
                        style="font-size:0.55rem; color:#fff; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);"></i>
                </button>
                <button class="sp-color-sw" data-color="black" style="background:#111;" title="Black"></button>
                <button class="sp-color-sw" data-color="white" style="background:#f5f5f5;" title="White"></button>
                <button class="sp-color-sw" data-color="brown" style="background:#8B4513;" title="Brown"></button>
                <button class="sp-color-sw" data-color="blue" style="background:#2c5aa0;" title="Blue"></button>
                <button class="sp-color-sw" data-color="green" style="background:#2d6a4f;" title="Green"></button>
                <button class="sp-color-sw" data-color="red" style="background:#c0392b;" title="Red"></button>
                <button class="sp-color-sw" data-color="beige" style="background:#d4b896;" title="Beige"></button>
            </div>
        </div>

        <button class="sp-clear-btn" id="sp-clear-all">
            <i class="fas fa-undo-alt"></i> Clear All Filters
        </button>
    </aside>

    <!-- ══════ MAIN ══════ -->
    <main class="sp-main">

        <!-- Toolbar -->
        <div class="sp-toolbar">
            <div class="sp-search-wrapper">
                <div class="sp-search-inner">
                    <i class="fas fa-search sp-search-icon"></i>
                    <input type="text" placeholder="Search products..." id="sp-search" class="sp-search-box"
                        autocomplete="off">
                    <div class="sp-search-spinner" id="sp-search-spinner"></div>
                    <button class="sp-search-clear" id="sp-search-clear" title="Clear search">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="sp-search-dropdown" id="sp-search-dropdown"></div>
            </div>
            <div class="sp-toolbar-right">
                <select class="sp-sort-select" id="sp-sort">
                    <option value="default">Sort: Default</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="name-asc">Name: A → Z</option>
                    <option value="name-desc">Name: Z → A</option>
                    <option value="newest">Newest First</option>
                </select>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="sp-product-grid" id="sp-grid">
            <?php
            $products = [
                [
                    'name' => 'Classic Heritage Trench',
                    'price' => 850,
                    'badge' => 'New',
                    'cat' => 'outerwear',
                    'brand' => 'Gucci',
                    'color' => 'beige',
                    'img' => 'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Minimalist Signature Watch',
                    'price' => 320,
                    'badge' => 'Bestseller',
                    'cat' => 'accessories',
                    'brand' => 'Prada',
                    'color' => 'black',
                    'img' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Artisan Chelsea Boots',
                    'price' => 450,
                    'badge' => 'Sale',
                    'cat' => 'footwear',
                    'brand' => 'Versace',
                    'color' => 'brown',
                    'img' => 'https://images.unsplash.com/photo-1549298916-b41d501d3772?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Premium Linen Shirt',
                    'price' => 120,
                    'badge' => '',
                    'cat' => 'menswear',
                    'brand' => 'Balenciaga',
                    'color' => 'white',
                    'img' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Sunshine Maxi Dress',
                    'price' => 180,
                    'badge' => '',
                    'cat' => 'womenswear',
                    'brand' => 'Gucci',
                    'color' => 'green',
                    'img' => 'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Urban Oversized Hoodie',
                    'price' => 95,
                    'badge' => '',
                    'cat' => 'menswear',
                    'brand' => 'Balenciaga',
                    'color' => 'black',
                    'img' => 'https://images.unsplash.com/photo-1620799140188-3b2a02fd9a77?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Slim Fit Wool Blazer',
                    'price' => 620,
                    'badge' => 'New',
                    'cat' => 'menswear',
                    'brand' => 'Prada',
                    'color' => 'black',
                    'img' => 'https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Floral Midi Skirt',
                    'price' => 145,
                    'badge' => '',
                    'cat' => 'womenswear',
                    'brand' => 'Dior',
                    'color' => 'blue',
                    'img' => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Leather Tote Bag',
                    'price' => 380,
                    'badge' => '',
                    'cat' => 'accessories',
                    'brand' => 'Gucci',
                    'color' => 'brown',
                    'img' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Canvas Running Sneakers',
                    'price' => 110,
                    'badge' => '',
                    'cat' => 'footwear',
                    'brand' => 'Balenciaga',
                    'color' => 'red',
                    'img' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Cashmere V-Neck Sweater',
                    'price' => 290,
                    'badge' => 'New',
                    'cat' => 'womenswear',
                    'brand' => 'Dior',
                    'color' => 'beige',
                    'img' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Structured Polo Shirt',
                    'price' => 85,
                    'badge' => '',
                    'cat' => 'menswear',
                    'brand' => 'Versace',
                    'color' => 'white',
                    'img' => 'https://images.unsplash.com/photo-1720514496333-2c552e9ee5f2?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
                ],
                [
                    'name' => 'Tailored Wool Overcoat',
                    'price' => 750,
                    'badge' => '',
                    'cat' => 'outerwear',
                    'brand' => 'Prada',
                    'color' => 'black',
                    'img' => 'https://images.unsplash.com/photo-1544022613-e87ca75a784a?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Silk Evening Gown',
                    'price' => 960,
                    'badge' => 'Exclusive',
                    'cat' => 'womenswear',
                    'brand' => 'Dior',
                    'color' => 'red',
                    'img' => 'https://images.unsplash.com/photo-1518622358385-8ea7d0794bf6?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Aviator Sunglasses',
                    'price' => 215,
                    'badge' => '',
                    'cat' => 'accessories',
                    'brand' => 'Versace',
                    'color' => 'black',
                    'img' => 'https://images.unsplash.com/photo-1511499767150-a48a237f0083?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Graphic Print Tee',
                    'price' => 65,
                    'badge' => '',
                    'cat' => 'menswear',
                    'brand' => 'Balenciaga',
                    'color' => 'white',
                    'img' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Silk Wrap Blouse',
                    'price' => 195,
                    'badge' => '',
                    'cat' => 'womenswear',
                    'brand' => 'Gucci',
                    'color' => 'blue',
                    'img' => 'https://images.unsplash.com/photo-1485968579580-b6d095142e6e?q=80&w=600&auto=format&fit=crop'
                ],
                [
                    'name' => 'Chino Tailored Trousers',
                    'price' => 155,
                    'badge' => '',
                    'cat' => 'menswear',
                    'brand' => 'Prada',
                    'color' => 'beige',
                    'img' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?q=80&w=600&auto=format&fit=crop'
                ],
            ];
            foreach ($products as $p): ?>
                <div class="product-card" data-category="<?= $p['cat'] ?>" data-price="<?= $p['price'] ?>"
                    data-brand="<?= $p['brand'] ?>" data-color="<?= $p['color'] ?>"
                    data-name="<?= htmlspecialchars(strtolower($p['name'])) ?>">
                    <a href="product-detail.php">
                        <div class="product-image">
                            <?php if ($p['badge']): ?>
                                <span class="product-badge">
                                    <?= $p['badge'] ?>
                                </span>
                            <?php endif; ?>
                            <img src="<?= $p['img'] ?>" alt="<?= htmlspecialchars($p['name']) ?>" loading="lazy">
                            <div class="product-actions">
                                <button class="action-btn" title="Add to Bag"><i class="fas fa-shopping-bag"></i></button>
                                <button class="action-btn" title="Wishlist"><i class="far fa-heart"></i></button>
                                <button class="action-btn" title="Quick View"><i class="fas fa-expand"></i></button>
                            </div>
                        </div>
                    </a>
                    <div class="product-info">
                        <p
                            style="font-size:0.68rem; color:#aaa; text-transform:uppercase; letter-spacing:1.5px; margin-bottom:0.3rem;">
                            <?= $p['brand'] ?>
                        </p>
                        <h3>
                            <?= htmlspecialchars($p['name']) ?>
                        </h3>
                        <div class="product-price">$
                            <?= number_format($p['price'], 2) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- No results message -->
            <div class="sp-no-results" id="sp-no-results">
                <i class="fas fa-search"></i>
                <p>No products match your filters.</p>
                <a href="#" id="sp-reset-link" style="color:var(--accent); font-weight:700;">Clear all filters</a>
            </div>
        </div>

        <!-- Pagination -->
        <div class="sp-pagination">
            <button class="sp-page-btn active">1</button>
            <button class="sp-page-btn">2</button>
            <button class="sp-page-btn">3</button>
            <button class="sp-page-btn"><i class="fas fa-chevron-right"></i></button>
        </div>

    </main>
</div>

<!-- Mobile Filter Button -->
<button class="sp-mobile-filter-btn" id="sp-mobile-filter-btn">
    <i class="fas fa-sliders-h"></i> Filters
</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const grid = document.getElementById('sp-grid');
        const allCards = Array.from(grid.querySelectorAll('.product-card'));
        const noResults = document.getElementById('sp-no-results');

        let activeFilters = { cat: 'all', brand: 'all', color: 'all', minPrice: 0, maxPrice: 99999, search: '' };

        /* ═══════════════════════════════════════════════
           ██  SEARCH BOX LOGIC
           ═══════════════════════════════════════════════ */
        const searchInput = document.getElementById('sp-search');
        const searchClear = document.getElementById('sp-search-clear');
        const searchDropdown = document.getElementById('sp-search-dropdown');
        const searchSpinner = document.getElementById('sp-search-spinner');
        let searchTimeout = null;
        let highlightedIndex = -1;

        /* Build dropdown HTML from matched cards */
        function buildDropdown(query) {
            const q = query.toLowerCase().trim();
            if (!q) {
                searchDropdown.classList.remove('open');
                return;
            }

            const matches = allCards.filter(card => {
                const name = card.dataset.name || '';
                const brand = (card.dataset.brand || '').toLowerCase();
                const cat = (card.dataset.category || '').toLowerCase();
                return name.includes(q) || brand.includes(q) || cat.includes(q);
            });

            let html = '';

            if (matches.length > 0) {
                html += `<div class="sp-search-dropdown-header">Suggestions <span>${matches.length} found</span></div>`;

                matches.slice(0, 8).forEach((card, idx) => {
                    const img = card.querySelector('img');
                    const nameEl = card.querySelector('h3');
                    const priceEl = card.querySelector('.product-price');
                    const brandEl = card.querySelector('.product-info p');
                    const rawName = nameEl ? nameEl.textContent.trim() : 'Product';
                    const price = priceEl ? priceEl.textContent.trim() : '';
                    const brand = brandEl ? brandEl.textContent.trim() : '';
                    const imgSrc = img ? img.src : '';

                    // Highlight matching text
                    const regex = new RegExp(`(${q.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')})`, 'gi');
                    const highlightedName = rawName.replace(regex, '<mark>$1</mark>');

                    html += `
                    <div class="sp-search-item" data-index="${idx}" data-card-index="${allCards.indexOf(card)}">
                        <img src="${imgSrc}" alt="${rawName}" class="sp-search-item-img">
                        <div class="sp-search-item-info">
                            <div class="sp-search-item-name">${highlightedName}</div>
                            <div class="sp-search-item-meta">
                                <span class="sp-search-item-price">${price}</span>
                                <span class="sp-search-item-brand">${brand}</span>
                            </div>
                        </div>
                        <i class="fas fa-chevron-right sp-search-item-arrow"></i>
                    </div>`;
                });

                html += `<div class="sp-search-footer"><small>Press <kbd>Enter</kbd> to filter · <kbd>Esc</kbd> to close</small></div>`;
            } else {
                html += `<div class="sp-search-dropdown-header">Search Results</div>`;
                html += `<div class="sp-search-no-result">
                    <i class="fas fa-search"></i>
                    <p>No products found for "${q}"</p>
                </div>`;
            }

            searchDropdown.innerHTML = html;
            searchDropdown.classList.add('open');
            highlightedIndex = -1;

            // Attach click handlers to items
            searchDropdown.querySelectorAll('.sp-search-item').forEach(item => {
                item.addEventListener('click', function () {
                    const cardIdx = parseInt(this.dataset.cardIndex);
                    const card = allCards[cardIdx];
                    if (card) {
                        const nameEl = card.querySelector('h3');
                        searchInput.value = nameEl ? nameEl.textContent.trim() : '';
                        activeFilters.search = searchInput.value.toLowerCase();
                        applyFilters();
                        closeDropdown();
                        // Scroll to the card
                        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        card.style.animation = 'sp-card-pulse 0.8s ease';
                        setTimeout(() => card.style.animation = '', 800);
                    }
                });
            });
        }

        function closeDropdown() {
            searchDropdown.classList.remove('open');
            highlightedIndex = -1;
        }

        /* Live search with debounce */
        searchInput.addEventListener('input', function () {
            const val = this.value.trim();

            // Toggle clear button
            searchClear.classList.toggle('visible', val.length > 0);

            // Show spinner
            searchSpinner.classList.add('active');

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                searchSpinner.classList.remove('active');
                activeFilters.search = val.toLowerCase();
                applyFilters();
                buildDropdown(val);
            }, 250);
        });

        /* Clear button */
        searchClear.addEventListener('click', function () {
            searchInput.value = '';
            this.classList.remove('visible');
            activeFilters.search = '';
            applyFilters();
            closeDropdown();
            searchInput.focus();
        });

        /* Keyboard navigation */
        searchInput.addEventListener('keydown', function (e) {
            const items = searchDropdown.querySelectorAll('.sp-search-item');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                highlightedIndex = Math.min(highlightedIndex + 1, items.length - 1);
                updateHighlight(items);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                highlightedIndex = Math.max(highlightedIndex - 1, -1);
                updateHighlight(items);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (highlightedIndex >= 0 && items[highlightedIndex]) {
                    items[highlightedIndex].click();
                } else {
                    // Just apply the filter to grid
                    activeFilters.search = this.value.toLowerCase().trim();
                    applyFilters();
                    closeDropdown();
                }
            } else if (e.key === 'Escape') {
                closeDropdown();
                searchInput.blur();
            }
        });

        function updateHighlight(items) {
            items.forEach((item, i) => {
                item.classList.toggle('highlighted', i === highlightedIndex);
            });
            // scroll highlighted item into view
            if (highlightedIndex >= 0 && items[highlightedIndex]) {
                items[highlightedIndex].scrollIntoView({ block: 'nearest' });
            }
        }

        /* Close dropdown when clicking outside */
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.sp-search-wrapper')) {
                closeDropdown();
            }
        });

        /* Re-open dropdown on focus if there's text */
        searchInput.addEventListener('focus', function () {
            if (this.value.trim().length > 0) {
                buildDropdown(this.value);
            }
        });

        /* ── CATEGORY ── */
        document.querySelectorAll('#sp-cat-filters button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#sp-cat-filters button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilters.cat = this.dataset.cat;
                applyFilters();
            });
        });

        /* ── PRICE PRESET ── */
        document.querySelectorAll('#sp-price-filters button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#sp-price-filters button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilters.minPrice = parseInt(this.dataset.min);
                activeFilters.maxPrice = parseInt(this.dataset.max);
                document.getElementById('sp-price-min').value = '';
                document.getElementById('sp-price-max').value = '';
                applyFilters();
            });
        });

        /* ── PRICE CUSTOM ── */
        document.getElementById('sp-apply-price').addEventListener('click', function () {
            const min = parseInt(document.getElementById('sp-price-min').value) || 0;
            const max = parseInt(document.getElementById('sp-price-max').value) || 99999;
            activeFilters.minPrice = min;
            activeFilters.maxPrice = max;
            document.querySelectorAll('#sp-price-filters button').forEach(b => b.classList.remove('active'));
            applyFilters();
        });

        /* ── BRAND ── */
        document.querySelectorAll('#sp-brand-filters button').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('#sp-brand-filters button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilters.brand = this.dataset.brand;
                applyFilters();
            });
        });

        /* ── COLOR ── */
        document.querySelectorAll('.sp-color-sw').forEach(sw => {
            sw.addEventListener('click', function () {
                document.querySelectorAll('.sp-color-sw').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                activeFilters.color = this.dataset.color;
                applyFilters();
            });
        });

        /* ── APPLY ALL FILTERS (including search) ── */
        function applyFilters() {
            let count = 0;
            allCards.forEach(card => {
                const cat = card.dataset.category;
                const price = parseFloat(card.dataset.price);
                const brand = card.dataset.brand;
                const color = card.dataset.color;
                const name = card.dataset.name || '';

                const matchCat = activeFilters.cat === 'all' || cat === activeFilters.cat;
                const matchBrand = activeFilters.brand === 'all' || brand === activeFilters.brand;
                const matchColor = activeFilters.color === 'all' || color === activeFilters.color;
                const matchPrice = price >= activeFilters.minPrice && price <= activeFilters.maxPrice;
                const matchSearch = !activeFilters.search ||
                    name.includes(activeFilters.search) ||
                    (brand || '').toLowerCase().includes(activeFilters.search) ||
                    (cat || '').toLowerCase().includes(activeFilters.search);

                const show = matchCat && matchBrand && matchColor && matchPrice && matchSearch;
                card.style.display = show ? '' : 'none';
                if (show) count++;
            });

            const countEl = document.getElementById('sp-count');
            const visibleCountEl = document.getElementById('sp-visible-count');
            if (countEl) countEl.textContent = count;
            if (visibleCountEl) visibleCountEl.textContent = count;
            noResults.style.display = count === 0 ? 'block' : 'none';
        }

        /* ── SORT ── */
        document.getElementById('sp-sort').addEventListener('change', function () {
            const cards = Array.from(grid.querySelectorAll('.product-card'));
            cards.sort((a, b) => {
                const pA = parseFloat(a.dataset.price), pB = parseFloat(b.dataset.price);
                const nA = a.dataset.name, nB = b.dataset.name;
                switch (this.value) {
                    case 'price-low': return pA - pB;
                    case 'price-high': return pB - pA;
                    case 'name-asc': return nA.localeCompare(nB);
                    case 'name-desc': return nB.localeCompare(nA);
                    default: return 0;
                }
            });
            cards.forEach(c => grid.appendChild(c));
            grid.appendChild(noResults);
        });

        /* ── CLEAR ALL ── */
        function clearAll() {
            activeFilters = { cat: 'all', brand: 'all', color: 'all', minPrice: 0, maxPrice: 99999, search: '' };
            // Also clear search
            searchInput.value = '';
            searchClear.classList.remove('visible');
            closeDropdown();
            document.querySelectorAll('#sp-cat-filters button, #sp-price-filters button, #sp-brand-filters button').forEach((b, i) => {
                b.classList.toggle('active', b.dataset.cat === 'all' || b.dataset.brand === 'all' || (b.dataset.min === '0' && b.dataset.max === '99999'));
            });
            document.querySelectorAll('.sp-color-sw').forEach(s => s.classList.toggle('active', s.dataset.color === 'all'));
            document.getElementById('sp-price-min').value = '';
            document.getElementById('sp-price-max').value = '';
            // Reset active states properly
            document.querySelector('#sp-cat-filters button[data-cat=all]').classList.add('active');
            document.querySelector('#sp-price-filters button[data-min="0"][data-max="99999"]').classList.add('active');
            document.querySelector('#sp-brand-filters button[data-brand=all]').classList.add('active');
            applyFilters();
        }

        document.getElementById('sp-clear-all').addEventListener('click', clearAll);
        document.getElementById('sp-reset-link')?.addEventListener('click', function (e) { e.preventDefault(); clearAll(); });

        /* ── GRID / LIST VIEW ── */
        document.getElementById('grid-view-btn').addEventListener('click', function () {
            grid.classList.remove('list-view');
            this.classList.add('active');
            document.getElementById('list-view-btn').classList.remove('active');
        });

        document.getElementById('list-view-btn').addEventListener('click', function () {
            grid.classList.add('list-view');
            this.classList.add('active');
            document.getElementById('grid-view-btn').classList.remove('active');
        });

        /* ── MOBILE SIDEBAR ── */
        document.getElementById('sp-mobile-filter-btn').addEventListener('click', function () {
            const sb = document.getElementById('sp-sidebar');
            sb.classList.add('open');
            document.getElementById('sp-sidebar-close').style.display = 'block';
        });

        document.getElementById('sp-sidebar-close').addEventListener('click', function () {
            document.getElementById('sp-sidebar').classList.remove('open');
            this.style.display = 'none';
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>