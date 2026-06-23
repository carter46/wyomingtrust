<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication
require_user_page_auth('../../login.php');

$page_title = 'My Assets - WyomingTrust';
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
<!-- Header -->
<header class="flex items-center justify-between whitespace-nowrap border-b border-solid border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
<div class="flex items-center gap-4 sm:gap-8">
<a href="dashboard.php" class="flex items-center gap-2 sm:gap-4 text-primary">
<div class="size-6 sm:size-8">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-lg sm:text-xl font-black leading-tight tracking-tight">WyomingTrust</h2>
</a>
</div>
<div class="flex items-center gap-2 sm:gap-4">
<a href="dashboard.php" class="text-sm text-slate-600 dark:text-slate-400 hover:text-primary hidden sm:inline">Dashboard</a>
<a href="../../api/logout.php" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700">Logout</a>
</div>
</header>
<main class="flex-1 flex flex-col items-center">
<div class="layout-content-container flex flex-col max-w-[1200px] w-full px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
<!-- Page Heading -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 mb-4 sm:mb-6">
<div class="flex flex-col gap-1">
<p class="text-[#0e131b] dark:text-white text-2xl sm:text-3xl lg:text-4xl font-black leading-tight tracking-[-0.033em]">My Crypto Assets</p>
<p class="text-[#4e6b97] text-sm sm:text-base font-normal leading-normal">View and manage your cryptocurrency holdings</p>
</div>
<div class="flex gap-2 sm:gap-4">
<a href="send.php" class="flex items-center justify-center gap-2 bg-primary text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg text-sm font-bold hover:bg-primary/90 transition-colors">
<span class="material-symbols-outlined text-base">send</span>
<span class="hidden sm:inline">Send</span>
</a>
<a href="receive.php" class="flex items-center justify-center gap-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg text-sm font-bold hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
<span class="material-symbols-outlined text-base">call_received</span>
<span class="hidden sm:inline">Receive</span>
</a>
<a href="swap.php" class="flex items-center justify-center gap-2 bg-accent-orange text-white px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg text-sm font-bold hover:bg-accent-orange/90 transition-colors">
<span class="material-symbols-outlined text-base">swap_horiz</span>
<span class="hidden sm:inline">Swap</span>
</a>
</div>
</div>
<!-- Portfolio Summary -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 p-4 mb-6">
<div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">account_balance_wallet</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Total Portfolio Value</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight">$<span id="totalPortfolioValue">0.00</span></p>
<p class="text-xs text-slate-500" id="portfolioChange">--</p>
</div>
<div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">trending_up</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">24h Change</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight" id="total24hChange">--</p>
</div>
<div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-primary">
<span class="material-symbols-outlined text-sm">inventory_2</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Total Assets</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-xl sm:text-2xl font-bold leading-tight" id="totalAssetsCount">0</p>
</div>
<div class="flex min-w-[200px] flex-1 flex-col gap-2 rounded-xl p-4 sm:p-6 border border-[#d0d9e7] dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<div class="flex items-center gap-2 text-accent-orange">
<span class="material-symbols-outlined text-sm">sync</span>
<p class="text-slate-500 dark:text-slate-400 text-xs sm:text-sm font-medium">Last Updated</p>
</div>
<p class="text-[#0e131b] dark:text-white tracking-tight text-sm sm:text-base font-bold leading-tight" id="lastUpdated">Just Now</p>
</div>
</div>
<!-- Assets List -->
<div class="overflow-hidden border border-slate-200 dark:border-slate-700 rounded-xl bg-white dark:bg-slate-900 shadow-sm">
<div class="p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700">
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
<h3 class="text-lg sm:text-xl font-bold">All Assets</h3>
<div class="flex gap-2 sm:gap-4">
<input type="text" id="assetSearch" placeholder="Search assets..." class="flex-1 sm:flex-none sm:w-64 px-4 py-2 text-sm border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-primary">
<button id="refreshPrices" class="px-4 py-2 text-sm font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
<span class="material-symbols-outlined text-base align-middle">refresh</span>
</button>
</div>
</div>
</div>
<div id="assetsContainer" class="p-4 sm:p-6">
<div class="text-center py-10 text-slate-500">
<div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent mb-4"></div>
<p>Loading assets...</p>
</div>
</div>
</div>
</div>
</main>
<footer class="border-t border-slate-200 dark:border-slate-800 py-6 sm:py-8 px-4 sm:px-10 bg-white dark:bg-slate-900">
<div class="max-w-[1200px] mx-auto flex flex-col sm:flex-row justify-between items-center gap-4 sm:gap-6">
<div class="flex items-center gap-2 opacity-50">
<span class="material-symbols-outlined text-sm">shield</span>
<p class="text-xs">WyomingTrust Compliance Grade A+</p>
</div>
<div class="flex flex-wrap gap-4 sm:gap-8 text-xs font-medium text-slate-500">
<a class="hover:text-primary" href="#">Privacy Policy</a>
<a class="hover:text-primary" href="#">Terms of Service</a>
<a class="hover:text-primary" href="#">Help Center</a>
</div>
</div>
</footer>
</div>
</div>
<script>
const COINGECKO_API = '/api/coingecko.php';
const REFRESH_INTERVAL = 300000; // 5 minutes (300 seconds) - reduced polling frequency
let cryptoPrices = {};
let userAssets = [];
let priceRefreshTimer = null;

