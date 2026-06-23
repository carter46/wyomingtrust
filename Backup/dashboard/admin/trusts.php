<?php
require_once __DIR__ . '/../../api/helpers.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Trust Services Management';

// Include shared layout
require_once __DIR__ . '/includes/layout.php';

function renderTrustsContent() {
?>

<div class="mb-4 sm:mb-6 lg:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4">
    <h1 class="text-2xl sm:text-3xl font-bold text-navy-900 dark:text-white">Trust Services Management</h1>
    <button onclick="showCreateTrustModal()" class="bg-primary text-navy-900 px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg font-semibold text-sm sm:text-base hover:opacity-90 w-full sm:w-auto flex items-center gap-2">
        <span class="material-icons-outlined text-sm">add</span>
        <span>Add New Service</span>
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

async function loadTrusts() {
    try {
        const response = await fetch('../../api/admin/trusts.php');
        const data = await response.json();
        if (data.success && data.trusts) {
            allTrusts = data.trusts;
            renderTrusts(data.trusts);
        } else {
            document.getElementById('trustsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Failed to load trust services</div>';
        }
    } catch (error) {
        console.error('Error loading trusts:', error);
        document.getElementById('trustsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Error loading trust services</div>';
    }
}

function renderTrusts(trusts) {
    const container = document.getElementById('trustsContainer');
    if (!trusts || trusts.length === 0) {
        container.innerHTML = '<div class="text-center py-8 sm:py-10 text-slate-500 text-sm sm:text-base">No trust services found</div>';
        return;
    }
    const html = `
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-navy-700">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Service Name</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Key</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Price</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Status</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-navy-700">
                    ${trusts.map(trust => `
                        <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50">
                            <td class="px-4 sm:px-6 py-3 sm:py-4 font-semibold text-sm">${escapeHtml(trust.service_name)}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-slate-500">${escapeHtml(trust.service_key)}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">${trust.is_free ? '<span class="text-green-600 font-bold">FREE</span>' : '$' + parseFloat(trust.price || 0).toFixed(2)}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" ${trust.is_active ? 'checked' : ''} onchange="toggleTrustStatus(${trust.id}, this.checked)" class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </label>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-wrap gap-2">
                                    <button onclick="editTrust(${trust.id})" class="text-primary hover:underline text-xs sm:text-sm flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">edit</span>
                                        <span>Edit</span>
                                    </button>
                                    <button onclick="deleteTrust(${trust.id})" class="text-red-600 hover:underline text-xs sm:text-sm flex items-center gap-1">
                                        <span class="material-icons-outlined text-sm">delete</span>
                                        <span>Delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            ${trusts.map(trust => `
                <div class="bg-slate-50 dark:bg-navy-700/50 rounded-lg p-4 border border-slate-200 dark:border-slate-600">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-sm text-navy-900 dark:text-white truncate">${escapeHtml(trust.service_name)}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">${escapeHtml(trust.service_key)}</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 ml-2">
                            <input type="checkbox" ${trust.is_active ? 'checked' : ''} onchange="toggleTrustStatus(${trust.id}, this.checked)" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/30 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                    <div class="flex items-center justify-between text-xs sm:text-sm mb-3">
                        <span class="${trust.is_free ? 'text-green-600 font-bold' : 'text-slate-500 dark:text-slate-400'}">${trust.is_free ? 'FREE' : '$' + parseFloat(trust.price || 0).toFixed(2)}</span>
                    </div>
                    <div class="flex gap-2 pt-3 border-t border-slate-200 dark:border-slate-600">
                        <button onclick="editTrust(${trust.id})" class="text-primary hover:underline text-xs flex items-center gap-1">
                            <span class="material-icons-outlined text-xs">edit</span>
                            <span>Edit</span>
                        </button>
                        <button onclick="deleteTrust(${trust.id})" class="text-red-600 hover:underline text-xs flex items-center gap-1">
                            <span class="material-icons-outlined text-xs">delete</span>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
    container.innerHTML = html;
}

function showCreateTrustModal() {
    const formHtml = `
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Service Key *</label>
                <input type="text" name="service_key" required 
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary" 
                       placeholder="e.g., irrevocable_trust">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Unique identifier for this service (lowercase, underscores)</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Service Name *</label>
                <input type="text" name="service_name" required 
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary" 
                       placeholder="e.g., Irrevocable Trust Service">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary" 
                          placeholder="Brief description of this trust service"></textarea>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_free" id="createIsFree" onchange="toggleCreatePriceField()" 
                           class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                    <span class="text-sm font-semibold text-navy-900 dark:text-white">Mark as Free Service</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 ml-6">When checked, price will be set to $0.00</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Price</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                    <input type="number" name="price" id="createPriceInput" step="0.01" min="0" value="0.00" required
                           class="w-full pl-7 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary" 
                           placeholder="0.00">
                </div>
            </div>
        </div>
    `;
    
    showFormModal('Add New Trust Service', formHtml, function(data) {
        const serviceKey = (data.service_key || '').trim().toLowerCase().replace(/\s+/g, '_');
        const serviceName = (data.service_name || '').trim();
        const description = (data.description || '').trim();
        const isFree = data.is_free === true || data.is_free === 'on';
        const price = isFree ? 0 : parseFloat(data.price || 0);
        
        if (!serviceKey || !serviceName) {
            showToast('Service key and name are required', 'warning');
            return;
        }
        
        createTrust(serviceKey, serviceName, description, price, isFree);
    });
}

function toggleCreatePriceField() {
    const checkbox = document.getElementById('createIsFree');
    const priceInput = document.getElementById('createPriceInput');
    
    if (checkbox && priceInput) {
        if (checkbox.checked) {
            priceInput.value = '0.00';
            priceInput.disabled = true;
        } else {
            priceInput.disabled = false;
        }
    }
}

async function createTrust(key, name, desc, price, isFree) {
    try {
        const response = await fetch('../../api/admin/trusts.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ 
                service_key: key, 
                service_name: name, 
                description: desc, 
                price: price,
                is_free: isFree ? 1 : 0,
                is_active: 1
            })
        });
        const data = await response.json();
        if (data.success) {
            showToast('Trust service created successfully', 'success');
            loadTrusts();
        } else {
            showToast(data.message || 'Failed to create service', 'error');
        }
    } catch (error) {
        console.error('Error creating trust:', error);
        showToast('Error creating service', 'error');
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
    
    const formHtml = `
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Service Key</label>
                <input type="text" value="${escapeHtml(trust.service_key)}" disabled
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-100 dark:bg-navy-900 text-slate-600 dark:text-slate-400 cursor-not-allowed">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Service key cannot be changed</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Service Name *</label>
                <input type="text" name="service_name" value="${escapeHtml(trust.service_name)}" required 
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Description</label>
                <textarea name="description" rows="3" 
                          class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">${escapeHtml(trust.description || '')}</textarea>
            </div>
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_free" id="editIsFree" ${trust.is_free ? 'checked' : ''} onchange="toggleEditPriceField()" 
                           class="w-4 h-4 text-primary border-slate-300 rounded focus:ring-primary">
                    <span class="text-sm font-semibold text-navy-900 dark:text-white">Mark as Free Service</span>
                </label>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 ml-6">When checked, price will be set to $0.00</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Price</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-500">$</span>
                    <input type="number" name="price" id="editPriceInput" step="0.01" min="0" value="${trust.is_free ? '0.00' : parseFloat(trust.price || 0).toFixed(2)}" required
                           class="w-full pl-7 pr-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary" 
                           ${trust.is_free ? 'disabled' : ''}>
                </div>
            </div>
        </div>
    `;
    
    showFormModal('Edit Trust Service', formHtml, function(data) {
        const serviceName = (data.service_name || '').trim();
        const description = (data.description || '').trim();
        const isFree = data.is_free === true || data.is_free === 'on';
        const price = isFree ? 0 : parseFloat(data.price || 0);
        
        if (!serviceName) {
            showToast('Service name is required', 'warning');
            return;
        }
        
        updateTrust(id, serviceName, description, price, isFree);
    });
}

function toggleEditPriceField() {
    const checkbox = document.getElementById('editIsFree');
    const priceInput = document.getElementById('editPriceInput');
    
    if (checkbox && priceInput) {
        if (checkbox.checked) {
            priceInput.value = '0.00';
            priceInput.disabled = true;
        } else {
            priceInput.disabled = false;
        }
    }
}

async function updateTrust(id, name, desc, price, isFree) {
    try {
        const response = await fetch('../../api/admin/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ 
                id: parseInt(id),
                service_name: name,
                description: desc,
                price: price,
                is_free: isFree ? 1 : 0
            })
        });
        const data = await response.json();
        if (data.success) {
            showToast('Trust service updated successfully', 'success');
            loadTrusts();
        } else {
            showToast(data.message || 'Failed to update service', 'error');
        }
    } catch (error) {
        console.error('Error updating trust:', error);
        showToast('Error updating service', 'error');
    }
}

async function deleteTrust(id) {
    const trust = allTrusts.find(t => t.id == id);
    if (!trust) {
        showToast('Trust service not found', 'error');
        return;
    }
    
    showConfirmModal(
        'Delete Trust Service',
        `Are you sure you want to delete "${escapeHtml(trust.service_name)}"? This action cannot be undone.`,
        async function() {
            try {
                const response = await fetch(`../../api/admin/trusts.php?id=${id}`, { method: 'DELETE' });
                const data = await response.json();
                if (data.success) {
                    showToast('Service deleted successfully', 'success');
                    loadTrusts();
                } else {
                    showToast(data.message || 'Failed to delete', 'error');
                }
            } catch (error) {
                console.error('Error deleting trust:', error);
                showToast('Error deleting service', 'error');
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

// Load trusts on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadTrusts);
} else {
    loadTrusts();
}
</script>

<?php
}

// Render the layout with trusts content
renderAdminLayout($page_title, 'trusts', 'renderTrustsContent');
?>
