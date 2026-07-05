<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$userName = $_SESSION['user_name'] ?? 'User';
$page_title = 'Dashboard | ' . ($userName !== 'User' ? $userName : 'WyomingTrust');
$active_nav = 'assets';

include __DIR__ . '/includes/layout.php';
?>

<!-- Welcome -->
<section>
<h1 class="font-headline-lg text-headline-lg text-primary mb-2">Welcome Back, <span id="userName"><?php echo escape_html($userName); ?></span>.</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Manage your trusts and monitor your crypto portfolio in one secure dashboard.</p>
</section>

<!-- Key Metrics -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
<div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant card-hover flex flex-col justify-between h-36">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Total Assets</span>
<div>
<p class="font-headline-md text-headline-md text-primary">$<span id="totalAssets">0.00</span></p>
<p class="text-sm text-secondary font-medium">in <span id="assetCount">0</span> assets</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant card-hover flex flex-col justify-between h-36">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Active Trusts</span>
<div>
<p class="font-headline-md text-headline-md text-primary" id="trustCount">0</p>
<p class="text-sm text-on-surface-variant">Securely Managed</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant card-hover flex flex-col justify-between h-36">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Beneficiaries</span>
<div>
<p class="font-headline-md text-headline-md text-primary" id="beneficiaryCount">0</p>
<p class="text-sm text-on-surface-variant">Assigned protections</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant card-hover flex flex-col justify-between h-36">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Last Updated</span>
<div>
<p class="font-headline-md text-headline-md text-primary" id="lastUpdated">Just Now</p>
<div class="flex items-center gap-2 text-deep-forest">
<span class="w-2 h-2 rounded-full bg-deep-forest animate-pulse"></span>
<p class="text-sm">System Sync</p>
</div>
</div>
</div>
</section>

<!-- Action Banners -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="relative overflow-hidden bg-primary p-8 rounded-2xl text-on-primary group">
<div class="relative z-10">
<h3 class="font-headline-md text-headline-md mb-3">Link an External Wallet?</h3>
<p class="font-body-md text-on-primary/80 mb-6 max-w-md">Securely connect your hardware or exchange holdings to WyomingTrust for unified estate management.</p>
<button type="button" onclick="window.location.href='link-wallet.php'" class="flex items-center gap-2 px-6 py-3 bg-secondary hover:bg-secondary/90 text-on-secondary rounded-lg font-bold transition-all">
Link Wallet
<span class="material-symbols-outlined">arrow_forward</span>
</button>
</div>
<div class="absolute top-0 right-0 -translate-y-1/4 translate-x-1/4 opacity-10 group-hover:opacity-20 transition-opacity pointer-events-none">
<span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'wght' 700;">account_balance_wallet</span>
</div>
</div>
<div class="relative overflow-hidden bg-warm-cream p-8 rounded-2xl border border-outline-variant group">
<div class="relative z-10">
<h3 class="font-headline-md text-headline-md text-primary mb-3">Create Another Trust?</h3>
<p class="font-body-md text-on-surface-variant mb-6 max-w-md">Expand your estate planning with new asset protections and customized legal frameworks.</p>
<button type="button" onclick="window.location.href='../../onboarding/onboarding.php'" class="flex items-center gap-2 px-6 py-3 border-2 border-primary text-primary hover:bg-primary hover:text-on-primary rounded-lg font-bold transition-all">
Create New Trust
<span class="material-symbols-outlined">add</span>
</button>
</div>
<div class="absolute top-0 right-0 -translate-y-1/4 translate-x-1/4 opacity-5 group-hover:opacity-10 transition-opacity pointer-events-none">
<span class="material-symbols-outlined text-[200px]" style="font-variation-settings: 'wght' 700;">gavel</span>
</div>
</div>
</section>

<!-- My Trusts -->
<section>
<div class="flex items-center justify-between mb-6">
<h2 class="font-headline-md text-headline-md text-primary">My Trusts</h2>
<a class="font-label-md text-label-md text-secondary hover:underline underline-offset-4" href="manage-trust.php">View All</a>
</div>
<div id="trustsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="col-span-full text-center py-10 text-on-surface-variant">Loading trusts...</div>
</div>
</section>

<!-- Crypto Portfolio -->
<section class="pb-20">
<div class="flex items-center justify-between mb-6">
<h2 class="font-headline-md text-headline-md text-primary">Crypto Portfolio</h2>
<a class="font-label-md text-label-md text-secondary hover:underline underline-offset-4" href="assets.php">View All Assets</a>
</div>
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant overflow-hidden shadow-sm">
<div id="assetsContainer">
<div class="p-10 text-center text-on-surface-variant">Loading assets...</div>
</div>
</div>
</section>