async function loadAssets() {
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        
        if (data.success && data.assets) {
            userAssets = data.assets;
            await fetchCryptoPrices();
            renderAssets();
            updatePortfolioSummary();
        } else {
            document.getElementById('assetsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Failed to load assets</div>';
        }
    } catch (error) {
        console.error('Error loading assets:', error);
        document.getElementById('assetsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Error loading assets</div>';
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

async function fetchCryptoPrices() {
    if (userAssets.length === 0) return;
    
    // Check cache first
    const cached = getCachedPrices();
    if (cached) {
        cryptoPrices = cached;
        updateLastUpdated();
        return;
    }
    
    try {
        const coinIds = userAssets.map(a => a.coin_key).filter(Boolean).join(',');
        if (!coinIds) {
            // Use existing price_usd from assets
            userAssets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
            updateLastUpdated();
            return;
        }
        
        // Split into batches
        const batches = batchCoinIds(coinIds, 12);
        const allPrices = {};
        
        for (const batch of batches) {
            let retries = 3;
            let delay = 5000;
            let success = false;
            
            while (retries > 0 && !success) {
                try {
                    const response = await fetch(
                        `${COINGECKO_API}?path=/simple/price&ids=${encodeURIComponent(batch)}&vs_currencies=usd&include_24hr_change=true`
                    );
                    
                    if (response.status === 429) {
                        console.warn(`Rate limit exceeded for batch. Waiting ${delay}ms...`);
                        await new Promise(resolve => setTimeout(resolve, delay));
                        delay *= 2;
                        retries--;
                        continue;
                    }
                    
                    if (response.ok) {
                        const data = await response.json();
                        if (data && !data.error) {
                            Object.assign(allPrices, data);
                            success = true;
                        }
                    }
                    
                    if (success) break;
                    retries--;
                } catch (error) {
                    console.error('Error fetching batch:', error);
                    retries--;
                    if (retries > 0) {
                        await new Promise(resolve => setTimeout(resolve, delay));
                        delay *= 2;
                    }
                }
                
                // Small delay between batches
                if (batches.length > 1) {
                    await new Promise(resolve => setTimeout(resolve, 1000));
                }
            }
            
            // Fallback to asset prices for failed batch
            if (!success) {
                const batchIds = batch.split(',');
                batchIds.forEach(id => {
                    const asset = userAssets.find(a => a.coin_key === id);
                    if (asset && asset.price_usd) {
                        allPrices[id] = {
                            usd: asset.price_usd,
                            usd_24h_change: asset.price_change_24h || 0
                        };
                    }
                });
            }
        }
        
        if (Object.keys(allPrices).length > 0) {
            cryptoPrices = allPrices;
            setCachedPrices(allPrices);
            updateLastUpdated();
        } else {
            // Final fallback
            userAssets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
            updateLastUpdated();
        }
    } catch (error) {
        console.error('Error fetching prices:', error);
        // Try cache or asset prices
        const cached = getCachedPrices();
        if (cached) {
            cryptoPrices = cached;
            updateLastUpdated();
        } else {
            userAssets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = {
                        usd: asset.price_usd,
                        usd_24h_change: asset.price_change_24h || 0
                    };
                }
            });
            updateLastUpdated();
        }
    }
}

