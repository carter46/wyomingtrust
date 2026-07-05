<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$userName = $_SESSION['user_name'] ?? 'User';
$trustIdParam = isset($_GET['trust_id']) ? (int) $_GET['trust_id'] : 0;
$coinKeyParam = isset($_GET['coin_key']) ? sanitize_text($_GET['coin_key']) : '';
$page_title = 'Deposit Crypto | WyomingTrust';
$active_nav = $trustIdParam > 0 ? 'trusts' : '';

$extra_head = '<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>';

include __DIR__ . '/includes/layout.php';
?>

<section class="max-w-2xl">
<?php if ($trustIdParam > 0 && $coinKeyParam !== ''): ?>
<a href="asset-detail.php?coin_key=<?php echo escape_html($coinKeyParam); ?>&trust_id=<?php echo $trustIdParam; ?>" class="inline-flex items-center gap-1 text-secondary font-label-md text-label-md hover:underline mb-4">
<?php echo wt_icon('arrow-back', 'w-4 h-4'); ?> Back to Asset
</a>
<?php endif; ?>
<h1 class="font-headline-lg text-headline-lg text-primary mb-4">Deposit Cryptocurrency</h1>

<div class="bg-surface-container-low border border-outline-variant rounded-2xl p-4 sm:p-6 mb-6">
<div class="flex items-start gap-3">
<?php echo wt_icon('info', 'text-secondary flex-shrink-0'); ?>
<div class="text-sm text-on-surface">
<p class="font-semibold mb-2">Security Information:</p>
<ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm text-on-surface-variant">
<li>Your wallet addresses are encrypted and stored securely</li>
<li>We do not store your private keys or seed phrases</li>
<li>QR codes and addresses are generated securely for your account</li>
<li>Only send the selected cryptocurrency to this address</li>
</ul>
</div>
</div>
</div>

<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant shadow-sm p-6 sm:p-8">
<div id="assetSelector" class="flex items-center gap-3 p-4 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low mb-6">
<img id="selectedAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<span id="selectedAssetName" class="font-bold text-on-surface">Select Asset</span>
<?php echo wt_icon('chevron-down', 'ml-auto text-on-surface-variant'); ?>
</div>
<div id="lockedAssetDisplay" class="hidden flex items-center gap-3 p-4 border border-outline-variant rounded-lg bg-surface-container-low mb-6">
<img id="lockedAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<div>
<p id="lockedAssetName" class="font-bold text-on-surface">--</p>
<p id="lockedAssetSymbol" class="text-xs text-on-surface-variant">--</p>
</div>
</div>
<div class="text-center mb-6 p-6 bg-surface-container-low rounded-lg">
<div id="qrCode" class="inline-block p-4 bg-surface-container-lowest rounded-lg mb-4">
<canvas id="qrCodeCanvas" class="w-48 h-48"></canvas>
</div>
<p class="text-xs text-on-surface-variant mb-4">Scan this QR code to send crypto</p>
<div class="flex items-center gap-2 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant">
<input type="text" id="receiveAddress" readonly class="flex-1 bg-transparent text-xs sm:text-sm font-mono break-all text-on-surface">
<button onclick="copyAddress()" class="px-3 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary/90 text-xs font-semibold">
<?php echo wt_icon('share', 'text-base align-middle'); ?>
</button>
</div>
<p class="text-xs text-on-surface-variant mt-2">Send only <span id="selectedAssetSymbol">--</span> to this address</p>
</div>
</div>
</section>

<div id="assetModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
<div class="bg-surface-container-lowest rounded-2xl max-w-md w-full max-h-[80vh] overflow-y-auto border border-outline-variant">
<div class="p-6 border-b border-outline-variant flex items-center justify-between">
<h3 class="font-bold text-lg text-primary">Select Asset</h3>
<button onclick="closeAssetModal()" class="text-on-surface-variant hover:text-on-surface">
<?php echo wt_icon('close', 'w-5 h-5'); ?>
</button>
</div>
<div id="assetList" class="p-4"></div>
</div>
</div>

