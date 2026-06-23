<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Swap Crypto - WyomingTrust';
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
<a href="swap.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
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
<main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-2xl mx-auto w-full">
<h1 class="text-2xl sm:text-3xl font-black mb-4 sm:mb-6">Swap Cryptocurrency</h1>

<!-- Security Disclaimer -->
<div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 sm:p-6 mb-6">
    <div class="flex items-start gap-3">
        <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">warning</span>
        <div class="text-sm text-amber-800 dark:text-amber-300">
            <p class="font-semibold mb-2">Important Security Notice:</p>
            <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm">
                <li>Exchange rates are provided by CoinGecko and may fluctuate</li>
                <li>Swaps are executed at current market rates</li>
                <li>Transaction fees apply to all swaps</li>
                <li>Cryptocurrency swaps are typically irreversible</li>
                <li>Always verify amounts before confirming</li>
            </ul>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
<div class="mb-6">
<label class="block text-sm font-semibold mb-2">From</label>
<div id="fromAssetSelector" class="flex items-center gap-3 p-4 border border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 mb-2">
<img id="fromAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<span id="fromAssetName" class="font-bold">Select Asset</span>
<span class="material-symbols-outlined ml-auto">expand_more</span>
</div>
<input type="number" id="fromAmount" step="0.00000001" placeholder="0.00" oninput="calculateSwap()" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<p class="text-xs text-slate-500 mt-2">Balance: <span id="fromBalance">--</span></p>
</div>
<div class="flex justify-center my-4">
<button onclick="swapAssets()" class="p-2 bg-slate-100 dark:bg-slate-800 rounded-full hover:bg-slate-200 dark:hover:bg-slate-700">
<span class="material-symbols-outlined text-2xl">swap_vert</span>
</button>
</div>
<div class="mb-6">
<label class="block text-sm font-semibold mb-2">To</label>
<div id="toAssetSelector" class="flex items-center gap-3 p-4 border border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 mb-2">
<img id="toAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<span id="toAssetName" class="font-bold">Select Asset</span>
<span class="material-symbols-outlined ml-auto">expand_more</span>
</div>
<input type="number" id="toAmount" readonly class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-800 text-sm">
<p class="text-xs text-slate-500 mt-2">Exchange Rate: <span id="exchangeRate">--</span></p>
</div>
<div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
<p class="text-xs text-slate-500 mb-2">Estimated Fee: <span id="swapFee">--</span></p>
</div>
<button onclick="executeSwap()" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors">
Swap
</button>
</div>
</main>
</div>
<div id="assetModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
<div class="bg-white dark:bg-slate-900 rounded-xl max-w-md w-full max-h-[80vh] overflow-y-auto">
<div class="p-6 border-b border-slate-200 dark:border-slate-700 flex items-center justify-between">
<h3 class="font-bold text-lg">Select Asset</h3>
<button onclick="closeAssetModal()" class="text-slate-500 hover:text-slate-700">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<div id="assetList" class="p-4"></div>
</div>
</div>
<script>
let userAssets = [];
let fromAsset = null;
let toAsset = null;
let cryptoPrices = {};
let currentModal = null;

async function loadAssets() {
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        if (data.success && data.assets) {
            userAssets = data.assets.filter(a => parseFloat(a.balance || 0) > 0);
            if (userAssets.length > 0) {
                fromAsset = userAssets[0];
                toAsset = userAssets.length > 1 ? userAssets[1] : userAssets[0];
                updateAssetSelectors();
            }
            renderAssetModal();
        }
    } catch (error) {
        console.error('Error loading assets:', error);
    }
}

async function fetchCryptoPrices() {
    if (userAssets.length === 0) return;
    try {
        const coinIds = userAssets.map(a => a.coin_key).filter(Boolean).join(',');
        const response = await fetch(`/api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(coinIds)}&vs_currencies=usd`);
        if (response.ok) cryptoPrices = await response.json();
    } catch (error) {
        console.error('Error fetching prices:', error);
    }
}

