<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <h2>MODERN<span>CLOSET</span></h2>
            <p>Elevate your style with our curated collections of premium fashion from the world's most iconic brands.
            </p>
        </div>
        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="<?= base_url() ?>">Home</a></li>
                <li><a href="<?= base_url('shop.php') ?>">Shop</a></li>
                <li><a href="<?= base_url('categories.php') ?>">Categories</a></li>
                <li><a href="<?= base_url('about.php') ?>">About Us</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h3>Support</h3>
            <ul>
                <li><a href="<?= base_url('contact.php') ?>">Contact Us</a></li>
                <li><a href="<?= base_url('faq.php') ?>">FAQ</a></li>
                <li><a href="<?= base_url('shipping.php') ?>">Shipping Info</a></li>
                <li><a href="<?= base_url('returns.php') ?>">Returns Policy</a></li>
            </ul>
        </div>
        <div class="footer-links">
            <h3>Follow Us</h3>
            <div class="social-icons">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-tiktok"></i></a>
                <a href="#"><i class="fab fa-pinterest"></i></a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy;
            <?= date('Y') ?> MODERN CLOSET. All rights reserved.
        </p>
    </div>
</footer>

<!-- Slide-out Cart Drawer -->
<div class="cart-drawer-overlay" id="cart-drawer-overlay" onclick="closeCartDrawer()"></div>
<div class="cart-drawer" id="cart-drawer">
    <div class="cart-drawer-header">
        <h2>Your Bag (<span id="drawer-cart-count">0</span>)</h2>
        <button class="cart-drawer-close" onclick="closeCartDrawer()"><i class="fas fa-times"></i></button>
    </div>
    <div class="cart-drawer-body" id="cart-drawer-body">
        <!-- Rendered via JS -->
    </div>
    <div class="cart-drawer-footer">
        <div class="cart-drawer-subtotal">
            <span>Subtotal</span>
            <span id="cart-drawer-subtotal-val">$0.00</span>
        </div>
        <button class="cart-drawer-checkout-btn" onclick="window.location.href='checkout.php'">Checkout Now</button>
        <button class="cart-drawer-view-cart" onclick="window.location.href='cart.php'">View Bag</button>
    </div>
</div>

<!-- JS: main scripts -->
<script src="<?= base_url('assets/js/main.js?v=' . time()) ?>"></script>
</body>

</html>