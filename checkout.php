<?php
/**
 * Fashion E-commerce Checkout UI - Redesigned based on User Example
 */

// Load Configuration and Database
require_once 'config/config.php';
require_once 'config/db.php';

// Include Header
include_once 'includes/header.php';
?>

<style>
    :root {
        --checkout-blue: #4461F2;
        --checkout-bg: #F9FAFB;
        --checkout-border: #E5E7EB;
        --checkout-text: #1F2937;
        --checkout-muted: #6B7280;
    }

    body {
        background-color: white;
        color: var(--checkout-text);
    }

    .checkout-wrapper {
        max-width: 1300px;
        margin: 0 auto;
        padding: 4rem 2rem;
        display: grid;
        grid-template-columns: 1fr 450px;
        gap: 4rem;
    }

    .checkout-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 2.5rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #f3f4f6;
    }

    /* Form Styles */
    .checkout-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .full-width {
        grid-column: span 2;
    }

    .form-group-label {
        font-weight: 600;
        font-size: 0.95rem;
        margin-bottom: 0.6rem;
        display: flex;
        align-items: center;
        gap: 4px;
        color: #374151;
    }

    .required-star {
        color: #EF4444;
    }

    .input-field {
        width: 100%;
        padding: 0.9rem 1.2rem;
        border: 1px solid var(--checkout-border);
        border-radius: 10px;
        font-size: 1rem;
        color: var(--checkout-text);
        transition: all 0.2s;
        background: #fdfdfd;
    }

    .input-field:focus {
        outline: none;
        border-color: var(--checkout-blue);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(68, 97, 242, 0.1);
    }

    .phone-input-wrapper {
        display: flex;
        border: 1px solid var(--checkout-border);
        border-radius: 10px;
        overflow: hidden;
        background: #fdfdfd;
    }

    .country-code {
        background: #F3F4F6;
        padding: 0 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        border-right: 1px solid var(--checkout-border);
        font-weight: 600;
        color: #4B5563;
    }

    .phone-input-wrapper input {
        border: none;
        flex: 1;
        padding: 0.9rem 1.2rem;
        font-size: 1rem;
        background: transparent;
    }

    .phone-input-wrapper input:focus {
        outline: none;
    }

    /* Payment Methods */
    .payment-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .payment-option {
        border: 1px solid var(--checkout-border);
        padding: 1rem;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s;
        background: #fff;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .payment-option img {
        height: 25px;
        object-fit: contain;
    }

    .payment-option i {
        font-size: 1.5rem;
        color: #10B981;
    }

    .payment-option:hover {
        border-color: var(--checkout-blue);
        background: #F0F4FF;
    }

    .payment-option.active {
        border-color: var(--checkout-blue);
        background: #F0F4FF;
        box-shadow: 0 0 0 2px var(--checkout-blue);
    }

    /* Order Summary Side */
    .order-sidebar {
        background: #fafbfc;
        padding: 2.5rem;
        border-radius: 24px;
        border: 1px solid #edf2f7;
        position: sticky;
        top: 120px;
        height: fit-content;
    }

    .review-cart-title {
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 2rem;
        color: #1a202c;
    }

    .cart-item-row {
        display: flex;
        gap: 1.2rem;
        margin-bottom: 1.8rem;
        padding-bottom: 1.8rem;
        border-bottom: 1px solid #edf2f7;
    }

    .cart-item-row:last-of-type {
        border-bottom: none;
        margin-bottom: 1rem;
    }

    .cart-item-img {
        width: 75px;
        height: 75px;
        border-radius: 12px;
        object-fit: cover;
        background: #fff;
        border: 1px solid #eee;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-info h4 {
        font-size: 0.95rem;
        font-weight: 700;
        margin-bottom: 0.3rem;
        color: #1a202c;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .cart-item-info p {
        color: var(--checkout-muted);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .cart-item-price {
        font-weight: 800;
        font-size: 1rem;
        color: var(--checkout-blue);
    }

    .discount-box {
        display: flex;
        gap: 0;
        margin: 2rem 0;
        background: #fff;
        padding: 4px;
        border-radius: 12px;
        border: 1px solid var(--checkout-border);
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    .discount-box input {
        flex: 1;
        background: transparent;
        border: none;
        padding: 0.8rem 1rem;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .apply-btn {
        background: #f3f4f6 !important;
        border: 1px solid #e5e7eb !important;
        color: #111 !important;
        font-weight: 700;
        padding: 0 1.5rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.85rem;
    }

    .apply-btn:hover {
        background: #e5e7eb !important;
    }

    /* Totals */
    .totals-area {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        margin: 2rem 0;
        padding: 1.5rem 0;
        border-top: 2px solid #edf2f7;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        font-weight: 600;
        color: #4a5568;
    }

    .total-row span:last-child {
        color: #1a202c;
    }

    .total-row.main-total {
        margin-top: 0.5rem;
        font-size: 1.4rem;
        font-weight: 900;
        color: #1a202c;
        border-top: 2px solid #1a202c;
        padding-top: 1.5rem;
    }

    .total-row.main-total span:last-child {
        color: var(--checkout-blue);
    }

    .pay-button {
        width: 100%;
        background: var(--checkout-blue);
        color: white;
        border: none;
        padding: 1.4rem;
        border-radius: 16px;
        font-size: 1.15rem;
        font-weight: 800;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 2rem;
        box-shadow: 0 10px 15px -3px rgba(68, 97, 242, 0.2);
    }

    .pay-button:hover {
        background: #3651d1;
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(68, 97, 242, 0.25);
    }

    .security-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-weight: 800;
        font-size: 0.9rem;
        margin-bottom: 1rem;
        color: #059669;
    }

    .security-note {
        text-align: center;
        color: #718096;
        font-size: 0.8rem;
        line-height: 1.6;
        padding: 0 0.5rem;
    }

    @media (max-width: 992px) {
        .checkout-wrapper {
            grid-template-columns: 1fr;
        }

        .checkout-form {
            grid-template-columns: 1fr;
        }

        .full-width {
            grid-column: span 1;
        }
    }

    /* Success Modal */
    #order-success-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 10000;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        padding: 3rem;
        border-radius: 24px;
        text-align: center;
        max-width: 480px;
        width: 90%;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    }
</style>

<!-- Order Success Modal -->
<div id="order-success-modal">
    <div class="modal-content">
        <i class="fas fa-check-circle" style="font-size: 5rem; color: #10B981; margin-bottom: 1.5rem;"></i>
        <h2 style="font-size: 2rem; margin-bottom: 0.8rem;">Order Placed Successfully!</h2>
        <p style="color: #6B7280; margin-bottom: 2rem; font-size: 1.1rem;">Thank you for your order. We will contact you soon for confirmation.</p>
        <div style="background: #F3F4F6; padding: 1.5rem; border-radius: 16px; margin-bottom: 2rem;">
            <p style="font-size: 0.95rem; color: #6B7280; margin-bottom: 0.4rem;">Order Tracking ID</p>
            <p id="tracking-number" style="font-size: 1.4rem; font-weight: 800; letter-spacing: 2px; color: var(--checkout-blue);">#ORD-000000</p>
        </div>
        <button onclick="window.location.href='index.php'" class="btn" style="width: 100%;">Continue Shopping</button>
    </div>
</div>

<div class="checkout-wrapper">
    <!-- Left: Shipping Information -->
    <div class="shipping-side">
        <h1 class="checkout-title">Checkout</h1>
        
        <h2 class="section-title">Shipping Information</h2>

        <form class="checkout-form" id="checkout-form">
            <div class="form-group">
                <label class="form-group-label">Full name <span class="required-star">*</span></label>
                <input type="text" class="input-field" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label class="form-group-label">Phone number <span class="required-star">*</span></label>
                <div class="phone-input-wrapper">
                    <div class="country-code">
                        <img src="https://flagcdn.com/w20/bd.png" width="20" alt="BD">
                        <span style="margin-left: 5px;">+880</span>
                    </div>
                    <input type="tel" placeholder="1XXXXXXXXX" required pattern="[0-9]{10}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-group-label">Email address (Optional)</label>
                <input type="email" class="input-field" placeholder="Enter email address">
            </div>

            <div class="form-group">
                <label class="form-group-label">Division <span class="required-star">*</span></label>
                <select class="input-field" required>
                    <option value="">Select Division</option>
                    <option value="Dhaka">Dhaka</option>
                    <option value="Chattogram">Chattogram</option>
                    <option value="Rajshahi">Rajshahi</option>
                    <option value="Khulna">Khulna</option>
                    <option value="Barishal">Barishal</option>
                    <option value="Sylhet">Sylhet</option>
                    <option value="Rangpur">Rangpur</option>
                    <option value="Mymensingh">Mymensingh</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-group-label">Zilla / District <span class="required-star">*</span></label>
                <input type="text" class="input-field" placeholder="Enter District" required>
            </div>

            <div class="form-group">
                <label class="form-group-label">Area / Thana <span class="required-star">*</span></label>
                <input type="text" class="input-field" placeholder="Enter Area" required>
            </div>

            <div class="form-group full-width">
                <label class="form-group-label">Detailed Address <span class="required-star">*</span></label>
                <textarea class="input-field" rows="3" placeholder="House no, Street name, Apartment, etc." style="resize: none;" required></textarea>
            </div>

            <div class="full-width">
                <h2 class="section-title" style="margin-top: 1rem;">Payment Method</h2>
                <div class="payment-grid">
                    <div class="payment-option active" data-method="bkash" onclick="selectPayment(this)">
                        <img src="https://imgs.search.brave.com/2gx9AyanNVmQGlTm0Bn-ZPxdIEz92LsfJgmFM264cn0/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9jZG4u/aW1nYmluLmNvbS82/LzIxLzEzL2JrYXNo/LWxvZ28t/bW9iaWxlLXBheW1l/bnQtc2VydmljZS1s/b2dvLVQ1RnIzTnZE/LmpwZw" alt="bKash">
                        <span>bKash</span>
                    </div>
                    <div class="payment-option" data-method="nagad" onclick="selectPayment(this)">
                        <img src="https://download.logo.wine/logo/Nagad/Nagad-Logo.wine.png" alt="Nagad">
                        <span>Nagad</span>
                    </div>
                    <div class="payment-option" data-method="cod" onclick="selectPayment(this)">
                        <i class="fas fa-hand-holding-usd"></i>
                        <span>Cash on Delivery</span>
                    </div>
                </div>
                <input type="hidden" name="payment_method" id="selected-payment" value="bkash">
            </div>

            <label class="checkbox-group full-width">
                <input type="checkbox" required checked>
                I agree to the <a href="#" style="color: var(--checkout-blue); text-decoration: none;">Terms and Conditions</a> and Privacy Policy.
            </label>
        </form>
    </div>

    <!-- Right: Order Review -->
    <aside class="order-sidebar">
        <h2 class="review-cart-title">Order Summary</h2>
        
        <div id="checkout-items">
            <!-- Items rendered via JS -->
        </div>

        <div class="discount-box">
            <i class="fas fa-percent" style="margin-left: 1rem; align-self: center; color: var(--checkout-muted);"></i>
            <input type="text" id="promo-code-input" placeholder="Promo code">
            <button class="apply-btn" onclick="applyPromo()">Apply</button>
        </div>

        <div class="totals-area">
            <div class="total-row">
                <span>Subtotal</span>
                <span id="checkout-subtotal">$0.00</span>
            </div>
            <div class="total-row">
                <span>Shipping Fee</span>
                <span>$5.00</span>
            </div>
            <div class="total-row" id="checkout-discount-row" style="display: none; color: #10B981;">
                <span>Discount</span>
                <span id="checkout-discount">-$0.00</span>
            </div>
            <div class="total-row main-total">
                <span>Grand Total</span>
                <span id="checkout-total">$0.00</span>
            </div>
        </div>

        <button class="pay-button" onclick="submitOrder()">Place Order Now</button>

        <div class="security-badge">
            <i class="fas fa-shield-alt" style="color: #10B981;"></i>
            100% Safe & Secure Payment
        </div>
        <p class="security-note">Your personal data will be used to process your order and for other purposes described in our privacy policy.</p>
    </aside>
</div>

<script>
    function selectPayment(el) {
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        el.classList.add('active');
        document.getElementById('selected-payment').value = el.getAttribute('data-method');
    }

    function renderCheckout() {
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        const itemsContainer = document.getElementById('checkout-items');
        let subtotal = 0;
        let discountRate = parseFloat(localStorage.getItem('discountRate')) || 0;

        if (cart.length === 0) {
            window.location.href = 'cart.php';
            return;
        }

        itemsContainer.innerHTML = '';

        cart.forEach(item => {
            subtotal += item.price * item.qty;
            const variationDetails = [];
            if (item.size) variationDetails.push(item.size);
            if (item.color && item.color !== 'Default') variationDetails.push(item.color);
            
            itemsContainer.innerHTML += `
                <div class="cart-item-row">
                    <img src="${item.image}" class="cart-item-img" alt="${item.name}">
                    <div class="cart-item-info">
                        <h4>${item.name}</h4>
                        <p>Qty: ${item.qty} ${variationDetails.length > 0 ? ' | ' + variationDetails.join(', ') : ''}</p>
                        <div class="cart-item-price">$${(item.price * item.qty).toFixed(2)}</div>
                    </div>
                </div>
            `;
        });

        document.getElementById('checkout-subtotal').innerText = '$' + subtotal.toFixed(2);

        let shipping = 5.00;
        let discountAmount = subtotal * discountRate;
        let total = subtotal + shipping - discountAmount;

        const discountRow = document.getElementById('checkout-discount-row');
        if (discountRate > 0) {
            discountRow.style.display = 'flex';
            document.getElementById('checkout-discount').innerText = '-$' + discountAmount.toFixed(2);
        } else {
            discountRow.style.display = 'none';
        }

        document.getElementById('checkout-total').innerText = '$' + total.toFixed(2);
    }

    function applyPromo() {
        const input = document.getElementById('promo-code-input').value.trim().toUpperCase();
        if (input === 'VOGUE20') {
            localStorage.setItem('discountRate', '0.20');
            if (window.showToast) showToast('Promo code applied! 20% off.');
            renderCheckout();
        } else {
            alert('Invalid promo code');
        }
    }

    function submitOrder() {
        const form = document.getElementById('checkout-form');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const trackCode = '#ORD-' + Math.floor(100000 + Math.random() * 900000);
        document.getElementById('tracking-number').innerText = trackCode;
        document.getElementById('order-success-modal').style.display = 'flex';

        localStorage.removeItem('cart');
        localStorage.removeItem('discountRate');
    }

    document.addEventListener('DOMContentLoaded', renderCheckout);
</script>

<?php
// Include Footer
include_once 'includes/footer.php';
?>