<script>
let cryptoPrices = {};

function formatDateSafe(value) {
    if (!value) return 'N/A';
    try {
        const s = String(value).trim();
        if (s === '' || s === '0000-00-00 00:00:00' || s === '0000-00-00') return 'N/A';
        const isoish = s.includes(' ') && !s.includes('T') ? s.replace(' ', 'T') : s;
        const d = new Date(isoish);
        if (Number.isNaN(d.getTime())) return 'N/A';
        return d.toLocaleDateString();
    } catch (e) {
        return 'N/A';
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function trustCardIcon(serviceKey) {
    const icons = {
        irrevocable_trust: { icon: 'shield', bg: 'bg-primary/5', color: 'text-primary' },
        revocable_living_trust: { icon: 'family_restroom', bg: 'bg-secondary/5', color: 'text-secondary' },
        crypto_asset_trust: { icon: 'currency_bitcoin', bg: 'bg-secondary/5', color: 'text-secondary' },
        smart_contract_trust: { icon: 'smart_toy', bg: 'bg-primary/5', color: 'text-primary' },
        trust_llc: { icon: 'business', bg: 'bg-primary/5', color: 'text-primary' },
    };
    return icons[serviceKey] || { icon: 'gavel', bg: 'bg-primary/5', color: 'text-primary' };
}

function updateLastSynced() {
    const el = document.getElementById('lastUpdated');
    if (el) el.textContent = 'Just Now';
}

function countUniqueBeneficiaries(trusts) {
    const seen = new Set();
    trusts.forEach(t => {
        const bens = Array.isArray(t.beneficiaries) ? t.beneficiaries :
            (Array.isArray(t.trust_data?.beneficiaries) ? t.trust_data.beneficiaries : []);
        bens.forEach(b => {
            const key = String(b.email || b.full_name || b.name || '').trim().toLowerCase();
            if (key) seen.add(key);
        });
    });
    return seen.size;
}

function assetValue(asset) {
    const price = asset.price_usd || cryptoPrices[asset.coin_key]?.usd || 0;
    return parseFloat(asset.balance || 0) * price;
}

async function loadDashboardData() {
    const trustsContainer = document.getElementById('trustsContainer');
    const trustCountEl = document.getElementById('trustCount');
    const beneficiaryEl = document.getElementById('beneficiaryCount');

    const showTrustsError = (message) => {
        if (trustsContainer) {
            trustsContainer.innerHTML = `<div class="col-span-full text-center py-10 text-error">${escapeHtml(message)}</div>`;
        }
        if (trustCountEl) trustCountEl.textContent = '0';
        if (beneficiaryEl) beneficiaryEl.textContent = '0';
    };

    try {
        try {
            const profileResponse = await fetch('../../api/user/profile.php', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            });
            if (profileResponse.ok) {
                const profileData = await profileResponse.json();
                if (profileData.success && profileData.user?.full_name) {
                    const nameEl = document.getElementById('userName');
                    if (nameEl) nameEl.textContent = profileData.user.full_name;
                }
            }
        } catch (profileError) {
            console.error('Error loading profile:', profileError);
        }

        const trustsResponse = await fetch('../../api/user/trusts.php', {
            credentials: 'same-origin',
            headers: { 'Accept': 'application/json' }
        });

        if (!trustsResponse.ok) {
            showTrustsError(`Failed to load trusts (HTTP ${trustsResponse.status})`);
        } else {
            let trustsData;
            try {
                trustsData = await trustsResponse.json();
            } catch (jsonError) {
                showTrustsError('Invalid response from server');
                trustsData = null;
            }

            if (trustsData && trustsData.success && Array.isArray(trustsData.trusts)) {
                const activeTrusts = trustsData.trusts.filter(t => (t.status || '').toLowerCase() === 'active');
                if (trustCountEl) trustCountEl.textContent = String(activeTrusts.length);

                const uniqueBeneficiaries = countUniqueBeneficiaries(trustsData.trusts);
                if (beneficiaryEl) beneficiaryEl.textContent = String(uniqueBeneficiaries);

                if (activeTrusts.length > 0) {
                    renderTrusts(activeTrusts);
                } else if (trustsData.trusts.length > 0) {
                    if (trustsContainer) {
                        trustsContainer.innerHTML = '<div class="col-span-full text-center py-10 text-on-surface-variant">No active trusts yet. <a href="manage-trust.php" class="text-secondary font-semibold hover:underline">View pending trusts</a></div>';
                    }
                } else {
                    renderTrusts([]);
                }
            } else {
                if (trustCountEl) trustCountEl.textContent = '0';
                if (beneficiaryEl) beneficiaryEl.textContent = '0';
                if (trustsContainer) {
                    trustsContainer.innerHTML = '<div class="col-span-full text-center py-10 text-on-surface-variant">No trusts yet. <a href="../../onboarding/onboarding.php" class="text-secondary font-semibold hover:underline">Create your first trust</a></div>';
                }
            }
        }

        try {
            const assetsResponse = await fetch('../../api/user/assets.php', {
                credentials: 'same-origin',
                headers: { 'Accept': 'application/json' }
            });

            if (assetsResponse.ok) {
                const assetsData = await assetsResponse.json();
                if (assetsData.success && Array.isArray(assetsData.assets)) {
                    if (assetsData.assets.length === 0) {
                        const totalAssetsEl = document.getElementById('totalAssets');
                        const assetCountEl = document.getElementById('assetCount');
                        if (totalAssetsEl) totalAssetsEl.textContent = '0.00';
                        if (assetCountEl) assetCountEl.textContent = '0';
                        renderAssets([]);
                    } else {
                        await fetchCryptoPrices(assetsData.assets);

                        let totalValue = 0;
                        assetsData.assets.forEach(asset => {
                            totalValue += assetValue(asset);
                        });

                        const totalAssetsEl = document.getElementById('totalAssets');
                        const assetCountEl = document.getElementById('assetCount');
                        if (totalAssetsEl) totalAssetsEl.textContent = totalValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        if (assetCountEl) assetCountEl.textContent = String(assetsData.assets.length);

                        renderAssets(assetsData.assets);
                    }
                }
            }
        } catch (assetsError) {
            console.error('Error loading assets:', assetsError);
        }

        updateLastSynced();
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showTrustsError('Error loading dashboard data. Please refresh the page.');
    }
}

function getCachedPrices() {
    try {
        const cached = sessionStorage.getItem('crypto_prices_cache');
        if (!cached) return null;
        const { data, timestamp } = JSON.parse(cached);
        if (Date.now() - timestamp < 30000) return data;
        sessionStorage.removeItem('crypto_prices_cache');
        return null;
    } catch (e) {
        return null;
    }
}

function setCachedPrices(prices) {
    try {
        sessionStorage.setItem('crypto_prices_cache', JSON.stringify({ data: prices, timestamp: Date.now() }));
    } catch (e) {}
}

function batchCoinIds(coinIds, batchSize = 12) {
    const ids = coinIds.split(',').filter(Boolean);
    const batches = [];
    for (let i = 0; i < ids.length; i += batchSize) {
        batches.push(ids.slice(i, i + batchSize).join(','));
    }
    return batches;
}

async function fetchCryptoPrices(assets) {
    if (!assets || assets.length === 0) return;

    const cached = getCachedPrices();
    if (cached) {
        cryptoPrices = cached;
        return;
    }

    try {
        const coinIds = assets.map(a => a.coin_key).filter(Boolean).join(',');
        if (!coinIds) return;

        const batches = batchCoinIds(coinIds, 12);
        const allPrices = {};

        for (const batch of batches) {
            try {
                const response = await fetch(`../../api/coingecko.php?path=/simple/price&ids=${encodeURIComponent(batch)}&vs_currencies=usd&include_24hr_change=true`, {
                    credentials: 'same-origin'
                });
                if (response.ok) {
                    const data = await response.json();
                    if (data && !data.error) Object.assign(allPrices, data);
                }
            } catch (error) {
                console.error('Error fetching batch:', error);
            }
            if (batches.length > 1) await new Promise(resolve => setTimeout(resolve, 500));
        }

        if (Object.keys(allPrices).length > 0) {
            cryptoPrices = allPrices;
            setCachedPrices(allPrices);
        } else {
            assets.forEach(asset => {
                if (asset.price_usd) {
                    cryptoPrices[asset.coin_key] = { usd: asset.price_usd, usd_24h_change: asset.price_change_24h || 0 };
                }
            });
        }
    } catch (error) {
        console.error('Error fetching prices:', error);
    }
}

function renderTrusts(trusts) {
    const container = document.getElementById('trustsContainer');
    if (!trusts || trusts.length === 0) {
        container.innerHTML = '<div class="col-span-full text-center py-10 text-on-surface-variant">No trusts yet. <a href="../../onboarding/onboarding.php" class="text-secondary font-semibold hover:underline">Create your first trust</a></div>';
        return;
    }

    container.innerHTML = trusts.map(trust => {
        const trustName = trust.trust_name || trust.service_name || 'Untitled Trust';
        const serviceKey = trust.service_key || trust.trust_type || '';
        const createdDate = formatDateSafe(trust.created_at);
        const trustId = trust.id || 0;
        const { icon, bg, color } = trustCardIcon(serviceKey);

        return `
            <div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant flex flex-col sm:flex-row items-start gap-6 card-hover">
                <div class="w-16 h-16 rounded-xl ${bg} flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined ${color} text-3xl">${icon}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-headline-md text-headline-md text-primary leading-tight">${escapeHtml(trustName)}</p>
                    <p class="text-sm text-on-surface-variant mt-1 mb-6">Created: ${createdDate}</p>
                    <div class="flex flex-wrap items-center gap-3">
                        <button type="button" onclick="window.location.href='manage-trust.php?id=${trustId}'" class="px-5 py-2.5 bg-primary text-on-primary rounded-lg font-label-md text-label-md hover:bg-primary/90 transition-colors">Manage</button>
                        <button type="button" onclick="window.location.href='manage-trust.php?id=${trustId}'" class="px-5 py-2.5 border border-outline-variant text-on-surface rounded-lg font-label-md text-label-md hover:bg-surface-container transition-colors">View Details</button>
                    </div>
                </div>
            </div>
        `;
    }).join('');
}

function renderAssets(assets) {
    const container = document.getElementById('assetsContainer');
    if (!assets || assets.length === 0) {
        container.innerHTML = '<div class="p-10 text-center text-on-surface-variant">No assets yet. <a href="link-wallet.php" class="text-secondary font-semibold hover:underline">Link a wallet</a> to get started.</div>';
        return;
    }

    const sortedAssets = [...assets].sort((a, b) => assetValue(b) - assetValue(a));

    const topAssets = sortedAssets.slice(0, 5);

    container.innerHTML = `
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="px-8 py-5 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Asset</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Balance</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest">Price</th>
                        <th class="px-8 py-5 font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest text-right">Value</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/30">
                    ${topAssets.map(asset => {
                        const price = asset.price_usd || cryptoPrices[asset.coin_key]?.usd || 0;
                        const change24h = asset.price_change_24h || cryptoPrices[asset.coin_key]?.usd_24h_change || 0;
                        const balance = parseFloat(asset.balance || 0);
                        const value = balance * price;
                        const changeClass = change24h >= 0 ? 'text-deep-forest' : 'text-error';
                        const changeSign = change24h >= 0 ? '+' : '';

                        return `
                            <tr class="hover:bg-surface transition-colors cursor-pointer group" onclick="window.location.href='asset-detail.php?coin_key=${encodeURIComponent(asset.coin_key)}'">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center overflow-hidden shrink-0">
                                            ${asset.logo
                                                ? `<img src="${escapeHtml(asset.logo)}" alt="${escapeHtml(asset.symbol || '')}" class="w-6 h-6 object-contain" onerror="this.style.display='none';this.nextElementSibling.style.display='flex';">`
                                                : ''}
                                            <span class="text-xs font-bold text-primary ${asset.logo ? 'hidden' : 'flex'} items-center justify-center w-full h-full">${escapeHtml((asset.symbol || '?').charAt(0))}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-primary">${escapeHtml(asset.display_name || asset.symbol || 'Unknown')}</p>
                                            <p class="text-xs text-on-surface-variant">${escapeHtml(asset.symbol || '')}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6"><p class="font-medium">${balance.toFixed(8)} ${escapeHtml(asset.symbol || '')}</p></td>
                                <td class="px-8 py-6">
                                    <p class="font-medium">$${price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: price > 1000 ? 2 : 6 })}</p>
                                    <p class="text-xs ${changeClass}">${changeSign}${Math.abs(change24h).toFixed(2)}%</p>
                                </td>
                                <td class="px-8 py-6 text-right font-bold text-primary">$${value.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            </tr>
                        `;
                    }).join('')}
                </tbody>
            </table>
        </div>
        ${sortedAssets.length > 5 ? `
        <div class="p-6 bg-surface-container-low text-center border-t border-outline-variant/30">
            <a href="assets.php" class="font-label-md text-label-md text-secondary hover:text-primary transition-colors inline-flex items-center justify-center gap-2">
                View All ${sortedAssets.length} Assets
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>` : ''}
    `;
}

document.addEventListener('DOMContentLoaded', loadDashboardData);
</script>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
