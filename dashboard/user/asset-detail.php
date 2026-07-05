<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$userName = $_SESSION['user_name'] ?? 'User';
$page_title = 'Asset Details | WyomingTrust';
$active_nav = '';
$extra_head = '<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>';

include __DIR__ . '/includes/layout.php';
?>

<section class="text-center">
<h1 class="font-headline-lg text-headline-lg text-primary mb-2" id="coinSymbol">Loading...</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant" id="coinName">Loading...</p>
</section>

<section class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant">
<div class="text-center">
<div class="text-3xl sm:text-4xl font-bold text-primary mb-2" id="currentPrice">$0.00</div>
<div class="text-lg font-medium mb-1" id="priceChange">--</div>
<div class="text-sm text-on-surface-variant" id="marketCap"></div>
</div>
</section>

<section>
<div class="flex gap-2 mb-4 overflow-x-auto pb-2">
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-surface-container-low text-on-surface-variant hover:bg-surface-container" data-days="1">1H</button>
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-primary text-on-primary active" data-days="1">1D</button>
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-surface-container-low text-on-surface-variant hover:bg-surface-container" data-days="7">1W</button>
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-surface-container-low text-on-surface-variant hover:bg-surface-container" data-days="30">1M</button>
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-surface-container-low text-on-surface-variant hover:bg-surface-container" data-days="365">1Y</button>
<button type="button" class="time-filter px-4 py-2 rounded-lg text-sm font-medium bg-surface-container-low text-on-surface-variant hover:bg-surface-container" data-days="max">All</button>
</div>
<div class="bg-surface-container-lowest rounded-2xl p-4 border border-outline-variant mb-4" style="height: 300px;">
<canvas id="priceChart"></canvas>
</div>
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-4">
<button type="button" id="sendBtn" class="px-4 py-3 rounded-lg bg-surface-container-low text-on-surface font-medium hover:bg-surface-container transition-colors">Send</button>
<button type="button" id="receiveBtn" class="px-4 py-3 rounded-lg bg-surface-container-low text-on-surface font-medium hover:bg-surface-container transition-colors">Receive</button>
<button type="button" onclick="window.location.href='swap.php'" class="px-4 py-3 rounded-lg bg-surface-container-low text-on-surface font-medium hover:bg-surface-container transition-colors">Swap</button>
<button type="button" onclick="window.location.href='assets.php'" class="px-4 py-3 rounded-lg bg-secondary text-on-secondary font-medium hover:bg-secondary/90 transition-colors">All Assets</button>
</div>
</section>

<section>
<div class="flex gap-2 mb-4 border-b border-outline-variant">
<button type="button" class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-primary text-primary" data-tab="holdings">Holdings</button>
<button type="button" class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-transparent text-on-surface-variant hover:text-on-surface" data-tab="history">History</button>
<button type="button" class="coin-tab px-4 py-2 text-sm font-medium border-b-2 border-transparent text-on-surface-variant hover:text-on-surface" data-tab="about">About</button>
</div>
<div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant mb-4">
<div class="text-center mb-4">
<h3 class="font-headline-md text-headline-md text-primary mb-4">My Balance</h3>
<div class="flex items-center justify-center gap-3 mb-4">
<img src="" alt="Crypto Logo" class="w-12 h-12 rounded-full" id="balanceLogo" onerror="this.style.display='none'">
<div class="text-xl font-bold text-primary" id="balanceSymbol">--</div>
</div>
<div class="text-2xl sm:text-3xl font-bold text-primary mb-2" id="balanceAmount">0.00000000</div>
<div class="text-lg text-on-surface-variant" id="balanceUSD">USD $0.00</div>
</div>
</div>
<div id="tabContent">
<div id="holdingsTab" class="tab-content">
<div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant">
<p class="text-on-surface-variant text-center">Balance information displayed above</p>
</div>
</div>
<div id="historyTab" class="tab-content hidden">
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant overflow-hidden">
<div id="transactionHistory" class="p-4">
<p class="text-on-surface-variant text-center">Loading transaction history...</p>
</div>
</div>
</div>
<div id="aboutTab" class="tab-content hidden pb-20">
<div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant">
<div id="coinAbout" class="text-on-surface-variant"><p>Loading coin information...</p></div>
</div>
</div>
</div>
</section>

<script>
let priceChart = null;
let currentDays = '1';
let currentAsset = null;
let assetBalance = 0;
let currentPrice = 0;

const urlParams = new URLSearchParams(window.location.search);
const coinKey = urlParams.get('coin_key') || 'bitcoin';

