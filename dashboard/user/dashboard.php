<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'User Dashboard - WyomingTrust';
$userName = $_SESSION['user_name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#F59E0B",
                        "accent-orange": "#F59E0B",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111721",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
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
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<!-- TopNavBar -->
<header class="flex items-center justify-between border-b border-solid border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
<div class="flex items-center gap-4 sm:gap-6 lg:gap-8 flex-1 min-w-0">
<div class="flex items-center gap-2 sm:gap-4 text-primary flex-shrink-0">
<div class="size-6 sm:size-8">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
<path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
</div>
<h2 class="text-lg sm:text-xl font-black leading-tight tracking-tight">WyomingTrust</h2>
</div>
<label class="hidden sm:flex flex-col min-w-40 h-10 max-w-64">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full">
<div class="text-[#4e6b97] flex border-none bg-slate-100 dark:bg-slate-800 items-center justify-center pl-4 rounded-l-lg" data-icon="search">
<span class="material-symbols-outlined text-base sm:text-lg">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e131b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-slate-100 dark:bg-slate-800 focus:border-none h-full placeholder:text-[#4e6b97] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal" placeholder="Search portfolio..." value=""/>
</div>
</label>
</div>
<div class="flex flex-1 justify-end gap-4 sm:gap-6 items-center">
<div class="hidden sm:flex gap-2">
<button class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
<span class="material-symbols-outlined">notifications</span>
</button>
<button onclick="window.location.href='profile.php'" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
<span class="material-symbols-outlined">settings</span>
</button>
</div>
<div class="hidden sm:flex items-center gap-3 border-l pl-6 border-slate-200 dark:border-slate-700">
<div class="text-right">
<p class="text-xs font-semibold" id="userNameDisplay"><?php echo htmlspecialchars($userName); ?></p>
<p class="text-[10px] text-slate-500">Premium Plan</p>
</div>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" data-alt="User profile portrait"></div>
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
<a href="profile.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">person</span>
<span>Profile</span>
</a>
<a href="../../api/logout.php" class="px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center gap-3 border-t border-slate-200 dark:border-slate-700 mt-2 pt-4">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
<main class="flex-1 flex flex-col items-center">
<div class="layout-content-container flex flex-col max-w-[1200px] w-full px-4 py-8">
<!-- PageHeading -->
<div class="flex flex-wrap justify-between gap-3 p-3 sm:p-4">
<div class="flex min-w-0 flex-col gap-1 flex-1">
<p class="text-[#0e131b] dark:text-white text-2xl sm:text-3xl lg:text-4xl font-black leading-tight tracking-[-0.033em]">Welcome Back, <span id="userName"><?php echo htmlspecialchars($userName); ?></span></p>
<p class="text-[#4e6b97] text-sm sm:text-base font-normal leading-normal">Manage your trusts and monitor your crypto portfolio in one secure dashboard.</p>
</div>
</div>
<!-- Stats -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 p-3 sm:p-4">
<div class="flex flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">account_balance_wallet</span>
<p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Total Assets</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight">$<span id="totalAssets">0.00</span> <span class="text-xs text-slate-400 font-normal ml-1">in <span id="assetCount">0</span> assets</span></p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">description</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Active Trusts</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight" id="trustCount">0</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">group</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Beneficiaries</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight" id="beneficiaryCount">0</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-accent-orange">
<span class="material-symbols-outlined text-sm">sync</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Last Updated</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-base sm:text-xl font-bold leading-tight" id="lastUpdated">Just Now</p>
</div>
</div>
<!-- CTA Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 p-3 sm:p-4">
<div class="flex flex-col bg-[#171F30] rounded-xl overflow-hidden shadow-lg p-4 sm:p-6 relative group">
<div class="flex flex-col gap-3 sm:gap-4 z-10">
<div>
<h3 class="text-white text-lg sm:text-xl font-bold">Need to Link an External Wallet?</h3>
<p class="text-white/80 text-xs sm:text-sm">Securely connect your hardware or exchange holdings to WyomingTrust.</p>
</div>
<button onclick="window.location.href='link-wallet.php'" class="bg-white text-primary w-full sm:w-fit px-4 sm:px-6 py-2 rounded-lg font-bold text-xs sm:text-sm hover:bg-slate-100 transition-colors">Link Wallet</button>
</div>
<span class="material-symbols-outlined absolute right-[-20px] bottom-[-20px] text-[80px] sm:text-[120px] text-white/10 rotate-12 hidden sm:block">account_balance_wallet</span>
</div>
<div class="flex flex-col bg-accent-orange rounded-xl overflow-hidden shadow-lg p-4 sm:p-6 relative group">
<div class="flex flex-col gap-3 sm:gap-4 z-10">
<div>
<h3 class="text-white text-lg sm:text-xl font-bold">Need to Create Another Trust?</h3>
<p class="text-white/80 text-xs sm:text-sm">Expand your estate planning with new asset protections.</p>
</div>
<button onclick="window.location.href='../../onboarding/onboarding.php'" class="bg-white text-accent-orange w-full sm:w-fit px-4 sm:px-6 py-2 rounded-lg font-bold text-xs sm:text-sm hover:bg-slate-100 transition-colors">Create New Trust</button>
</div>
<span class="material-symbols-outlined absolute right-[-20px] bottom-[-20px] text-[80px] sm:text-[120px] text-white/10 rotate-12 hidden sm:block">verified_user</span>
</div>
</div>
<!-- Section: My Trusts -->
<div class="mt-8">
<div class="flex items-center justify-between px-4 pb-4">
<h2 class="text-2xl font-bold tracking-tight">My Trusts</h2>
<button class="text-primary text-sm font-semibold hover:underline">View All</button>
</div>
<div id="trustsContainer" class="px-4">
<!-- Trusts will be loaded dynamically via API -->
<div class="text-center py-10 text-slate-500">Loading trusts...</div>
</div>
</div>
<!-- Quick Actions -->
<div class="mt-8 mb-8 px-4">
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
<a href="assets.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">account_balance_wallet</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Assets</span>
</a>
<a href="transactions.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">history</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Transactions</span>
</a>
<a href="send.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">send</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Send</span>
</a>
<a href="receive.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">call_received</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Receive</span>
</a>
<a href="swap.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">swap_horiz</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Swap</span>
</a>
<a href="link-wallet.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">link</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Link Wallet</span>
</a>
<a href="manage-trust.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">account_balance</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Trusts</span>
</a>
<a href="profile.php" class="flex flex-col items-center gap-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-[#171F30] hover:bg-[#1f2a3f] transition-colors">
<span class="material-symbols-outlined text-2xl text-primary">person</span>
<span class="text-xs sm:text-sm font-semibold text-center text-white">Profile</span>
</a>
</div>
</div>
<!-- Section: Portfolio Activity -->
<div class="mt-8 mb-20 px-4">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
<h2 class="text-xl sm:text-2xl font-bold tracking-tight">Crypto Portfolio</h2>
<div class="flex gap-2 sm:gap-4">
<button onclick="window.location.href='assets.php'" class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-xs sm:text-sm hover:text-primary transition-colors">
<span class="material-symbols-outlined text-base">account_balance_wallet</span>
<span class="hidden sm:inline">View All Assets</span>
<span class="sm:hidden">Assets</span>
</button>
</div>
</div>
<div class="overflow-hidden border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 shadow-sm">
<div id="assetsContainer">
<div class="p-6 sm:p-10 text-center text-slate-500 text-sm sm:text-base">Loading assets...</div>
</div>
</div>
</div>
</div>
</main>
<!-- Simple Footer -->
<footer class="border-t border-slate-200 dark:border-slate-800 py-6 sm:py-8 px-4 sm:px-10 bg-white dark:bg-slate-900">
<div class="max-w-[1200px] mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6">
<div class="flex items-center gap-2 opacity-50">
<span class="material-symbols-outlined text-xs sm:text-sm">shield</span>
<p class="text-[10px] sm:text-xs">WyomingTrust Compliance Grade A+</p>
</div>
<div class="flex flex-wrap gap-4 sm:gap-8 text-xs font-medium text-slate-500 justify-center sm:justify-start">
<a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
<a class="hover:text-primary transition-colors" href="#">Help Center</a>
<a class="hover:text-primary transition-colors hidden sm:inline" href="#">Security</a>
</div>
<p class="text-[10px] text-slate-400">© 2024 WyomingTrust</p>
</div>
</footer>
</div>
</div>
<script>
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

let cryptoPrices = {};

// Helper function to safely format dates
function formatDateSafe(value) {
    if (!value) return 'N/A';
    try {
        const s = String(value).trim();
        if (s === '' || s === '0000-00-00 00:00:00' || s === '0000-00-00') return 'N/A';
        // Try to normalize MySQL datetime "YYYY-MM-DD HH:MM:SS" -> "YYYY-MM-DDTHH:MM:SS"
        const isoish = s.includes(' ') && !s.includes('T') ? s.replace(' ', 'T') : s;
        const d = new Date(isoish);
        if (Number.isNaN(d.getTime())) return 'N/A';
        return d.toLocaleDateString();
    } catch (e) {
        return 'N/A';
    }
}

// Load user data, trusts, and assets
async function loadDashboardData() {
    const trustsContainer = document.getElementById('trustsContainer');
    const trustCountEl = document.getElementById('trustCount');
    const beneficiaryEl = document.getElementById('beneficiaryCount');
    
    // Helper to show error in trusts container
    const showTrustsError = (message) => {
        if (trustsContainer) {
            trustsContainer.innerHTML = `<div class="text-center py-10 text-red-500">${escapeHtml(message)}</div>`;
        }
        if (trustCountEl) trustCountEl.textContent = '0';
        if (beneficiaryEl) beneficiaryEl.textContent = '0';
    };
    
    try {
        // Load trusts
        const trustsResponse = await fetch('../../api/user/trusts.php', {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        });
        
        if (!trustsResponse.ok) {
            console.error('Failed to fetch trusts:', trustsResponse.status, trustsResponse.statusText);
            showTrustsError(`Failed to load trusts (HTTP ${trustsResponse.status})`);
            // Continue to try loading assets even if trusts fail
        } else {
            let trustsData;
            try {
                trustsData = await trustsResponse.json();
            } catch (jsonError) {
                console.error('Failed to parse trusts JSON:', jsonError);
                showTrustsError('Invalid response from server');
                // Continue to try loading assets
            }
            
            if (trustsData && trustsData.success && Array.isArray(trustsData.trusts)) {
                // "Active Trusts" should count active trusts, not total
                const activeTrusts = trustsData.trusts.filter(t => {
                    const status = (t.status || '').toLowerCase();
                    return status === 'active';
                });
                if (trustCountEl) {
                    trustCountEl.textContent = String(activeTrusts.length);
                }
                
                // Beneficiaries: sum across trusts (use top-level beneficiaries array from API or fallback to nested)
                const totalBeneficiaries = trustsData.trusts.reduce((sum, t) => {
                    const bens = Array.isArray(t.beneficiaries) ? t.beneficiaries.length : 
                                (Array.isArray(t.trust_data?.beneficiaries) ? t.trust_data.beneficiaries.length : 0);
                    return sum + bens;
                }, 0);
                if (beneficiaryEl) {
                    beneficiaryEl.textContent = String(totalBeneficiaries);
                }

                renderTrusts(trustsData.trusts);
            } else {
                console.warn('Trusts data format unexpected:', trustsData);
                // Set counts to 0 if no trusts
                if (trustCountEl) trustCountEl.textContent = '0';
                if (beneficiaryEl) beneficiaryEl.textContent = '0';
                if (trustsContainer) {
                    trustsContainer.innerHTML = '<div class="text-center py-10 text-slate-500">No trusts yet. <a href="../../onboarding/onboarding.php" class="text-primary hover:underline">Create your first trust</a></div>';
                }
            }
        }
        
        // Load assets with real-time prices (don't let failures break the whole page)
        try {
            const assetsResponse = await fetch('../../api/user/assets.php', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            });
            
            if (assetsResponse.ok) {
                const assetsData = await assetsResponse.json();
                
                if (assetsData.success && assetsData.assets) {
                    // Fetch real-time prices from CoinGecko
                    await fetchCryptoPrices(assetsData.assets);
                    
                    // Calculate total value in USD using real-time prices
                    let totalValue = 0;
                    assetsData.assets.forEach(asset => {
                        // Try multiple price sources: API response, CoinGecko cache, or 0
                        const price = asset.price_usd || cryptoPrices[asset.coin_key]?.usd || 0;
                        const balance = parseFloat(asset.balance || 0);
                        totalValue += balance * price;
                    });
                    
                    const totalAssetsEl = document.getElementById('totalAssets');
                    const assetCountEl = document.getElementById('assetCount');
                    if (totalAssetsEl) totalAssetsEl.textContent = totalValue.toFixed(2);
                    if (assetCountEl) assetCountEl.textContent = String(assetsData.assets.length);
                    
                    // Render assets after prices are fetched
                    renderAssets(assetsData.assets);
                }
            } else {
                console.error('Failed to fetch assets:', assetsResponse.status);
            }
        } catch (assetsError) {
            console.error('Error loading assets:', assetsError);
            // Don't show error to user, just log it
        }
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showTrustsError('Error loading dashboard data. Please refresh the page.');
    }
}

// Price caching utility
function getCachedPrices() {
    try {
        const cached = sessionStorage.getItem('crypto_prices_cache');
        if (!cached) return null;
        const { data, timestamp } = JSON.parse(cached);
        const age = Date.now() - timestamp;
        if (age < 30000) { // 30 seconds cache
            return data;
        }
        sessionStorage.removeItem('crypto_prices_cache');
        return null;
    } catch (e) {
        return null;
    }
}

function setCachedPrices(prices) {
    try {
        sessionStorage.setItem('crypto_prices_cache', JSON.stringify({
            data: prices,
            timestamp: Date.now()
        }));
    } catch (e) {
        // Ignore storage errors
    }
}

// Batch coin IDs into groups to reduce request size
function batchCoinIds(coinIds, batchSize = 12) {
    const ids = coinIds.split(',').filter(Boolean);
    const batches = [];
    for (let i = 0; i < ids.length; i += batchSize) {
        batches.push(ids.slice(i, i + batchSize).join(','));
    }
    return batches;
}

async function fetchCryptoPrices(assets) {
    if (!assets || assets.length === 0) return;
    
    // Check cache first
    const cached = getCachedPrices();
    if (cached) {
        cryptoPrices = cached;
        return;
    }
    
    try {
        const coinIds = assets.map(a => a.coin_key).filter(Boolean).join(',');
        if (!coinIds) {
            // Try to use existing price_usd from assets
            assets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
            return;
        }
        
        // Split into batches to reduce rate limiting
        const batches = batchCoinIds(coinIds, 12);
        const allPrices = {};
        
        for (const batch of batches) {
            try {
                const response = await fetch(`/api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(batch)}&vs_currencies=usd&include_24hr_change=true`);
                
                if (response.ok) {
                    const data = await response.json();
                    if (data && !data.error) {
                        Object.assign(allPrices, data);
                        
                        // Check if using cached data
                        const priceSource = response.headers.get('X-Price-Source');
                        if (priceSource === 'cache' || priceSource === 'cache-fallback') {
                            const lastUpdated = response.headers.get('X-Cache-Last-Updated');
                            if (lastUpdated) {
                                console.log('Using cached prices. Last updated:', lastUpdated);
                            }
                        }
                    }
                }
            } catch (error) {
                console.error('Error fetching batch:', error);
                // Don't retry aggressively - server-side cache will handle fallback
            }
            
            // Small delay between batches to avoid rate limits
            if (batches.length > 1) {
                await new Promise(resolve => setTimeout(resolve, 500));
            }
        }
        
        if (Object.keys(allPrices).length > 0) {
            cryptoPrices = allPrices;
            setCachedPrices(allPrices);
        } else {
            // Final fallback: use asset price_usd values
            assets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
        }
    } catch (error) {
        console.error('Error fetching prices:', error);
        // Fallback to cached or asset prices
        const cached = getCachedPrices();
        if (cached) {
            cryptoPrices = cached;
        } else {
            assets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
        }
    }
}

function renderTrusts(trusts) {
    const container = document.getElementById('trustsContainer');
    if (!trusts || trusts.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-slate-500">No trusts yet. <a href="../../onboarding/onboarding.php" class="text-primary hover:underline">Create your first trust</a></div>';
        return;
    }
    
    const trustHtml = trusts.map(trust => {
        const trustName = trust.trust_name || trust.service_name || 'Untitled Trust';
        const trustType = trust.trust_type || trust.service_name || 'Standard';
        const createdDate = formatDateSafe(trust.created_at);
        const trustId = trust.id || 0;
        
        return '<div class="p-4 sm:p-6 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm mb-4">' +
            '<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4 border-b border-slate-100 dark:border-slate-800 pb-4 sm:pb-6 mb-4 sm:mb-6">' +
            '<div class="flex items-start gap-2 sm:gap-4 flex-1">' +
            '<div class="bg-primary/10 p-2 sm:p-3 rounded-lg text-primary flex-shrink-0">' +
            '<span class="material-symbols-outlined text-xl sm:text-2xl md:text-3xl">account_balance</span>' +
            '</div>' +
            '<div class="min-w-0 flex-1">' +
            '<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">' +
            '<h3 class="text-sm sm:text-base md:text-xl font-bold truncate">' + escapeHtml(trustName) + '</h3>' +
            '<span class="bg-primary/10 text-primary text-[9px] sm:text-[10px] uppercase font-bold px-2 py-0.5 rounded inline-block w-fit">' + escapeHtml(trustType) + '</span>' +
            '</div>' +
            '<p class="text-slate-500 text-[10px] sm:text-xs mt-1">Created: ' + createdDate + '</p>' +
            '</div>' +
            '</div>' +
            '<div class="flex gap-2 flex-shrink-0">' +
            '<button onclick="window.location.href=\'manage-trust.php?id=' + trustId + '\'" class="px-3 sm:px-4 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 whitespace-nowrap">Manage</button>' +
            '<button onclick="window.location.href=\'manage-trust.php?id=' + trustId + '\'" class="px-3 sm:px-4 py-1.5 sm:py-2 text-[10px] sm:text-xs font-bold bg-primary text-white rounded-lg hover:bg-primary/90 whitespace-nowrap">View Details</button>' +
            '</div>' +
            '</div>' +
            '</div>';
    }).join('');
    
    container.innerHTML = trustHtml;
}

function renderAssets(assets) {
    const container = document.getElementById('assetsContainer');
    if (!assets || assets.length === 0) {
        container.innerHTML = '<div class="p-6 sm:p-10 text-center text-slate-500 text-sm sm:text-base">No assets yet. <a href="link-wallet.php" class="text-primary hover:underline">Link a wallet</a> to get started.</div>';
        return;
    }
    
    // Sort assets by price (highest first)
    const sortedAssets = [...assets].sort((a, b) => {
        const priceA = a.price_usd || cryptoPrices[a.coin_key]?.usd || 0;
        const priceB = b.price_usd || cryptoPrices[b.coin_key]?.usd || 0;
        return priceB - priceA;
    });
    
    // Show top 5 assets in compact table (works on mobile too)
    const topAssets = sortedAssets.slice(0, 5);
    
    const tableHtml = `
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-500 uppercase">Asset</th>
                        <th class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-500 uppercase">Balance</th>
                        <th class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-500 uppercase">Price</th>
                        <th class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 text-[10px] sm:text-xs font-bold text-slate-500 uppercase text-right">Value</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    ${topAssets.map(asset => {
                        const price = asset.price_usd || cryptoPrices[asset.coin_key]?.usd || 0;
                        const change24h = asset.price_change_24h || cryptoPrices[asset.coin_key]?.usd_24h_change || 0;
                        const balance = parseFloat(asset.balance || 0);
                        const value = balance * price;
                        const changeClass = change24h >= 0 ? 'text-green-600' : 'text-red-600';
                        const changeSign = change24h >= 0 ? '+' : '';
                        
                        return `
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors cursor-pointer" onclick="window.location.href='asset-detail.php?coin_key=${escapeHtml(asset.coin_key)}'">
                                <td class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4">
                                    <div class="flex items-center gap-1.5 sm:gap-2 md:gap-3">
                                        <img src="${asset.logo || ''}" alt="${asset.display_name}" class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 rounded-full flex-shrink-0" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hidden">
                                            <span class="text-[8px] sm:text-[10px] md:text-xs font-bold">${escapeHtml((asset.symbol || '?').charAt(0))}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-[10px] sm:text-xs md:text-sm truncate">${escapeHtml(asset.display_name || asset.symbol || 'Unknown')}</p>
                                            <p class="text-[9px] sm:text-[10px] md:text-xs text-slate-400">${escapeHtml(asset.symbol || '')}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4">
                                    <p class="text-[10px] sm:text-xs md:text-sm font-medium">${balance.toFixed(8)}</p>
                                    <p class="text-[9px] sm:text-[10px] md:text-xs text-slate-500">${escapeHtml(asset.symbol || '')}</p>
                                </td>
                                <td class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4">
                                    <p class="text-[10px] sm:text-xs md:text-sm font-medium">$${price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: price > 1000 ? 2 : 6})}</p>
                                    <p class="text-[9px] sm:text-[10px] md:text-xs ${changeClass}">${changeSign}${Math.abs(change24h).toFixed(2)}%</p>
                                </td>
                                <td class="px-2 sm:px-4 md:px-6 py-2 sm:py-3 md:py-4 text-right">
                                    <p class="text-[10px] sm:text-xs md:text-sm font-bold">$${value.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</p>
                                </td>
                            </tr>
                        `;
                    }).join('')}
                </tbody>
            </table>
        </div>
        ${sortedAssets.length > 5 ? `
        <div class="bg-slate-50 dark:bg-slate-800/50 p-4 text-center border-t border-slate-100 dark:border-slate-800">
            <a href="assets.php" class="text-primary font-bold text-xs sm:text-sm hover:underline">View All ${sortedAssets.length} Assets →</a>
        </div>
        ` : ''}
    `;
    
    container.innerHTML = tableHtml;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Load data on page load
document.addEventListener('DOMContentLoaded', loadDashboardData);
</script>
</body>
</html>
