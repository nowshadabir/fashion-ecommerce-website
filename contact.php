<?php
/**
 * Contact Page
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* =====================================================
   CONTACT PAGE STYLES
   ===================================================== */

    /* ── Hero Split Panel ─────────────────────────────── */
    .ct-hero {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 420px;
    }

    .ct-hero-left {
        background: linear-gradient(135deg, #111 0%, #1c1c1c 100%);
        padding: 5rem 8%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .ct-hero-left::before {
        content: '';
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 280px;
        height: 280px;
        border-radius: 50%;
        background: rgba(212, 175, 55, 0.06);
    }

    .ct-hero-left .eyebrow {
        font-size: 0.7rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .ct-hero-left .eyebrow::before {
        content: '';
        width: 35px;
        height: 1px;
        background: var(--accent);
    }

    .ct-hero-left h1 {
        font-size: 3.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fff;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }

    .ct-hero-left p {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.5);
        line-height: 1.9;
        max-width: 420px;
    }

    .ct-hero-right {
        background: url('https://images.unsplash.com/photo-1531973576160-7125cd663d86?q=80&w=1200&auto=format&fit=crop') no-repeat center center / cover;
        position: relative;
    }

    .ct-hero-right::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to left, transparent, rgba(17, 17, 17, 0.4));
    }

    /* ── Contact Info Cards ───────────────────────────── */
    .ct-info-strip {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        border-bottom: 1px solid var(--border);
    }

    .ct-info-card {
        padding: 3rem 2.5rem;
        border-right: 1px solid var(--border);
        transition: background 0.3s;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.8rem;
    }

    .ct-info-card:last-child {
        border-right: none;
    }

    .ct-info-card:hover {
        background: #fafafa;
    }

    .ct-info-icon {
        width: 52px;
        height: 52px;
        background: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
    }

    .ct-info-icon i {
        color: var(--accent);
        font-size: 1.1rem;
    }

    .ct-info-card h3 {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        color: #aaa;
    }

    .ct-info-card p,
    .ct-info-card a {
        font-size: 1rem;
        font-weight: 600;
        color: var(--primary);
        line-height: 1.5;
    }

    .ct-info-card small {
        font-size: 0.8rem;
        color: #999;
    }

    /* ── Main Form + Sidebar ──────────────────────────── */
    .ct-main {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 5rem;
        padding: 5rem 8%;
        align-items: start;
    }

    /* Form side */
    .ct-form-section h2 {
        font-size: 1.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .ct-form-section .subtitle {
        font-size: 0.9rem;
        color: #888;
        margin-bottom: 2.5rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border);
    }

    .ct-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .ct-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .ct-field {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .ct-field label {
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        color: #333;
    }

    .ct-field input,
    .ct-field select,
    .ct-field textarea {
        padding: 0.95rem 1.1rem;
        border: 1.5px solid var(--border);
        font-family: inherit;
        font-size: 0.95rem;
        color: var(--primary);
        outline: none;
        transition: border-color 0.25s, box-shadow 0.25s;
        background: #fff;
        width: 100%;
        resize: vertical;
    }

    .ct-field input:focus,
    .ct-field select:focus,
    .ct-field textarea:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.06);
    }

    .ct-field .error-msg {
        font-size: 0.78rem;
        color: #e74c3c;
        display: none;
    }

    .ct-field.invalid input,
    .ct-field.invalid textarea,
    .ct-field.invalid select {
        border-color: #e74c3c;
    }

    .ct-field.invalid .error-msg {
        display: block;
    }

    .ct-field.valid input,
    .ct-field.valid textarea {
        border-color: #2ecc71;
    }

    .ct-submit-btn {
        padding: 1.1rem 3rem;
        background: var(--primary);
        color: #fff;
        border: 2px solid var(--primary);
        font-family: inherit;
        font-size: 0.9rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: all 0.3s;
        align-self: flex-start;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .ct-submit-btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }

    .ct-submit-btn.sending {
        opacity: 0.7;
        pointer-events: none;
    }

    .ct-success-msg {
        display: none;
        padding: 1.5rem;
        background: #d4edda;
        border-left: 4px solid #2ecc71;
        font-size: 0.95rem;
        color: #155724;
        line-height: 1.6;
    }

    /* Sidebar */
    .ct-sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .ct-sidebar-card {
        padding: 2rem;
        border: 1.5px solid var(--border);
        position: relative;
        overflow: hidden;
    }

    .ct-sidebar-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--accent);
    }

    .ct-sidebar-card h3 {
        font-size: 0.88rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 800;
        margin-bottom: 1rem;
    }

    .ct-sidebar-card p {
        font-size: 0.88rem;
        color: #666;
        line-height: 1.8;
    }

    .ct-hours-list {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
    }

    .ct-hours-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.88rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #f5f5f5;
    }

    .ct-hours-row span {
        color: #888;
    }

    .ct-hours-row strong {
        font-weight: 700;
    }

    .ct-social-links {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .ct-social-links a {
        width: 40px;
        height: 40px;
        border: 1.5px solid var(--border);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
        color: #555;
        transition: all 0.25s;
    }

    .ct-social-links a:hover {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
    }

    /* ── FAQ Accordion ────────────────────────────────── */
    .ct-faq {
        padding: 5rem 8%;
        background: #f9f7f4;
    }

    .ct-faq h2 {
        font-size: 1.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        margin-bottom: 3rem;
    }

    .ct-accordion {
        max-width: 800px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .ct-acc-item {
        border: 1.5px solid var(--border);
        background: #fff;
        overflow: hidden;
    }

    .ct-acc-head {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.4rem 1.8rem;
        background: none;
        border: none;
        font-family: inherit;
        font-size: 0.95rem;
        font-weight: 700;
        cursor: pointer;
        text-align: left;
        transition: background 0.2s;
        gap: 1rem;
    }

    .ct-acc-head:hover {
        background: #f9f9f9;
    }

    .ct-acc-head.active {
        background: var(--primary);
        color: #fff;
    }

    .ct-acc-icon {
        flex-shrink: 0;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid currentColor;
        border-radius: 50%;
        font-size: 0.75rem;
        transition: transform 0.3s;
    }

    .ct-acc-head.active .ct-acc-icon {
        transform: rotate(45deg);
    }

    .ct-acc-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .ct-acc-body p {
        padding: 1.2rem 1.8rem 1.6rem;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.8;
    }

    /* ── Map placeholder ──────────────────────────────── */
    .ct-map {
        height: 320px;
        background:
            linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.45)),
            url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2070&auto=format&fit=crop') no-repeat center center / cover;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        gap: 1rem;
    }

    .ct-map i {
        color: var(--accent);
        font-size: 1.8rem;
    }

    /* ── Responsive ───────────────────────────────────── */
    @media (max-width: 1100px) {
        .ct-main {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

        .ct-sidebar {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .ct-hero {
            grid-template-columns: 1fr;
        }

        .ct-hero-right {
            height: 200px;
        }

        .ct-hero-left h1 {
            font-size: 2.2rem;
        }

        .ct-info-strip {
            grid-template-columns: 1fr;
        }

        .ct-info-card {
            border-right: none;
            border-bottom: 1px solid var(--border);
        }

        .ct-form-row {
            grid-template-columns: 1fr;
        }

        .ct-main {
            padding: 3rem 5%;
        }

        .ct-faq {
            padding: 3rem 5%;
        }

        .ct-sidebar {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Hero -->
<section class="ct-hero">
    <div class="ct-hero-left">
        <p class="eyebrow">Get in Touch</p>
        <h1>We'd Love to Hear from You</h1>
        <p>Whether you have a question about an order, need styling advice, or want to explore a press partnership — our
            team is ready and happy to help.</p>
    </div>
    <div class="ct-hero-right"></div>
</section>

<!-- Info Strip -->
<div class="ct-info-strip">
    <div class="ct-info-card">
        <div class="ct-info-icon"><i class="fas fa-map-marker-alt"></i></div>
        <h3>Visit Us</h3>
        <p>138 Fashion Avenue<br>Gulshan-2, Dhaka 1212</p>
        <small>Bangladesh</small>
    </div>
    <div class="ct-info-card">
        <div class="ct-info-icon"><i class="fas fa-phone-alt"></i></div>
        <h3>Call or WhatsApp</h3>
        <a href="tel:+8801700000000">+880 170-000-0000</a>
        <small>Sun – Thu, 10am – 7pm</small>
    </div>
    <div class="ct-info-card">
        <div class="ct-info-icon"><i class="fas fa-envelope"></i></div>
        <h3>Email Us</h3>
        <a href="mailto:hello@moderncloset.com">hello@moderncloset.com</a>
        <small>We reply within 24 hours</small>
    </div>
</div>

<!-- Main Section: Form + Sidebar -->
<div class="ct-main">

    <!-- Contact Form -->
    <div class="ct-form-section">
        <h2>Send a Message</h2>
        <p class="subtitle">Fill out the form below and a member of our team will get back to you within one business
            day.</p>

        <div class="ct-success-msg" id="ct-success">
            <strong><i class="fas fa-check-circle"></i> Message sent successfully!</strong><br>
            Thank you for reaching out. We'll be in touch within 24 hours.
        </div>

        <form class="ct-form" id="ct-contact-form" novalidate>
            <div class="ct-form-row">
                <div class="ct-field" id="field-name">
                    <label for="ct-name">Full Name *</label>
                    <input type="text" id="ct-name" placeholder="e.g. Arman Hossain">
                    <span class="error-msg">Please enter your full name.</span>
                </div>
                <div class="ct-field" id="field-email">
                    <label for="ct-email">Email Address *</label>
                    <input type="email" id="ct-email" placeholder="you@example.com">
                    <span class="error-msg">Please enter a valid email address.</span>
                </div>
            </div>

            <div class="ct-form-row">
                <div class="ct-field" id="field-phone">
                    <label for="ct-phone">Phone (Optional)</label>
                    <input type="tel" id="ct-phone" placeholder="+880 1XX-XXXXXXX">
                </div>
                <div class="ct-field">
                    <label for="ct-subject">Subject *</label>
                    <select id="ct-subject">
                        <option value="">— Select a topic —</option>
                        <option>Order &amp; Shipping</option>
                        <option>Returns &amp; Refunds</option>
                        <option>Product Enquiry</option>
                        <option>Styling Consultation</option>
                        <option>Press &amp; Partnerships</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <div class="ct-field" id="field-message">
                <label for="ct-message">Message *</label>
                <textarea id="ct-message" rows="6" placeholder="Tell us how we can help you..."></textarea>
                <span class="error-msg">Please enter a message (at least 15 characters).</span>
            </div>

            <button type="submit" class="ct-submit-btn" id="ct-submit-btn">
                <i class="fas fa-paper-plane"></i>
                Send Message
            </button>
        </form>
    </div>

    <!-- Sidebar -->
    <aside class="ct-sidebar">
        <!-- Store Hours -->
        <div class="ct-sidebar-card">
            <h3><i class="fas fa-clock" style="color:var(--accent); margin-right:0.5rem;"></i> Store Hours</h3>
            <div class="ct-hours-list">
                <div class="ct-hours-row"><span>Sunday – Thursday</span> <strong>10:00am – 7:00pm</strong></div>
                <div class="ct-hours-row"><span>Friday</span> <strong>2:00pm – 7:00pm</strong></div>
                <div class="ct-hours-row"><span>Saturday</span> <strong>10:00am – 6:00pm</strong></div>
                <div class="ct-hours-row"><span>Public Holidays</span> <strong>Closed</strong></div>
            </div>
        </div>

        <!-- Follow Us -->
        <div class="ct-sidebar-card">
            <h3><i class="fas fa-share-alt" style="color:var(--accent); margin-right:0.5rem;"></i> Follow Us</h3>
            <p style="margin-bottom:1.2rem;">Stay updated on new arrivals, exclusive deals, and styling inspiration.</p>
            <div class="ct-social-links">
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
                <a href="#" title="Pinterest"><i class="fab fa-pinterest-p"></i></a>
                <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <!-- Personal Stylist -->
        <div class="ct-sidebar-card" style="background: var(--primary); border-color: var(--primary);">
            <h3 style="color:var(--accent);">
                <i class="fas fa-user-tie" style="margin-right:0.5rem;"></i> Personal Styling
            </h3>
            <p style="color:rgba(255,255,255,0.6); margin-bottom:1.5rem;">Not sure what to wear? Book a free 1-on-1
                session with our expert stylists — online or in-store.</p>
            <a href="contact.php"
                style="display:inline-block; padding:0.8rem 1.5rem; background:var(--accent); color:var(--primary); font-weight:700; font-size:0.82rem; text-transform:uppercase; letter-spacing:1.5px;">Book
                Session</a>
        </div>
    </aside>
</div>

<!-- Map -->
<div class="ct-map">
    <i class="fas fa-map-pin"></i>
    <span>138 Fashion Avenue, Gulshan-2, Dhaka</span>
</div>

<!-- FAQ Accordion -->
<section class="ct-faq">
    <h2>Frequently Asked Questions</h2>
    <div class="ct-accordion">

        <div class="ct-acc-item">
            <button class="ct-acc-head">
                How long does delivery take?
                <span class="ct-acc-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ct-acc-body">
                <p>Standard delivery within Dhaka takes 1–2 business days. For other cities in Bangladesh, expect 3–5
                    business days. International orders typically arrive in 7–14 business days depending on your
                    location and customs clearance.</p>
            </div>
        </div>

        <div class="ct-acc-item">
            <button class="ct-acc-head">
                What is your return policy?
                <span class="ct-acc-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ct-acc-body">
                <p>We offer a 30-day return window on all full-price items in their original, unworn condition with tags
                    attached. Sale items are final sale. To initiate a return, simply email us at hello@moderncloset.com
                    with your order number.</p>
            </div>
        </div>

        <div class="ct-acc-item">
            <button class="ct-acc-head">
                Are the products authentic and genuine?
                <span class="ct-acc-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ct-acc-body">
                <p>Absolutely. 100% authenticity is the cornerstone of our brand. Every item we stock is sourced
                    directly from the brand or from authorised distributors. We will never sell replicas or grey-market
                    goods — your trust is everything to us.</p>
            </div>
        </div>

        <div class="ct-acc-item">
            <button class="ct-acc-head">
                Can I track my order?
                <span class="ct-acc-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ct-acc-body">
                <p>Yes! Once your order is dispatched, you will receive an email with your tracking number and a link to
                    our delivery partner's tracking portal. You can check the status of your parcel any time.</p>
            </div>
        </div>

        <div class="ct-acc-item">
            <button class="ct-acc-head">
                Do you offer gift wrapping?
                <span class="ct-acc-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ct-acc-body">
                <p>Yes! We offer complimentary premium gift wrapping on all orders. Simply select the "Gift Wrap" option
                    at checkout and include a personalised message. We'll take care of the rest with our signature
                    black-and-gold packaging.</p>
            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ── Form Validation ─── */
        const form = document.getElementById('ct-contact-form');

        function validateField(fieldId, inputId, condition) {
            const field = document.getElementById(fieldId);
            const input = document.getElementById(inputId);
            if (!field || !input) return condition;
            if (!condition) {
                field.classList.add('invalid');
                field.classList.remove('valid');
            } else {
                field.classList.remove('invalid');
                field.classList.add('valid');
            }
            return condition;
        }

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const name = document.getElementById('ct-name').value.trim();
            const email = document.getElementById('ct-email').value.trim();
            const message = document.getElementById('ct-message').value.trim();
            const emailRe = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            let valid = true;
            if (!validateField('field-name', 'ct-name', name.length >= 2)) valid = false;
            if (!validateField('field-email', 'ct-email', emailRe.test(email))) valid = false;
            if (!validateField('field-message', 'ct-message', message.length >= 15)) valid = false;

            if (!valid) return;

            // Simulate send
            const btn = document.getElementById('ct-submit-btn');
            btn.classList.add('sending');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Sending…';

            setTimeout(() => {
                form.style.display = 'none';
                document.getElementById('ct-success').style.display = 'block';
                btn.classList.remove('sending');
                if (typeof showToast === 'function') showToast('Message sent! We\'ll reply within 24 hours.');
            }, 1800);
        });

        // Real-time validation on blur
        document.getElementById('ct-name')?.addEventListener('blur', function () {
            validateField('field-name', 'ct-name', this.value.trim().length >= 2);
        });
        document.getElementById('ct-email')?.addEventListener('blur', function () {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            validateField('field-email', 'ct-email', re.test(this.value.trim()));
        });
        document.getElementById('ct-message')?.addEventListener('blur', function () {
            validateField('field-message', 'ct-message', this.value.trim().length >= 15);
        });

        /* ── FAQ Accordion ─── */
        const accHeads = document.querySelectorAll('.ct-acc-head');
        accHeads.forEach(head => {
            head.addEventListener('click', function () {
                const isActive = this.classList.contains('active');
                // Close all
                accHeads.forEach(h => {
                    h.classList.remove('active');
                    h.nextElementSibling.style.maxHeight = '0';
                });
                // Open clicked (if it wasn't already open)
                if (!isActive) {
                    this.classList.add('active');
                    this.nextElementSibling.style.maxHeight =
                        this.nextElementSibling.scrollHeight + 'px';
                }
            });
        });
    });
</script>

<?php include_once 'includes/footer.php'; ?>