async function initializePage() {
    try {
        const coinsResponse = await fetch('../../api/coins.php');
        const coinsData = await coinsResponse.json();
        if (!coinsData.success || !coinsData.coins) throw new Error('Failed to load coins');

        const coin = coinsData.coins.find(c => c.coin_key === coinKey);
        if (!coin) throw new Error('Coin not found');

        currentAsset = { id: coin.coin_key, symbol: coin.symbol, name: coin.display_name, logo: coin.logo };
        document.getElementById('coinSymbol').textContent = currentAsset.symbol;
        document.getElementById('coinName').textContent = currentAsset.name;
        document.getElementById('balanceSymbol').textContent = currentAsset.symbol;
        document.getElementById('balanceLogo').src = currentAsset.logo;

        await loadUserBalance();
        await fetchAssetData();
        await fetchChartData(currentDays);
        setupEventListeners();
        loadTransactionHistory();
    } catch (error) {
        console.error('Error initializing page:', error);
        document.getElementById('coinSymbol').textContent = 'Error';
        document.getElementById('coinName').textContent = error.message;
    }
}

async function loadUserBalance() {
    try {
        const response = await fetch('../../api/user/assets.php', { credentials: 'same-origin' });
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
    document.getElementById('balanceAmount').textContent = `${assetBalance.toFixed(8)} ${currentAsset.symbol}`;
    const usdValue = assetBalance * currentPrice;
    document.getElementById('balanceUSD').textContent = `USD $${usdValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
}

function setupEventListeners() {
    document.querySelectorAll('.time-filter').forEach(filter => {
        filter.addEventListener('click', function() {
            document.querySelectorAll('.time-filter').forEach(f => {
                f.classList.remove('active', 'bg-primary', 'text-on-primary');
                f.classList.add('bg-surface-container-low', 'text-on-surface-variant');
            });
            this.classList.add('active', 'bg-primary', 'text-on-primary');
            this.classList.remove('bg-surface-container-low', 'text-on-surface-variant');
            currentDays = this.getAttribute('data-days');
            fetchChartData(currentDays);
        });
    });

    document.querySelectorAll('.coin-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            const tabName = this.getAttribute('data-tab');
            document.querySelectorAll('.coin-tab').forEach(t => {
                t.classList.remove('border-primary', 'text-primary');
                t.classList.add('border-transparent', 'text-on-surface-variant');
            });
            this.classList.add('border-primary', 'text-primary');
            this.classList.remove('border-transparent', 'text-on-surface-variant');
            document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            if (tabName === 'history') loadTransactionHistory();
        });
    });

    document.getElementById('sendBtn').addEventListener('click', () => {
        window.location.href = `send.php?coin_key=${currentAsset.id}`;
    });
    document.getElementById('receiveBtn').addEventListener('click', () => {
        window.location.href = `receive.php?coin_key=${currentAsset.id}`;
    });
}

function getCachedAssetPrice(coinId) {
    try {
        const cached = sessionStorage.getItem('crypto_prices_cache');
        if (!cached) return null;
        const { data, timestamp } = JSON.parse(cached);
        if (Date.now() - timestamp < 30000 && data && data[coinId]) return data[coinId];
        return null;
    } catch (e) { return null; }
}

async function fetchAssetData() {
    try {
        const cached = getCachedAssetPrice(currentAsset.id);
        if (cached) {
            currentPrice = cached.usd || 0;
            updatePriceDisplay(currentPrice, cached.usd_24h_change || 0, cached.usd_market_cap || 0);
            updateBalanceDisplay();
            return;
        }
        const response = await fetch(`../../api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(currentAsset.id)}&vs_currencies=usd&include_24hr_change=true&include_market_cap=true`, { credentials: 'same-origin' });
        if (response.status === 429 && cached) {
            currentPrice = cached.usd || 0;
            updatePriceDisplay(currentPrice, cached.usd_24h_change || 0, cached.usd_market_cap || 0);
            updateBalanceDisplay();
            return;
        }
        const data = await response.json();
        if (data && data[currentAsset.id]) {
            const assetData = data[currentAsset.id];
            currentPrice = assetData.usd || 0;
            updatePriceDisplay(currentPrice, assetData.usd_24h_change || 0, assetData.usd_market_cap || 0);
            updateBalanceDisplay();
        }
    } catch (error) {
        console.error('Error fetching asset data:', error);
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
        let response = await fetch(url, { credentials: 'same-origin' });
        if (response.status === 429) {
            await new Promise(resolve => setTimeout(resolve, 5000));
            response = await fetch(url, { credentials: 'same-origin' });
        }
        if (response.ok) {
            const data = await response.json();
            if (data && data.prices) processChartData(data.prices, days);
            else createFallbackChart();
        } else createFallbackChart();
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
            if (days === '1') label = date.getHours() + 'h';
            else if (days === '7') label = date.toLocaleDateString('en', { weekday: 'short' });
            else if (days === '30') label = date.getDate() + '/' + (date.getMonth() + 1);
            else label = date.toLocaleDateString('en', { month: 'short' });
            labels.push(label);
            chartData.push(price);
        }
    });
    createChart(labels, chartData);
}

function createChart(labels, data) {
    const ctx = document.getElementById('priceChart').getContext('2d');
    if (priceChart) priceChart.destroy();
    const isPositive = data[data.length - 1] >= data[0];
    const chartColor = isPositive ? '#2D4B3F' : '#ba1a1a';
    priceChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: `${currentAsset.symbol} Price`,
                data,
                borderColor: chartColor,
                backgroundColor: isPositive ? 'rgba(45, 75, 63, 0.1)' : 'rgba(186, 26, 26, 0.1)',
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
                        label: (context) => `$${context.parsed.y.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
                    }
                }
            },
            scales: { x: { display: false, grid: { display: false } }, y: { display: false, grid: { display: false } } },
            interaction: { intersect: false, mode: 'nearest' }
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
        data: { labels, datasets: [{ data, borderColor: '#2D4B3F', backgroundColor: 'rgba(45, 75, 63, 0.1)', borderWidth: 2, fill: true, tension: 0.4, pointRadius: 0 }] },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { display: false }, y: { display: false } } }
    });
}