function updateAssetSelectors() {
    if (fromAsset) {
        document.getElementById('fromAssetLogo').src = fromAsset.logo || '';
        document.getElementById('fromAssetLogo').classList.remove('hidden');
        document.getElementById('fromAssetName').textContent = fromAsset.display_name || fromAsset.symbol;
        document.getElementById('fromBalance').textContent = `${parseFloat(fromAsset.balance || 0).toFixed(8)} ${fromAsset.symbol}`;
    }
    if (toAsset) {
        document.getElementById('toAssetLogo').src = toAsset.logo || '';
        document.getElementById('toAssetLogo').classList.remove('hidden');
        document.getElementById('toAssetName').textContent = toAsset.display_name || toAsset.symbol;
    }
    calculateSwap();
}

function calculateSwap() {
    if (!fromAsset || !toAsset) return;
    const amount = parseFloat(document.getElementById('fromAmount').value) || 0;
    const fromPrice = cryptoPrices[fromAsset.coin_key]?.usd || 0;
    const toPrice = cryptoPrices[toAsset.coin_key]?.usd || 0;
    
    if (fromPrice > 0 && toPrice > 0) {
        const exchangeRate = fromPrice / toPrice;
        const toAmount = amount * exchangeRate;
        document.getElementById('toAmount').value = toAmount.toFixed(8);
        document.getElementById('exchangeRate').textContent = `1 ${fromAsset.symbol} = ${exchangeRate.toFixed(8)} ${toAsset.symbol}`;
        document.getElementById('swapFee').textContent = `~${(amount * 0.003).toFixed(8)} ${fromAsset.symbol}`;
    }
}

function swapAssets() {
    const temp = fromAsset;
    fromAsset = toAsset;
    toAsset = temp;
    updateAssetSelectors();
}

function renderAssetModal() {
    const list = document.getElementById('assetList');
    list.innerHTML = userAssets.map(asset => `
        <div onclick="selectAsset('${asset.coin_key}')" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
            <img src="${asset.logo || ''}" alt="${asset.display_name}" class="w-10 h-10 rounded-full" onerror="this.style.display='none'">
            <div class="flex-1">
                <p class="font-semibold">${asset.display_name}</p>
                <p class="text-xs text-slate-500">${parseFloat(asset.balance || 0).toFixed(8)} ${asset.symbol}</p>
            </div>
        </div>
    `).join('');
}

document.getElementById('fromAssetSelector')?.addEventListener('click', () => {
    currentModal = 'from';
    document.getElementById('assetModal').classList.remove('hidden');
    document.getElementById('assetModal').classList.add('flex');
});

document.getElementById('toAssetSelector')?.addEventListener('click', () => {
    currentModal = 'to';
    document.getElementById('assetModal').classList.remove('hidden');
    document.getElementById('assetModal').classList.add('flex');
});

function selectAsset(coinKey) {
    const asset = userAssets.find(a => a.coin_key === coinKey);
    if (asset) {
        if (currentModal === 'from') {
            fromAsset = asset;
        } else {
            toAsset = asset;
        }
        updateAssetSelectors();
        closeAssetModal();
    }
}

function closeAssetModal() {
    document.getElementById('assetModal').classList.add('hidden');
    document.getElementById('assetModal').classList.remove('flex');
}

async function executeSwap() {
    if (!fromAsset || !toAsset) {
        alert('Please select both assets');
        return;
    }
    const fromAmount = parseFloat(document.getElementById('fromAmount').value);
    if (!fromAmount || fromAmount <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    if (fromAmount > parseFloat(fromAsset.balance || 0)) {
        alert('Insufficient balance');
        return;
    }
    try {
        // Get CSRF token
        const tokenResponse = await fetch('../../api/session.php');
        const tokenData = await tokenResponse.json();
        const csrfToken = tokenData.csrf_token || null;
        
        const response = await fetch('../../api/user/swap.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken || ''
            },
            body: JSON.stringify({
                from_coin_key: fromAsset.coin_key,
                to_coin_key: toAsset.coin_key,
                from_amount: fromAmount,
                to_amount: parseFloat(document.getElementById('toAmount').value),
                fee: fromAmount * 0.003,
                csrf_token: csrfToken
            })
        });
        const data = await response.json();
        if (data.success) {
            alert('Swap completed successfully!');
            window.location.href = 'transactions.php';
        } else {
            alert(data.message || 'Failed to execute swap');
        }
    } catch (error) {
        console.error('Error executing swap:', error);
        alert('Failed to execute swap');
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    await loadAssets();
    await fetchCryptoPrices();
});

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
