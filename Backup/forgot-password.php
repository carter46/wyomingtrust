<?php
$page_title = 'Forgot Password - WyomingTrust';
include 'includes/header.php';
?>
<section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-navy-900">
<div class="max-w-md w-full space-y-8">
<div class="text-center">
<h1 class="text-4xl font-bold text-navy-900 dark:text-white mb-2">Forgot Password?</h1>
<p class="text-lg text-slate-600 dark:text-slate-400">No worries! Enter your email address and we'll help you reset your password.</p>
</div>
<form class="mt-8 space-y-6" id="forgotPasswordForm">
<div>
<label for="email" class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Email Address</label>
<input id="email" name="email" type="email" required class="appearance-none relative block w-full px-4 py-3 border border-slate-300 dark:border-slate-700 placeholder-slate-400 text-navy-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary sm:text-sm bg-white dark:bg-navy-800" placeholder="Enter your registered email">
</div>
<div id="errorMessage" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded"></div>
<div id="successMessage" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded">
<p class="flex items-center gap-2">
<span class="material-icons-outlined text-sm">check_circle</span>
<span id="successText">Password reset link has been sent to your email address.</span>
</p>
</div>
<div>
<button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-base font-semibold rounded-lg text-navy-900 bg-primary hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all shadow-lg shadow-primary/20">
Send Reset Instructions
</button>
</div>
<div class="text-center space-y-2">
<p class="text-sm text-slate-600 dark:text-slate-400">
Remember your password? <a href="login.php" class="font-semibold text-primary hover:text-primary/80">Sign In</a>
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
document.getElementById('forgotPasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const emailInput = document.getElementById('email');
    const email = emailInput.value.trim();
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    const submitBtn = e.target.querySelector('button[type="submit"]');
    
    // Hide previous messages
    errorMessage.classList.add('hidden');
    successMessage.classList.add('hidden');
    
    if (!email) {
        errorMessage.textContent = 'Please enter your email address';
        errorMessage.classList.remove('hidden');
        return;
    }
    
    // Disable button and show loading
    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';
    
    try {
        const response = await fetch('api/forgot-password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ email: email })
        });
        
        const data = await response.json();
        
        if (data.success) {
            successMessage.classList.remove('hidden');
            emailInput.disabled = true;
            submitBtn.textContent = 'Email Sent!';
            submitBtn.classList.add('bg-green-600', 'hover:bg-green-700');
            submitBtn.classList.remove('bg-primary', 'hover:opacity-90');
        } else {
            errorMessage.textContent = data.message || 'Failed to send reset email. Please try again.';
            errorMessage.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = 'Send Reset Instructions';
        }
    } catch (error) {
        console.error('Error:', error);
        errorMessage.textContent = 'An error occurred. Please try again later.';
        errorMessage.classList.remove('hidden');
        submitBtn.disabled = false;
        submitBtn.textContent = 'Send Reset Instructions';
    }
});
</script>
<?php include 'includes/footer.php'; ?>
