<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Profile Settings - WyomingTrust';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<script>
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                    colors: {
                        "primary": "#F59E0B",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111721",
                    },
                fontFamily: {
                    "display": ["Inter"]
                },
            },
        },
    }
</script>
<style>
    .material-symbols-outlined {
        font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
    }
</style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen text-[#0e131b] dark:text-white">
<div class="min-h-screen flex flex-col">
<header class="flex items-center justify-between border-b border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
<div class="flex items-center gap-2 sm:gap-4">
<a href="dashboard.php" class="flex items-center gap-2 sm:gap-4 text-primary">
<div class="size-6 sm:size-8"><svg fill="none" viewbox="0 0 48 48"><path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path></svg></div>
<h2 class="text-lg sm:text-xl font-black">WyomingTrust</h2>
</a>
</div>
<div class="flex flex-1 justify-end gap-4 sm:gap-6 items-center">
<div class="hidden sm:flex gap-2">
<button onclick="window.history.back()" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
<span class="material-symbols-outlined">arrow_back</span>
</button>
</div>
<button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="sm:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 ml-auto">
<span class="material-symbols-outlined">menu</span>
</button>
<a href="../../api/logout.php" class="hidden sm:flex text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 px-2 sm:px-0">Logout</a>
</div>
</header>
<!-- Mobile Navigation Menu -->
<div id="mobileMenu" class="hidden sm:hidden pb-4 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
<div class="flex flex-col gap-1 px-4 pt-4">
<a href="dashboard.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a href="assets.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">account_balance_wallet</span>
<span>Assets</span>
</a>
<a href="transactions.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">history</span>
<span>Transactions</span>
</a>
<a href="send.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">send</span>
<span>Send</span>
</a>
<a href="receive.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">call_received</span>
<span>Receive</span>
</a>
<a href="swap.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">swap_horiz</span>
<span>Swap</span>
</a>
<a href="link-wallet.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">link</span>
<span>Link Wallet</span>
</a>
<a href="manage-trust.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">account_balance</span>
<span>Manage Trusts</span>
</a>
<a href="profile.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
<span class="material-symbols-outlined">person</span>
<span>Profile</span>
</a>
<a href="../../api/logout.php" class="px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center gap-3 border-t border-slate-200 dark:border-slate-700 mt-2 pt-4">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
<main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-2xl mx-auto w-full">
<h1 class="text-2xl sm:text-3xl font-black mb-4 sm:mb-6">Profile Settings</h1>
<div class="space-y-6">
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
<h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Account Information</h2>
<div class="space-y-4">
<div>
<label class="block text-sm font-semibold mb-2">Full Name</label>
<input type="text" id="fullName" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
</div>
<div>
<label class="block text-sm font-semibold mb-2">Email Address</label>
<input type="email" id="email" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<p class="text-xs text-slate-500 mt-2">Email verification: <span id="emailStatus" class="font-semibold">--</span></p>
</div>
<button onclick="updateProfile()" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors">
Save Changes
</button>
</div>
</div>
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
<h2 class="text-lg sm:text-xl font-bold mb-4 sm:mb-6">Change Password</h2>
<div class="space-y-4">
<div>
<label class="block text-sm font-semibold mb-2">Current Password</label>
<div class="relative">
<input type="password" id="currentPassword" class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<button type="button" onclick="togglePasswordVisibility('currentPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
<div>
<label class="block text-sm font-semibold mb-2">New Password</label>
<div class="relative">
<input type="password" id="newPassword" class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<button type="button" onclick="togglePasswordVisibility('newPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
<div>
<label class="block text-sm font-semibold mb-2">Confirm New Password</label>
<div class="relative">
<input type="password" id="confirmPassword" class="w-full px-4 py-3 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<button type="button" onclick="togglePasswordVisibility('confirmPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
<span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
</button>
</div>
</div>
<button onclick="changePassword()" class="w-full bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 py-3 rounded-lg font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
Change Password
</button>
</div>
</div>
</div>
</main>
</div>
<script>
let userProfile = null;

async function loadProfile() {
    try {
        const response = await fetch('../../api/user/profile.php');
        const data = await response.json();
        if (data.success && data.user) {
            userProfile = data.user;
            document.getElementById('fullName').value = userProfile.full_name || '';
            document.getElementById('email').value = userProfile.email || '';
            document.getElementById('emailStatus').textContent = userProfile.email_verified ? 'Verified' : 'Not Verified';
            document.getElementById('emailStatus').className = userProfile.email_verified ? 'font-semibold text-green-600' : 'font-semibold text-amber-600';
        }
    } catch (error) {
        console.error('Error loading profile:', error);
    }
}

async function updateProfile() {
    const fullName = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    
    if (!fullName || !email) {
        alert('Please fill in all fields');
        return;
    }
    
    try {
        const response = await fetch('../../api/user/profile.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                full_name: fullName,
                email: email
            })
        });
        const data = await response.json();
        if (data.success) {
            alert('Profile updated successfully!');
            if (email !== userProfile.email) {
                alert('Verification email sent. Please verify your new email address.');
            }
            loadProfile();
        } else {
            alert(data.message || 'Failed to update profile');
        }
    } catch (error) {
        console.error('Error updating profile:', error);
        alert('Failed to update profile');
    }
}

async function changePassword() {
    const current = document.getElementById('currentPassword').value;
    const newPass = document.getElementById('newPassword').value;
    const confirm = document.getElementById('confirmPassword').value;
    
    if (!current || !newPass || !confirm) {
        alert('Please fill in all password fields');
        return;
    }
    
    if (newPass !== confirm) {
        alert('New passwords do not match');
        return;
    }
    
    if (newPass.length < 8) {
        alert('Password must be at least 8 characters long');
        return;
    }
    
    try {
        const response = await fetch('../../api/user/profile.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                current_password: current,
                password: newPass
            })
        });
        const data = await response.json();
        if (data.success) {
            alert('Password changed successfully!');
            document.getElementById('currentPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
        } else {
            alert(data.message || 'Failed to change password');
        }
    } catch (error) {
        console.error('Error changing password:', error);
        alert('Failed to change password');
    }
}

document.addEventListener('DOMContentLoaded', loadProfile);
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        btn.innerHTML = '<span class="material-symbols-outlined">close</span>';
    } else {
        menu.classList.add('hidden');
        btn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
    }
}
</script>
</body>
</html>
