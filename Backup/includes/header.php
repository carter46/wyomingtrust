<?php
// Shared header navigation component
// Get current page for active state
require_once __DIR__ . '/../api/helpers.php';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo isset($page_title) ? escape_html($page_title) : 'WyomingTrust | Secure Your Digital Legacy'; ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Lexend:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet"/>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#F59E0B",
                        "background-light": "#F8FAFC",
                        "background-dark": "#0F172A",
                        "navy-900": "#0F172A",
                        "navy-800": "#1E293B",
                        "navy-700": "#334155",
                    },
                    fontFamily: {
                        display: ["Lexend", "sans-serif"],
                        sans: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.75rem",
                    },
                },
            },
        };
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4 { font-family: 'Lexend', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .material-icons-outlined.filled-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .filled-icon {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 transition-colors duration-300">
<!-- Top Bar with Security Badges -->
<div class="bg-navy-900 text-white/80 py-1.5 sm:py-2 border-b border-white/10 text-[10px] sm:text-xs">
    <div class="max-w-7xl mx-auto px-4 flex flex-wrap justify-center items-center gap-3 sm:gap-8">
        <div class="flex items-center gap-1 sm:gap-1.5">
            <span class="material-icons-outlined text-[12px] sm:text-[14px]">shield</span> 
            <span class="hidden sm:inline">Bank-Level Security</span>
            <span class="sm:hidden">Secure</span>
        </div>
        <div class="flex items-center gap-1 sm:gap-1.5">
            <span class="material-icons-outlined text-[12px] sm:text-[14px]">currency_bitcoin</span> 
            <span class="hidden sm:inline">Multi-Crypto Support</span>
            <span class="sm:hidden">Crypto</span>
        </div>
        <div class="flex items-center gap-1 sm:gap-1.5">
            <span class="material-icons-outlined text-[12px] sm:text-[14px]">add_task</span> 
            <span class="hidden sm:inline">Free Setup</span>
            <span class="sm:hidden">Free</span>
        </div>
    </div>
</div>
<!-- Banner -->
<div class="bg-[#FFF9E6] dark:bg-amber-50 py-1 sm:py-1.5 text-center text-[10px] sm:text-[11px] font-medium text-slate-600 border-b border-[#FEEBB3] dark:border-amber-200 px-2">
    <span class="material-icons-outlined text-primary text-xs sm:text-sm mr-1">warning</span>
    <span class="hidden sm:inline">Secure Your Digital Legacy with Professional Trust Management</span>
    <span class="sm:hidden">Secure Your Digital Legacy</span>
</div>
<nav class="sticky top-0 z-50 bg-white/80 dark:bg-navy-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
<div class="flex justify-between items-center h-16 sm:h-20">
<div class="flex items-center gap-2">
<a href="index.php" class="flex items-center gap-2">
<div class="bg-primary p-1 sm:p-1.5 rounded-lg">
<span class="material-icons-outlined text-navy-900 font-bold text-base sm:text-lg">account_balance</span>
</div>
<span class="text-lg sm:text-xl font-bold tracking-tight text-navy-900 dark:text-white">Wyoming<span class="text-primary">Trust</span></span>
</a>
</div>
<!-- Desktop Navigation -->
<div class="hidden lg:flex items-center space-x-8">
<!-- Trust Services Dropdown -->
<div class="relative group">
<a class="text-sm font-medium hover:text-primary transition-colors cursor-pointer flex items-center gap-1" href="#">
Trust Services
<span class="material-icons-outlined text-xs">expand_more</span>
</a>
<div class="absolute top-full left-0 mt-2 w-64 bg-white dark:bg-navy-800 rounded-lg shadow-xl border border-slate-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
<div class="py-2">
<a href="irrevocable_trust_service.php" class="block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-navy-700 transition-colors">Irrevocable Trust Service</a>
<a href="revocable_living_trust_details.php" class="block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-navy-700 transition-colors">Revocable Living Trust</a>
<a href="crypto_asset_trust_service.php" class="block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-navy-700 transition-colors">Crypto Asset Trust Service</a>
<a href="smart_contract_trust_service.php" class="block px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-navy-700 transition-colors">Smart Contract Trust Service</a>
</div>
</div>
</div>
<a class="text-sm font-medium hover:text-primary transition-colors <?php echo ($current_page === 'trust_llc') ? 'text-primary' : ''; ?>" href="trust_llc.php">Wyoming LLC</a>
<a class="text-sm font-medium hover:text-primary transition-colors <?php echo ($current_page === 'about_us') ? 'text-primary' : ''; ?>" href="about_us.php">About Us</a>
<a class="text-sm font-medium hover:text-primary transition-colors <?php echo ($current_page === 'contact_us') ? 'text-primary' : ''; ?>" href="contact_us.php">Contact Us</a>
<a class="text-sm font-medium hover:text-primary transition-colors <?php echo ($current_page === 'pricing') ? 'text-primary' : ''; ?>" href="pricing.php">Pricing</a>
</div>
<div class="hidden lg:flex items-center gap-4">
<?php if (isset($_SESSION['user_id'])): ?>
<a href="dashboard/user/dashboard.php" class="text-sm font-medium px-4 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Dashboard</a>
<a href="onboarding/onboarding.php" class="bg-primary text-navy-900 px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary/20">Create Trust</a>
<?php else: ?>
<a href="login.php" class="text-sm font-medium px-4 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">Sign In</a>
<a href="onboarding/onboarding.php" class="bg-primary text-navy-900 px-6 py-2.5 rounded-lg font-semibold text-sm hover:opacity-90 transition-all shadow-lg shadow-primary/20">Create Trust</a>
<?php endif; ?>
</div>
<!-- Mobile Menu Button -->
<button id="mobileMenuBtn" class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" onclick="toggleMobileMenu()">
<span class="material-icons-outlined">menu</span>
</button>
</div>
<!-- Mobile Navigation Menu -->
<div id="mobileMenu" class="hidden lg:hidden pb-4 border-t border-slate-200 dark:border-slate-800">
<div class="flex flex-col space-y-1 pt-4">
<a href="irrevocable_trust_service.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Irrevocable Trust</a>
<a href="revocable_living_trust_details.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Revocable Trust</a>
<a href="crypto_asset_trust_service.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Crypto Asset Trust</a>
<a href="smart_contract_trust_service.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Smart Contract Trust</a>
<a href="trust_llc.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Wyoming LLC</a>
<a href="about_us.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">About Us</a>
<a href="contact_us.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Contact Us</a>
<a href="pricing.php" class="px-4 py-2 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Pricing</a>
<div class="flex flex-col gap-2 px-4 pt-2 border-t border-slate-200 dark:border-slate-800 mt-2">
<?php if (isset($_SESSION['user_id'])): ?>
<a href="dashboard/user/dashboard.php" class="text-center text-sm font-medium px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Dashboard</a>
<a href="onboarding/onboarding.php" class="text-center bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition-all">Create Trust</a>
<?php else: ?>
<a href="login.php" class="text-center text-sm font-medium px-4 py-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Sign In</a>
<a href="onboarding/onboarding.php" class="text-center bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold text-sm hover:opacity-90 transition-all">Create Trust</a>
<?php endif; ?>
</div>
</div>
</div>
</div>
</nav>
<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        btn.innerHTML = '<span class="material-icons-outlined">close</span>';
    } else {
        menu.classList.add('hidden');
        btn.innerHTML = '<span class="material-icons-outlined">menu</span>';
    }
}
</script>