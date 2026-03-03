/*
 * Fashion E-commerce Main Scripts
 */

// --- Global Utilities (Available to all pages) ---
function initCartWishlist() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    updateBadges(cart.length, wishlist.length);
}

function updateBadges(cartCount, wishlistCount) {
    const cartBadge = document.getElementById('cart-count');
    const wishBadge = document.getElementById('wishlist-count');

    if (cartBadge) {
        cartBadge.innerText = cartCount;
        cartBadge.style.display = cartCount > 0 ? 'flex' : 'none';
    }
    if (wishBadge) {
        wishBadge.innerText = wishlistCount;
        wishBadge.style.display = wishlistCount > 0 ? 'flex' : 'none';
    }
}

function showToast(message) {
    let toast = document.getElementById('toast-notification');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'toast-notification';
        toast.style.cssText = `
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #111;
            color: #fff;
            padding: 1rem 1.5rem;
            border-radius: 5px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-size: 0.9rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 10px;
        `;
        document.body.appendChild(toast);
    }

    toast.innerHTML = `<i class="fas fa-check-circle" style="color: #2ecc71;"></i> ${message}`;

    // Trigger animation
    setTimeout(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateY(0)';
    }, 10);

    // Hide after 3 seconds
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(20px)';
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function () {
    const mobileMenu = document.getElementById('mobile-menu');
    const navMenu = document.getElementById('nav-menu');

    if (mobileMenu && navMenu) {
        mobileMenu.addEventListener('click', function () {
            navMenu.classList.toggle('active');
            document.body.classList.toggle('menu-active');

            // Toggle between bars and times icons
            const icon = mobileMenu.querySelector('i');
            if (icon.classList.contains('fa-bars')) {
                icon.classList.replace('fa-bars', 'fa-times');
            } else {
                icon.classList.replace('fa-times', 'fa-bars');
            }
        });

        // Close menu when clicking outside
        document.body.addEventListener('click', function (e) {
            if (document.body.classList.contains('menu-active') && !navMenu.contains(e.target) && !mobileMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                document.body.classList.remove('menu-active');
                const icon = mobileMenu.querySelector('i');
                if (icon.classList.contains('fa-times')) {
                    icon.classList.replace('fa-times', 'fa-bars');
                }
            }
        });
    }

    // Shop Filter Sidebar Logic
    const filterBtn = document.getElementById('filter-btn');
    const shopSidebar = document.getElementById('shop-sidebar');
    const closeFilter = document.getElementById('close-filter');

    if (filterBtn && shopSidebar) {
        filterBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            shopSidebar.classList.add('active');
            document.body.classList.add('filter-active');
            if (closeFilter) closeFilter.style.display = 'block';
        });

        if (closeFilter) {
            closeFilter.addEventListener('click', function () {
                shopSidebar.classList.remove('active');
                document.body.classList.remove('filter-active');
            });
        }

        // Close on outside click
        document.body.addEventListener('click', function (e) {
            if (document.body.classList.contains('filter-active') && !shopSidebar.contains(e.target) && !filterBtn.contains(e.target)) {
                shopSidebar.classList.remove('active');
                document.body.classList.remove('filter-active');
            }
        });
    }

    // --- JS Filtering (Shop Page) ---
    const categoryLinks = document.querySelectorAll('#category-filters a');
    const priceLinks = document.querySelectorAll('#price-filters a');
    const brandLinks = document.querySelectorAll('#brand-filters a');
    const productCards = document.querySelectorAll('.product-card');
    const shopSearch = document.getElementById('shop-search');
    const pageTitle = document.getElementById('page-title');
    const resultCount = document.getElementById('result-count');
    const sortSelect = document.getElementById('sort-select');
    const productGrid = document.getElementById('product-grid');

    function filterProducts() {
        const activeCatLi = document.querySelector('#category-filters .active-cat');
        const activeCat = activeCatLi ? activeCatLi.querySelector('a').dataset.category : 'all';

        const activePriceLi = document.querySelector('#price-filters .active-cat');
        const minPrice = activePriceLi ? parseFloat(activePriceLi.querySelector('a').dataset.min) : 0;
        const maxPrice = activePriceLi ? parseFloat(activePriceLi.querySelector('a').dataset.max) : 999999;

        const activeBrandLi = document.querySelector('#brand-filters .active-cat');
        const activeBrand = activeBrandLi ? activeBrandLi.querySelector('a').dataset.brand : 'all';

        let visibleCount = 0;

        productCards.forEach(card => {
            const productCat = card.dataset.category;
            const productPrice = parseFloat(card.dataset.price);
            const productBrand = card.dataset.brand;

            const matchesCat = (activeCat === 'all' || productCat === activeCat);
            const matchesPrice = (productPrice >= minPrice && productPrice <= maxPrice);
            const matchesBrand = (activeBrand === 'all' || productBrand === activeBrand);

            if (matchesCat && matchesPrice && matchesBrand) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        if (resultCount) resultCount.innerText = `Showing ${visibleCount} results`;

        let emptyMsg = document.getElementById('empty-msg');
        if (visibleCount === 0 && productCards.length > 0) {
            if (!emptyMsg) {
                emptyMsg = document.createElement('div');
                emptyMsg.id = 'empty-msg';
                emptyMsg.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 5rem 0;';
                emptyMsg.innerHTML = '<i class="fas fa-search" style="font-size: 3rem; color: #ddd; margin-bottom: 1.5rem;"></i><p>No products found matching your filters.</p>';
                productGrid.appendChild(emptyMsg);
            }
        } else if (emptyMsg) {
            emptyMsg.remove();
        }
    }

    function sortProducts() {
        const sortBy = sortSelect.value;
        const cardsArray = Array.from(productCards);

        cardsArray.sort((a, b) => {
            const priceA = parseFloat(a.dataset.price);
            const priceB = parseFloat(b.dataset.price);
            const nameA = a.querySelector('h3').innerText.toLowerCase();
            const nameB = b.querySelector('h3').innerText.toLowerCase();

            if (sortBy === 'price-low') return priceA - priceB;
            if (sortBy === 'price-high') return priceB - priceA;
            if (sortBy === 'name-asc') return nameA.localeCompare(nameB);
            return 0;
        });

        cardsArray.forEach(card => productGrid.appendChild(card));
    }

    categoryLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('#category-filters li').forEach(li => li.classList.remove('active-cat'));
            this.parentElement.classList.add('active-cat');
            if (pageTitle) pageTitle.innerText = this.innerText.replace(/\(\d+\)/, '').trim();
            filterProducts();
            if (shopSidebar) {
                shopSidebar.classList.remove('active');
                document.body.classList.remove('filter-active');
            }
        });
    });

    priceLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('#price-filters li').forEach(li => li.classList.remove('active-cat'));
            this.parentElement.classList.add('active-cat');
            filterProducts();
            if (shopSidebar) {
                shopSidebar.classList.remove('active');
                document.body.classList.remove('filter-active');
            }
        });
    });

    brandLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelectorAll('#brand-filters li').forEach(li => li.classList.remove('active-cat'));
            this.parentElement.classList.add('active-cat');
            filterProducts();
            if (shopSidebar) {
                shopSidebar.classList.remove('active');
                document.body.classList.remove('filter-active');
            }
        });
    });

    if (sortSelect) sortSelect.addEventListener('change', sortProducts);

    // --- Global Click Listener for Actions ---
    document.body.addEventListener('click', function (e) {
        let actionBtn = e.target.closest('.action-btn') || e.target.closest('.btn');
        if (actionBtn && !actionBtn.closest('.qty-input')) {
            let container = actionBtn.closest('.product-card') || actionBtn.closest('.product-detail-container') || actionBtn.closest('.cart-product');

            if (!container) return;

            // Extract Data
            let nameEl = container.querySelector('h3') || container.querySelector('h1');
            let name = nameEl ? nameEl.innerText.trim() : 'Unknown Product';

            let priceEl = container.querySelector('.product-price') || container.querySelector('.price');
            let priceText = priceEl ? priceEl.innerText : '$0.00';
            let priceNum = parseFloat(priceText.replace(/[^0-9.-]+/g, ""));

            let imgEl = container.querySelector('img');
            let img = imgEl ? imgEl.src : '';

            let qtyInput = container.querySelector('.qty-input input');
            let qty = qtyInput ? parseInt(qtyInput.value) : 1;

            // Extract specific variations if chosen
            let activeSizeNode = container.querySelector('.size-btn.active');
            let activeColorNode = container.querySelector('.color-btn.active');

            // Set values if selected; for default list view, size will be empty and color 'Default'
            let size = activeSizeNode ? activeSizeNode.dataset.size : '';
            let color = activeColorNode ? activeColorNode.dataset.color : 'Default';

            let productObj = {
                id: name.toLowerCase().replace(/\s+/g, '-'),
                name: name,
                price: priceNum,
                image: img,
                size: size,
                color: color
            };

            // Add to Cart
            if (actionBtn.querySelector('.fa-shopping-bag') || actionBtn.innerText.includes('Add to Bag')) {
                e.preventDefault();
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Find existing item with VERY SAME id, size, and color to merge
                let existingItem = cart.find(item => item.id === productObj.id && (item.size || '') === (productObj.size || '') && (item.color || 'Default') === (productObj.color || 'Default'));

                if (existingItem) {
                    existingItem.qty += qty;
                } else {
                    productObj.qty = qty;
                    cart.push(productObj);
                }
                localStorage.setItem('cart', JSON.stringify(cart));
                initCartWishlist();
                if (typeof openCartDrawer === 'function') openCartDrawer();
            }

            // Add to Wishlist
            if (actionBtn.querySelector('.fa-heart')) {
                e.preventDefault();
                let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                let isExist = wishlist.find(item => item.id === productObj.id);
                if (!isExist) {
                    wishlist.push(productObj);
                    localStorage.setItem('wishlist', JSON.stringify(wishlist));

                    let icon = actionBtn.querySelector('.fa-heart');
                    if (icon.classList.contains('far')) {
                        icon.classList.replace('far', 'fas');
                        icon.style.color = '#e74c3c';
                    }
                    showToast(productObj.name + ' saved to wishlist');
                } else {
                    showToast(productObj.name + ' is already in wishlist');
                }
                initCartWishlist();
            }
        }
    });

    // Initialize counts on page load
    initCartWishlist();
});

