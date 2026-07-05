<?php
require_once __DIR__ . '/../../api/helpers.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Trust Services Management';

require_once __DIR__ . '/includes/layout.php';

function renderTrustsContent() {
?>

<div class="mb-4 sm:mb-6 lg:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-navy-900 dark:text-white">Trust Services</h1>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Configure the four trust types users can select during onboarding.</p>
    </div>
    <button id="addTrustBtn" onclick="showCreateTrustModal()" class="bg-primary text-navy-900 px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg font-semibold text-sm sm:text-base hover:opacity-90 w-full sm:w-auto flex items-center gap-2">
        <span class="material-icons-outlined text-sm">add</span>
        <span>Add Trust Type</span>
    </button>
</div>

<div id="messageContainer" class="mb-3 sm:mb-4"></div>
<div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
    <div id="trustsContainer" class="p-4 sm:p-6">
        <div class="text-center py-8 sm:py-10 text-slate-500 text-sm sm:text-base">Loading trust services...</div>
    </div>
</div>

<script src="includes/modal.js"></script>
<script>
let allTrusts = [];
let trustTypeOptions = {};
let suggestedAssetTypes = [];

async function loadTrusts() {
    try {
        const response = await fetch('../../api/admin/trusts.php');
        const data = await response.json();
        if (data.success && data.trusts) {
            allTrusts = data.trusts;
            trustTypeOptions = data.trust_type_options || {};
            suggestedAssetTypes = data.suggested_asset_types || [];
            renderTrusts(data.trusts);
            updateAddButton();
        } else {
            document.getElementById('trustsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Failed to load trust services</div>';
        }
    } catch (error) {
        console.error('Error loading trusts:', error);
        document.getElementById('trustsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Error loading trust services</div>';
    }
}

function updateAddButton() {
    const btn = document.getElementById('addTrustBtn');
    if (!btn) return;
    const configured = new Set(allTrusts.map(t => t.service_key));
    const available = Object.keys(trustTypeOptions).filter(k => !configured.has(k));
    btn.disabled = available.length === 0;
    btn.classList.toggle('opacity-50', available.length === 0);
    btn.classList.toggle('cursor-not-allowed', available.length === 0);
}

function renderTrusts(trusts) {
    const container = document.getElementById('trustsContainer');
    if (!trusts || trusts.length === 0) {
        container.innerHTML = '<div class="text-center py-8 sm:py-10 text-slate-500 text-sm sm:text-base">No trust types configured yet. Click <strong>Add Trust Type</strong> to get started.</div>';
        return;
    }

    const html = `
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-navy-700">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Trust Type</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Display Name</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Asset Types</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Price</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Status</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-navy-700">
                    ${trusts.map(trust => renderTrustRow(trust)).join('')}
                </tbody>
            </table>
        </div>
        <div class="md:hidden space-y-4">
            ${trusts.map(trust => renderTrustCard(trust)).join('')}
        </div>
    `;
    container.innerHTML = html;
}

function renderAssetTypesSummary(trust) {
    if (trust.is_crypto) {
        return '<span class="text-xs text-slate-500">User deposits crypto</span>';
    }
    const count = Array.isArray(trust.asset_types) ? trust.asset_types.length : 0;
    if (count === 0) {
        return '<span class="text-xs text-amber-600">None configured</span>';
    }
    const preview = trust.asset_types.slice(0, 3).map(escapeHtml).join(', ');
    const more = count > 3 ? ` +${count - 3} more` : '';
    return `<span class="text-xs text-slate-600 dark:text-slate-300">${preview}${more}</span>`;
}

function renderTrustRow(trust) {
    return `
        <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50">
            <td class="px-4 sm:px-6 py-3 sm:py-4">
                <p class="font-semibold text-sm">${escapeHtml(trust.trust_type_label || trust.service_name)}</p>
                <p class="text-xs text-slate-500 mt-0.5">${escapeHtml(trust.service_key)}</p>
            </td>
            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">${escapeHtml(trust.service_name)}</td>
            <td class="px-4 sm:px-6 py-3 sm:py-4">${renderAssetTypesSummary(trust)}</td>
            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">${trust.is_free ? '<span class="text-green-600 font-bold">FREE</span>' : '$' + parseFloat(trust.price || 0).toFixed(2)}</td>
            <td class="px-4 sm:px-6 py-3 sm:py-4">${renderStatusToggle(trust)}</td>
            <td class="px-4 sm:px-6 py-3 sm:py-4">${renderActions(trust)}</td>
        </tr>
    `;
}

function renderTrustCard(trust) {
    return `
        <div class="bg-slate-50 dark:bg-navy-700/50 rounded-lg p-4 border border-slate-200 dark:border-slate-600">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0">
                    <h3 class="font-bold text-sm text-navy-900 dark:text-white">${escapeHtml(trust.trust_type_label || trust.service_name)}</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${escapeHtml(trust.service_name)}</p>
                </div>
                ${renderStatusToggle(trust)}
            </div>
            <div class="text-xs text-slate-500 mb-2">${renderAssetTypesSummary(trust)}</div>
            <div class="flex items-center justify-between text-xs sm:text-sm mb-3">
                <span class="${trust.is_free ? 'text-green-600 font-bold' : 'text-slate-500 dark:text-slate-400'}">${trust.is_free ? 'FREE' : '$' + parseFloat(trust.price || 0).toFixed(2)}</span>
            </div>
            <div class="flex gap-2 pt-3 border-t border-slate-200 dark:border-slate-600">${renderActions(trust, true)}</div>
        </div>
    `;
}

function renderStatusToggle(trust) {
    return `
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" ${trust.is_active ? 'checked' : ''} onchange="toggleTrustStatus(${trust.id}, this.checked)" class="sr-only peer">
            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
        </label>
    `;
}

function renderActions(trust, mobile = false) {
    const size = mobile ? 'text-xs' : 'text-xs sm:text-sm';
    return `
        <button onclick="editTrust(${trust.id})" class="text-primary hover:underline ${size} flex items-center gap-1">
            <span class="material-icons-outlined ${mobile ? 'text-xs' : 'text-sm'}">edit</span>
            <span>Edit</span>
        </button>
        <button onclick="deleteTrust(${trust.id})" class="text-red-600 hover:underline ${size} flex items-center gap-1">
            <span class="material-icons-outlined ${mobile ? 'text-xs' : 'text-sm'}">delete</span>
            <span>Delete</span>
        </button>
    `;
}

function getAvailableTrustTypes(excludeKey = null) {
    const configured = new Set(allTrusts.map(t => t.service_key).filter(k => k !== excludeKey));
    return Object.entries(trustTypeOptions).filter(([key]) => !configured.has(key));
}

function buildTrustTypeSelect(selectedKey = '', disabled = false) {
    const available = getAvailableTrustTypes(selectedKey);
    const options = available.map(([key, label]) =>
        `<option value="${escapeHtml(key)}" ${key === selectedKey ? 'selected' : ''}>${escapeHtml(label)}</option>`
    ).join('');
    return `
        <select name="trust_type" id="trustTypeSelect" required ${disabled ? 'disabled' : ''} onchange="onTrustTypeChange()"
                class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
            <option value="">Select trust type...</option>
            ${options}
        </select>
    `;
}

function buildAssetTypesSection(assetTypes = [], isCrypto = false) {
    const hiddenClass = isCrypto ? 'hidden' : '';
    const rows = (assetTypes.length ? assetTypes : ['']).map((name, i) => `
        <div class="flex items-center gap-2 asset-type-row">
            <input type="text" name="asset_types[]" value="${escapeHtml(name)}"
                   class="flex-1 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-sm"
                   placeholder="e.g. Real Estate, Bank Accounts, Stocks">
            <button type="button" onclick="removeAssetTypeRow(this)" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg" title="Remove">
                <span class="material-icons-outlined text-sm">close</span>
            </button>
        </div>
    `).join('');

    return `
        <div id="assetTypesSection" class="${hiddenClass} border-t border-slate-200 dark:border-slate-700 pt-4 mt-2">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <label class="block text-sm font-semibold text-navy-900 dark:text-white">Asset Types</label>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Add the asset categories users can include in this trust.</p>
                </div>
                <button type="button" onclick="addSuggestedAssetTypes()" class="text-xs text-primary hover:underline whitespace-nowrap">Add suggested types</button>
            </div>
            <div id="assetTypesList" class="space-y-2 max-h-48 overflow-y-auto">${rows}</div>
            <button type="button" onclick="addAssetTypeRow()" class="mt-3 text-sm text-primary font-semibold flex items-center gap-1 hover:underline">
                <span class="material-icons-outlined text-sm">add</span> Add asset type
            </button>
        </div>
    `;
}

function onTrustTypeChange() {
    const select = document.getElementById('trustTypeSelect');
    const nameInput = document.getElementById('serviceNameInput');
    const section = document.getElementById('assetTypesSection');
    if (!select) return;

    const key = select.value;
    const isCrypto = key === 'crypto_asset_trust';

    if (nameInput && key && trustTypeOptions[key] && !nameInput.dataset.userEdited) {
        nameInput.value = trustTypeOptions[key];
    }

    if (section) {
        section.classList.toggle('hidden', isCrypto);
    }
}

function addAssetTypeRow(value = '') {
    const list = document.getElementById('assetTypesList');
    if (!list) return;
    const row = document.createElement('div');
    row.className = 'flex items-center gap-2 asset-type-row';
    row.innerHTML = `
        <input type="text" name="asset_types[]" value="${escapeHtml(value)}"
               class="flex-1 px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-sm"
               placeholder="e.g. Real Estate, Bank Accounts, Stocks">
        <button type="button" onclick="removeAssetTypeRow(this)" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg" title="Remove">
            <span class="material-icons-outlined text-sm">close</span>
        </button>
    `;
    list.appendChild(row);
    row.querySelector('input')?.focus();
}

function removeAssetTypeRow(btn) {
    const list = document.getElementById('assetTypesList');
    const row = btn.closest('.asset-type-row');
    if (!list || !row) return;
    if (list.querySelectorAll('.asset-type-row').length <= 1) {
        row.querySelector('input').value = '';
        return;
    }
    row.remove();
}

function addSuggestedAssetTypes() {
    const list = document.getElementById('assetTypesList');
    if (!list) return;
    const existing = new Set(Array.from(list.querySelectorAll('input[name="asset_types[]"]')).map(i => i.value.trim().toLowerCase()).filter(Boolean));
    suggestedAssetTypes.forEach(name => {
        if (!existing.has(name.toLowerCase())) {
            addAssetTypeRow(name);
            existing.add(name.toLowerCase());
        }
    });
}

function buildPricingFields(isFree = false, price = '0.00') {
    return `
        <div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_free" id="modalIsFree" ${isFree ? 'checked' : ''} onchange="toggleModalPriceField()"
                       class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                <span class="text-sm font-semibold text-navy-900 dark:text-white">Mark as Free Service</span>
            </label>
        </div>
        <div>
            <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Price</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                <input type="number" name="price" id="modalPriceInput" step="0.01" min="0" value="${isFree ? '0.00' : price}" required
                       class="w-full pl-7 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary"
                       ${isFree ? 'disabled' : ''}>
            </div>
        </div>
    `;
}

function toggleModalPriceField() {
    const checkbox = document.getElementById('modalIsFree');
    const priceInput = document.getElementById('modalPriceInput');
    if (checkbox && priceInput) {
        if (checkbox.checked) {
            priceInput.value = '0.00';
            priceInput.disabled = true;
        } else {
            priceInput.disabled = false;
        }
    }
}

function showCreateTrustModal() {
    const available = getAvailableTrustTypes();
    if (available.length === 0) {
        showToast('All four trust types are already configured', 'warning');
        return;
    }

    const formHtml = `
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Trust Type *</label>
                ${buildTrustTypeSelect()}
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Choose one of the four predefined trust types.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Display Name *</label>
                <input type="text" name="service_name" id="serviceNameInput" required
                       oninput="this.dataset.userEdited='1'"
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary"
                       placeholder="Shown to users during onboarding">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary"
                          placeholder="Brief description shown on onboarding and marketing pages"></textarea>
            </div>
            ${buildPricingFields()}
            ${buildAssetTypesSection([], false)}
        </div>
    `;

    showFormModal('Add Trust Type', formHtml, function(data) {
        const trustType = (data.trust_type || '').trim();
        const serviceName = (data.service_name || '').trim();
        const description = (data.description || '').trim();
        const isFree = data.is_free === true || data.is_free === 'on';
        const price = isFree ? 0 : parseFloat(data.price || 0);
        const assetTypes = Array.isArray(data.asset_types) ? data.asset_types : [];

        if (!trustType || !serviceName) {
            showToast('Trust type and display name are required', 'warning');
            return;
        }

        createTrust({ trust_type: trustType, service_name: serviceName, description, price, is_free: isFree ? 1 : 0, asset_types: assetTypes });
    });

    setTimeout(onTrustTypeChange, 50);
}

async function createTrust(payload) {
    try {
        const response = await fetch('../../api/admin/trusts.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ ...payload, is_active: 1 })
        });
        const data = await response.json();
        if (data.success) {
            showToast('Trust type configured successfully', 'success');
            loadTrusts();
        } else {
            showToast(data.message || 'Failed to create trust type', 'error');
        }
    } catch (error) {
        console.error('Error creating trust:', error);
        showToast('Error creating trust type', 'error');
    }
}

async function toggleTrustStatus(id, isActive) {
    try {
        const response = await fetch('../../api/admin/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id, is_active: isActive ? 1 : 0 })
        });
        const data = await response.json();
        if (!data.success) {
            showToast(data.message || 'Failed to update status', 'error');
            loadTrusts();
        } else {
            showToast(`Service ${isActive ? 'activated' : 'deactivated'} successfully`, 'success');
        }
    } catch (error) {
        console.error('Error updating status:', error);
        showToast('Error updating status', 'error');
        loadTrusts();
    }
}

function editTrust(id) {
    const trust = allTrusts.find(t => t.id == id);
    if (!trust) {
        showToast('Trust service not found', 'error');
        return;
    }

    const assetTypes = Array.isArray(trust.asset_types) ? trust.asset_types : [];
    const formHtml = `
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Trust Type</label>
                <input type="text" value="${escapeHtml(trust.trust_type_label || trust.service_name)}" disabled
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-100 dark:bg-navy-900 text-slate-600 dark:text-slate-400 cursor-not-allowed">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Trust type cannot be changed after creation.</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Display Name *</label>
                <input type="text" name="service_name" value="${escapeHtml(trust.service_name)}" required
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Description</label>
                <textarea name="description" rows="3"
                          class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">${escapeHtml(trust.description || '')}</textarea>
            </div>
            ${buildPricingFields(!!trust.is_free, trust.is_free ? '0.00' : parseFloat(trust.price || 0).toFixed(2))}
            ${buildAssetTypesSection(assetTypes, !!trust.is_crypto)}
        </div>
    `;

    showFormModal('Edit Trust Type', formHtml, function(data) {
        const serviceName = (data.service_name || '').trim();
        const description = (data.description || '').trim();
        const isFree = data.is_free === true || data.is_free === 'on';
        const price = isFree ? 0 : parseFloat(data.price || 0);
        const payload = {
            id: parseInt(id, 10),
            service_name: serviceName,
            description,
            price,
            is_free: isFree ? 1 : 0,
        };
        if (!trust.is_crypto) {
            payload.asset_types = Array.isArray(data.asset_types) ? data.asset_types : [];
        }
        updateTrust(payload);
    });
}

async function updateTrust(payload) {
    try {
        const response = await fetch('../../api/admin/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        });
        const data = await response.json();
        if (data.success) {
            showToast('Trust type updated successfully', 'success');
            loadTrusts();
        } else {
            showToast(data.message || 'Failed to update trust type', 'error');
        }
    } catch (error) {
        console.error('Error updating trust:', error);
        showToast('Error updating trust type', 'error');
    }
}

async function deleteTrust(id) {
    const trust = allTrusts.find(t => t.id == id);
    if (!trust) {
        showToast('Trust service not found', 'error');
        return;
    }

    showConfirmModal(
        'Delete Trust Type',
        `Are you sure you want to delete "${escapeHtml(trust.trust_type_label || trust.service_name)}"? This action cannot be undone.`,
        async function() {
            try {
                const response = await fetch(`../../api/admin/trusts.php?id=${id}`, { method: 'DELETE' });
                const data = await response.json();
                if (data.success) {
                    showToast('Trust type deleted successfully', 'success');
                    loadTrusts();
                } else {
                    showToast(data.message || 'Failed to delete', 'error');
                }
            } catch (error) {
                console.error('Error deleting trust:', error);
                showToast('Error deleting trust type', 'error');
            }
        }
    );
}

function escapeHtml(text) {
    if (typeof text !== 'string') return text;
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadTrusts);
} else {
    loadTrusts();
}
</script>

<?php
}

renderAdminLayout($page_title, 'trusts', 'renderTrustsContent');
?>