function renderAssets() {
    const container = document.getElementById('assetsContainer');
    if (!userAssets || userAssets.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-slate-500">No assets found. <a href="../../onboarding/onboarding.php" class="text-primary hover:underline">Start by linking a wallet</a></div>';
        return;
    }
    
    const searchTerm = document.getElementById('assetSearch')?.value.toLowerCase() || '';
    const filteredAssets = userAssets.filter(asset => {
        const name = (asset.display_name || '').toLowerCase();
        const symbol = (asset.symbol || '').toLowerCase();
        return name.includes(searchTerm) || symbol.includes(searchTerm);
    });
    
    // Sort assets by price (highest first)
    const sortedAssets = [...filteredAssets].sort((a, b) => {
        const priceA = a.price_usd || cryptoPrices[a.coin_key]?.usd || 0;
        const priceB = b.price_usd || cryptoPrices[b.coin_key]?.usd || 0;
        return priceB - priceA;
    });
    
    const assetsHTML = `
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
                    ${sortedAssets.map(asset => {
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
    `;
    
    container.innerHTML = assetsHTML || '<div class="text-center py-10 text-slate-500">No assets match your search</div>';
}

function updatePortfolioSummary() {
    let totalValue = 0;
    let totalChange = 0;
    let totalAssets = 0;
    
    userAssets.forEach(asset => {
        const price = asset.price_usd || 0;
        const change24h = asset.price_change_24h || 0;
        const balance = parseFloat(asset.balance || 0);
        const value = balance * price;
        
        if (balance > 0) {
            totalAssets++;
            totalValue += value;
            totalChange += (value * change24h / 100);
        }
    });
    
    const changePercent = totalValue > 0 ? (totalChange / (totalValue - totalChange) * 100) : 0;
    const changeClass = totalChange >= 0 ? 'text-green-600' : 'text-red-600';
    const changeSign = totalChange >= 0 ? '+' : '';
    
    document.getElementById('totalPortfolioValue').textContent = totalValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('portfolioChange').innerHTML = `<span class="${changeClass}">${changeSign}$${Math.abs(totalChange).toFixed(2)} (${changeSign}${Math.abs(changePercent).toFixed(2)}%)</span>`;
    document.getElementById('total24hChange').innerHTML = `<span class="${changeClass}">${changeSign}${Math.abs(changePercent).toFixed(2)}%</span>`;
    document.getElementById('totalAssetsCount').textContent = totalAssets;
}

function updateLastUpdated() {
    const now = new Date();
    document.getElementById('lastUpdated').textContent = now.toLocaleTimeString();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function startPriceRefresh() {
    if (priceRefreshTimer) clearInterval(priceRefreshTimer);
    priceRefreshTimer = setInterval(() => {
        fetchCryptoPrices().then(() => {
            renderAssets();
            updatePortfolioSummary();
        });
    }, REFRESH_INTERVAL);
}

// Event listeners
document.getElementById('refreshPrices')?.addEventListener('click', () => {
    fetchCryptoPrices().then(() => {
        renderAssets();
        updatePortfolioSummary();
    });
});

document.getElementById('assetSearch')?.addEventListener('input', () => {
    renderAssets();
});

// Initialize
document.addEventListener('DOMContentLoaded', () => {
    loadAssets();
    startPriceRefresh();
});
</script>
</body>
</html>
