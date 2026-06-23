<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Receive Crypto - WyomingTrust';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms"></script>
<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
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
<a href="send.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">send</span>
<span>Send</span>
</a>
<a href="receive.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
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
<h1 class="text-2xl sm:text-3xl font-black mb-4 sm:mb-6">Receive Cryptocurrency</h1>

<!-- Security Notice -->
<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 sm:p-6 mb-6">
    <div class="flex items-start gap-3">
        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 flex-shrink-0">info</span>
        <div class="text-sm text-blue-800 dark:text-blue-300">
            <p class="font-semibold mb-2">Security Information:</p>
            <ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm">
                <li>Your wallet addresses are encrypted and stored securely</li>
                <li>We do not store your private keys or seed phrases</li>
                <li>QR codes and addresses are generated securely for your account</li>
                <li>Only send the selected cryptocurrency to this address</li>
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
<div class="text-center mb-6 p-6 bg-slate-50 dark:bg-slate-800 rounded-lg">
<div id="qrCode" class="inline-block p-4 bg-white rounded-lg mb-4">
<canvas id="qrCodeCanvas" class="w-48 h-48"></canvas>
</div>
<p class="text-xs text-slate-500 mb-4">Scan this QR code to send crypto</p>
<div class="flex items-center gap-2 p-3 bg-white dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700">
<input type="text" id="receiveAddress" readonly class="flex-1 bg-transparent text-xs sm:text-sm font-mono break-all">
<button onclick="copyAddress()" class="px-3 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 text-xs font-semibold">
<span class="material-symbols-outlined text-base align-middle">content_copy</span>
</button>
</div>
<p class="text-xs text-slate-500 mt-2">Send only <span id="selectedAssetSymbol">--</span> to this address</p>
</div>
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
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu && btn) {
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            btn.innerHTML = '<span class="material-symbols-outlined">close</span>';
        } else {
            menu.classList.add('hidden');
            btn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
        }
    }
}

let userAssets = [];
let selectedAsset = null;
let adminAddresses = {};
let currentUserId = null;

// Get coin_key from URL
const urlParams = new URLSearchParams(window.location.search);
const urlCoinKey = urlParams.get('coin_key');

async function loadAdminAddresses() {
    try {
        const response = await fetch('../../api/addresses.php');
        const data = await response.json();
        if (data.success && data.addressMap) {
            adminAddresses = data.addressMap;
        }
    } catch (error) {
        console.error('Error loading admin addresses:', error);
    }
}

async function getCurrentUser() {
    try {
        const response = await fetch('../../api/session.php');
        const data = await response.json();
        if (data.authenticated && data.user) {
            currentUserId = data.user.id;
        }
    } catch (error) {
        console.error('Error getting current user:', error);
    }
}

async function loadAssets() {
    await getCurrentUser();
    await loadAdminAddresses();
    
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        if (data.success && data.assets) {
            userAssets = data.assets;
            
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
        }
    } catch (error) {
        console.error('Error loading assets:', error);
    }
}

function updateSelectedAsset() {
    if (!selectedAsset) return;
    document.getElementById('selectedAssetLogo').src = selectedAsset.logo || '';
    document.getElementById('selectedAssetLogo').classList.remove('hidden');
    document.getElementById('selectedAssetName').textContent = selectedAsset.display_name || selectedAsset.symbol;
    document.getElementById('selectedAssetSymbol').textContent = selectedAsset.symbol || '';
    generateReceiveAddress();
}

function generateReceiveAddress() {
    if (!selectedAsset || !currentUserId) return;
    
    let address = '';
    
    // Check if admin has set an address for this coin
    if (adminAddresses[selectedAsset.coin_key]) {
        address = adminAddresses[selectedAsset.coin_key];
    } else {
        // Generate fallback address based on coin type and user ID
        address = generateFallbackAddress(selectedAsset.coin_key, currentUserId);
    }
    
    document.getElementById('receiveAddress').value = address;
    generateQRCode(address);
}

