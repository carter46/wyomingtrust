<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$userName = $_SESSION['user_name'] ?? 'User';
$page_title = 'Dashboard | ' . ($userName !== 'User' ? $userName : 'WyomingTrust');
$active_nav = 'dashboard';

include __DIR__ . '/includes/layout.php';
?>

<!-- Welcome -->
<section>
<h1 class="font-headline-lg text-headline-lg text-primary mb-2">Welcome Back, <span id="userName"><?php echo escape_html($userName); ?></span>.</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">Manage your trusts, beneficiaries, and estate planning from one secure dashboard.</p>
</section>

<!-- Key Metrics (3 cards) -->
<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="metric-card-gradient p-8 rounded-2xl card-hover flex flex-col justify-between min-h-[10rem] text-on-primary shadow-lg">
<span class="text-sm md:text-base uppercase tracking-widest text-on-primary/70 font-bold">Active Trusts</span>
<div>
<p class="metric-stat-value font-headline-lg text-on-primary" id="trustCount">0</p>
<p class="text-base md:text-lg text-on-primary/80 mt-2 font-medium">Securely Managed</p>
</div>
</div>
<div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant card-hover flex flex-col justify-between min-h-[10rem]">
<span class="text-sm md:text-base uppercase tracking-widest text-on-surface-variant font-bold">Beneficiaries</span>
<div>
<p class="metric-stat-value font-headline-lg text-primary" id="beneficiaryCount">0</p>
<p class="text-base md:text-lg text-on-surface-variant mt-2 font-medium">Assigned protections</p>
</div>
</div>
<div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant card-hover flex flex-col justify-between min-h-[10rem]">
<span class="text-sm md:text-base uppercase tracking-widest text-on-surface-variant font-bold">Last Updated</span>
<div>
<p class="metric-stat-value font-headline-lg text-primary" id="lastUpdated">—</p>
<div class="flex items-center gap-2 text-deep-forest mt-2">
<span class="w-2.5 h-2.5 rounded-full bg-deep-forest animate-pulse"></span>
<p class="text-base md:text-lg font-medium">System Sync</p>
</div>
</div>
</div>
</section>

<!-- Create Trust Banner (full width) -->
<section>
<div class="relative overflow-hidden bg-warm-cream p-8 md:p-12 rounded-2xl border border-outline-variant group">
<div class="relative z-10 max-w-2xl">
<h3 class="font-headline-md text-headline-md md:text-[28px] text-primary mb-3">Create Another Trust?</h3>
<p class="font-body-md md:text-lg text-on-surface-variant mb-8">Expand your estate planning with new asset protections and customized legal frameworks.</p>
<button type="button" onclick="window.location.href='../../onboarding/onboarding.php'" class="inline-flex items-center gap-2 px-8 py-4 border-2 border-primary text-primary hover:bg-primary hover:text-on-primary rounded-lg font-bold text-base transition-all">
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
<section class="pb-20">
<div class="flex items-center justify-between mb-6">
<h2 class="font-headline-md text-headline-md text-primary">My Trusts</h2>
<a class="font-label-md text-label-md text-secondary hover:underline underline-offset-4" href="manage-trust.php">View All</a>
</div>
<div id="trustsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="col-span-full text-center py-10 text-on-surface-variant">Loading trusts...</div>
</div>
</section>

<script>
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

        updateLastSynced();
    } catch (error) {
        console.error('Error loading dashboard data:', error);
        showTrustsError('Error loading dashboard data. Please refresh the page.');
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

document.addEventListener('DOMContentLoaded', loadDashboardData);
</script>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
