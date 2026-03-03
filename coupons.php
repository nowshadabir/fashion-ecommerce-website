<?php
/**
 * Coupons & Deals Page
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* =====================================================
   COUPONS PAGE STYLES
   ===================================================== */

    .cp-hero {
        background: linear-gradient(135deg, #111 0%, #1e1e1e 60%, #2d2009 100%);
        padding: 5rem 5%;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cp-hero::before {
        content: '%';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 22rem;
        font-weight: 900;
        color: rgba(212, 175, 55, 0.04);
        line-height: 1;
        user-select: none;
    }

    .cp-hero-content {
        position: relative;
        z-index: 2;
    }

    .cp-hero .eyebrow {
        display: inline-block;
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1rem;
        background: rgba(212, 175, 55, 0.12);
        padding: 0.4rem 1.2rem;
        border-radius: 99px;
    }

    .cp-hero h1 {
        font-size: 3rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 5px;
        color: #fff;
        margin-bottom: 1rem;
        line-height: 1.1;
    }

    .cp-hero p {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.55);
        max-width: 480px;
        margin: 0 auto;
        line-height: 1.8;
    }

    /* Coupon validator box */
    .cp-validator {
        max-width: 600px;
        margin: 3.5rem auto 0;
        display: flex;
        gap: 0;
        border: 2px solid rgba(212, 175, 55, 0.35);
        overflow: hidden;
    }

    .cp-validator input {
        flex: 1;
        padding: 1.1rem 1.4rem;
        background: rgba(255, 255, 255, 0.07);
        border: none;
        color: #fff;
        font-family: inherit;
        font-size: 1rem;
        outline: none;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .cp-validator input::placeholder {
        color: rgba(255, 255, 255, 0.3);
        text-transform: none;
        letter-spacing: 0;
    }

    .cp-validator button {
        padding: 1.1rem 2rem;
        background: var(--accent);
        border: none;
        font-family: inherit;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: var(--primary);
        cursor: pointer;
        transition: background 0.25s;
        white-space: nowrap;
    }

    .cp-validator button:hover {
        background: #e6c240;
    }

    .cp-validator-msg {
        text-align: center;
        margin-top: 1rem;
        font-size: 0.88rem;
        min-height: 1.4em;
    }

    /* Stats strip */
    .cp-stats-strip {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        border-bottom: 1px solid var(--border);
    }

    .cp-stat {
        padding: 2rem;
        text-align: center;
        border-right: 1px solid var(--border);
    }

    .cp-stat:last-child {
        border-right: none;
    }

    .cp-stat-num {
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--primary);
        line-height: 1;
    }

    .cp-stat-num span {
        color: var(--accent);
    }

    .cp-stat-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #888;
        margin-top: 0.4rem;
    }

    /* Main coupons section */
    .cp-section {
        padding: 5rem 5%;
    }

    .cp-section-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }

    .cp-section-header h2 {
        font-size: 1.5rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .cp-section-header small {
        font-size: 0.82rem;
        color: #aaa;
    }

    /* Coupon card */
    .cp-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .cp-card {
        border: 1.5px solid var(--border);
        position: relative;
        overflow: hidden;
        transition: box-shadow 0.3s, transform 0.3s;
        background: #fff;
    }

    .cp-card:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.1);
        transform: translateY(-4px);
    }

    .cp-card-top {
        padding: 1.8rem 2rem 1.4rem;
        border-bottom: 2px dashed #eee;
        position: relative;
    }

    /* Circular cutouts on dashed divider line */
    .cp-card-top::before,
    .cp-card-top::after {
        content: '';
        position: absolute;
        bottom: -14px;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        background: #f5f5f5;
        border: 1.5px solid var(--border);
        z-index: 2;
    }

    .cp-card-top::before {
        left: -14px;
    }

    .cp-card-top::after {
        right: -14px;
    }

    .cp-card-type {
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 2.5px;
        text-transform: uppercase;
        padding: 0.3rem 0.8rem;
        border-radius: 3px;
        display: inline-block;
        margin-bottom: 1rem;
    }

    .cp-card-type.type-pct {
        background: #fff3cd;
        color: #9a6500;
    }

    .cp-card-type.type-flat {
        background: #d4edda;
        color: #155724;
    }

    .cp-card-type.type-free {
        background: #d1ecf1;
        color: #0c5460;
    }

    .cp-card-type.type-vip {
        background: #f5d0d0;
        color: #721c24;
    }

    .cp-card-discount {
        font-size: 3.2rem;
        font-weight: 900;
        color: var(--primary);
        line-height: 1;
        letter-spacing: -1px;
        margin-bottom: 0.4rem;
    }

    .cp-card-discount span {
        font-size: 1.5rem;
        vertical-align: middle;
    }

    .cp-card-desc {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .cp-tag-row {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .cp-tag {
        font-size: 0.7rem;
        background: #f5f5f5;
        color: #555;
        padding: 0.25rem 0.6rem;
        border-radius: 3px;
    }

    .cp-card-bottom {
        padding: 1.4rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .cp-code-display {
        flex: 1;
        background: #f8f8f8;
        border: 1.5px dashed #ccc;
        padding: 0.7rem 1rem;
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--primary);
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .cp-code-display:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    .cp-copy-btn {
        width: 44px;
        height: 44px;
        background: var(--primary);
        border: none;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        transition: background 0.2s;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cp-copy-btn:hover {
        background: var(--accent);
        color: var(--primary);
    }

    .cp-copy-btn.copied {
        background: #2ecc71;
    }

    /* Expiry bar */
    .cp-expiry {
        padding: 0 2rem 1rem;
        font-size: 0.75rem;
        color: #aaa;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .cp-expiry i {
        color: #e74c3c;
    }

    .cp-expiry.urgent {
        color: #e74c3c;
        font-weight: 600;
    }

    /* Ribbon for hot deals */
    .cp-ribbon {
        position: absolute;
        top: 18px;
        right: -28px;
        background: #e74c3c;
        color: #fff;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 0.3rem 2.2rem;
        transform: rotate(45deg);
    }

    /* Countdown timer */
    .cp-countdown {
        display: flex;
        gap: 1rem;
        align-items: center;
        justify-content: center;
        background: var(--primary);
        color: #fff;
        padding: 2rem 5%;
        text-align: center;
    }

    .cp-countdown .label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--accent);
        margin-right: 1.5rem;
    }

    .cp-time-unit {
        text-align: center;
    }

    .cp-time-num {
        font-size: 2.5rem;
        font-weight: 900;
        line-height: 1;
        font-variant-numeric: tabular-nums;
    }

    .cp-time-label {
        font-size: 0.65rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: rgba(255, 255, 255, 0.45);
        margin-top: 0.2rem;
    }

    .cp-time-sep {
        font-size: 2rem;
        opacity: 0.4;
        align-self: flex-start;
        padding-top: 0.2rem;
    }

    /* CTA Banner */
    .cp-cta-banner {
        margin: 0 5% 5rem;
        padding: 4rem;
        background: linear-gradient(135deg, var(--primary) 0%, #2c2c2c 100%);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .cp-cta-banner h3 {
        font-size: 1.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fff;
        margin-bottom: 0.5rem;
    }

    .cp-cta-banner p {
        color: rgba(255, 255, 255, 0.55);
        font-size: 0.95rem;
    }

    .cp-cta-banner .btn {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
        padding: 1rem 2.5rem;
        flex-shrink: 0;
    }

    .cp-cta-banner .btn:hover {
        background: #fff;
        border-color: #fff;
        transform: none;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .cp-grid {
            grid-template-columns: 1fr 1fr;
        }

        .cp-stats-strip {
            grid-template-columns: 1fr 1fr;
        }

        .cp-stat:nth-child(2) {
            border-right: none;
        }

        .cp-stat:nth-child(3) {
            border-top: 1px solid var(--border);
        }

        .cp-cta-banner {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 600px) {
        .cp-grid {
            grid-template-columns: 1fr;
        }

        .cp-hero h1 {
            font-size: 2rem;
            letter-spacing: 3px;
        }

        .cp-stats-strip {
            grid-template-columns: 1fr 1fr;
        }

        .cp-validator {
            flex-direction: column;
        }

        .cp-validator button {
            width: 100%;
        }

        .cp-countdown {
            flex-wrap: wrap;
        }

        .cp-cta-banner {
            padding: 2.5rem;
        }

        .cp-section {
            padding: 3rem 4%;
        }
    }
</style>

<!-- Hero -->
<section class="cp-hero">
    <div class="cp-hero-content">
        <span class="eyebrow">Exclusive Deals</span>
        <h1>Coupons & Offers</h1>
        <p>Unlock savings on premium fashion. Browse our curated deals and copy your code in one click.</p>

        <!-- Coupon Validator -->
        <div class="cp-validator">
            <input type="text" id="cp-input" placeholder="Enter a promo code..." maxlength="20">
            <button onclick="validateCoupon()">Apply Code</button>
        </div>
        <p class="cp-validator-msg" id="cp-validator-msg"></p>
    </div>
</section>

<!-- Stats Strip -->
<div class="cp-stats-strip">
    <div class="cp-stat">
        <div class="cp-stat-num">12<span>+</span></div>
        <div class="cp-stat-label">Active Coupons</div>
    </div>
    <div class="cp-stat">
        <div class="cp-stat-num">Up to <span>40%</span></div>
        <div class="cp-stat-label">Max Discount</div>
    </div>
    <div class="cp-stat">
        <div class="cp-stat-num">2,400<span>+</span></div>
        <div class="cp-stat-label">Happy Customers</div>
    </div>
    <div class="cp-stat">
        <div class="cp-stat-num">Free<span> ship</span></div>
        <div class="cp-stat-label">On orders ৳500+</div>
    </div>
</div>

<!-- Flash Sale Countdown -->
<div class="cp-countdown">
    <span class="label">Flash Sale Ends In:</span>
    <div class="cp-time-unit">
        <div class="cp-time-num" id="cd-hours">00</div>
        <div class="cp-time-label">Hours</div>
    </div>
    <span class="cp-time-sep">:</span>
    <div class="cp-time-unit">
        <div class="cp-time-num" id="cd-mins">00</div>
        <div class="cp-time-label">Minutes</div>
    </div>
    <span class="cp-time-sep">:</span>
    <div class="cp-time-unit">
        <div class="cp-time-num" id="cd-secs">00</div>
        <div class="cp-time-label">Seconds</div>
    </div>
</div>

<!-- Featured Coupons -->
<section class="cp-section">
    <div class="cp-section-header">
        <h2>Featured Coupons</h2>
        <small>Click code to copy &nbsp;<i class="fas fa-hand-pointer"></i></small>
    </div>

    <div class="cp-grid">

        <!-- Coupon 1 - Hot -->
        <div class="cp-card">
            <div class="cp-ribbon">HOT</div>
            <div class="cp-card-top">
                <span class="cp-card-type type-pct">% Off</span>
                <div class="cp-card-discount"><span>20</span>% OFF</div>
                <p class="cp-card-desc">Get 20% off your entire order. No minimum spend required. Valid on all
                    full-price items.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">All Items</span>
                    <span class="cp-tag">Full-price</span>
                    <span class="cp-tag">One-time use</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('VOGUE20', this)">VOGUE20</div>
                <button class="cp-copy-btn" onclick="copyCoupon('VOGUE20', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry urgent"><i class="fas fa-clock"></i> Expires in 2 days</p>
        </div>

        <!-- Coupon 2 -->
        <div class="cp-card">
            <div class="cp-card-top">
                <span class="cp-card-type type-flat">Flat Discount</span>
                <div class="cp-card-discount"><span>$</span>50 OFF</div>
                <p class="cp-card-desc">Save $50 on orders above $300. A perfect opportunity to stock up on wardrobe
                    essentials.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">Min. $300</span>
                    <span class="cp-tag">Outerwear</span>
                    <span class="cp-tag">Accessories</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('SAVE50', this)">SAVE50</div>
                <button class="cp-copy-btn" onclick="copyCoupon('SAVE50', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry"><i class="fas fa-clock"></i> Valid until March 31, 2026</p>
        </div>

        <!-- Coupon 3 -->
        <div class="cp-card">
            <div class="cp-card-top">
                <span class="cp-card-type type-free">Free Shipping</span>
                <div class="cp-card-discount" style="font-size:2rem;">FREE SHIP</div>
                <p class="cp-card-desc">Enjoy free worldwide express shipping on any order, regardless of total value.
                    No minimum required.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">All Orders</span>
                    <span class="cp-tag">Express</span>
                    <span class="cp-tag">Worldwide</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('FREESHIP', this)">FREESHIP</div>
                <button class="cp-copy-btn" onclick="copyCoupon('FREESHIP', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry"><i class="fas fa-clock"></i> Valid until April 15, 2026</p>
        </div>

        <!-- Coupon 4 -->
        <div class="cp-card">
            <div class="cp-ribbon" style="background: var(--accent); color: var(--primary);">VIP</div>
            <div class="cp-card-top">
                <span class="cp-card-type type-vip">VIP Member</span>
                <div class="cp-card-discount"><span>30</span>% OFF</div>
                <p class="cp-card-desc">Exclusive 30% off for registered members. Sign up free and save on your next
                    purchase.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">Members Only</span>
                    <span class="cp-tag">Sitewide</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('VIP30', this)">VIP30</div>
                <button class="cp-copy-btn" onclick="copyCoupon('VIP30', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry"><i class="fas fa-clock"></i> Ongoing — Members only</p>
        </div>

        <!-- Coupon 5 -->
        <div class="cp-card">
            <div class="cp-card-top">
                <span class="cp-card-type type-pct">% Off</span>
                <div class="cp-card-discount"><span>15</span>% OFF</div>
                <p class="cp-card-desc">15% off all womenswear collections. Update your wardrobe for the new season at a
                    great price.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">Womenswear</span>
                    <span class="cp-tag">New arrivals</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('HER15', this)">HER15</div>
                <button class="cp-copy-btn" onclick="copyCoupon('HER15', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry"><i class="fas fa-clock"></i> Valid until March 20, 2026</p>
        </div>

        <!-- Coupon 6 -->
        <div class="cp-card">
            <div class="cp-card-top">
                <span class="cp-card-type type-flat">Bundle Deal</span>
                <div class="cp-card-discount"><span>$</span>100 OFF</div>
                <p class="cp-card-desc">Buy any 2 or more full-price items and save $100. Mix &amp; match across all
                    categories.</p>
                <div class="cp-tag-row">
                    <span class="cp-tag">2+ Items</span>
                    <span class="cp-tag">Mix &amp; Match</span>
                    <span class="cp-tag">Full-price</span>
                </div>
            </div>
            <div class="cp-card-bottom">
                <div class="cp-code-display" onclick="copyCoupon('BUNDLE100', this)">BUNDLE100</div>
                <button class="cp-copy-btn" onclick="copyCoupon('BUNDLE100', this.previousElementSibling, this)"
                    title="Copy Code">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <p class="cp-expiry urgent"><i class="fas fa-clock"></i> Expires in 5 days</p>
        </div>

    </div>
</section>

<!-- CTA Banner -->
<div class="cp-cta-banner">
    <div>
        <h3>Become a VIP Member</h3>
        <p>Register for free and unlock exclusive member-only discounts, early access to sales, and more.</p>
    </div>
    <a href="login.php" class="btn">Join Free &nbsp;<i class="fas fa-arrow-right"></i></a>
</div>

<script>
    // Coupon database
    const validCoupons = {
        'VOGUE20': { discount: '20% off your entire order', valid: true },
        'SAVE50': { discount: '$50 off orders over $300', valid: true },
        'FREESHIP': { discount: 'Free worldwide express shipping', valid: true },
        'VIP30': { discount: '30% off — members only', valid: true },
        'HER15': { discount: '15% off all womenswear', valid: true },
        'BUNDLE100': { discount: '$100 off when buying 2+ items', valid: true },
    };

    function validateCoupon() {
        const input = document.getElementById('cp-input');
        const msgEl = document.getElementById('cp-validator-msg');
        const code = input.value.trim().toUpperCase();

        if (!code) {
            msgEl.innerHTML = '<span style="color:#e74c3c;">Please enter a coupon code.</span>';
            return;
        }

        if (validCoupons[code]) {
            msgEl.innerHTML = `<span style="color:#2ecc71;"><i class="fas fa-check-circle"></i> 
            <strong>${code}</strong> is valid! — ${validCoupons[code].discount}.</span>`;
            input.style.color = '#2ecc71';
        } else {
            msgEl.innerHTML = `<span style="color:#e74c3c;"><i class="fas fa-times-circle"></i>
            Sorry, <strong>${code}</strong> is not a valid or active coupon.</span>`;
            input.style.color = '#e74c3c';
            input.value = '';
            setTimeout(() => { input.style.color = '#fff'; }, 1500);
        }
    }

    document.getElementById('cp-input').addEventListener('keydown', function (e) {
        if (e.key === 'Enter') validateCoupon();
    });

    // Copy coupon code
    function copyCoupon(code, displayEl, btnEl) {
        navigator.clipboard.writeText(code).then(() => {
            if (displayEl) {
                const orig = displayEl.textContent;
                displayEl.textContent = 'Copied!';
                setTimeout(() => { displayEl.textContent = orig; }, 1500);
            }
            if (btnEl && btnEl.classList.contains('cp-copy-btn')) {
                btnEl.classList.add('copied');
                btnEl.innerHTML = '<i class="fas fa-check"></i>';
                setTimeout(() => {
                    btnEl.classList.remove('copied');
                    btnEl.innerHTML = '<i class="fas fa-copy"></i>';
                }, 1500);
            }
            if (typeof showToast === 'function') showToast(`Code "${code}" copied to clipboard!`);
        }).catch(() => {
            // Fallback for older browsers
            if (typeof showToast === 'function') showToast(`Code: ${code} — Copy manually.`);
        });
    }

    // Countdown timer: counts down to next midnight
    function updateCountdown() {
        const now = new Date();
        const end = new Date(now);
        end.setDate(end.getDate() + 1);
        end.setHours(0, 0, 0, 0);

        const diff = end - now;
        const h = Math.floor(diff / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
        document.getElementById('cd-mins').textContent = String(m).padStart(2, '0');
        document.getElementById('cd-secs').textContent = String(s).padStart(2, '0');
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>

<?php include_once 'includes/footer.php'; ?>