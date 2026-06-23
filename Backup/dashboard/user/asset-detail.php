<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Asset Details - WyomingTrust';
$userName = $_SESSION['user_name'] ?? 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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
<a href="dashboard.php" class="flex items-center gap-2">
<div class="size-6 sm:size-8">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
</svg>
</div>
<h2 class="text-lg sm:text-xl font-black leading-tight tracking-tight">WyomingTrust</h2>
</a>
</div>
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

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center">
<div class="layout-content-container flex flex-col max-w-[1200px] w-full px-4 py-8">
<!-- Coin Header -->
<div class="text-center mb-6">
<h1 class="text-2xl sm:text-3xl font-bold mb-2" id="coinSymbol">Loading...</h1>
<p class="text-slate-500 dark:text-slate-400" id="coinName">Loading...</p>
</div>

<!-- Price Section -->
<div class="bg-white dark:bg-slate-900 rounded-xl p-6 mb-4 border border-slate-200 dark:border-slate-700">
<div class="text-center">
<div class="text-3xl sm:text-4xl font-bold mb-2" id="currentPrice">$0.00</div>
<div class="text-lg font-medium mb-1" id="priceChange">--</div>
<div class="text-sm text-slate-500 dark:text-slate-400" id="marketCap"></div>
</div>
</div>

<!-- Time Filters -->
<div class="flex gap-2 mb-4 overflow-x-auto pb-2">
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700" data-days="1">1H</button>
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-primary text-white active" data-days="1">1D</button>
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700" data-days="7">1W</button>
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700" data-days="30">1M</button>
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700" data-days="365">1Y</button>
<button class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-700" data-days="max">All</button>
</div>

<!-- Chart Container -->
<div class="bg-white dark:bg-slate-900 rounded-xl p-4 mb-4 border border-slate-200 dark:border-slate-700" style="height: 300px;">
<canvas id="priceChart"></canvas>
</div>

<!-- Action Buttons -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
<button id="sendBtn" class="px-4 py-3 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Send</button>
<button id="receiveBtn" class="px-4 py-3 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Receive</button>
<button onclick="window.location.href='swap.php'" class="px-4 py-3 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-medium hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">Swap</button>
<button onclick="window.location.href='dashboard.php'" class="px-4 py-3 rounded-lg bg-primary text-white font-medium hover:bg-primary/90 transition-colors">Buy</button>
</div>

<!-- Tabs -->
<div class="flex gap-2 mb-4 border-b border-slate-200 dark:border-slate-700">
<button class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-primary text-primary" data-tab="holdings">Holdings</button>
<button class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300" data-tab="history">History</button>
<button class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-transparent text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300" data-tab="about">About</button>
</div>

<!-- Balance Section -->
<div class="bg-white dark:bg-slate-900 rounded-xl p-6 mb-4 border border-slate-200 dark:border-slate-700">
<div class="text-center mb-4">
<h3 class="text-lg font-semibold mb-4">My Balance</h3>
<div class="flex items-center justify-center gap-3 mb-4">
<img src="" alt="Crypto Logo" class="w-12 h-12 rounded-full" id="balanceLogo" onerror="this.style.display='none'">
<div class="text-xl font-bold" id="balanceSymbol">--</div>
</div>
<div class="text-2xl sm:text-3xl font-bold mb-2" id="balanceAmount">0.00000000</div>
<div class="text-lg text-slate-500 dark:text-slate-400" id="balanceUSD">USD $0.00</div>
</div>
</div>

<!-- Tab Content -->
<div id="tabContent" class="mt-6">
<!-- Holdings Tab Content -->
<div id="holdingsTab" class="tab-content">
<div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
<p class="text-slate-500 dark:text-slate-400 text-center">Balance information displayed above</p>
</div>
</div>

<!-- History Tab Content -->
<div id="historyTab" class="tab-content hidden">
<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700">
<div id="transactionHistory" class="p-4">
<p class="text-slate-500 dark:text-slate-400 text-center">Loading transaction history...</p>
</div>
</div>
</div>

