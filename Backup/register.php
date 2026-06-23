<?php
// Redirect to onboarding process - onboarding IS the registration process
header('Location: onboarding/onboarding.php');
exit;
?>
<section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-navy-900">
<div class="max-w-md w-full space-y-8">
<div>
<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">Create your account</h2>
<p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">Join WyomingTrust to secure your digital legacy</p>
</div>
<form class="mt-8 space-y-6" id="registerForm">
<div class="rounded-md shadow-sm space-y-4">
<div>
<label for="full_name" class="sr-only">Full Name</label>
<input id="full_name" name="full_name" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Full Name">
</div>
<div>
<label for="email" class="sr-only">Email address</label>
<input id="email" name="email" type="email" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Email address">
</div>
<div>
<label for="password" class="sr-only">Password</label>
<div class="relative">
<input id="password" name="password" type="password" required class="appearance-none relative block w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Password">
<button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
</button>
</div>
<p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters with uppercase, lowercase, number, and special character</p>
</div>
<div>
<label for="confirm_password" class="sr-only">Confirm Password</label>
<div class="relative">
<input id="confirm_password" name="confirm_password" type="password" required class="appearance-none relative block w-full px-3 py-2 pr-10 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm" placeholder="Confirm Password">
<button type="button" onclick="togglePasswordVisibility('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
</div>
<div id="errorMessage" class="hidden bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-4 py-3 rounded"></div>
<div id="successMessage" class="hidden bg-green-50 dark:bg-green-900/20 border border-green-400 text-green-700 dark:text-green-400 px-4 py-3 rounded"></div>
<div>
<button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
Create Account
</button>
</div>
<div class="text-sm text-center">
<a href="login.php" class="font-medium text-primary hover:text-primary/80">Already have an account? Sign In</a>
</div>
</form>
</div>
</section>
<script>
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const errorMessage = document.getElementById('errorMessage');
    const successMessage = document.getElementById('successMessage');
    errorMessage.classList.add('hidden');
    successMessage.classList.add('hidden');
    
    const fullName = document.getElementById('full_name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        errorMessage.textContent = 'Passwords do not match';
        errorMessage.classList.remove('hidden');
        return;
    }
    
    const formData = {
        full_name: fullName,
        email: email,
        password: password
    };
    
    try {
        const response = await fetch('api/register.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (data.success) {
            successMessage.textContent = data.message || 'Registration successful!';
            successMessage.classList.remove('hidden');
            
            if (data.redirect_url) {
                setTimeout(() => {
                    window.location.href = data.redirect_url;
                }, 2000);
            } else if (data.requires_verification) {
                setTimeout(() => {
                    window.location.href = 'verify-status.php?email=' + encodeURIComponent(email);
                }, 2000);
            } else {
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
            }
        } else {
            errorMessage.textContent = data.message || 'Registration failed';
            errorMessage.classList.remove('hidden');
        }
    } catch (error) {
        console.error('Registration error:', error);
        errorMessage.textContent = 'An unexpected error occurred. Please try again.';
        errorMessage.classList.remove('hidden');
    }
});

// Password visibility toggle function
function togglePasswordVisibility(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('.toggle-password-icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.textContent = 'visibility';
    } else {
        input.type = 'password';
        icon.textContent = 'visibility_off';
    }
}
</script>
<?php include 'includes/footer.php'; ?>
