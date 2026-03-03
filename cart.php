<?php
/**
 * Fashion E-commerce Shopping Cart UI - Modern Redesign
 */

// Load Configuration and Database
require_once 'config/config.php';
require_once 'config/db.php';

// Include Header
include_once 'includes/header.php';
?>

<style>
    /* Modern Cart Styles */
    :root {
        --cart-blue: #4461F2;
        --cart-gold: #d4af37;
        --cart-bg: #F9FAFB;
        --cart-border: #E5E7EB;
        --cart-text: #1F2937;
        --cart-muted: #6B7280;
    }

    body {
        background-color: var(--cart-bg);
    }

    .cart-page-wrapper {
        max-width: 1300px;
        margin: 0 auto;
        padding: 4rem 2rem;
    }

    .cart-page-header {
        display: flex;
        align-items: baseline;
        gap: 1.5rem;
        margin-bottom: 3rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--cart-border);
    }

    .cart-page-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--cart-text);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .cart-page-header span {
        font-size: 1.1rem;
        color: var(--cart-muted);
        font-weight: 500;
    }

    .cart-grid {
        display: grid;
        grid-template-columns: 1fr 420px;
        gap: 3rem;
        align-items: start;
    }

    /* Cart Items List */
    .cart-items-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .cart-card {
        background: #fff;
        border-radius: 16px;
        padding: 1.5rem;
        display: flex;
        gap: 2rem;
        border: 1px solid var(--cart-border);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }

    .cart-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .cart-card-img {
        width: 140px;
        height: 180px;
        object-fit: cover;
        border-radius: 12px;
        background: #f4f4f5;
    }

    .cart-card-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .cart-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .cart-card-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: var(--cart-text);
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        letter-spacing: 0.5px;
    }

    .cart-card-price {
        font-size: 1.25rem;
        font-weight: 900;
        color: var(--cart-blue);
    }

    /* Options & Variations */
    .cart-options-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .custom-select-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }

    .custom-select-wrapper label {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--cart-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-select {
        appearance: none;
        background: #f9fafb;
        border: 1px solid var(--cart-border);
        padding: 0.6rem 2rem 0.6rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        color: var(--cart-text);
        font-weight: 600;
        cursor: pointer;
        /* Custom arrow icon */
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2214%22%20height%3D%228%22%20viewBox%3D%220%200%2014%208%22%3E%3Cpath%20fill%3D%22%236B7280%22%20d%3D%22M7%208L0%201.27273L1.33333%200L7%205.45455L12.6667%200L14%201.27273L7%208Z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 0.8rem center;
        background-size: 10px;
        transition: all 0.2s;
    }

    .custom-select:hover {
        border-color: #cbd5e1;
    }

    .custom-select:focus {
        outline: none;
        border-color: var(--cart-blue);
        box-shadow: 0 0 0 3px rgba(68, 97, 242, 0.1);
    }

    /* Bottom Actions of Card */
    .cart-card-bottom {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 1.5rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: #f9fafb;
        border: 1px solid var(--cart-border);
        border-radius: 8px;
        overflow: hidden;
    }

    .qty-control button {
        width: 36px;
        height: 36px;
        background: transparent;
        border: none;
        color: var(--cart-text);
        font-size: 1rem;
        cursor: pointer;
        display: grid;
        place-items: center;
        transition: background 0.2s;
    }

    .qty-control button:hover {
        background: #e5e7eb;
    }

    .qty-control input {
        width: 40px;
        height: 36px;
        background: transparent;
        border: none;
        text-align: center;
        font-weight: 700;
        font-size: 1rem;
        pointer-events: none;
    }

    .action-links {
        display: flex;
        gap: 1rem;
    }

    .action-badge {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0.5rem 0.8rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }

    .btn-remove {
        background: #fef2f2;
        color: #ef4444;
    }
    .btn-remove:hover { background: #fee2e2; }

    .btn-duplicate {
        background: #f0fdf4;
        color: #10b981;
    }
    .btn-duplicate:hover { background: #dcfce7; }


    /* Shopping Actions (Below list) */
    .shopping-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 3rem;
    }

    .btn-secondary {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 700;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.2s;
        border: 2px solid var(--cart-border);
        background: #fff;
        color: var(--cart-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-secondary:hover {
        border-color: var(--cart-text);
    }

    /* Summary Sidebar */
    .cart-summary {
        background: #fff;
        padding: 2.5rem;
        border-radius: 24px;
        border: 1px solid var(--cart-border);
        position: sticky;
        top: 100px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .cart-summary h2 {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: var(--cart-text);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1.2rem;
        font-size: 1rem;
        color: var(--cart-muted);
        font-weight: 500;
    }

    .summary-line.highlight {
        color: #10b981;
    }

    .summary-line span:last-child {
        color: var(--cart-text);
        font-weight: 700;
    }
    
    .summary-line.highlight span:last-child {
        color: #10b981;
    }

    .promo-area {
        margin: 2rem 0;
        border-top: 1px solid var(--cart-border);
        border-bottom: 1px solid var(--cart-border);
        padding: 1.5rem 0;
    }

    .promo-input-group {
        display: flex;
        gap: 0.5rem;
    }

    .promo-input-group input {
        flex: 1;
        padding: 0.8rem 1rem;
        border: 1px solid var(--cart-border);
        border-radius: 8px;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .promo-input-group input:focus {
        border-color: var(--cart-blue);
    }

    .promo-input-group button {
        padding: 0 1.5rem;
        background: var(--cart-text);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }
    .promo-input-group button:hover {
        background: #000;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-top: 0.5rem;
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--cart-text);
    }
    
    .summary-total span:last-child {
        color: var(--cart-blue);
    }

    .btn-checkout {
        width: 100%;
        padding: 1.2rem;
        background: var(--cart-blue);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        margin-top: 2.5rem;
        transition: all 0.2s;
        box-shadow: 0 4px 14px rgba(68, 97, 242, 0.3);
    }

    .btn-checkout:hover {
        background: #3651d1;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(68, 97, 242, 0.4);
    }

    .trust-badges {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.85rem;
        color: var(--cart-muted);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .trust-badges i {
        color: #10b981;
        font-size: 1rem;
        margin-right: 4px;
    }

    /* Mobile Responsiveness */
    @media (max-width: 1024px) {
        .cart-grid {
            grid-template-columns: 1fr;
            gap: 3rem;
        }
        .cart-summary {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .cart-page-wrapper {
            padding: 2rem 1rem 5rem;
        }

        .cart-page-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
            margin-bottom: 2rem;
        }

        .cart-page-header h1 {
            font-size: 2rem;
        }

        .cart-card {
            flex-direction: column;
            gap: 1.5rem;
            padding: 1.2rem;
        }

        .cart-card-img {
            width: 100%;
            height: 250px;
        }

        .cart-card-top {
            flex-direction: column;
        }

        .cart-card-price {
            margin-top: 0.5rem;
        }

        .cart-card-bottom {
            flex-direction: column;
            align-items: stretch;
            gap: 1.5rem;
        }

        .action-links {
            justify-content: space-between;
        }
        
        .action-badge {
            flex: 1;
            justify-content: center;
            padding: 0.8rem;
        }

        .shopping-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .shopping-actions button, 
        .shopping-actions a {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="cart-page-wrapper" id="cart-page-container">
    
    <div class="cart-page-header">
        <h1>Your Shopping Bag</h1>
        <span id="header-item-count">Loading items...</span>
    </div>

    <div class="cart-grid">
        <!-- Left: Cart Items -->
        <div class="cart-left">
            <div class="cart-items-container" id="cart-container-list">
                <!-- JS will populate -->
            </div>

            <!-- Actions -->
            <div class="shopping-actions">
                <a href="<?= base_url() ?>" class="btn-secondary"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                <button class="btn-secondary" onclick="renderCart()"><i class="fas fa-sync-alt"></i> Refresh Bag</button>
            </div>
        </div>

        <!-- Right: Summary -->
        <aside class="cart-summary">
            <h2>Order Summary</h2>
            
            <div class="summary-line">
                <span>Subtotal</span>
                <span id="summary-subtotal">$0.00</span>
            </div>
            
            <div class="summary-line highlight" id="discount-row" style="display: none;">
                <span>Discount Applied</span>
                <span id="summary-discount">-$0.00</span>
            </div>
            
            <div class="summary-line">
                <span>Shipping</span>
                <span style="color: #10b981;">Free</span>
            </div>
            
            <div class="promo-area">
                <div class="promo-input-group">
                    <input type="text" id="promo-code-input" placeholder="Promo code (e.g. VOGUE20)">
                    <button onclick="applyPromo()">Apply</button>
                </div>
            </div>

            <div class="summary-total">
                <span>Total</span>
                <span id="summary-total">$0.00</span>
            </div>

            <button class="btn-checkout" onclick="goToCheckout()">Proceed To Checkout</button>

            <div class="trust-badges">
                <div><i class="fas fa-shield-alt"></i> Secure Encrypted Checkout</div>
                <div style="font-size: 0.75rem; margin-top: 5px;">We accept all major credit cards & local payments.</div>
            </div>
        </aside>
    </div>
</div>

<script>
    let currentDiscountRate = 0;
    let currentSubtotal = 0;

    function renderCart() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const container = document.getElementById('cart-container-list');
        const headerCount = document.getElementById('header-item-count');
        currentSubtotal = 0;

        container.innerHTML = '';

        if (cart.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 5rem 2rem; background: #fff; border-radius: 16px; border: 1px dashed #d1d5db;">
                    <i class="fas fa-shopping-bag" style="font-size: 3rem; color: #d1d5db; margin-bottom: 1rem;"></i>
                    <h3 style="font-size: 1.5rem; color: #374151; margin-bottom: 0.5rem;">Your bag is empty</h3>
                    <p style="color: #6b7280;">Looks like you haven't added anything to your cart yet.</p>
                </div>
            `;
            headerCount.innerText = '(0 Items)';
            updateSummary();
            return;
        }

        let totalItems = 0;

        cart.forEach((item, index) => {
            totalItems += item.qty;
            const itemTotal = item.price * item.qty;
            currentSubtotal += itemTotal;

            // Detect if item is clothing or watch for specific options
            const isClothing = /shirt|hoodie|dress|trench|coat|pant|top|suit/i.test(item.name);
            const isWatch = /watch/i.test(item.name);

            // Default values if not set
            const size = item.size || (isClothing ? 'M' : '');
            const color = item.color || 'Default';

            let optionsHtml = '';
            if (isClothing) {
                optionsHtml += `
                    <div class="custom-select-wrapper">
                        <label>Size</label>
                        <select class="custom-select" onchange="updateItemOption(${index}, 'size', this.value)">
                            <option value="S" ${size === 'S' ? 'selected' : ''}>S</option>
                            <option value="M" ${size === 'M' ? 'selected' : ''}>M</option>
                            <option value="L" ${size === 'L' ? 'selected' : ''}>L</option>
                            <option value="XL" ${size === 'XL' ? 'selected' : ''}>XL</option>
                            <option value="XXL" ${size === 'XXL' ? 'selected' : ''}>XXL</option>
                        </select>
                    </div>
                `;
            }

            optionsHtml += `
                <div class="custom-select-wrapper">
                    <label>${isWatch ? 'Strap ' : ''}Color</label>
                    <select class="custom-select" onchange="updateItemOption(${index}, 'color', this.value)">
                        <option value="Default" ${color === 'Default' ? 'selected' : ''}>Original</option>
                        <option value="Black" ${color === 'Black' ? 'selected' : ''}>Midnight Black</option>
                        <option value="White" ${color === 'White' ? 'selected' : ''}>Classic White</option>
                        <option value="Brown" ${color === 'Brown' ? 'selected' : ''}>Deep Brown</option>
                        <option value="Navy" ${color === 'Navy' ? 'selected' : ''}>Navy Blue</option>
                    </select>
                </div>
            `;

            container.innerHTML += `
                <div class="cart-card">
                    <img src="${item.image}" alt="${item.name}" class="cart-card-img">
                    <div class="cart-card-content">
                        <div>
                            <div class="cart-card-top">
                                <h3 class="cart-card-title">${item.name}</h3>
                                <div class="cart-card-price">$${(item.price * item.qty).toFixed(2)}</div>
                            </div>
                            
                            <div class="cart-options-grid">
                                ${optionsHtml}
                            </div>
                        </div>

                        <div class="cart-card-bottom">
                            <div class="qty-control">
                                <button onclick="changeCartQty(${index}, -1)"><i class="fas fa-minus"></i></button>
                                <input type="text" value="${item.qty}" readonly>
                                <button onclick="changeCartQty(${index}, 1)"><i class="fas fa-plus"></i></button>
                            </div>
                            
                            <div class="action-links">
                                <button class="action-badge btn-remove" onclick="removeFromCart(${index})">
                                    <i class="fas fa-trash-alt"></i> <span class="hide-on-mobile">Remove</span>
                                </button>
                                <button class="action-badge btn-duplicate" onclick="duplicateItem(${index})">
                                    <i class="fas fa-copy"></i> Add Variation
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        headerCount.innerText = `(${totalItems} Items)`;
        updateSummary();
    }

    function updateSummary() {
        document.getElementById('summary-subtotal').innerText = '$' + currentSubtotal.toFixed(2);

        let discountAmount = currentSubtotal * currentDiscountRate;
        let total = currentSubtotal - discountAmount;

        const discountRow = document.getElementById('discount-row');
        if (currentDiscountRate > 0) {
            discountRow.style.display = 'flex';
            document.getElementById('summary-discount').innerText = '-$' + discountAmount.toFixed(2);
        } else {
            discountRow.style.display = 'none';
        }

        document.getElementById('summary-total').innerText = '$' + total.toFixed(2);

        // Update header navbar badge dynamically
        const cartBadge = document.getElementById('cart-count');
        if (cartBadge) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            cartBadge.innerText = cart.length;
            cartBadge.style.display = cart.length > 0 ? 'flex' : 'none';
        }
    }

    function applyPromo() {
        const input = document.getElementById('promo-code-input').value.trim().toUpperCase();
        if (input === 'VOGUE20') {
            currentDiscountRate = 0.20; // 20% off
            if (window.showToast) {
                showToast('Promo code applied! 20% off.');
            }
        } else if (input === '') {
            currentDiscountRate = 0; // Remove discount if cleared
        } else {
            alert('Invalid promo code');
            currentDiscountRate = 0;
        }
        updateSummary();
    }

    function changeCartQty(index, delta) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart[index]) {
            cart[index].qty += delta;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();
        }
    }

    function removeFromCart(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
    }

    function updateItemOption(index, option, value) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (!cart[index]) return;

        // Update the item
        cart[index][option] = value;

        // Ensure defaults are set for comparison
        const isClothing = /shirt|hoodie|dress|trench|coat|pant|top|suit/i.test(cart[index].name);
        if (!cart[index].size && isClothing) cart[index].size = 'M';
        if (!cart[index].color) cart[index].color = 'Default';

        // Check if this change makes it identical to ANOTHER item in the cart
        let duplicateIndex = cart.findIndex((item, idx) =>
            idx !== index &&
            item.id === cart[index].id &&
            (item.size || (isClothing ? 'M' : '')) === cart[index].size &&
            (item.color || 'Default') === cart[index].color
        );

        if (duplicateIndex !== -1) {
            // Merge quantities
            cart[duplicateIndex].qty += cart[index].qty;
            // Remove the current one
            cart.splice(index, 1);
            if (window.showToast) showToast(`Combined identical items (${value})`);
        } else {
            if (window.showToast) showToast(`Updated ${option} to ${value}`);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart(); // Re-render to show merge or update
    }

    function duplicateItem(index) {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (!cart[index]) return;

        // Clone the item
        let newItem = { ...cart[index] };
        newItem.qty = 1; // Start with 1 qty for new variation

        // If original had more than 1, decrease it. 
        if (cart[index].qty > 1) {
            cart[index].qty -= 1;
        }

        // Add to cart as a new entry (using splice to place it next to original)
        cart.splice(index + 1, 0, newItem);

        localStorage.setItem('cart', JSON.stringify(cart));
        if (window.showToast) showToast(`Added new variation for ${newItem.name}`);
        renderCart();
    }

    function goToCheckout() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }
        localStorage.setItem('discountRate', currentDiscountRate);
        window.location.href = 'checkout.php';
    }

    document.addEventListener('DOMContentLoaded', renderCart);
</script>

<?php
// Include Footer
include_once 'includes/footer.php';
?>