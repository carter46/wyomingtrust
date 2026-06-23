<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Send Crypto - WyomingTrust';
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
<div class="flex items-center gap-2 sm:gap-4 flex-1 min-w-0">
<a href="dashboard.php" class="flex items-center gap-2 sm:gap-4 text-primary flex-shrink-0">
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
<a href="send.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
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
<main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 sm:py-8 max-w-2xl mx-auto w-full">
<h1 class="text-2xl sm:text-3xl font-black mb-4 sm:mb-6">Send Cryptocurrency</h1>

<!-- Security Disclaimer -->
<div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-4 sm:p-6 mb-6">
    <div class="flex items-start gap-3">
        <span class="material-symbols-outlined text-amber-600 dark:text-amber-400 flex-shrink-0">warning</span>
        <div class="text-sm text-amber-800 dark:text-amber-300">
            <p class="font-semibold mb-2">Security Notice:</p>
            <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm">
                <li>All wallet addresses are validated before transactions</li>
                <li>Cryptocurrency transactions are irreversible - verify addresses carefully</li>
                <li>We use AES-256-CBC encryption to protect your wallet data</li>
                <li>Your private keys are never stored in plain text</li>
                <li>Double-check recipient addresses before confirming transactions</li>
            </ul>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm p-6 sm:p-8">
<div id="assetSelector" class="flex items-center gap-3 p-4 border border-slate-300 dark:border-slate-600 rounded-lg cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 mb-6">
<img id="selectedAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<span id="selectedAssetName" class="font-bold">Select Asset</span>
<span class="material-symbols-outlined ml-auto">expand_more</span>
</div>
<div class="mb-6">
<label class="block text-sm font-semibold mb-2">Recipient Address</label>
<div class="flex gap-2">
<input type="text" id="recipientAddress" placeholder="Enter wallet address" class="flex-1 px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<button onclick="pasteAddress()" class="px-4 py-3 bg-slate-100 dark:bg-slate-800 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700">
<span class="material-symbols-outlined text-base">content_paste</span>
</button>
</div>
</div>
<div class="mb-6">
<label class="block text-sm font-semibold mb-2">Amount</label>
<div class="flex gap-2 items-center">
<input type="number" id="amountInput" step="0.00000001" placeholder="0.00" oninput="calculateUSD()" class="flex-1 px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<button onclick="setMaxAmount()" class="px-4 py-3 bg-slate-100 dark:bg-slate-800 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-semibold">MAX</button>
</div>
<p class="text-xs text-slate-500 mt-2">Balance: <span id="selectedAssetBalance">--</span></p>
<p class="text-xs text-primary mt-1" id="amountUSD">≈ $0.00</p>
</div>
<div class="mb-6">
<label class="block text-sm font-semibold mb-2">Network Fee</label>
<div class="flex gap-2">
<button onclick="selectFee('slow')" class="fee-option flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">Slow</button>
<button onclick="selectFee('normal')" class="fee-option active flex-1 px-4 py-2 border border-primary bg-primary/10 rounded-lg text-sm">Normal</button>
<button onclick="selectFee('fast')" class="fee-option flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">Fast</button>
</div>
<p class="text-xs text-slate-500 mt-2">Fee: <span id="networkFee">--</span></p>
</div>
<div class="mb-6 p-4 bg-slate-50 dark:bg-slate-800 rounded-lg">
<div class="flex justify-between text-sm mb-2">
<span class="text-slate-600 dark:text-slate-400">Total</span>
<span class="font-bold" id="totalAmount">--</span>
</div>
<div class="flex justify-between text-xs text-slate-500">
<span>Total USD</span>
<span id="totalUSD">--</span>
</div>
</div>
<button onclick="sendTransaction()" class="w-full bg-primary text-white py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors">
Send Transaction
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
let selectedAsset = null;
let cryptoPrices = {};
let selectedFee = 'normal';

// Fee structure (similar to node spacedebugger)
const fees = {
    slow: { btc: 0.0001, eth: 0.001, ltc: 0.001, bch: 0.001, pol: 0.01, doge: 1, usdt: 1, trx: 1, xrp: 0.01, ada: 0.5, sol: 0.0001, dot: 0.01, bnb: 0.001, usdc: 1 },
    normal: { btc: 0.0002, eth: 0.002, ltc: 0.002, bch: 0.002, pol: 0.02, doge: 2, usdt: 2, trx: 2, xrp: 0.02, ada: 1, sol: 0.0002, dot: 0.02, bnb: 0.002, usdc: 2 },
    fast: { btc: 0.0005, eth: 0.005, ltc: 0.005, bch: 0.005, pol: 0.05, doge: 5, usdt: 5, trx: 5, xrp: 0.05, ada: 2, sol: 0.0005, dot: 0.05, bnb: 0.005, usdc: 5 }
};