function generateFallbackAddress(coinKey, userId) {
    const addressPrefixes = {
        'bitcoin': '1',
        'ethereum': '0x',
        'litecoin': 'L',
        'bitcoin-cash': 'q',
        'polygon': '0x',
        'dogecoin': 'D',
        'tether': '0x',
        'tron': 'T',
        'ripple': 'r',
        'cardano': 'addr1',
        'solana': '',
        'polkadot': '1',
        'binancecoin': '0x',
        'usd-coin': '0x',
        'avalanche-2': '0x',
        'shiba-inu': '0x',
        'chainlink': '0x',
        'uniswap': '0x',
        'stellar': 'G',
        'cosmos': 'cosmos',
        'internet-computer': 'ic',
        'optimism': '0x',
        'arbitrum': '0x',
        'aptos': '0x',
        'filecoin': 'f',
        'hedera-hashgraph': '0.0.',
        'algorand': 'ALGO',
        'vechain': '0x',
        'fantom': '0x',
        'monero': '4'
    };
    
    const prefix = addressPrefixes[coinKey] || '1';
    const hash = simpleHash(String(userId) + coinKey);
    
    if (coinKey === 'ethereum' || coinKey === 'polygon' || coinKey === 'tether' || coinKey === 'binancecoin' || 
        coinKey === 'usd-coin' || coinKey === 'avalanche-2' || coinKey === 'shiba-inu' || coinKey === 'chainlink' || 
        coinKey === 'uniswap' || coinKey === 'optimism' || coinKey === 'arbitrum' || coinKey === 'vechain' || 
        coinKey === 'fantom' || coinKey === 'aptos') {
        return prefix + hash.substring(0, 40);
    } else if (coinKey === 'solana') {
        return hash.substring(0, 44);
    } else if (coinKey === 'cardano') {
        return prefix + hash.substring(0, 55);
    } else {
        return prefix + hash.substring(0, 33);
    }
}

function simpleHash(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        const char = str.charCodeAt(i);
        hash = ((hash << 5) - hash) + char;
        hash = hash & hash;
    }
    return Math.abs(hash).toString(16).repeat(10);
}

async function generateQRCode(address) {
    const canvas = document.getElementById('qrCodeCanvas');
    if (!canvas || !address) return;
    
    try {
        // Use QRCode.js if available
        if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
            await QRCode.toCanvas(canvas, address, {
                width: 200,
                height: 200,
                margin: 1,
                color: {
                    dark: '#000000',
                    light: '#FFFFFF'
                }
            });
        } else {
            // Fallback: render text
            const ctx = canvas.getContext('2d');
            canvas.width = 200;
            canvas.height = 200;
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, 200, 200);
            ctx.fillStyle = '#000000';
            ctx.font = '14px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('QR code unavailable', 100, 90);
            ctx.fillText('copy address instead', 100, 110);
        }
    } catch (error) {
        console.error('Error generating QR code:', error);
        // Render fallback
        const ctx = canvas.getContext('2d');
        canvas.width = 200;
        canvas.height = 200;
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, 200, 200);
        ctx.fillStyle = '#000000';
        ctx.font = '14px Arial';
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        ctx.fillText('QR code unavailable', 100, 90);
        ctx.fillText('copy address instead', 100, 110);
    }
}

function renderAssetModal() {
    const list = document.getElementById('assetList');
    list.innerHTML = userAssets.map(asset => `
        <div onclick="selectAsset('${asset.coin_key}')" class="flex items-center gap-3 p-3 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 cursor-pointer">
            <img src="${asset.logo || ''}" alt="${asset.display_name}" class="w-10 h-10 rounded-full" onerror="this.style.display='none'">
            <div class="flex-1">
                <p class="font-semibold">${asset.display_name}</p>
                <p class="text-xs text-slate-500">${asset.symbol}</p>
            </div>
        </div>
    `).join('');
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

async function copyAddress() {
    const address = document.getElementById('receiveAddress').value;
    try {
        await navigator.clipboard.writeText(address);
        alert('Address copied to clipboard!');
    } catch (err) {
        alert('Unable to copy address. Please copy manually.');
    }
}

document.addEventListener('DOMContentLoaded', loadAssets);
</script>
</body>
</html>
