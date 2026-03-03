<?php
/**
 * About Us Page
 */
require_once 'config/config.php';
include_once 'includes/header.php';
?>

<style>
    /* =====================================================
   ABOUT PAGE STYLES
   ===================================================== */

    /* ── Hero ─────────────────────────────────────────── */
    .ab-hero {
        position: relative;
        height: 92vh;
        min-height: 600px;
        display: flex;
        align-items: flex-end;
        overflow: hidden;
    }

    .ab-hero-bg {
        position: absolute;
        inset: 0;
        background:
            linear-gradient(to right, rgba(0, 0, 0, 0.82) 38%, rgba(0, 0, 0, 0.2) 100%),
            url('https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop') no-repeat center center / cover;
        transform: scale(1.04);
        transition: transform 8s ease;
    }

    .ab-hero:hover .ab-hero-bg {
        transform: scale(1);
    }

    .ab-hero-content {
        position: relative;
        z-index: 2;
        padding: 5rem 8% 6rem;
        max-width: 700px;
    }

    .ab-hero-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 5px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .ab-hero-eyebrow::before {
        content: '';
        display: block;
        width: 40px;
        height: 1px;
        background: var(--accent);
    }

    .ab-hero-content h1 {
        font-size: 4.5rem;
        font-weight: 900;
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.05;
        margin-bottom: 1.8rem;
    }

    .ab-hero-content p {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.65);
        line-height: 1.9;
        max-width: 550px;
    }

    .ab-hero-scroll {
        position: absolute;
        bottom: 2.5rem;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.4);
        font-size: 0.7rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        z-index: 2;
    }

    .ab-hero-scroll::after {
        content: '';
        display: block;
        width: 1px;
        height: 50px;
        background: rgba(255, 255, 255, 0.25);
        animation: scrollPulse 2s infinite;
    }

    @keyframes scrollPulse {

        0%,
        100% {
            transform: scaleY(1);
            opacity: 0.4;
        }

        50% {
            transform: scaleY(0.5);
            opacity: 0.1;
        }
    }

    /* ── Stats Bar ────────────────────────────────────── */
    .ab-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        background: var(--primary);
    }

    .ab-stat {
        padding: 2.5rem 2rem;
        text-align: center;
        border-right: 1px solid rgba(255, 255, 255, 0.08);
    }

    .ab-stat:last-child {
        border-right: none;
    }

    .ab-stat-num {
        font-size: 2.8rem;
        font-weight: 900;
        color: var(--accent);
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .ab-stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: rgba(255, 255, 255, 0.45);
        font-weight: 600;
    }

    /* ── Story Section ────────────────────────────────── */
    .ab-story {
        display: grid;
        grid-template-columns: 1fr 1fr;
        align-items: center;
        gap: 0;
        padding: 7rem 8%;
    }

    .ab-story-text .eyebrow {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .ab-story-text h2 {
        font-size: 2.8rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        line-height: 1.12;
        margin-bottom: 1.5rem;
    }

    .ab-story-text p {
        font-size: 1rem;
        color: #666;
        line-height: 1.9;
        margin-bottom: 1.2rem;
    }

    .ab-story-text .ab-story-quote {
        margin: 2rem 0;
        padding: 1.5rem 2rem;
        border-left: 3px solid var(--accent);
        background: #fafafa;
        font-size: 1.1rem;
        font-style: italic;
        color: #333;
        line-height: 1.7;
    }

    .ab-story-img {
        position: relative;
        padding-left: 4rem;
    }

    .ab-story-img .img-main {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        display: block;
    }

    .ab-story-img .img-accent {
        position: absolute;
        width: 45%;
        aspect-ratio: 1/1.2;
        object-fit: cover;
        bottom: -3rem;
        left: 0;
        border: 5px solid #fff;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .ab-story-img .ab-since {
        position: absolute;
        top: 2rem;
        right: -1rem;
        background: var(--accent);
        color: var(--primary);
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 6px 20px rgba(212, 175, 55, 0.35);
    }

    .ab-story-img .ab-since span {
        display: block;
        font-size: 2rem;
        font-weight: 900;
        line-height: 1;
    }

    .ab-story-img .ab-since small {
        font-size: 0.65rem;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-weight: 700;
    }

    /* ── Values Section ───────────────────────────────── */
    .ab-values {
        background: #f9f7f4;
        padding: 6rem 8%;
        text-align: center;
    }

    .ab-values .section-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.8rem;
    }

    .ab-values h2 {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 3.5rem;
    }

    .ab-values-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        text-align: left;
    }

    .ab-value-card {
        padding: 2.5rem;
        background: #fff;
        border: 1px solid #eee;
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        overflow: hidden;
    }

    .ab-value-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent), transparent);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.4s ease;
    }

    .ab-value-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.08);
    }

    .ab-value-card:hover::before {
        transform: scaleX(1);
    }

    .ab-value-icon {
        width: 54px;
        height: 54px;
        background: #111;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
    }

    .ab-value-icon i {
        color: var(--accent);
        font-size: 1.2rem;
    }

    .ab-value-card h3 {
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }

    .ab-value-card p {
        font-size: 0.9rem;
        color: #777;
        line-height: 1.7;
    }

    /* ── Timeline ─────────────────────────────────────── */
    .ab-timeline {
        padding: 6rem 8%;
        max-width: 900px;
        margin: 0 auto;
    }

    .ab-timeline h2 {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        text-align: center;
        margin-bottom: 4rem;
    }

    .ab-tl-list {
        position: relative;
        padding-left: 3rem;
        border-left: 2px solid var(--border);
    }

    .ab-tl-item {
        position: relative;
        margin-bottom: 3rem;
        padding-left: 2rem;
    }

    .ab-tl-item::before {
        content: '';
        position: absolute;
        left: -3.6rem;
        top: 0.35rem;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: var(--accent);
        border: 3px solid #fff;
        box-shadow: 0 0 0 2px var(--accent);
    }

    .ab-tl-year {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--accent);
        margin-bottom: 0.4rem;
    }

    .ab-tl-item h3 {
        font-size: 1.15rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
    }

    .ab-tl-item p {
        font-size: 0.9rem;
        color: #777;
        line-height: 1.7;
    }

    /* ── Team Section ─────────────────────────────────── */
    .ab-team {
        background: var(--primary);
        padding: 6rem 8%;
        text-align: center;
    }

    .ab-team .section-eyebrow {
        font-size: 0.72rem;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--accent);
        font-weight: 700;
        margin-bottom: 0.8rem;
    }

    .ab-team h2 {
        font-size: 2.2rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fff;
        margin-bottom: 3.5rem;
    }

    .ab-team-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
    }

    .ab-team-card {
        text-align: center;
    }

    .ab-team-photo {
        width: 100%;
        aspect-ratio: 3/4;
        object-fit: cover;
        display: block;
        filter: grayscale(30%);
        transition: filter 0.4s;
        margin-bottom: 1.5rem;
    }

    .ab-team-card:hover .ab-team-photo {
        filter: grayscale(0%);
    }

    .ab-team-name {
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #fff;
        margin-bottom: 0.3rem;
    }

    .ab-team-role {
        font-size: 0.78rem;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 600;
        margin-bottom: 0.8rem;
    }

    .ab-team-socials {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .ab-team-socials a {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.5);
        transition: all 0.2s;
    }

    .ab-team-socials a:hover {
        border-color: var(--accent);
        color: var(--accent);
    }

    /* ── CTA ──────────────────────────────────────────── */
    .ab-cta {
        padding: 6rem 8%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        background: #fff;
    }

    .ab-cta h2 {
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 2px;
        line-height: 1.1;
        margin-bottom: 1.5rem;
    }

    .ab-cta h2 span {
        color: var(--accent);
    }

    .ab-cta p {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.8;
        margin-bottom: 2rem;
    }

    .ab-cta-btns {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .ab-cta-btns .btn {
        background: var(--primary);
        color: #fff;
        border-color: var(--primary);
        padding: 1rem 2.2rem;
    }

    .ab-cta-btns .btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
        transform: none;
    }

    .ab-cta-btns .btn-outline-dark {
        display: inline-block;
        padding: 1rem 2.2rem;
        border: 2px solid var(--primary);
        color: var(--primary);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-size: 0.88rem;
        transition: all 0.3s;
    }

    .ab-cta-btns .btn-outline-dark:hover {
        background: var(--primary);
        color: #fff;
    }

    .ab-cta-img {
        position: relative;
    }

    .ab-cta-img img {
        width: 100%;
        aspect-ratio: 4/3;
        object-fit: cover;
        display: block;
    }

    .ab-cta-img::before {
        content: '';
        position: absolute;
        inset: -12px;
        border: 2px solid var(--accent);
        z-index: -1;
        opacity: 0.4;
    }

    /* ── Responsive ───────────────────────────────────── */
    @media (max-width: 1100px) {
        .ab-values-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .ab-team-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .ab-hero-content h1 {
            font-size: 2.8rem;
        }

        .ab-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .ab-stat:nth-child(2) {
            border-right: none;
        }

        .ab-stat:nth-child(3) {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        .ab-story {
            grid-template-columns: 1fr;
        }

        .ab-story-img {
            padding-left: 0;
            margin-top: 4rem;
        }

        .ab-story-img .img-accent {
            display: none;
        }

        .ab-story-img .ab-since {
            display: none;
        }

        .ab-values-grid {
            grid-template-columns: 1fr;
        }

        .ab-team-grid {
            grid-template-columns: 1fr 1fr;
        }

        .ab-cta {
            grid-template-columns: 1fr;
        }

        .ab-cta-img {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .ab-hero-content h1 {
            font-size: 2rem;
        }

        .ab-team-grid {
            grid-template-columns: 1fr 1fr;
        }

        .ab-hero-content {
            padding: 3rem 5% 4rem;
        }
    }
</style>

<!-- Hero -->
<section class="ab-hero">
    <div class="ab-hero-bg"></div>
    <div class="ab-hero-content">
        <p class="ab-hero-eyebrow">Our Story</p>
        <h1>Fashion Is More Than Clothing</h1>
        <p>We believe in the transformative power of great design — that what you wear shapes not only how the world
            sees you, but how you see yourself. Since 2010, we've built MODERN CLOSET on that conviction.</p>
    </div>
    <div class="ab-hero-scroll">Scroll</div>
</section>

<!-- Stats Bar -->
<div class="ab-stats">
    <div class="ab-stat">
        <div class="ab-stat-num" data-target="14">0</div>
        <div class="ab-stat-label">Years of Excellence</div>
    </div>
    <div class="ab-stat">
        <div class="ab-stat-num" data-target="120">0</div>
        <div class="ab-stat-label">Premium Brands</div>
    </div>
    <div class="ab-stat">
        <div class="ab-stat-num" data-target="48000">0</div>
        <div class="ab-stat-label">Happy Customers</div>
    </div>
    <div class="ab-stat">
        <div class="ab-stat-num" data-target="32">0</div>
        <div class="ab-stat-label">Countries Served</div>
    </div>
</div>

<!-- Our Story -->
<section class="ab-story">
    <div class="ab-story-text">
        <p class="eyebrow">Who We Are</p>
        <h2>Curated for the Discerning Few</h2>
        <p>MODERN CLOSET was born from a simple frustration: finding exceptional fashion shouldn't require a trip to a
            single boutique in Paris. Our founders set out to bridge the gap between internationally celebrated
            designers and style-conscious individuals worldwide.</p>
        <p>We meticulously curate every piece in our collection — from heritage trench coats and leather goods to
            minimalist timepieces — ensuring that only the finest craftsmanship earns a place in our edit.</p>
        <blockquote class="ab-story-quote">
            "Style is a way to say who you are without having to speak. We're here to make that statement effortlessly
            yours."
        </blockquote>
        <p style="font-size:0.82rem; color:#aaa;">— Founders, MODERN CLOSET</p>
    </div>

    <div class="ab-story-img">
        <img class="img-main"
            src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?q=80&w=800&auto=format&fit=crop"
            alt="Our Story">
        <img class="img-accent"
            src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=400&auto=format&fit=crop"
            alt="Style Detail">
        <div class="ab-since">
            <span>2010</span>
            <small>Est.</small>
        </div>
    </div>
</section>

<!-- Our Values -->
<section class="ab-values">
    <p class="section-eyebrow">What We Stand For</p>
    <h2>Our Core Values</h2>
    <div class="ab-values-grid">
        <div class="ab-value-card">
            <div class="ab-value-icon"><i class="fas fa-gem"></i></div>
            <h3>Uncompromising Quality</h3>
            <p>Every item we carry is hand-selected by our team of expert buyers with decades of collective industry
                experience.</p>
        </div>
        <div class="ab-value-card">
            <div class="ab-value-icon"><i class="fas fa-leaf"></i></div>
            <h3>Responsible Fashion</h3>
            <p>We actively partner with brands committed to sustainable practices, ethical sourcing, and reducing
                fashion's footprint.</p>
        </div>
        <div class="ab-value-card">
            <div class="ab-value-icon"><i class="fas fa-users"></i></div>
            <h3>Client-First Service</h3>
            <p>From personalised styling consultations to white-glove delivery, your experience is designed around you.
            </p>
        </div>
        <div class="ab-value-card">
            <div class="ab-value-icon"><i class="fas fa-globe"></i></div>
            <h3>Global Reach, Local Touch</h3>
            <p>We ship to 32+ countries while maintaining the personalised service feel of a neighbourhood boutique.</p>
        </div>
    </div>
</section>

<!-- Timeline -->
<section class="ab-timeline">
    <h2>Our Journey</h2>
    <div class="ab-tl-list">
        <div class="ab-tl-item">
            <p class="ab-tl-year">2010</p>
            <h3>The Beginning</h3>
            <p>MODERN CLOSET opens its first physical boutique in Dhaka with just 12 curated brands and a bold vision to
                redefine premium fashion retail in South Asia.</p>
        </div>
        <div class="ab-tl-item">
            <p class="ab-tl-year">2014</p>
            <h3>Going Digital</h3>
            <p>We launch our first e-commerce platform, taking our curated edit to customers across Bangladesh and
                neighbouring countries.</p>
        </div>
        <div class="ab-tl-item">
            <p class="ab-tl-year">2017</p>
            <h3>International Expansion</h3>
            <p>Partnerships with 40+ global luxury brands and the launch of worldwide shipping to over 20 countries.</p>
        </div>
        <div class="ab-tl-item">
            <p class="ab-tl-year">2020</p>
            <h3>Sustainability Pledge</h3>
            <p>We commit to our Green Closet initiative — ensuring all new brand partnerships meet strict ethical and
                environmental standards.</p>
        </div>
        <div class="ab-tl-item">
            <p class="ab-tl-year">2024</p>
            <h3>The Modern Era</h3>
            <p>A complete platform redesign, over 48,000 satisfied customers, and an expanded catalogue of 120+ premium
                brands from around the world.</p>
        </div>
    </div>
</section>

<!-- Team -->
<section class="ab-team">
    <p class="section-eyebrow">The People Behind the Brand</p>
    <h2>Meet Our Team</h2>
    <div class="ab-team-grid">
        <div class="ab-team-card">
            <img class="ab-team-photo"
                src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=400&auto=format&fit=crop"
                alt="Arman Hossain">
            <p class="ab-team-name">Arman Hossain</p>
            <p class="ab-team-role">Co-Founder &amp; CEO</p>
            <div class="ab-team-socials">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="ab-team-card">
            <img class="ab-team-photo"
                src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=400&auto=format&fit=crop"
                alt="Nadia Rahman">
            <p class="ab-team-name">Nadia Rahman</p>
            <p class="ab-team-role">Co-Founder &amp; Creative Dir.</p>
            <div class="ab-team-socials">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                <a href="#"><i class="fab fa-pinterest-p"></i></a>
            </div>
        </div>
        <div class="ab-team-card">
            <img class="ab-team-photo"
                src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?q=80&w=400&auto=format&fit=crop"
                alt="Rafi Islam">
            <p class="ab-team-name">Rafi Islam</p>
            <p class="ab-team-role">Head of Buying</p>
            <div class="ab-team-socials">
                <a href="#"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
        <div class="ab-team-card">
            <img class="ab-team-photo"
                src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=400&auto=format&fit=crop"
                alt="Sumaiya Khan">
            <p class="ab-team-name">Sumaiya Khan</p>
            <p class="ab-team-role">Head of Styling</p>
            <div class="ab-team-socials">
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="ab-cta">
    <div>
        <h2>Ready to Elevate <span>Your Style?</span></h2>
        <p>Explore our curated collections or reach out to our team of personal stylists for a bespoke shopping
            experience tailored to you.</p>
        <div class="ab-cta-btns">
            <a href="index.php" class="btn">Shop Collection</a>
            <a href="contact.php" class="btn-outline-dark">Contact Us</a>
        </div>
    </div>
    <div class="ab-cta-img">
        <img src="https://images.unsplash.com/photo-1469334031218-e382a71b716b?q=80&w=800&auto=format&fit=crop"
            alt="Elevate Your Style">
    </div>
</section>

<script>
    // Animated counter for stats
    document.addEventListener('DOMContentLoaded', function () {
        const counters = document.querySelectorAll('.ab-stat-num[data-target]');

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const target = parseInt(el.getAttribute('data-target'));
                const suffix = target >= 1000 ? '+' : (el.closest('.ab-stat').querySelector('.ab-stat-label').textContent.includes('Countries') ? '+' : '+');
                let start = 0;
                const step = Math.ceil(target / 60);
                const timer = setInterval(() => {
                    start += step;
                    if (start >= target) {
                        start = target;
                        clearInterval(timer);
                    }
                    el.textContent = start >= 1000
                        ? (start / 1000).toFixed(0) + 'k' + suffix
                        : start + suffix;
                }, 20);
                observer.unobserve(el);
            });
        }, { threshold: 0.5 });

        counters.forEach(c => observer.observe(c));
    });
</script>

<?php include_once 'includes/footer.php'; ?>