function getFeeForCoin(coinKey) {
    const coinKeyLower = coinKey.toLowerCase();
    const feeTier = fees[selectedFee] || fees.normal;
    
    // Map coin keys to fee symbols
    const feeMap = {
        'bitcoin': 'btc',
        'ethereum': 'eth',
        'litecoin': 'ltc',
        'bitcoin-cash': 'bch',
        'polygon': 'pol',
        'dogecoin': 'doge',
        'tether': 'usdt',
        'tron': 'trx',
        'ripple': 'xrp',
        'cardano': 'ada',
        'solana': 'sol',
        'polkadot': 'dot',
        'binancecoin': 'bnb',
        'usd-coin': 'usdc'
    };
    
    const feeSymbol = feeMap[coinKeyLower] || 'btc';
    return feeTier[feeSymbol] || 0.0001;
}

// Get coin_key from URL
const urlParams = new URLSearchParams(window.location.search);
const urlCoinKey = urlParams.get('coin_key');

async function loadAssets() {
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        if (data.success && data.assets) {
            userAssets = data.assets.filter(a => parseFloat(a.balance || 0) > 0);
            
            // Pre-select coin from URL if provided
            if (urlCoinKey) {
                const asset = userAssets.find(a => a.coin_key === urlCoinKey);
                if (asset) {
                    selectedAsset = asset;
                }
            }
            
            // Default to first asset if nothing selected
            if (!selectedAsset && userAssets.length > 0) {
                selectedAsset = userAssets[0];
            }
            
            if (selectedAsset) {
                updateSelectedAsset();
            }
            renderAssetModal();
            await fetchCryptoPrices();
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

function updateSelectedAsset() {
    if (!selectedAsset) return;
    document.getElementById('selectedAssetLogo').src = selectedAsset.logo || '';
    document.getElementById('selectedAssetLogo').classList.remove('hidden');
    document.getElementById('selectedAssetName').textContent = selectedAsset.display_name || selectedAsset.symbol;
    document.getElementById('selectedAssetBalance').textContent = `${parseFloat(selectedAsset.balance || 0).toFixed(8)} ${selectedAsset.symbol}`;
    calculateTotal();
}

function renderAssetModal() {
    const list = document.getElementById('assetList');
    if (!list) return;
    
    if (!userAssets || userAssets.length === 0) {
        list.innerHTML = '<div class="p-4 text-center text-slate-500">No assets available. <a href="link-wallet.php" class="text-primary hover:underline">Link a wallet</a></div>';
        return;
    }
    
    list.innerHTML = userAssets.map(asset => {
        const balance = parseFloat(asset.balance || 0);
        const displayName = asset.display_name || asset.symbol || 'Unknown';
        const symbol = asset.symbol || '';
        const coinKey = asset.coin_key || '';
        const logo = asset.logo || '';
        
        return `
        <div onclick="selectAsset('${coinKey}')" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
            <img src="${logo}" alt="${displayName}" class="w-10 h-10 rounded-full" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center hidden">
                <span class="text-xs font-bold">${displayName.charAt(0)}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold truncate">${displayName}</p>
                <p class="text-xs text-slate-500">${balance.toFixed(8)} ${symbol}</p>
            </div>
        </div>
        `;
    }).join('');
}

document.getElementById('assetSelector')?.addEventListener('click', () => {
    document.getElementById('assetModal').classList.remove('hidden');
    document.getElementById('assetModal').classList.add('flex');
});

function selectAsset(coinKey) {
    selectedAsset = userAssets.find(a => a.coin_key === coinKey);
    if (selectedAsset) {
        updateSelectedAsset();
        closeAssetModal();
    }
}

function closeAssetModal() {
    document.getElementById('assetModal').classList.add('hidden');
    document.getElementById('assetModal').classList.remove('flex');
}

function selectFee(feeType) {
    selectedFee = feeType;
    document.querySelectorAll('.fee-option').forEach(opt => {
        opt.classList.remove('active', 'bg-primary/10', 'border-primary');
        opt.classList.add('border-slate-300', 'dark:border-slate-600', 'bg-white', 'dark:bg-slate-800');
    });
    const targetBtn = document.querySelector(`[onclick="selectFee('${feeType}')"]`);
    if (targetBtn) {
        targetBtn.classList.add('active', 'bg-primary/10', 'border-primary');
        targetBtn.classList.remove('border-slate-300', 'dark:border-slate-600', 'bg-white', 'dark:bg-slate-800');
    }
    calculateTotal();
}

function calculateUSD() {
    if (!selectedAsset) return;
    const amount = parseFloat(document.getElementById('amountInput').value) || 0;
    const price = cryptoPrices[selectedAsset.coin_key]?.usd || 0;
    document.getElementById('amountUSD').textContent = `≈ $${(amount * price).toFixed(2)}`;
    calculateTotal();
}

function calculateTotal() {
    if (!selectedAsset) return;
    const amount = parseFloat(document.getElementById('amountInput').value) || 0;
    const fee = getFeeForCoin(selectedAsset.coin_key);
    const total = amount + fee;
    const balance = parseFloat(selectedAsset.balance || 0);
    
    document.getElementById('totalAmount').textContent = `${total.toFixed(8)} ${selectedAsset.symbol}`;
    const price = cryptoPrices[selectedAsset.coin_key]?.usd || 0;
    document.getElementById('totalUSD').textContent = `$${(total * price).toFixed(2)}`;
    document.getElementById('networkFee').textContent = `~${fee.toFixed(8)} ${selectedAsset.symbol}`;
    
    // Show balance warning if insufficient
    if (total > balance) {
        document.getElementById('totalAmount').classList.add('text-red-600');
    } else {
        document.getElementById('totalAmount').classList.remove('text-red-600');
    }
}

function setMaxAmount() {
    if (!selectedAsset) return;
    const balance = parseFloat(selectedAsset.balance || 0);
    const fee = getFeeForCoin(selectedAsset.coin_key);
    const maxAmount = Math.max(0, balance - fee);
    document.getElementById('amountInput').value = maxAmount.toFixed(8);
    calculateUSD();
}

async function pasteAddress() {
    try {
        const text = await navigator.clipboard.readText();
        document.getElementById('recipientAddress').value = text;
    } catch (err) {
        alert('Unable to access clipboard. Please paste manually.');
    }
}

async function sendTransaction() {
    if (!selectedAsset) {
        alert('Please select an asset');
        return;
    }
    const amount = parseFloat(document.getElementById('amountInput').value);
    const recipient = document.getElementById('recipientAddress').value.trim();
    const balance = parseFloat(selectedAsset.balance || 0);
    const fee = getFeeForCoin(selectedAsset.coin_key);
    const total = amount + fee;
    
    if (!amount || amount <= 0) {
        alert('Please enter a valid amount');
        return;
    }
    if (!recipient) {
        alert('Please enter recipient address');
        return;
    }
    if (total > balance) {
        alert(`Insufficient balance. You have ${balance.toFixed(8)} ${selectedAsset.symbol}, but need ${total.toFixed(8)} (including fee)`);
        return;
    }
    
    if (!confirm(`Send ${amount.toFixed(8)} ${selectedAsset.symbol} to ${recipient.substring(0, 10)}...?\nFee: ${fee.toFixed(8)} ${selectedAsset.symbol}\nTotal: ${total.toFixed(8)} ${selectedAsset.symbol}`)) {
        return;
    }
    
    try {
        const token = await getCsrfToken();
        const response = await fetch('../../api/user/send.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': token || ''
            },
            body: JSON.stringify({
                coin_key: selectedAsset.coin_key,
                recipient,
                amount,
                fee: fee,
                csrf_token: token
            })
        });
        const data = await response.json();
        if (data.success) {
            alert('Transaction sent successfully!');
            window.location.href = 'dashboard.php';
        } else {
            alert(data.message || 'Failed to send transaction');
        }
    } catch (error) {
        console.error('Error sending transaction:', error);
        alert('Failed to send transaction: ' + (error.message || 'Unknown error'));
    }
}

// CSRF token management
let csrfToken = null;

async function getCsrfToken() {
    if (csrfToken) return csrfToken;
    try {
        const response = await fetch('../../api/session.php');
        const data = await response.json();
        if (data.csrf_token) {
            csrfToken = data.csrf_token;
            return csrfToken;
        }
    } catch (error) {
        console.error('Failed to get CSRF token:', error);
    }
    return null;
}

document.addEventListener('DOMContentLoaded', async () => {
    await getCsrfToken(); // Initialize CSRF token
    await loadAssets();
    await fetchCryptoPrices();
});
</script>
</body>
</html>
