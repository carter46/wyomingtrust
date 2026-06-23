<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication
require_user_page_auth('../../login.php');

// Get wallet link settings
$db = getDatabase();
$stmt = $db->prepare('SELECT wallet_link_use_modal, wallet_link_url FROM site_settings WHERE id = 1 LIMIT 1');
$stmt->execute();
$walletSettings = $stmt->fetch(PDO::FETCH_ASSOC);

$useModal = isset($walletSettings['wallet_link_use_modal']) ? (int)$walletSettings['wallet_link_use_modal'] : 1;
$walletLinkUrl = $walletSettings['wallet_link_url'] ?? '';

$page_title = 'Link Wallet - WyomingTrust';
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<!-- Google Fonts & Material Symbols -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#F59E0B",
                        "navy-brand": "#0A192F",
                        "background-light": "#f8f7f5",
                        "background-dark": "#231a0f",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        /* Subtle blockchain node pattern */
        .blockchain-pattern {
            background-color: transparent;
            background-image: radial-gradient(#0A192F 0.5px, transparent 0.5px), radial-gradient(#0A192F 0.5px, #f8f7f5 0.5px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            opacity: 0.03;
        }
        .dark .blockchain-pattern {
            background-image: radial-gradient(#F59E0B 0.5px, transparent 0.5px), radial-gradient(#F59E0B 0.5px, #231a0f 0.5px);
            opacity: 0.05;
        }
    </style>
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-[#1d150c] dark:text-white min-h-screen flex flex-col">
<!-- Top Navigation Bar -->
<header class="w-full border-b border-[#eaddcd] dark:border-[#3d2f1f] bg-white/80 dark:bg-background-dark/80 backdrop-blur-md sticky top-0 z-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="p-1.5 bg-navy-brand dark:bg-primary rounded-lg text-white dark:text-navy-brand">
<span class="material-symbols-outlined block">account_balance_wallet</span>
</div>
<a href="dashboard.php" class="text-navy-brand dark:text-white text-xl font-bold tracking-tight">WyomingTrust</a>
</div>
<div class="flex items-center gap-3">
<div class="hidden md:flex items-center gap-8">
<a class="text-sm font-medium hover:text-primary transition-colors" href="dashboard.php">Dashboard</a>
<a class="text-sm font-medium hover:text-primary transition-colors" href="assets.php">Assets</a>
<a class="text-sm font-medium hover:text-primary transition-colors" href="transactions.php">Transactions</a>
</div>
<button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="md:hidden p-2 text-[#a17745] hover:bg-primary/10 rounded-lg transition-colors ml-auto">
<span class="material-symbols-outlined">menu</span>
</button>
<a href="../../api/logout.php" class="hidden md:flex text-sm text-red-600 dark:text-red-400 hover:text-red-700">Logout</a>
</div>
</header>
<!-- Mobile Navigation Menu -->
<div id="mobileMenu" class="hidden md:hidden pb-4 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
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
<a href="link-wallet.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
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
<!-- Main Content Area -->
<main class="flex-grow flex items-center justify-center relative px-4 py-12">
<!-- Pattern Overlay -->
<div class="absolute inset-0 blockchain-pattern pointer-events-none"></div>
<div class="layout-content-container flex flex-col max-w-[520px] w-full z-10">
<!-- Connection Card -->
<div class="bg-white dark:bg-[#2d2216] p-8 md:p-12 rounded-xl shadow-xl border border-[#eaddcd]/50 dark:border-[#3d2f1f]">
<div class="flex flex-col items-center text-center space-y-6">
<!-- Icon Visual -->
<div class="relative">
<div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-4xl">link</span>
</div>
<div class="absolute -bottom-1 -right-1 w-8 h-8 bg-white dark:bg-[#2d2216] rounded-full border-4 border-background-light dark:border-background-dark flex items-center justify-center">
<span class="material-symbols-outlined text-navy-brand dark:text-primary text-xs font-bold">lock</span>
</div>
</div>
<!-- Text Content -->
<div class="space-y-3">
<h2 class="text-navy-brand dark:text-white text-3xl font-bold leading-tight tracking-tight">Connect Your Wallet</h2>
<p class="text-[#a17745] dark:text-gray-400 text-base max-w-[340px] mx-auto">
                            Securely connect your external wallet to access your funds and manage your digital legacy.
                        </p>
</div>
<!-- CTA Button -->
<button id="connectWalletBtn" onclick="openWalletModal()" class="w-full py-4 bg-primary text-white text-lg font-bold rounded-lg shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-2 group">
<span class="truncate">Connect Wallet</span>
<span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
<!-- Trust Footer -->
<div class="pt-6 border-t border-[#f4eee6] dark:border-[#3d2f1f] w-full flex flex-col gap-4">
<div class="flex items-center justify-center gap-2 text-xs text-[#a17745] font-medium uppercase tracking-widest">
<span class="material-symbols-outlined text-sm">verified_user</span>
                            Non-custodial and secure
                        </div>
<!-- Stats Highlight -->
<div class="grid grid-cols-2 gap-4">
<div class="p-3 bg-background-light dark:bg-background-dark rounded-lg text-left">
<p class="text-[10px] text-[#a17745] font-bold uppercase">Supported</p>
<p class="text-lg font-bold text-navy-brand dark:text-white">20+ Wallets</p>
</div>
<div class="p-3 bg-background-light dark:bg-background-dark rounded-lg text-left">
<p class="text-[10px] text-[#a17745] font-bold uppercase">Encryption</p>
<p class="text-lg font-bold text-navy-brand dark:text-white">AES-256</p>
</div>
</div>
</div>
</div>
<!-- Supporting Information -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="flex items-center gap-3 p-4 bg-white/50 dark:bg-[#2d2216]/50 rounded-lg border border-dashed border-[#eaddcd] dark:border-[#3d2f1f]">
<span class="material-symbols-outlined text-primary text-xl">shield</span>
<span class="text-xs font-semibold text-[#1d150c] dark:text-gray-300">Privacy First</span>
</div>
<div class="flex items-center gap-3 p-4 bg-white/50 dark:bg-[#2d2216]/50 rounded-lg border border-dashed border-[#eaddcd] dark:border-[#3d2f1f]">
<span class="material-symbols-outlined text-primary text-xl">bolt</span>
<span class="text-xs font-semibold text-[#1d150c] dark:text-gray-300">Fast Sync</span>
</div>
<div class="flex items-center gap-3 p-4 bg-white/50 dark:bg-[#2d2216]/50 rounded-lg border border-dashed border-[#eaddcd] dark:border-[#3d2f1f]">
<span class="material-symbols-outlined text-primary text-xl">account_tree</span>
<span class="text-xs font-semibold text-[#1d150c] dark:text-gray-300">Multi-Chain</span>
</div>
</div>
</div>
</main>
<!-- Wallet Selection Modal -->
<?php if ($useModal): ?>
<div id="walletModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
<div class="bg-white dark:bg-[#2d2216] rounded-xl shadow-2xl border border-[#eaddcd] dark:border-[#3d2f1f] max-w-md w-full max-h-[90vh] overflow-y-auto">
<div class="p-6 border-b border-[#eaddcd] dark:border-[#3d2f1f] flex items-center justify-between">
<h3 class="text-xl font-bold text-navy-brand dark:text-white">Select Wallet</h3>
<button onclick="closeWalletModal()" class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div class="p-6 space-y-3">
<!-- Security Notice -->
<div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg mb-4">
<p class="text-xs text-amber-800 dark:text-amber-300 font-semibold mb-2">🔒 Security Notice:</p>
<ul class="text-xs text-amber-700 dark:text-amber-400 space-y-1 list-disc pl-4">
<li>Wallet data is encrypted using AES-256-CBC encryption</li>
<li>We never store your private keys or seed phrases</li>
<li>All wallet information is encrypted at rest</li>
</ul>
</div>
<!-- Wallet Options -->
<div id="wallet-metamask" onclick="selectWallet('metamask')" class="flex items-center justify-between p-4 rounded-lg bg-primary/10 border-2 border-primary shadow-sm cursor-pointer hover:bg-primary/20 transition-colors">
<div class="flex items-center gap-3">
<div class="size-10 rounded-full bg-white dark:bg-[#3d2f1f] p-1 flex items-center justify-center">
<img class="size-full object-contain" alt="MetaMask logo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWfVybyxVRMMOA3-0jJXnV0NSa3hm3i9NSY6KBGa5YJKjvsUunZmezgaei3EgOaOmVPQsVa-3DO8QUkrj8oW_vBIGux0TWZMbnrp7kU0JwCyFTbP4MI-JMzyIdxbNRcZ33bVZU6A7-lUAKkC98Nwm_UYfbnzgBhPRXWKIWyEo2Nlv9Votw8z271vMEZFZ1KOCTNWs21osdA7q4GMkfTLZgi-47MbQT7YjK1WV1jSKmMkYSkft1tUg_r7-p1J21uAb35OVJdT7mswUM"/>
</div>
<div class="text-left">
<span class="text-navy-brand dark:text-white font-semibold text-base block">MetaMask</span>
<span class="text-xs text-[#a17745]">Browser Extension</span>
</div>
</div>
<span id="metamask-selected" class="bg-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider hidden">Selected</span>
</div>
<div id="wallet-coinbase" onclick="selectWallet('coinbase')" class="flex items-center gap-3 p-4 rounded-lg border border-[#eaddcd] dark:border-[#3d2f1f] cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
<div class="size-10 rounded-full bg-white dark:bg-[#3d2f1f] p-1 flex items-center justify-center">
<span class="material-symbols-outlined text-blue-600 text-2xl">account_balance_wallet</span>
</div>
<div class="text-left flex-1">
<span class="text-navy-brand dark:text-white font-medium text-base block">Coinbase Wallet</span>
<span class="text-xs text-[#a17745]">Mobile & Extension</span>
</div>
</div>
<div id="wallet-trust" onclick="selectWallet('trust')" class="flex items-center gap-3 p-4 rounded-lg border border-[#eaddcd] dark:border-[#3d2f1f] cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
<div class="size-10 rounded-full bg-white dark:bg-[#3d2f1f] p-1 flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-2xl">shield_with_heart</span>
</div>
<div class="text-left flex-1">
<span class="text-navy-brand dark:text-white font-medium text-base block">Trust Wallet</span>
<span class="text-xs text-[#a17745]">Mobile App</span>
</div>
</div>
<div id="wallet-walletconnect" onclick="selectWallet('walletconnect')" class="flex items-center gap-3 p-4 rounded-lg border border-[#eaddcd] dark:border-[#3d2f1f] cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
<div class="size-10 rounded-full bg-white dark:bg-[#3d2f1f] p-1 flex items-center justify-center">
<span class="material-symbols-outlined text-blue-400 text-2xl">sync</span>
</div>
<div class="text-left flex-1">
<span class="text-navy-brand dark:text-white font-medium text-base block">WalletConnect</span>
<span class="text-xs text-[#a17745]">Universal Protocol</span>
</div>
</div>
</div>
<div class="p-6 border-t border-[#eaddcd] dark:border-[#3d2f1f]">
<button id="connectBtn" onclick="linkWallet()" class="w-full py-3 bg-primary text-white text-base font-bold rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
Connect
</button>
</div>
</div>
</div>
<?php endif; ?>
<!-- Footer -->
<footer class="w-full px-4 sm:px-6 py-8 border-t border-[#eaddcd] dark:border-[#3d2f1f] bg-white/40 dark:bg-background-dark/40">
<div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
<div class="flex flex-wrap items-center justify-center gap-8">
<a class="text-[#a17745] text-sm hover:text-primary transition-colors" href="#">Privacy Policy</a>
<a class="text-[#a17745] text-sm hover:text-primary transition-colors" href="#">Terms of Service</a>
<a class="text-[#a17745] text-sm hover:text-primary transition-colors" href="#">Security Standards</a>
<a class="text-[#a17745] text-sm hover:text-primary transition-colors" href="#">Support</a>
</div>
<p class="text-[#a17745] text-sm font-medium">© 2024 WyomingTrust. Digital Asset Management.</p>
</div>
</footer>
<script>
const wallets = {
    'metamask': { name: 'MetaMask', iconUrl: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAWfVybyxVRMMOA3-0jJXnV0NSa3hm3i9NSY6KBGa5YJKjvsUunZmezgaei3EgOaOmVPQsVa-3DO8QUkrj8oW_vBIGux0TWZMbnrp7kU0JwCyFTbP4MI-JMzyIdxbNRcZ33bVZU6A7-lUAKkC98Nwm_UYfbnzgBhPRXWKIWyEo2Nlv9Votw8z271vMEZFZ1KOCTNWs21osdA7q4GMkfTLZgi-47MbQT7YjK1WV1jSKmMkYSkft1tUg_r7-p1J21uAb35OVJdT7mswUM' },
    'coinbase': { name: 'Coinbase Wallet', icon: 'account_balance_wallet', color: 'blue-600' },
    'trust': { name: 'Trust Wallet', icon: 'shield_with_heart', color: 'primary' },
    'walletconnect': { name: 'WalletConnect', icon: 'sync', color: 'blue-400' }
};

let selectedWallet = 'metamask'; // Default to MetaMask

function openWalletModal() {
    <?php if ($useModal): ?>
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.classList.remove('hidden');
        selectWallet('metamask'); // Reset to default
    }
    <?php else: ?>
    // Modal disabled - redirect to URL
    window.location.href = '<?php echo htmlspecialchars($walletLinkUrl ?: '#', ENT_QUOTES, 'UTF-8'); ?>';
    <?php endif; ?>
}

function closeWalletModal() {
    <?php if ($useModal): ?>
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    <?php endif; ?>
}

function selectWallet(walletId) {
    selectedWallet = walletId;
    
    // Reset all wallet cards
    ['metamask', 'coinbase', 'trust', 'walletconnect'].forEach(id => {
        const walletEl = document.getElementById('wallet-' + id);
        const selectedBadge = document.getElementById(id + '-selected');
        if (walletEl) {
            walletEl.className = 'flex items-center gap-3 p-4 rounded-lg border border-[#eaddcd] dark:border-[#3d2f1f] cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors';
        }
        if (selectedBadge) {
            selectedBadge.classList.add('hidden');
        }
    });
    
    // Highlight selected wallet
    const selectedEl = document.getElementById('wallet-' + walletId);
    const selectedBadge = document.getElementById(walletId + '-selected');
    if (selectedEl) {
        selectedEl.className = 'flex items-center justify-between p-4 rounded-lg bg-primary/10 border-2 border-primary shadow-sm cursor-pointer hover:bg-primary/20 transition-colors';
    }
    if (selectedBadge) {
        selectedBadge.classList.remove('hidden');
    }
}

async function linkWallet() {
    const wallet = wallets[selectedWallet];
    const connectBtn = document.getElementById('connectBtn');
    
    if (connectBtn) {
        connectBtn.disabled = true;
        connectBtn.textContent = 'Connecting...';
    }
    
    try {
        // Get CSRF token
        const tokenResponse = await fetch('../../api/session.php');
        const tokenData = await tokenResponse.json();
        const csrfToken = tokenData.csrf_token || null;
        
        const response = await fetch('../../api/user/wallets.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken || ''
            },
            body: JSON.stringify({
                wallet_type: selectedWallet,
                wallet_name: wallet.name,
                wallet_data: { connected: true, timestamp: new Date().toISOString() },
                csrf_token: csrfToken
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Wallet linked successfully!');
            window.location.href = 'dashboard.php';
        } else {
            alert('Failed to link wallet: ' + (data.message || 'Unknown error'));
            if (connectBtn) {
                connectBtn.disabled = false;
                connectBtn.textContent = 'Connect';
            }
        }
    } catch (error) {
        console.error('Error linking wallet:', error);
        alert('An error occurred while linking wallet. Please try again.');
        if (connectBtn) {
            connectBtn.disabled = false;
            connectBtn.textContent = 'Connect';
        }
    }
}

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

// Close modal on outside click
<?php if ($useModal): ?>
document.addEventListener('click', function(event) {
    const modal = document.getElementById('walletModal');
    if (modal && event.target === modal) {
        closeWalletModal();
    }
});
<?php endif; ?>
</script>
</body>
</html>
