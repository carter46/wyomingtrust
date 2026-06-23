<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication (and ensure account still exists)
require_user_page_auth('../../login.php');

$page_title = 'Transaction History - WyomingTrust';
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
<div class="relative flex h-auto min-h-screen w-full flex-col overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<header class="flex items-center justify-between border-b border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
<div class="flex items-center gap-2 sm:gap-4">
<a href="dashboard.php" class="flex items-center gap-2 sm:gap-4 text-primary">
<div class="size-6 sm:size-8"><svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path></svg></div>
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
<a href="transactions.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3 bg-primary/10 text-primary">
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
<main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
<div class="max-w-[1200px] mx-auto">
<h1 class="text-2xl sm:text-3xl lg:text-4xl font-black mb-2 sm:mb-4">Transaction History</h1>
<p class="text-slate-500 text-sm sm:text-base mb-6 sm:mb-8">View all your cryptocurrency transactions</p>
<div class="flex flex-col sm:flex-row gap-4 mb-6 sm:mb-8">
<select id="typeFilter" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<option value="">All Types</option>
<option value="send">Send</option>
<option value="receive">Receive</option>
<option value="swap">Swap</option>
<option value="payment">Payment</option>
</select>
<select id="statusFilter" class="px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
<option value="">All Status</option>
<option value="completed">Completed</option>
<option value="pending">Pending</option>
<option value="failed">Failed</option>
</select>
<input type="text" id="searchInput" placeholder="Search transactions..." class="flex-1 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-sm">
</div>
<div id="transactionsContainer" class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
<div class="p-10 text-center text-slate-500">
<div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent mb-4"></div>
<p>Loading transactions...</p>
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
</div>
</div>
</footer>
</div>
</div>
<script>
let transactions = [];
let cryptoPrices = {};

async function loadTransactions() {
    try {
        const response = await fetch('../../api/user/transactions.php');
        const data = await response.json();
        
        if (data.success && data.transactions) {
            transactions = data.transactions;
            await fetchCryptoPrices();
            renderTransactions();
        } else {
            document.getElementById('transactionsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Failed to load transactions</div>';
        }
    } catch (error) {
        console.error('Error loading transactions:', error);
        document.getElementById('transactionsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Error loading transactions</div>';
    }
}

async function fetchCryptoPrices() {
    const coinIds = [...new Set(transactions.map(t => t.coin_key || t.asset_symbol?.toLowerCase()).filter(Boolean))];
    if (coinIds.length === 0) return;
    
    try {
        const response = await fetch(`/api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(coinIds.join(','))}&vs_currencies=usd`);
        if (response.ok) {
            cryptoPrices = await response.json();
        }
    } catch (error) {
        console.error('Error fetching prices:', error);
    }
}

function renderTransactions() {
    const container = document.getElementById('transactionsContainer');
    const typeFilter = document.getElementById('typeFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    
    let filtered = transactions.filter(t => {
        if (typeFilter && t.type !== typeFilter) return false;
        if (statusFilter && t.status !== statusFilter) return false;
        if (searchTerm) {
            const searchable = `${t.asset_symbol} ${t.coin_name} ${t.recipient} ${t.status}`.toLowerCase();
            if (!searchable.includes(searchTerm)) return false;
        }
        return true;
    });
    
    if (filtered.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-slate-500">No transactions found</div>';
        return;
    }
    
    const html = filtered.map(t => {
        const amount = parseFloat(t.amount || 0);
        const coinSymbol = t.coin_symbol || t.asset_symbol || '?';
        const logo = t.coin_logo || '';
        const typeIcon = t.type === 'send' ? 'send' : t.type === 'receive' ? 'call_received' : t.type === 'swap' ? 'swap_horiz' : 'payment';
        const statusClass = t.status === 'completed' ? 'bg-green-100 text-green-700 dark:bg-green-900/20 dark:text-green-400' : 
                           t.status === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400' :
                           'bg-red-100 text-red-700 dark:bg-red-900/20 dark:text-red-400';
        
        return `
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 p-4 sm:p-6 border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                <div class="flex items-center gap-3 sm:gap-4 flex-1 min-w-0">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">${typeIcon}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="font-bold text-sm sm:text-base">${escapeHtml(t.type.charAt(0).toUpperCase() + t.type.slice(1))}</h4>
                            <span class="px-2 py-0.5 text-xs rounded ${statusClass}">${escapeHtml(t.status)}</span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500">${new Date(t.created_at).toLocaleString()}</p>
                        ${t.recipient ? `<p class="text-xs text-slate-400 mt-1 truncate">To: ${escapeHtml(t.recipient.substring(0, 20))}${t.recipient.length > 20 ? '...' : ''}</p>` : ''}
                    </div>
                </div>
                <div class="flex items-center gap-3 sm:gap-6 flex-shrink-0">
                    <div class="text-right">
                        <p class="text-sm sm:text-base font-bold">${t.type === 'send' ? '-' : t.type === 'receive' ? '+' : ''}${amount.toFixed(8)} ${coinSymbol}</p>
                        ${cryptoPrices[t.coin_key || t.asset_symbol?.toLowerCase()] ? 
                            `<p class="text-xs text-slate-500">$${(amount * (cryptoPrices[t.coin_key || t.asset_symbol?.toLowerCase()].usd || 0)).toFixed(2)}</p>` : 
                            '<p class="text-xs text-slate-500">--</p>'}
                    </div>
                </div>
            </div>
        `;
    }).join('');
    
    container.innerHTML = html;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

document.getElementById('typeFilter')?.addEventListener('change', renderTransactions);
document.getElementById('statusFilter')?.addEventListener('change', renderTransactions);
document.getElementById('searchInput')?.addEventListener('input', renderTransactions);

document.addEventListener('DOMContentLoaded', loadTransactions);

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
