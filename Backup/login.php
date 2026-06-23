<?php
// Start session before checking (header.php also includes helpers.php, but require_once prevents duplication)
require_once __DIR__ . '/api/helpers.php';

// If already logged in, redirect to dashboard or onboarding based on redirect parameter
// helpers.php already starts the session, so $_SESSION is available
if (isset($_SESSION['user_id'])) {
    $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard';
    if ($redirect === 'onboarding') {
        header('Location: onboarding/onboarding.php');
        exit;
    } else {
        header('Location: dashboard/user/dashboard.php');
        exit;
    }
}

$page_title = 'Sign In - WyomingTrust';
$redirectTo = isset($_GET['redirect']) ? $_GET['redirect'] : 'dashboard';
include 'includes/header.php';
?>
<section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-navy-900">
<div class="max-w-md w-full space-y-8">
<div class="text-center">
<h1 class="text-4xl font-bold text-navy-900 dark:text-white mb-2">Welcome Back</h1>
<p class="text-lg text-slate-600 dark:text-slate-400">Sign in to access your trusts</p>
</div>
<form class="mt-8 space-y-6" id="loginForm">
<div class="space-y-4">
<div>
<label for="email" class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Email Address</label>
<input id="email" name="email" type="email" required class="appearance-none relative block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 placeholder-slate-400 text-navy-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm bg-white dark:bg-navy-800" placeholder="john.doe@example.com">
</div>
<div>
<label for="password" class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Password</label>
<div class="relative">
<input id="password" name="password" type="password" required class="appearance-none relative block w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-700 placeholder-slate-400 text-navy-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm bg-white dark:bg-navy-800" placeholder="Enter your password">
<button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-navy-900 dark:hover:text-white focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-xl toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
</div>
<div class="flex items-center justify-between">
<div class="flex items-center">
<input id="remember_me" name="remember_me" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-slate-300 dark:border-slate-700 rounded">
<label for="remember_me" class="ml-2 block text-sm text-slate-600 dark:text-slate-400">Remember me</label>
</div>
<div class="text-sm">
<a href="forgot-password.php" class="font-medium text-primary hover:text-primary/80">Forgot password?</a>
</div>
</div>
<input type="hidden" id="redirectTo" value="<?php echo htmlspecialchars($redirectTo); ?>">
<div id="errorMessage" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded"></div>

<!-- Email Verification Notice (shown when email not verified) -->
<div id="verificationNotice" class="hidden bg-amber-50 dark:bg-amber-900/20 border border-amber-400 dark:border-amber-600 rounded-lg p-4 mb-4">
    <div class="flex items-start gap-3">
        <span class="material-icons-outlined text-amber-600 dark:text-amber-400">warning</span>
        <div class="flex-1">
            <h3 class="font-semibold text-amber-900 dark:text-amber-300 mb-1">Email Verification Required</h3>
            <p class="text-sm text-amber-700 dark:text-amber-400 mb-3">Please verify your email address before logging in.</p>
            
            <!-- Resend Email Section -->
            <div class="space-y-2">
                <button 
                    id="resendVerificationBtn" 
                    class="w-full bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    onclick="resendVerificationEmail()"
                >
                    Resend Verification Email
                </button>
                
                <!-- Countdown Timer -->
                <div id="resendCountdown" class="hidden text-center">
                    <p class="text-xs text-amber-600 dark:text-amber-400 mb-1">
                        Please wait <span id="countdownSeconds" class="font-bold">60</span> seconds before requesting another email.
                    </p>
                    <div class="w-full bg-amber-200 dark:bg-amber-900/40 rounded-full h-1.5">
                        <div id="countdownProgress" class="bg-amber-600 dark:bg-amber-500 h-1.5 rounded-full transition-all duration-1000" style="width: 100%;"></div>
                    </div>
                </div>
                
                <!-- Success/Error Messages -->
                <div id="resendMessage" class="hidden text-xs mt-2"></div>
            </div>
        </div>
    </div>