// --- Cart Drawer Logic ---
function openCartDrawer() {
    const overlay = document.getElementById('cart-drawer-overlay');
    const drawer = document.getElementById('cart-drawer');
    if (overlay && drawer) {
        overlay.classList.add('active');
        drawer.classList.add('active');
        document.body.style.overflow = 'hidden';
        renderCartDrawer();
    }
}

function closeCartDrawer() {
    const overlay = document.getElementById('cart-drawer-overlay');
    const drawer = document.getElementById('cart-drawer');
    if (overlay && drawer) {
        overlay.classList.remove('active');
        drawer.classList.remove('active');
        document.body.style.overflow = '';
    }
}

function renderCartDrawer() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const bodyContainer = document.getElementById('cart-drawer-body');
    const headerCount = document.getElementById('drawer-cart-count');
    const subtotalText = document.getElementById('cart-drawer-subtotal-val');

    if (!bodyContainer) return;

    let subtotal = 0;
    bodyContainer.innerHTML = '';

    if (cart.length === 0) {
        bodyContainer.innerHTML = `
            <div class="cart-drawer-empty">
                <i class="fas fa-shopping-bag"></i>
                <p>Your bag is currently empty.</p>
                <button class="btn btn-outline" onclick="closeCartDrawer(); window.location.href='index.php'" style="margin-top:20px;width:100%">Shop Now</button>
            </div>
        `;
        headerCount.innerText = '0';
        subtotalText.innerText = '$0.00';
        return;
    }

    let totalItems = 0;
    cart.forEach((item, index) => {
        totalItems += item.qty;
        subtotal += item.price * item.qty;

        let optionStr = [];
        if (item.size) optionStr.push('Size: ' + item.size);
        if (item.color && item.color !== 'Default') optionStr.push('Color: ' + item.color);

        bodyContainer.innerHTML += `
            <div class="cart-drawer-item">
                <img src="${item.image}" alt="${item.name}">
                <div class="cart-drawer-item-details">
                    <div>
                        <span class="cart-drawer-item-title">${item.name}</span>
                        <div class="cart-drawer-item-options">${optionStr.join(' | ')}</div>
                        <div class="cart-drawer-item-price">$${(item.price * item.qty).toFixed(2)}</div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:flex-end; margin-top:5px;">
                        <div class="cart-drawer-qty-control">
                            <button onclick="drawerChangeQty(${index}, -1)"><i class="fas fa-minus"></i></button>
                            <input type="text" value="${item.qty}" readonly>
                            <button onclick="drawerChangeQty(${index}, 1)"><i class="fas fa-plus"></i></button>
                        </div>
                        <button class="cart-drawer-remove" onclick="drawerRemoveItem(${index})">Remove</button>
                    </div>
                </div>
            </div>
        `;
    });

    headerCount.innerText = totalItems;
    subtotalText.innerText = '$' + subtotal.toFixed(2);

    // Also sync the global badges
    updateBadges(cart.length, JSON.parse(localStorage.getItem('wishlist'))?.length || 0);
}

function drawerChangeQty(index, delta) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart[index]) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) {
            cart.splice(index, 1);
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCartDrawer();

        // If we happen to be on cart.php, it's nice to sync that UI too
        if (typeof renderCart === 'function') {
            renderCart();
        }
    }
}

function drawerRemoveItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCartDrawer();

    if (typeof renderCart === 'function') {
        renderCart();
    }
}
