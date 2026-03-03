<?php
/**
 * Fashion E-commerce Wishlist UI
 */

// Load Configuration and Database
require_once 'config/config.php';
require_once 'config/db.php';

// Include Header
include_once 'includes/header.php';
?>

<div class="cart-header" style="text-align: center;">
    <h1>Your Wishlist</h1>
    <p id="wishlist-summary">0 items in your wishlist</p>
</div>

<section class="section-padding" style="padding-top: 2rem;">
    <div class="product-grid" id="wishlist-grid" style="padding: 0 5%; min-height: 40vh;">
        <!-- JS will populate -->
    </div>
</section>

<script>
    function renderWishlist() {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const grid = document.getElementById('wishlist-grid');
        const summary = document.getElementById('wishlist-summary');

        grid.innerHTML = '';

        if (wishlist.length === 0) {
            grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 5rem 0;"><i class="far fa-heart" style="font-size: 4rem; color: #ddd; margin-bottom: 1.5rem;"></i><h2>Your wishlist is empty</h2><p style="color: #666; margin-top: 1rem;">Start adding your favorite styles!</p><a href="index.php" class="btn" style="margin-top: 2rem;">Discover Fashion</a></div>';
            summary.innerText = '0 items in your wishlist';
            return;
        }

        wishlist.forEach((item, index) => {
            const price = typeof item.price === 'number' ? item.price : 0;
            grid.innerHTML += `
                <div class="product-card">
                    <div class="product-image" style="position: relative;">
                        <img src="${item.image}" alt="${item.name}">
                        <button onclick="removeFromWishlist(${index})" style="position: absolute; top: 1rem; right: 1rem; background: white; border: none; width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #e74c3c; box-shadow: 0 4px 10px rgba(0,0,0,0.1); z-index: 10;"><i class="fas fa-trash-alt"></i></button>
                    </div>
                    <div class="product-info">
                        <h3>${item.name}</h3>
                        <div class="product-price">$${price.toFixed(2)}</div>
                        <button onclick="moveToCart(${index})" class="btn" style="width: 100%; margin-top: 1rem;">Move to Bag</button>
                    </div>
                </div>
            `;
        });

        summary.innerText = `${wishlist.length} item${wishlist.length > 1 ? 's' : ''} in your wishlist`;
    }

    function removeFromWishlist(index) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const itemName = wishlist[index] ? wishlist[index].name : 'Item';
        wishlist.splice(index, 1);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));

        // Use global utilities
        if (typeof initCartWishlist === 'function') initCartWishlist();
        if (typeof showToast === 'function') showToast(itemName + ' removed from wishlist');

        renderWishlist();
    }

    function moveToCart(index) {
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        if (wishlist[index]) {
            let item = wishlist[index];

            // Add to cart
            let existingCartItem = cart.find(cItem => cItem.id === item.id);
            if (existingCartItem) {
                existingCartItem.qty += 1;
            } else {
                item.qty = 1;
                cart.push(item);
            }
            localStorage.setItem('cart', JSON.stringify(cart));

            // Remove from wishlist
            wishlist.splice(index, 1);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));

            // Update UI using global utilities
            if (typeof initCartWishlist === 'function') initCartWishlist();
            if (typeof showToast === 'function') showToast(item.name + ' moved to your bag');

            renderWishlist();
        }
    }

    document.addEventListener('DOMContentLoaded', renderWishlist);
</script>

<?php
// Include Footer
include_once 'includes/footer.php';
?>