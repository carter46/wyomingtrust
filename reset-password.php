<?php
$page_title = 'Reset Password - WyomingTrust';
$token = isset($_GET['token']) ? trim($_GET['token']) : '';

if (empty($token)) {
    header('Location: login.php?error=missing_token');
    exit;
}

include 'includes/header.php';
?>
<section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-navy-900">
<div class="max-w-md w-full space-y-8">
<div class="text-center">
<h1 class="text-4xl font-bold text-navy-900 dark:text-white mb-2">Reset Your Password</h1>
<p class="text-lg text-slate-600 dark:text-slate-400">Enter your new password below</p>
</div>
<form class="mt-8 space-y-6" id="resetPasswordForm">
<input type="hidden" id="resetToken" value="<?php echo htmlspecialchars($token); ?>">
<div id="tokenError" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded mb-4">
<p class="flex items-center gap-2">
<span class="material-icons-outlined text-sm">error</span>
<span id="tokenErrorText">Invalid or expired reset token. Please request a new password reset link.</span>
</p>
</div>
<div id="passwordForm" class="space-y-4">
<div>
<label for="password" class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">New Password</label>
<div class="relative">
<input id="password" name="password" type="password" required class="appearance-none relative block w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-700 placeholder-slate-400 text-navy-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm bg-white dark:bg-navy-800" placeholder="Enter your new password">
<button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-navy-900 dark:hover:text-white focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-xl toggle-password-icon">visibility_off</span>
</button>
</div>
<p class="mt-1 text-xs text-slate-500">Password must be at least 8 characters with uppercase, lowercase, number, and special character</p>
</div>
<div>
<label for="confirm_password" class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Confirm New Password</label>
<div class="relative">
<input id="confirm_password" name="confirm_password" type="password" required class="appearance-none relative block w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-700 placeholder-slate-400 text-navy-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm bg-white dark:bg-navy-800" placeholder="Confirm your new password">
<button type="button" onclick="togglePasswordVisibility('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-navy-900 dark:hover:text-white focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-xl toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
</div>
<div id="errorMessage" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded"></div>
<div id="successMessage" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded">
<p class="flex items-center gap-2">
<span class="material-icons-outlined text-sm">check_circle</span>
<span>Password reset successfully! Redirecting to login...</span>
</p>
</div>
<div id="submitButtonContainer">
<button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-navy-900 bg-primary hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all shadow-lg shadow-primary/20">
Reset Password
</button>
</div>
<div class="text-center space-y-2">
<p class="text-sm text-slate-600 dark:text-slate-400">
<a href="login.php" class="font-semibold text-primary hover:text-primary/80">Back to Sign In</a>
</p>
<p class="text-sm text-slate-600 dark:text-slate-400">
Don't have a valid reset link? <a href="forgot-password.php" class="font-semibold text-primary hover:text-primary/80">Request a new one</a>
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
// Validate token on page load
async function validateResetToken() {
    const token = document.getElementById('resetToken').value;
    const tokenError = document.getElementById('tokenError');
    const tokenErrorText = document.getElementById('tokenErrorText');
    const passwordForm = document.getElementById('passwordForm');
    const submitButtonContainer = document.getElementById('submitButtonContainer');
    const form = document.getElementById('resetPasswordForm');
    
    try {
        // Check token validity by attempting to fetch user info (we'll create a simple endpoint or check in reset API)
        // For now, we'll validate when form is submitted
        // Token validation will happen server-side on submit
    } catch (error) {
        console.error('Token validation error:', error);
    }
}

// Validate token on page load
document.addEventListener('DOMContentLoaded', async () => {
    const token = document.getElementById('resetToken').value;
    const tokenError = document.getElementById('tokenError');
    const tokenErrorText = document.getElementById('tokenErrorText');
    const passwordForm = document.getElementById('passwordForm');
    const submitButtonContainer = document.getElementById('submitButtonContainer');
    const form = document.getElementById('resetPasswordForm');
    
    if (!token || token.length < 32) {
        tokenError.classList.remove('hidden');
        tokenErrorText.textContent = 'Invalid reset token format. Please use the link from your email.';
        passwordForm.style.display = 'none';
        submitButtonContainer.style.display = 'none';
        return;
    }
    
    // Validate token with server
    try {
        const response = await fetch(`api/reset-password.php?token=${encodeURIComponent(token)}`);
        const data = await response.json();
        
        if (!data.success || !data.valid) {
            tokenError.classList.remove('hidden');
            tokenErrorText.textContent = data.message || 'Invalid or expired reset token. Please request a new password reset link.';
            passwordForm.style.display = 'none';
            submitButtonContainer.style.display = 'none';
        } else {
            // Token is valid, show form
            tokenError.classList.add('hidden');
            passwordForm.style.display = 'block';
            submitButtonContainer.style.display = 'block';
        }
    } catch (error) {
        console.error('Token validation error:', error);
        // Don't block the form on network errors - let server-side validation handle it
    }
});

document.getElementById('resetPasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const tokenInput = document.getElementById('resetToken');
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    const token = tokenInput.value;
    
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Hide previous messages
    errorMessage.classList.add('hidden');
    successMessage.classList.add('hidden');
    
    if (!password || !confirmPassword) {
        errorMessage.textContent = 'Please enter both password fields';
        errorMessage.classList.remove('hidden');
        return;
    }
    
    if (password !== confirmPassword) {
        errorMessage.textContent = 'Passwords do not match';
        errorMessage.classList.remove('hidden');
        return;
    }
    
    if (password.length < 8) {
        errorMessage.textContent = 'Password must be at least 8 characters long';
        errorMessage.classList.remove('hidden');
        return;
    }
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.textContent = 'Resetting...';
    
    try {
        const response = await fetch('api/reset-password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                token: token,
                password: password,
                confirm_password: confirmPassword
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            successMessage.classList.remove('hidden');
            passwordInput.disabled = true;
            confirmPasswordInput.disabled = true;
            submitBtn.textContent = 'Password Reset!';
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            submitBtn.classList.remove('bg-primary', 'hover:opacity-90');
            
            // Redirect to login after 3 seconds
            setTimeout(() => {
                window.location.href = 'login.php?reset=success';
            }, 3000);
        } else {
            errorMessage.textContent = data.message || 'Failed to reset password. Please try again or request a new reset link.';
            errorMessage.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Reset Password';
        }
    } catch (error) {
        console.error('Error:', error);
        errorMessage.textContent = 'An error occurred. Please try again later.';
        errorMessage.classList.remove('hidden');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Reset Password';
    }
});

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