<!-- About Tab Content -->
<div id="aboutTab" class="tab-content hidden">
<div class="bg-white dark:bg-slate-900 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
<div id="coinAbout" class="text-slate-500 dark:text-slate-400">
<p>Loading coin information...</p>
</div>
</div>
</div>
</div>
</div>
</main>
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

let priceChart = null;
let currentDays = '1';
let currentAsset = null;
let assetBalance = 0;
let currentPrice = 0;

// Get coin_key from URL
const urlParams = new URLSearchParams(window.location.search);
const coinKey = urlParams.get('coin_key') || 'bitcoin';

// Load coin configuration and user balance
async function initializePage() {
    try {
        // Load coins list
        const coinsResponse = await fetch('../../api/coins.php');
        const coinsData = await coinsResponse.json();
        
        if (!coinsData.success || !coinsData.coins) {
            throw new Error('Failed to load coins');
        }
        
        // Find the coin by coin_key
        const coin = coinsData.coins.find(c => c.coin_key === coinKey);
        if (!coin) {
            throw new Error('Coin not found');
        }
        
        currentAsset = {
            id: coin.coin_key,
            symbol: coin.symbol,
            name: coin.display_name,
            logo: coin.logo
        };
        
        // Update page header
        document.getElementById('coinSymbol').textContent = currentAsset.symbol;
        document.getElementById('coinName').textContent = currentAsset.name;
        document.getElementById('balanceSymbol').textContent = currentAsset.symbol;
        document.getElementById('balanceLogo').src = currentAsset.logo;
        
        // Load user balance
        await loadUserBalance();
        
        // Load price data
        await fetchAssetData();
        
        // Load chart
        await fetchChartData(currentDays);
        
        // Setup event listeners
        setupEventListeners();
        
        // Load transaction history
        loadTransactionHistory();
        
    } catch (error) {
        console.error('Error initializing page:', error);
        document.getElementById('coinSymbol').textContent = 'Error';
        document.getElementById('coinName').textContent = error.message;
    }
}

async function loadUserBalance() {
    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        
        if (data.success && data.assets) {
            const asset = data.assets.find(a => a.coin_key === coinKey);
            assetBalance = asset ? parseFloat(asset.balance || 0) : 0;
            updateBalanceDisplay();
        }
    } catch (error) {
        console.error('Error loading user balance:', error);
    }
}

