<?php
$page_title = 'Verify Your Email - WyomingTrust';
include 'includes/header.php';

// Get email from query parameter or session
$email = $_GET['email'] ?? $_SESSION['user_email'] ?? '';
?>

<section class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-navy-900">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white dark:bg-navy-800 rounded-xl shadow-lg p-8 border border-slate-200 dark:border-slate-700">
            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div class="bg-primary/10 p-4 rounded-full">
                    <span class="material-icons-outlined text-primary text-5xl">mail_outline</span>
                </div>
            </div>
            
            <!-- Title -->
            <h2 class="text-center text-3xl font-bold text-gray-900 dark:text-white mb-2">
                Check Your Email
            </h2>
            
            <!-- Message -->
            <p class="text-center text-gray-600 dark:text-slate-400 mb-6">
                We've sent a verification email to
                <strong class="text-gray-900 dark:text-white"><?php echo htmlspecialchars($email); ?></strong>
            </p>
            
            <p class="text-center text-sm text-gray-500 dark:text-slate-500 mb-8">
                Please click the verification link in the email to activate your account. The link will expire in 24 hours.
            </p>
            
            <!-- Resend Section -->
            <div class="space-y-4">
                <div id="resendContainer">
                    <p class="text-center text-sm text-gray-500 dark:text-slate-500 mb-4">
                        Didn't receive the email?
                    </p>
                    <button 
                        id="resendButton" 
                        class="w-full bg-primary text-navy-900 px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed"
                        onclick="resendVerificationEmail()"
                    >
                        Resend Verification Email
                    </button>
                </div>
                
                <!-- Countdown Timer -->
                <div id="countdownContainer" class="hidden text-center">
                    <p class="text-sm text-gray-600 dark:text-slate-400 mb-2">
                        Please wait <span id="countdown" class="font-bold text-primary">60</span> seconds before requesting another email.
                    </p>
                    <div class="w-full bg-slate-200 dark:bg-slate-700 rounded-full h-2">
                        <div id="countdownBar" class="bg-primary h-2 rounded-full transition-all duration-1000" style="width: 100%;"></div>
                    </div>
                </div>
                
                <!-- Success/Error Messages -->
                <div id="messageContainer" class="hidden"></div>
                
                <!-- Back to Login -->
                <div class="pt-4 border-t border-slate-200 dark:border-slate-700">
                    <p class="text-center text-sm text-gray-500 dark:text-slate-500 mb-4">
                        Already verified?
                    </p>
                    <a 
                        href="login.php" 
                        class="block w-full text-center bg-slate-100 dark:bg-navy-700 text-gray-900 dark:text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-200 dark:hover:bg-navy-600 transition-colors"
                    >
                        Go to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let countdownInterval = null;
let cooldownRemaining = 0;

// Check if there's a stored cooldown end time
const cooldownEnd = sessionStorage.getItem('verification_cooldown_end');
if (cooldownEnd) {
    const remaining = Math.max(0, Math.ceil((parseInt(cooldownEnd) - Date.now()) / 1000));
    if (remaining > 0) {
        startCountdown(remaining);
    }
}

function resendVerificationEmail() {
    const email = '<?php echo htmlspecialchars($email, ENT_QUOTES); ?>';
    
    if (!email) {
        showMessage('Email address not found. Please register again.', 'error');
        return;
    }
    
    const button = document.getElementById('resendButton');
    const resendContainer = document.getElementById('resendContainer');
    const countdownContainer = document.getElementById('countdownContainer');
    const messageContainer = document.getElementById('messageContainer');
    
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
            showMessage(data.message || 'Verification email sent successfully!', 'success');
            
            // Start countdown
            const cooldown = data.cooldown_remaining || 60;
            startCountdown(cooldown);
            
            // Store cooldown end time
            const cooldownEnd = Date.now() + (cooldown * 1000);
            sessionStorage.setItem('verification_cooldown_end', cooldownEnd.toString());
        } else {
            showMessage(data.message || 'Failed to send verification email. Please try again.', 'error');
            
            if (data.cooldown_remaining && data.cooldown_remaining > 0) {
                startCountdown(data.cooldown_remaining);
                const cooldownEnd = Date.now() + (data.cooldown_remaining * 1000);
                sessionStorage.setItem('verification_cooldown_end', cooldownEnd.toString());
            } else {
                button.disabled = false;
                button.textContent = 'Resend Verification Email';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('An error occurred. Please try again later.', 'error');
        button.disabled = false;
        button.textContent = 'Resend Verification Email';
    });
}

function startCountdown(seconds) {
    const button = document.getElementById('resendButton');
    const resendContainer = document.getElementById('resendContainer');
    const countdownContainer = document.getElementById('countdownContainer');
    const countdownDisplay = document.getElementById('countdown');
    const countdownBar = document.getElementById('countdownBar');
    
    cooldownRemaining = seconds;
    
    // Clear existing interval
    if (countdownInterval) {
        clearInterval(countdownInterval);
    }
    
    // Hide button, show countdown
    resendContainer.classList.add('hidden');
    countdownContainer.classList.remove('hidden');
    
    // Update countdown display and bar
    updateCountdownDisplay();
    
    countdownInterval = setInterval(() => {
        cooldownRemaining--;
        updateCountdownDisplay();
        
        if (cooldownRemaining <= 0) {
            clearInterval(countdownInterval);
            countdownInterval = null;
            
            // Show button, hide countdown
            countdownContainer.classList.add('hidden');
            resendContainer.classList.remove('hidden');
            button.disabled = false;
            button.textContent = 'Resend Verification Email';
            
            // Clear stored cooldown
            sessionStorage.removeItem('verification_cooldown_end');
        }
    }, 1000);
}

function updateCountdownDisplay() {
    const countdownDisplay = document.getElementById('countdown');
    const countdownBar = document.getElementById('countdownBar');
    
    if (countdownDisplay) {
        countdownDisplay.textContent = cooldownRemaining;
    }
    
    if (countdownBar && cooldownRemaining > 0) {
        const percentage = (cooldownRemaining / 60) * 100;
        countdownBar.style.width = percentage + '%';
    }
}

function showMessage(message, type) {
    const messageContainer = document.getElementById('messageContainer');
    
    const bgColor = type === 'success' 
        ? 'bg-green-50 dark:bg-green-900/20 border-green-400 text-green-700 dark:text-green-400'
        : 'bg-red-50 dark:bg-red-900/20 border-red-400 text-red-700 dark:text-red-400';
    
    messageContainer.className = `p-4 rounded-lg border ${bgColor} mb-4`;
    messageContainer.textContent = message;
    messageContainer.classList.remove('hidden');
    
    // Auto-hide success messages after 5 seconds
    if (type === 'success') {
        setTimeout(() => {
            messageContainer.classList.add('hidden');
        }, 5000);
    }
}
</script>

<?php include 'includes/footer.php'; ?>
