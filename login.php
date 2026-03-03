<?php
/**
 * Fashion E-commerce Login/Register Page
 */
require_once 'config/config.php';
require_once 'config/db.php';

// If user is already "logged in" (demo session), redirect to dashboard
if (isset($_SESSION['customer_logged_in']) && $_SESSION['customer_logged_in'] === true) {
    redirect(base_url('customer/dashboard.php'));
}

// Handle login form submission
$login_error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Demo login — accept any non-empty email+password
    // Replace this block with real DB authentication when ready
    if (!empty($email) && !empty($password)) {
        $_SESSION['customer_logged_in'] = true;
        $_SESSION['customer_email'] = $email;
        $_SESSION['customer_name'] = explode('@', $email)[0]; // derive name from email for demo
        $_SESSION['customer_id'] = 1001; // demo ID
        redirect(base_url('customer/dashboard.php'));
    } else {
        $login_error = 'Please enter your email and password.';
    }
}

include_once 'includes/header.php';
?>

<style>
    .auth-wrapper {
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
    }

    /* Left panel: branding */
    .auth-brand-panel {
        background:
            linear-gradient(135deg, rgba(0, 0, 0, 0.88) 0%, rgba(0, 0, 0, 0.55) 100%),
            url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1400&auto=format&fit=crop') no-repeat center center / cover;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        padding: 4rem;
        color: #fff;
    }

    .auth-brand-panel .brand-name {
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 3px;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .auth-brand-panel .brand-name span {
        color: var(--accent);
    }

    .auth-brand-panel .brand-tagline {
        font-size: 0.88rem;
        color: rgba(255, 255, 255, 0.5);
        margin-bottom: 3rem;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .auth-brand-panel .perks {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .auth-perk {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.75);
    }

    .auth-perk i {
        color: var(--accent);
        font-size: 1rem;
        width: 20px;
        text-align: center;
    }

    /* Right panel: form */
    .auth-form-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 4rem;
        background: #fff;
    }

    .auth-form-inner {
        width: 100%;
        max-width: 420px;
    }

    .auth-tabs {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #eee;
        margin-bottom: 2.5rem;
    }

    .auth-tab-btn {
        flex: 1;
        padding: 1rem;
        background: none;
        border: none;
        border-bottom: 3px solid transparent;
        margin-bottom: -2px;
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #aaa;
        cursor: pointer;
        transition: all 0.25s;
    }

    .auth-tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
    }

    .auth-panel {
        display: none;
    }

    .auth-panel.active {
        display: block;
    }

    .auth-panel h2 {
        font-size: 1.4rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.4rem;
    }

    .auth-panel .sub {
        font-size: 0.85rem;
        color: #999;
        margin-bottom: 2rem;
    }

    .auth-field {
        margin-bottom: 1.4rem;
    }

    .auth-field label {
        display: block;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.5rem;
    }

    .auth-field input {
        width: 100%;
        padding: 1rem 1.1rem;
        border: 1.5px solid #e5e5e5;
        font-family: inherit;
        font-size: 0.95rem;
        outline: none;
        transition: border-color 0.25s, box-shadow 0.25s;
        background: #fafafa;
    }

    .auth-field input:focus {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 3px rgba(17, 17, 17, 0.05);
    }

    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.8rem;
    }

    .auth-remember {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.82rem;
        color: #666;
        cursor: pointer;
    }

    .auth-options a {
        font-size: 0.82rem;
        color: #888;
        text-decoration: underline;
    }

    .auth-options a:hover {
        color: var(--primary);
    }

    .auth-submit-btn {
        width: 100%;
        padding: 1.1rem;
        background: var(--primary);
        color: #fff;
        border: 2px solid var(--primary);
        font-family: inherit;
        font-size: 0.88rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        cursor: pointer;
        transition: all 0.25s;
    }

    .auth-submit-btn:hover {
        background: var(--accent);
        border-color: var(--accent);
        color: var(--primary);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0;
        font-size: 0.78rem;
        color: #ccc;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .auth-divider::before,
    .auth-divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e5e5e5;
    }

    .auth-social-row {
        display: flex;
        gap: 1rem;
    }

    .auth-social-btn {
        flex: 1;
        padding: 0.85rem;
        border: 1.5px solid #e5e5e5;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        font-family: inherit;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.25s;
    }

    .auth-social-btn:hover {
        border-color: var(--primary);
        background: #fafafa;
    }

    .auth-error-msg {
        background: #fdecea;
        border-left: 3px solid #e74c3c;
        padding: 0.9rem 1rem;
        font-size: 0.85rem;
        color: #c0392b;
        margin-bottom: 1.4rem;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    @media (max-width: 900px) {
        .auth-wrapper {
            grid-template-columns: 1fr;
        }

        .auth-brand-panel {
            display: none;
        }

        .auth-form-panel {
            padding: 3rem 5%;
            min-height: 100vh;
        }
    }
</style>

<div class="auth-wrapper">

    <!-- Left: Branding -->
    <div class="auth-brand-panel">
        <div class="brand-name">MODERN<span>CLOSET</span></div>
        <p class="brand-tagline">Premium Fashion for Every Moment</p>
        <div class="perks">
            <div class="auth-perk"><i class="fas fa-gem"></i> Access exclusive member-only deals</div>
            <div class="auth-perk"><i class="fas fa-box-open"></i> Track all your orders in real time</div>
            <div class="auth-perk"><i class="fas fa-heart"></i> Save items to your wishlist</div>
            <div class="auth-perk"><i class="fas fa-undo-alt"></i> Easy one-click returns</div>
            <div class="auth-perk"><i class="fas fa-user-tie"></i> Free personal styling sessions</div>
        </div>
    </div>

    <!-- Right: Form -->
    <div class="auth-form-panel">
        <div class="auth-form-inner">

            <!-- Tabs -->
            <div class="auth-tabs">
                <button class="auth-tab-btn active" data-tab="tab-login">Sign In</button>
                <button class="auth-tab-btn" data-tab="tab-register">Create Account</button>
            </div>

            <!-- Sign In Tab -->
            <div class="auth-panel active" id="tab-login">
                <h2>Welcome Back</h2>
                <p class="sub">Sign in to your MODERN CLOSET account</p>

                <?php if ($login_error): ?>
                    <div class="auth-error-msg">
                        <i class="fas fa-exclamation-circle"></i>
                        <?= htmlspecialchars($login_error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" id="login-form">
                    <input type="hidden" name="action" value="login">
                    <div class="auth-field">
                        <label for="login-email">Email Address</label>
                        <input type="email" id="login-email" name="email" placeholder="you@example.com" required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="auth-field">
                        <label for="login-pass">Password</label>
                        <input type="password" id="login-pass" name="password" placeholder="••••••••" required>
                    </div>
                    <div class="auth-options">
                        <label class="auth-remember">
                            <input type="checkbox" name="remember"> Remember me
                        </label>
                        <a href="#">Forgot password?</a>
                    </div>
                    <button type="submit" class="auth-submit-btn">
                        Sign In &nbsp;<i class="fas fa-arrow-right"></i>
                    </button>
                </form>

                <div class="auth-divider">or continue with</div>

                <div class="auth-social-row">
                    <button class="auth-social-btn" onclick="demoLogin()">
                        <i class="fab fa-google" style="color:#EA4335;"></i> Google
                    </button>
                    <button class="auth-social-btn" onclick="demoLogin()">
                        <i class="fab fa-facebook-f" style="color:#1877F2;"></i> Facebook
                    </button>
                </div>

                <!-- Demo shortcut for testing -->
                <p style="text-align:center; margin-top:1.5rem; font-size:0.8rem; color:#ccc;">
                    Demo: Any email + any password will sign you in.
                </p>
            </div>

            <!-- Register Tab -->
            <div class="auth-panel" id="tab-register">
                <h2>Create Account</h2>
                <p class="sub">Join MODERN CLOSET — it's free forever</p>

                <form method="POST" id="reg-form">
                    <input type="hidden" name="action" value="register">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                        <div class="auth-field">
                            <label>First Name</label>
                            <input type="text" name="fname" placeholder="Arman" required>
                        </div>
                        <div class="auth-field">
                            <label>Last Name</label>
                            <input type="text" name="lname" placeholder="Hossain" required>
                        </div>
                    </div>
                    <div class="auth-field">
                        <label>Email Address</label>
                        <input type="email" name="email" placeholder="you@example.com" required>
                    </div>
                    <div class="auth-field">
                        <label>Phone Number</label>
                        <input type="tel" name="phone" placeholder="+880 1XX-XXXXXXX">
                    </div>
                    <div class="auth-field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters" required minlength="8">
                    </div>
                    <div class="auth-field" style="margin-bottom:1.8rem;">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirm" placeholder="Repeat password" required>
                    </div>
                    <label
                        style="font-size:0.8rem; color:#666; display:flex; align-items:flex-start; gap:0.6rem; margin-bottom:1.8rem; cursor:pointer;">
                        <input type="checkbox" required style="margin-top:2px; flex-shrink:0;">
                        I agree to the <a href="#" style="color:var(--primary); font-weight:600;">&nbsp;Terms of
                            Service&nbsp;</a> and <a href="#"
                            style="color:var(--primary); font-weight:600;">&nbsp;Privacy Policy</a>
                    </label>
                    <button type="submit" class="auth-submit-btn">
                        Create Account &nbsp;<i class="fas fa-user-plus"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Tab switching
        const tabs = document.querySelectorAll('.auth-tab-btn');
        const panels = document.querySelectorAll('.auth-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));
                this.classList.add('active');
                document.getElementById(this.dataset.tab).classList.add('active');
            });
        });

        // Register form submit -> demo login
        document.getElementById('reg-form')?.addEventListener('submit', function (e) {
            e.preventDefault();
            const pass = this.querySelector('[name=password]').value;
            const conf = this.querySelector('[name=password_confirm]').value;
            if (pass !== conf) {
                if (typeof showToast === 'function') showToast('Passwords do not match!');
                return;
            }
            // Simulate registration success -> login
            this.querySelector('[name=action]').value = 'login';
            const emailVal = this.querySelector('[name=email]').value;
            this.querySelector('[name=email]') || Object.assign(document.createElement('input'), { type: 'hidden', name: 'email', value: emailVal });

            // Submit as login
            const loginForm = document.getElementById('login-form');
            loginForm.querySelector('#login-email').value = emailVal;
            loginForm.querySelector('#login-pass').value = pass;
            loginForm.submit();
        });
    });

    // Demo login via social buttons
    function demoLogin() {
        document.getElementById('login-email').value = 'demo@moderncloset.com';
        document.getElementById('login-pass').value = 'demo1234';
        document.getElementById('login-form').submit();
    }
</script>

<?php include_once 'includes/footer.php'; ?>