function updateBalanceDisplay() {
    const balanceAmountEl = document.getElementById('balanceAmount');
    const balanceUSDEl = document.getElementById('balanceUSD');
    
    balanceAmountEl.textContent = `${assetBalance.toFixed(8)} ${currentAsset.symbol}`;
    
    const usdValue = assetBalance * currentPrice;
    balanceUSDEl.textContent = `USD $${usdValue.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
}

function setupEventListeners() {
    // Time filter buttons
    document.querySelectorAll('.time-filter').forEach(filter => {
        filter.addEventListener('click', function() {
            document.querySelectorAll('.time-filter').forEach(f => {
                f.classList.remove('active', 'bg-primary', 'text-white');
                f.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-600', 'dark:text-slate-400');
            });
            this.classList.add('active', 'bg-primary', 'text-white');
            this.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-600', 'dark:text-slate-400');
            
            const days = this.getAttribute('data-days');
            currentDays = days;
            fetchChartData(days);
        });
    });
    
    // Tab buttons
    document.querySelectorAll('.coin-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            
            // Update tab buttons
            document.querySelectorAll('.coin-tab').forEach(t => {
                t.classList.remove('border-primary', 'text-primary');
                t.classList.add('border-transparent', 'text-slate-500', 'dark:text-slate-400');
            });
            this.classList.add('border-primary', 'text-primary');
            this.classList.remove('border-transparent', 'text-slate-500', 'dark:text-slate-400');
            
            // Show/hide tab content
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            
            if (tabName === 'history') {
                loadTransactionHistory();
            }
        });
    });
    
    // Send/Receive buttons
    document.getElementById('sendBtn').addEventListener('click', () => {
        window.location.href = `send.php?coin_key=${currentAsset.id}`;
    });
    
    document.getElementById('receiveBtn').addEventListener('click', () => {
        window.location.href = `receive.php?coin_key=${currentAsset.id}`;
    });
}

// Price caching for asset detail
function getCachedAssetPrice(coinId) {
    try {
        const cached = sessionStorage.getItem('crypto_prices_cache');
        if (!cached) return null;
        const { data, timestamp } = JSON.parse(cached);
        const age = Date.now() - timestamp;
        if (age < 30000 && data && data[coinId]) {
            return data[coinId];
        }
        return null;
    } catch (e) {
        return null;
    }
}

async function fetchAssetData() {
    try {
        // Check cache first
        const cached = getCachedAssetPrice(currentAsset.id);
        if (cached) {
            currentPrice = cached.usd || 0;
            updatePriceDisplay(currentPrice, cached.usd_24h_change || 0, cached.usd_market_cap || 0);
            updateBalanceDisplay();
            return;
        }
        
        const response = await fetch(`../../api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(currentAsset.id)}&vs_currencies=usd&include_24hr_change=true&include_market_cap=true`);
        
        // Handle rate limiting
        if (response.status === 429) {
            console.warn('Rate limit exceeded. Using cached price if available.');
            if (cached) {
                currentPrice = cached.usd || 0;
                updatePriceDisplay(currentPrice, cached.usd_24h_change || 0, cached.usd_market_cap || 0);
                updateBalanceDisplay();
            }
            return;
        }
        
        const data = await response.json();
        
        if (data && data[currentAsset.id]) {
            const assetData = data[currentAsset.id];
            currentPrice = assetData.usd || 0;
            const priceChange24h = assetData.usd_24h_change || 0;
            const marketCap = assetData.usd_market_cap || 0;
            
            updatePriceDisplay(currentPrice, priceChange24h, marketCap);
            updateBalanceDisplay();
        }
    } catch (error) {
        console.error('Error fetching asset data:', error);
        // Try cached price as fallback
        const cached = getCachedAssetPrice(currentAsset.id);
        if (cached) {
            currentPrice = cached.usd || 0;
            updatePriceDisplay(currentPrice, cached.usd_24h_change || 0, cached.usd_market_cap || 0);
            updateBalanceDisplay();
        }
    }
}

async function fetchChartData(days = '1') {
    try {
        const url = `../../api/coingecko.php?path=/coins/${encodeURIComponent(currentAsset.id)}/market_chart&vs_currency=usd&days=${encodeURIComponent(days)}`;
        let response = await fetch(url);
        
        // Handle rate limiting with retry
        if (response.status === 429) {
            console.warn('Rate limit exceeded for chart. Waiting before retry...');
            await new Promise(resolve => setTimeout(resolve, 5000));
            response = await fetch(url);
        }
        
        if (response.ok) {
            const data = await response.json();
            if (data && data.prices) {
                processChartData(data.prices, days);
            } else {
                createFallbackChart();
            }
        } else {
            createFallbackChart();
        }
    } catch (error) {
        console.error('Error fetching chart data:', error);
        createFallbackChart();
    }
}

function processChartData(prices, days) {
    const labels = [];
    const chartData = [];
    
    const sampleInterval = Math.max(1, Math.floor(prices.length / 50));
    
    prices.forEach(([timestamp, price], index) => {
        if (index % sampleInterval === 0) {
            const date = new Date(timestamp);
            let label;
            
            if (days === '1') {
                label = date.getHours() + 'h';
            } else if (days === '7') {
                label = date.toLocaleDateString('en', { weekday: 'short' });
            } else if (days === '30') {
                label = date.getDate() + '/' + (date.getMonth() + 1);
            } else {
                label = date.toLocaleDateString('en', { month: 'short' });
            }
            
            labels.push(label);
            chartData.push(price);
        }
    });
    
    createChart(labels, chartData);
}

function createChart(labels, data) {
    const ctx = document.getElementById('priceChart').getContext('2d');
    
    if (priceChart) {
        priceChart.destroy();
    }
    
    const isPositive = data[data.length - 1] >= data[0];
    const chartColor = isPositive ? '#10b981' : '#ef4444';
    
    priceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: `${currentAsset.symbol} Price`,
                data: data,
                borderColor: chartColor,
                backgroundColor: isPositive ? 'rgba(16, 185, 129, 0.1)' : 'rgba(239, 68, 68, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: function(context) {
                            return `$${context.parsed.y.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
                        }
                    }
                }
            },
            scales: {
                x: { display: false, grid: { display: false } },
                y: { display: false, grid: { display: false } }
            },
            interaction: {
                intersect: false,
                mode: 'nearest'
            }
        }
    });
}

