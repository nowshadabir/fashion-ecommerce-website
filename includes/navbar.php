<div class="announcement-bar">
    Limited Time: Use code <strong>"VOGUE20"</strong> for 20% off all collections!
</div>
<header class="navbar">
    <div class="navbar-brand">
        <a href="<?= base_url() ?>">MODERN<span>CLOSET</span></a>
    </div>
    <div class="menu-toggle" id="mobile-menu">
        <i class="fas fa-bars"></i>
    </div>
    <nav class="nav-links" id="nav-menu">
        <a href="<?= base_url() ?>">HOME</a>
        <a href="shop.php">SHOP</a>
        <a href="coupons.php">COUPONS</a>
        <a href="categories.php">CATEGORIES</a>
        <a href="about.php">ABOUT</a>
        <a href="contact.php">CONTACT</a>
    </nav>
    <div class="nav-icons" style="display: flex; gap: 1.5rem; align-items: center;">
        <?php if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in']): ?>
            <div class="nav-user-menu" style="position:relative;">
                <button id="nav-user-btn" onclick="toggleUserMenu()"
                    style="background:none; border:none; cursor:pointer; display:flex; align-items:center; gap:0.5rem; color:var(--primary); font-family:inherit;">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['customer_name'] ?? 'U') ?>&background=111111&color=d4af37&size=60&bold=true&font-size=0.4"
                        style="width:30px; height:30px; border-radius:50%; border:2px solid var(--accent);" alt="User">
                    <span
                        style="font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:1px; max-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"><?= htmlspecialchars(ucfirst($_SESSION['customer_name'] ?? 'Account')) ?></span>
                    <i class="fas fa-chevron-down" style="font-size:0.6rem;"></i>
                </button>
                <div id="nav-user-dropdown"
                    style="display:none; position:absolute; top:calc(100% + 12px); right:0; min-width:200px; background:#fff; box-shadow:0 8px 30px rgba(0,0,0,0.12); border:1px solid #eee; z-index:3000; border-top:3px solid var(--accent);">
                    <div style="padding:1rem 1.2rem; border-bottom:1px solid #f5f5f5;">
                        <p style="font-size:0.8rem; font-weight:700;">
                            <?= htmlspecialchars(ucwords($_SESSION['customer_name'] ?? '')) ?></p>
                        <p style="font-size:0.72rem; color:#aaa;"><?= htmlspecialchars($_SESSION['customer_email'] ?? '') ?>
                        </p>
                    </div>
                    <a href="<?= base_url('customer/dashboard.php') ?>"
                        style="display:flex; align-items:center; gap:0.7rem; padding:0.85rem 1.2rem; font-size:0.85rem; color:#333; border-bottom:1px solid #f5f5f5; transition:background 0.2s;"
                        onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''"><i
                            class="fas fa-th-large" style="width:16px; color:var(--accent);"></i> Dashboard</a>
                    <a href="<?= base_url('customer/dashboard.php?tab=orders') ?>"
                        style="display:flex; align-items:center; gap:0.7rem; padding:0.85rem 1.2rem; font-size:0.85rem; color:#333; border-bottom:1px solid #f5f5f5; transition:background 0.2s;"
                        onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''"><i
                            class="fas fa-box" style="width:16px; color:var(--accent);"></i> My Orders</a>
                    <a href="<?= base_url('customer/dashboard.php?tab=wishlist') ?>"
                        style="display:flex; align-items:center; gap:0.7rem; padding:0.85rem 1.2rem; font-size:0.85rem; color:#333; border-bottom:1px solid #f5f5f5; transition:background 0.2s;"
                        onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background=''"><i
                            class="far fa-heart" style="width:16px; color:var(--accent);"></i> Wishlist</a>
                    <a href="<?= base_url('customer/dashboard.php?logout=1') ?>"
                        style="display:flex; align-items:center; gap:0.7rem; padding:0.85rem 1.2rem; font-size:0.85rem; color:#e74c3c;"
                        onmouseover="this.style.background='#fff5f5'" onmouseout="this.style.background=''"><i
                            class="fas fa-sign-out-alt" style="width:16px;"></i> Sign Out</a>
                </div>
            </div>
            <script>
                function toggleUserMenu() {
                    const d = document.getElementById('nav-user-dropdown');
                    d.style.display = d.style.display === 'none' ? 'block' : 'none';
                }
                document.addEventListener('click', function (e) {
                    const btn = document.getElementById('nav-user-btn');
                    const dd = document.getElementById('nav-user-dropdown');
                    if (dd && btn && !btn.contains(e.target)) dd.style.display = 'none';
                });
            </script>
        <?php else: ?>
            <a href="<?= base_url('login.php') ?>"
                style="display:flex; align-items:center; gap:0.4rem; font-size:0.78rem; font-weight:700; text-transform:uppercase; letter-spacing:1px;"
                title="Sign In">
                <i class="fas fa-user-circle" style="font-size:1.3rem;"></i>
            </a>
        <?php endif; ?>
        <a href="<?= base_url('wishlist.php') ?>" style="position: relative;" id="nav-wishlist">
            <i class="far fa-heart"></i>
            <span class="badge" id="wishlist-count"
                style="position: absolute; top: -8px; right: -10px; background: #e74c3c; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: bold; display: none;">0</span>
        </a>
        <a href="#" onclick="openCartDrawer(); return false;" style="position: relative;" id="nav-cart">
            <i class="fas fa-shopping-bag"></i>
            <span class="badge" id="cart-count"
                style="position: absolute; top: -8px; right: -10px; background: var(--primary); color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; font-weight: bold; display: none;">0</span>
        </a>
    </div>
</header>