</div>

<div>
<button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-navy-900 bg-primary hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all shadow-lg shadow-primary/20">
Sign In
</button>
</div>
<!-- Success message for email verification -->
<div id="verificationSuccess" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded mb-4">
    <div class="flex items-center gap-2">
        <span class="material-icons-outlined text-sm">check_circle</span>
        <span>Email verified successfully! You can now log in.</span>
    </div>
</div>

<!-- Success message for password reset -->
<div id="passwordResetSuccess" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded mb-4">
    <div class="flex items-center gap-2">
        <span class="material-icons-outlined text-sm">check_circle</span>
        <span>Password reset successfully! You can now log in with your new password.</span>
    </div>
</div>

<div class="text-center space-y-2">
<p class="text-sm text-slate-600 dark:text-slate-400">
Don't have an account? <a href="onboarding/onboarding.php" class="font-semibold text-primary hover:text-primary/80">Create a Trust</a>
</p>
<p class="text-xs text-slate-500 dark:text-slate-500 flex items-center justify-center gap-1">
<span class="material-icons-outlined text-sm">lock</span>
Your data is encrypted and secured
</p>
</div>
</form>
</div>
</section>
<script>
let countdownInterval = null;
let cooldownRemaining = 0;
let currentEmail = '';

// Wait for DOM to be fully loaded before accessing elements
document.addEventListener('DOMContentLoaded', function() {
    // Check for verification success message in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('verified') === '1') {
        const verificationSuccess = document.getElementById('verificationSuccess');
        if (verificationSuccess) {
            verificationSuccess.classList.remove('hidden');
            // Remove verified parameter from URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }

    // Check for password reset success message
    if (urlParams.get('reset') === 'success') {
        const passwordResetSuccess = document.getElementById('passwordResetSuccess');
        if (passwordResetSuccess) {
            passwordResetSuccess.classList.remove('hidden');
            // Remove reset parameter from URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
    
    // Check if there's a stored cooldown end time
    const cooldownEnd = sessionStorage.getItem('login_verification_cooldown_end');
    if (cooldownEnd) {
        const remaining = Math.max(0, Math.ceil((parseInt(cooldownEnd) - Date.now()) / 1000));
        if (remaining > 0) {
            const email = sessionStorage.getItem('login_verification_email');
            if (email) {
                startResendCountdown(remaining, email);
            }
        }
    }

    
    // Get login form and add submit handler
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) {
        console.error('Login form not found');
        return;
    }
    
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const errorMessage = document.getElementById('errorMessage');
        const verificationNotice = document.getElementById('verificationNotice');
    
    currentEmail = emailInput.value;
    
    const formData = {
        email: currentEmail,
        password: passwordInput.value
    };
    
    const response = await fetch('api/login.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(formData)
    });
    
    const data = await response.json();
    
    if (data.success) {
        // Clear any stored cooldown
        sessionStorage.removeItem('login_verification_cooldown_end');
        sessionStorage.removeItem('login_verification_email');
        
        // Small delay to ensure session is saved on server before redirect
        setTimeout(() => {
            // Redirect based on parameter or default to dashboard
            const redirectTo = document.getElementById('redirectTo').value || 'dashboard';
            if (redirectTo === 'onboarding') {
                window.location.href = 'onboarding/onboarding.php';
            } else {
                window.location.href = 'dashboard/user/dashboard.php';
            }
        }, 100);
    } else {
        errorMessage.textContent = data.message || 'Login failed';
        errorMessage.classList.remove('hidden');
        
        // Check if error is due to unverified email (403 status or specific message)
        if (response.status === 403 || data.message?.toLowerCase().includes('verify')) {
            verificationNotice.classList.remove('hidden');
            errorMessage.classList.add('hidden'); // Hide generic error, show verification notice
        } else {
            verificationNotice.classList.add('hidden');
        }
    }
    });
}); // End DOMContentLoaded