function createFallbackChart() {
    const ctx = document.getElementById('priceChart').getContext('2d');
    if (priceChart) priceChart.destroy();
    
    const labels = ['12h', '14h', '16h', '18h', '20h', '22h', '24h'];
    const data = [currentPrice * 0.98, currentPrice * 0.99, currentPrice, currentPrice * 1.01, currentPrice * 1.02, currentPrice * 1.01, currentPrice];
    
    priceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { display: false },
                y: { display: false }
            }
        }
    });
}

function updatePriceDisplay(price, change, marketCap) {
    const currentPriceEl = document.getElementById('currentPrice');
    const priceChangeEl = document.getElementById('priceChange');
    const marketCapEl = document.getElementById('marketCap');
    
    if (price) {
        currentPriceEl.textContent = `$${price.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }
    
        if (change !== undefined) {
            const changeAmount = (change / 100) * price;
            const isPositive = change >= 0;
            const changeText = `${isPositive ? '▲' : '▼'} $${Math.abs(changeAmount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})} (${isPositive ? '+' : ''}${change.toFixed(2)}%)`;
            priceChangeEl.textContent = changeText;
            priceChangeEl.className = isPositive ? 'text-lg font-medium mb-1 text-green-600' : 'text-lg font-medium mb-1 text-red-600';
        }
    
    if (marketCap) {
        marketCapEl.textContent = `Market Cap: $${(marketCap / 1e9).toFixed(2)}B`;
    }
}

async function loadTransactionHistory() {
    const historyContainer = document.getElementById('transactionHistory');
    historyContainer.innerHTML = '<p class="text-slate-500 dark:text-slate-400 text-center">Loading...</p>';
    
    try {
        const response = await fetch(`../../api/user/transactions.php?coin_key=${encodeURIComponent(coinKey)}`);
        const data = await response.json();
        
        if (data.success && data.transactions && data.transactions.length > 0) {
            const historyHtml = data.transactions.map(tx => {
                const type = escapeHtml(tx.type || 'unknown');
                const amount = parseFloat(tx.amount || 0);
                const date = new Date(tx.created_at);
                const typeClass = type === 'send' ? 'text-red-600' : type === 'receive' ? 'text-green-600' : 'text-slate-600';
                const typeIcon = type === 'send' ? 'arrow_upward' : type === 'receive' ? 'arrow_downward' : 'swap_horiz';
                const coinSymbol = escapeHtml(tx.coin_symbol || currentAsset.symbol || '');
                const status = escapeHtml(tx.status || 'completed');
                
                return `
                    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined ${typeClass}">${typeIcon}</span>
                            <div>
                                <p class="font-medium">${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">${escapeHtml(date.toLocaleDateString())} ${escapeHtml(date.toLocaleTimeString())}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold ${typeClass}">${type === 'send' ? '-' : '+'}${amount.toFixed(8)} ${coinSymbol}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">${status}</p>
                        </div>
                    </div>
                `;
            }).join('');
            
            historyContainer.innerHTML = historyHtml;
        } else {
            historyContainer.innerHTML = '<p class="text-slate-500 dark:text-slate-400 text-center p-4">No transaction history</p>';
        }
    } catch (error) {
        console.error('Error loading transaction history:', error);
        historyContainer.innerHTML = '<p class="text-red-500 text-center p-4">Error loading transaction history</p>';
    }
}

// Update price every 30 seconds
setInterval(fetchAssetData, 30000);

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', initializePage);

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