function updatePriceDisplay(price, change, marketCap) {
    if (price) {
        document.getElementById('currentPrice').textContent = `$${price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }
    if (change !== undefined) {
        const changeAmount = (change / 100) * price;
        const isPositive = change >= 0;
        const el = document.getElementById('priceChange');
        el.textContent = `${isPositive ? '▲' : '▼'} $${Math.abs(changeAmount).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })} (${isPositive ? '+' : ''}${change.toFixed(2)}%)`;
        el.className = isPositive ? 'text-lg font-medium mb-1 text-deep-forest' : 'text-lg font-medium mb-1 text-error';
    }
    if (marketCap) {
        document.getElementById('marketCap').textContent = `Market Cap: $${(marketCap / 1e9).toFixed(2)}B`;
    }
}

async function loadTransactionHistory() {
    const historyContainer = document.getElementById('transactionHistory');
    historyContainer.innerHTML = '<p class="text-on-surface-variant text-center">Loading...</p>';
    try {
        const response = await fetch(`../../api/user/transactions.php?coin_key=${encodeURIComponent(coinKey)}`, { credentials: 'same-origin' });
        const data = await response.json();
        if (data.success && data.transactions && data.transactions.length > 0) {
            historyContainer.innerHTML = data.transactions.map(tx => {
                const type = escapeHtml(tx.type || 'unknown');
                const amount = parseFloat(tx.amount || 0);
                const date = new Date(tx.created_at);
                const typeClass = type === 'send' ? 'text-error' : type === 'receive' ? 'text-deep-forest' : 'text-on-surface-variant';
                const iconName = type === 'send' ? 'send' : type === 'receive' ? 'receive' : 'swap';
                const coinSymbol = escapeHtml(tx.coin_symbol || currentAsset.symbol || '');
                const status = escapeHtml(tx.status || 'completed');
                return `
                    <div class="flex items-center justify-between p-4 border-b border-outline-variant/30">
                        <div class="flex items-center gap-3">
                            ${typeof wtIcon === 'function' ? wtIcon(iconName, 'w-5 h-5 ' + typeClass) : ''}
                            <div>
                                <p class="font-medium text-on-surface">${type.charAt(0).toUpperCase() + type.slice(1)}</p>
                                <p class="text-xs text-on-surface-variant">${escapeHtml(date.toLocaleDateString())} ${escapeHtml(date.toLocaleTimeString())}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold ${typeClass}">${type === 'send' ? '-' : '+'}${amount.toFixed(8)} ${coinSymbol}</p>
                            <p class="text-xs text-on-surface-variant">${status}</p>
                        </div>
                    </div>`;
            }).join('');
        } else {
            historyContainer.innerHTML = '<p class="text-on-surface-variant text-center p-4">No transaction history</p>';
        }
    } catch (error) {
        console.error('Error loading transaction history:', error);
        historyContainer.innerHTML = '<p class="text-error text-center p-4">Error loading transaction history</p>';
    }
}

setInterval(fetchAssetData, 30000);

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

document.addEventListener('DOMContentLoaded', initializePage);
</script>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