function resendVerificationEmail() {
    const email = currentEmail || document.getElementById('email').value;
    
    if (!email) {
        showResendMessage('Please enter your email address first.', 'error');
        return;
    }
    
    const button = document.getElementById('resendVerificationBtn');
    const messageContainer = document.getElementById('resendMessage');
    
    // Disable button
    button.disabled = true;
    button.textContent = 'Sending...';
    
    // Hide previous messages
    messageContainer.classList.add('hidden');
    
    fetch('api/user/resend-verification.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showResendMessage(data.message || 'Verification email sent successfully!', 'success');
            
            // Start countdown
            const cooldown = data.cooldown_remaining || 60;
            startResendCountdown(cooldown, email);
            
            // Store cooldown end time and email
            const cooldownEnd = Date.now() + (cooldown * 1000);
            sessionStorage.setItem('login_verification_cooldown_end', cooldownEnd.toString());
            sessionStorage.setItem('login_verification_email', email);
        } else {
            showResendMessage(data.message || 'Failed to send verification email. Please try again.', 'error');
            
            if (data.cooldown_remaining && data.cooldown_remaining > 0) {
                startResendCountdown(data.cooldown_remaining, email);
                const cooldownEnd = Date.now() + (data.cooldown_remaining * 1000);
                sessionStorage.setItem('login_verification_cooldown_end', cooldownEnd.toString());
                sessionStorage.setItem('login_verification_email', email);
            } else {
                button.disabled = false;
                button.textContent = 'Resend Verification Email';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showResendMessage('An error occurred. Please try again later.', 'error');
        button.disabled = false;
        button.textContent = 'Resend Verification Email';
    });
}

function startResendCountdown(seconds, email) {
    const button = document.getElementById('resendVerificationBtn');
    const countdownContainer = document.getElementById('resendCountdown');
    const countdownDisplay = document.getElementById('countdownSeconds');
    const countdownProgress = document.getElementById('countdownProgress');
    
    cooldownRemaining = seconds;
    currentEmail = email;
    
    // Clear existing interval
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
    
    // Show countdown, hide button
    button.classList.add('hidden');
    countdownContainer.classList.remove('hidden');
    
    // Update countdown display and progress
    updateResendCountdown();
    
    countdownInterval = setInterval(() => {
        cooldownRemaining--;
        updateResendCountdown();
        
        if (cooldownRemaining <= 0) {
            clearInterval(countdownInterval);
            countdownInterval = null;
            
            // Show button, hide countdown
            countdownContainer.classList.add('hidden');
            button.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Resend Verification Email';
            
            // Clear stored cooldown
            sessionStorage.removeItem('login_verification_cooldown_end');
            sessionStorage.removeItem('login_verification_email');
        }
    }, 1000);
}

function updateResendCountdown() {
    const countdownDisplay = document.getElementById('countdownSeconds');
    const countdownProgress = document.getElementById('countdownProgress');
    
    if (countdownDisplay) {
        countdownDisplay.textContent = cooldownRemaining;
    }
    
    if (countdownProgress && cooldownRemaining > 0) {
        const percentage = (cooldownRemaining / 60) * 100;
        countdownProgress.style.width = percentage + '%';
    }
}

function showResendMessage(message, type) {
    const messageContainer = document.getElementById('resendMessage');
    
    const bgColor = type === 'success' 
        ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400'
        : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400';
    
    messageContainer.className = `p-2 rounded text-xs ${bgColor}`;
    messageContainer.textContent = message;
    messageContainer.classList.remove('hidden');
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            messageContainer.classList.add('hidden');
        }, 5000);
    }
}

// Password visibility toggle function - must be in global scope for onclick handlers
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('.toggle-password-icon');
    
    if (input && icon) {
        if (input.type === 'password') {
            input.type = 'text';
            icon.textContent = 'visibility';
        } else {
            input.type = 'password';
            icon.textContent = 'visibility_off';
        }
    }
}
</script>
<?php include 'includes/footer.php'; ?>