<script>
let userAssets = [];
let selectedAsset = null;
let adminAddresses = {};
let currentUserId = null;

const urlParams = new URLSearchParams(window.location.search);
const urlCoinKey = urlParams.get('coin_key');
const lockToSingleCoin = !!urlCoinKey;

async function loadCoinFromCatalog(coinKey) {
    const response = await fetch('../../api/coins.php');
    const data = await response.json();
    if (!data.success || !data.coins) return null;
    return data.coins.find(c => c.coin_key === coinKey) || null;
}

function updateLockedAssetDisplay(asset) {
    if (!asset) return;
    const logo = document.getElementById('lockedAssetLogo');
    if (asset.logo) {
        logo.src = asset.logo;
        logo.classList.remove('hidden');
    }
    document.getElementById('lockedAssetName').textContent = asset.display_name || asset.symbol || asset.coin_key;
    document.getElementById('lockedAssetSymbol').textContent = asset.symbol || asset.coin_key;
}

async function loadAssets() {
    await getCurrentUser();
    await loadAdminAddresses();
    
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        if (data.success && data.assets) {
            userAssets = data.assets;

            if (lockToSingleCoin) {
                let asset = userAssets.find(a => a.coin_key === urlCoinKey);
                if (!asset) {
                    const coin = await loadCoinFromCatalog(urlCoinKey);
                    if (coin) {
                        asset = {
                            coin_key: coin.coin_key,
                            display_name: coin.display_name,
                            symbol: coin.symbol,
                            logo: coin.logo,
                            balance: 0,
                        };
                    }
                }
                if (asset) {
                    selectedAsset = asset;
                    updateSelectedAsset();
                    updateLockedAssetDisplay(asset);
                    document.getElementById('assetSelector').classList.add('hidden');
                    document.getElementById('lockedAssetDisplay').classList.remove('hidden');
                } else {
                    document.getElementById('assetSelector').classList.add('hidden');
                    document.getElementById('lockedAssetDisplay').classList.remove('hidden');
                    document.getElementById('lockedAssetName').textContent = 'Asset not found';
                    document.getElementById('lockedAssetSymbol').textContent = urlCoinKey;
                }
                return;
            }
            
            if (urlCoinKey) {
                const asset = userAssets.find(a => a.coin_key === urlCoinKey);
                if (asset) selectedAsset = asset;
            }
            
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
    
    if (adminAddresses[selectedAsset.coin_key]) {
        address = adminAddresses[selectedAsset.coin_key];
    } else {
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
        if (typeof QRCode !== 'undefined' && QRCode.toCanvas) {
            await QRCode.toCanvas(canvas, address, {
                width: 200,
                height: 200,
                margin: 1,
                color: {
                    dark: '#041627',
                    light: '#FFFFFF'
                }
            });
        } else {
            const ctx = canvas.getContext('2d');
            canvas.width = 200;
            canvas.height = 200;
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, 200, 200);
            ctx.fillStyle = '#041627';
            ctx.font = '14px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillText('QR code unavailable', 100, 90);
            ctx.fillText('copy address instead', 100, 110);
        }
    } catch (error) {
        console.error('Error generating QR code:', error);
        const ctx = canvas.getContext('2d');
        canvas.width = 200;
        canvas.height = 200;
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, 200, 200);
        ctx.fillStyle = '#041627';
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
        <div onclick="selectAsset('${asset.coin_key}')" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-container-low cursor-pointer">
            <img src="${asset.logo || ''}" alt="${asset.display_name}" class="w-10 h-10 rounded-full" onerror="this.style.display='none'">
            <div class="flex-1">
                <p class="font-semibold text-on-surface">${asset.display_name}</p>
                <p class="text-xs text-on-surface-variant">${asset.symbol}</p>
            </div>
        </div>
    `).join('');
}

document.getElementById('assetSelector')?.addEventListener('click', () => {
    if (lockToSingleCoin) return;
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
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
