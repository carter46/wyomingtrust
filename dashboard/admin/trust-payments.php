<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Trust Payment Approvals';

// Include shared layout
require_once __DIR__ . '/includes/layout.php';

function renderTrustPaymentsContent() {
?>

<div class="mb-4 sm:mb-6 lg:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-navy-900 dark:text-white">Trust Payment Approvals</h1>
    <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base mt-2">Review and approve/reject pending trust service payments</p>
</div>

<div id="messageContainer" class="mb-3 sm:mb-4"></div>

<div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
    <div id="paymentsContainer" class="p-4 sm:p-6">
        <div class="text-center py-8 sm:py-10 text-slate-500 text-sm sm:text-base">Loading pending payments...</div>
    </div>
</div>

<script src="includes/modal.js"></script>
<script>
let allPayments = [];

async function loadPayments() {
    try {
        const response = await fetch('../../api/admin/trust-payments.php');
        const data = await response.json();
        
        if (data.success && data.payments) {
            allPayments = data.payments;
            renderPayments(data.payments);
        } else {
            document.getElementById('paymentsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Failed to load payments</div>';
        }
    } catch (error) {
        console.error('Error loading payments:', error);
        document.getElementById('paymentsContainer').innerHTML = '<div class="text-center py-10 text-red-500">Error loading payments</div>';
    }
}

function renderPayments(payments) {
    const container = document.getElementById('paymentsContainer');
    if (!payments || payments.length === 0) {
        container.innerHTML = '<div class="text-center py-8 sm:py-10 text-slate-500 text-sm sm:text-base">No pending payments</div>';
        return;
    }
    
    const html = `
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-navy-700">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Trust ID</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">User</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Service</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Amount</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Payment Method</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Created</th>
                        <th class="px-4 sm:px-6 py-3 text-xs font-bold uppercase text-slate-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-navy-700">
                    ${payments.map(payment => `
                        <tr class="hover:bg-slate-50 dark:hover:bg-navy-700/50">
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-mono">#${payment.id}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-navy-900 dark:text-white">${escapeHtml(payment.user_name || 'N/A')}</div>
                                    <div class="text-xs text-slate-500 dark:text-slate-400">${escapeHtml(payment.user_email || '')}</div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">${escapeHtml(payment.service_name || 'N/A')}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm font-semibold">$${parseFloat(payment.price || 0).toFixed(2)}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-sm">${escapeHtml(payment.payment_method_name || 'N/A')}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 text-xs sm:text-sm text-slate-500">${new Date(payment.created_at).toLocaleDateString()}</td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex flex-wrap gap-2">
                                    <button onclick="viewDetails(${payment.id})" class="text-blue-600 dark:text-blue-400 hover:underline text-xs sm:text-sm">View</button>
                                    <button onclick="approvePayment(${payment.id})" class="text-green-600 dark:text-green-400 hover:underline text-xs sm:text-sm font-semibold">Approve</button>
                                    <button onclick="rejectPayment(${payment.id})" class="text-red-600 dark:text-red-400 hover:underline text-xs sm:text-sm">Reject</button>
                                </div>
                            </td>
                        </tr>
                    `).join('')}
                </tbody>
            </table>
        </div>
        <!-- Mobile Card View -->
        <div class="md:hidden space-y-4">
            ${payments.map(payment => `
                <div class="bg-slate-50 dark:bg-navy-700/50 rounded-lg p-4 border border-slate-200 dark:border-slate-600">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-sm text-navy-900 dark:text-white">Trust #${payment.id}</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-1">${escapeHtml(payment.user_name || 'N/A')} (${escapeHtml(payment.user_email || '')})</p>
                        </div>
                        <span class="px-2 py-1 rounded text-xs bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400">Pending</span>
                    </div>
                    <div class="space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Service:</span>
                            <span class="font-medium text-navy-900 dark:text-white">${escapeHtml(payment.service_name || 'N/A')}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Amount:</span>
                            <span class="font-semibold text-navy-900 dark:text-white">$${parseFloat(payment.price || 0).toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Payment:</span>
                            <span class="text-navy-900 dark:text-white">${escapeHtml(payment.payment_method_name || 'N/A')}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500 dark:text-slate-400">Created:</span>
                            <span class="text-navy-900 dark:text-white">${new Date(payment.created_at).toLocaleDateString()}</span>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <button onclick="viewDetails(${payment.id})" class="flex-1 px-3 py-2 text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-lg hover:opacity-90">View</button>
                        <button onclick="approvePayment(${payment.id})" class="flex-1 px-3 py-2 text-xs font-semibold bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg hover:opacity-90">Approve</button>
                        <button onclick="rejectPayment(${payment.id})" class="flex-1 px-3 py-2 text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400 rounded-lg hover:opacity-90">Reject</button>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
    
    container.innerHTML = html;
}

function viewDetails(trustId) {
    const payment = allPayments.find(p => p.id == trustId);
    if (!payment) {
        showToast('Payment not found', 'error');
        return;
    }
    
    const trustData = payment.trust_data || {};
    const personalInfo = trustData.personal_info || {};
    const beneficiaries = trustData.beneficiaries || [];
    const paymentInfo = trustData.payment_info || {};
    
    const detailsHtml = `
        <div class="space-y-4">
            <div>
                <h4 class="font-bold text-sm text-navy-900 dark:text-white mb-2">Trust Information</h4>
                <div class="space-y-1 text-sm">
                    <div><span class="text-slate-500 dark:text-slate-400">Trust ID:</span> <span class="font-mono">#${payment.id}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Service:</span> ${escapeHtml(payment.service_name || 'N/A')}</div>
                    <div><span class="text-slate-500 dark:text-slate-400">Amount:</span> <span class="font-semibold">$${parseFloat(payment.price || 0).toFixed(2)}</span></div>
                    <div><span class="text-slate-500 dark:text-slate-400">Payment Method:</span> ${escapeHtml(payment.payment_method_name || 'N/A')}</div>
                    <div><span class="text-slate-500 dark:text-slate-400">Status:</span> <span class="px-2 py-0.5 rounded text-xs bg-amber-100 text-amber-700 dark:bg-amber-900/20 dark:text-amber-400">Pending</span></div>
                </div>
            </div>
            
            <div>
                <h4 class="font-bold text-sm text-navy-900 dark:text-white mb-2">User Information</h4>
                <div class="space-y-1 text-sm">
                    <div><span class="text-slate-500 dark:text-slate-400">Name:</span> ${escapeHtml(payment.user_name || 'N/A')}</div>
                    <div><span class="text-slate-500 dark:text-slate-400">Email:</span> ${escapeHtml(payment.user_email || 'N/A')}</div>
                </div>
            </div>
            
            ${personalInfo.full_name ? `
            <div>
                <h4 class="font-bold text-sm text-navy-900 dark:text-white mb-2">Personal Information</h4>
                <div class="space-y-1 text-sm">
                    <div><span class="text-slate-500 dark:text-slate-400">Full Name:</span> ${escapeHtml(personalInfo.full_name || 'N/A')}</div>
                    ${personalInfo.email ? `<div><span class="text-slate-500 dark:text-slate-400">Email:</span> ${escapeHtml(personalInfo.email)}</div>` : ''}
                    ${personalInfo.street ? `<div><span class="text-slate-500 dark:text-slate-400">Address:</span> ${escapeHtml(personalInfo.street || '')} ${escapeHtml(personalInfo.city || '')}, ${escapeHtml(personalInfo.state || '')} ${escapeHtml(personalInfo.zip || '')}</div>` : ''}
                </div>
            </div>
            ` : ''}
            
            ${beneficiaries.length > 0 ? `
            <div>
                <h4 class="font-bold text-sm text-navy-900 dark:text-white mb-2">Beneficiaries (${beneficiaries.length})</h4>
                <div class="space-y-2 text-sm">
                    ${beneficiaries.map((ben, idx) => `
                        <div class="p-2 bg-slate-50 dark:bg-navy-700/50 rounded">
                            <div class="font-medium">${escapeHtml(ben.name || 'N/A')}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">${escapeHtml(ben.relationship || 'N/A')} - ${parseFloat(ben.allocation || 0).toFixed(1)}%</div>
                        </div>
                    `).join('')}
                </div>
            </div>
            ` : ''}
            
            ${paymentInfo.amount ? `
            <div>
                <h4 class="font-bold text-sm text-navy-900 dark:text-white mb-2">Payment Details</h4>
                <div class="space-y-1 text-sm">
                    <div><span class="text-slate-500 dark:text-slate-400">Amount:</span> $${parseFloat(paymentInfo.amount || 0).toFixed(2)}</div>
                    <div><span class="text-slate-500 dark:text-slate-400">Confirmed:</span> ${paymentInfo.user_confirmed ? 'Yes' : 'No'}</div>
                    ${paymentInfo.confirmed_at ? `<div><span class="text-slate-500 dark:text-slate-400">Confirmed At:</span> ${new Date(paymentInfo.confirmed_at).toLocaleString()}</div>` : ''}
                </div>
            </div>
            ` : ''}
        </div>
    `;
    
    showModal('Trust Payment Details', detailsHtml, [
        { label: 'Close', onclick: 'closeModal()', class: 'bg-slate-200 dark:bg-slate-700 text-slate-900 dark:text-white' }
    ]);
}

function approvePayment(trustId) {
    const payment = allPayments.find(p => p.id == trustId);
    if (!payment) {
        showToast('Payment not found', 'error');
        return;
    }
    
    showConfirmModal(
        'Approve Payment',
        `Are you sure you want to approve this payment?\n\nTrust ID: #${payment.id}\nUser: ${escapeHtml(payment.user_name || 'N/A')}\nAmount: $${parseFloat(payment.price || 0).toFixed(2)}\n\nThis will activate the trust.`,
        async function() {
            try {
                // Get CSRF token
                const csrfResponse = await fetch('../../api/admin/session.php');
                const csrfData = await csrfResponse.json();
                const csrfToken = csrfData.csrf_token;
                
                const response = await fetch('../../api/admin/trust-payments.php', {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        trust_id: trustId,
                        action: 'approve',
                        csrf_token: csrfToken
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Payment approved successfully. Trust is now active.', 'success');
                    loadPayments();
                } else {
                    showToast(data.message || 'Failed to approve payment', 'error');
                }
            } catch (error) {
                console.error('Error approving payment:', error);
                showToast('Error approving payment', 'error');
            }
        }
    );
}

function rejectPayment(trustId) {
    const payment = allPayments.find(p => p.id == trustId);
    if (!payment) {
        showToast('Payment not found', 'error');
        return;
    }
    
    showConfirmModal(
        'Reject Payment',
        `Are you sure you want to reject this payment?\n\nTrust ID: #${payment.id}\nUser: ${escapeHtml(payment.user_name || 'N/A')}\nAmount: $${parseFloat(payment.price || 0).toFixed(2)}\n\nThe trust will remain pending.`,
        async function() {
            try {
                // Get CSRF token
                const csrfResponse = await fetch('../../api/admin/session.php');
                const csrfData = await csrfResponse.json();
                const csrfToken = csrfData.csrf_token;
                
                const response = await fetch('../../api/admin/trust-payments.php', {
                    method: 'PATCH',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        trust_id: trustId,
                        action: 'reject',
                        csrf_token: csrfToken
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Payment rejected. Trust is now inactive.', 'success');
                    loadPayments();
                } else {
                    showToast(data.message || 'Failed to reject payment', 'error');
                }
            } catch (error) {
                console.error('Error rejecting payment:', error);
                showToast('Error rejecting payment', 'error');
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

// Load payments on page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadPayments);
} else {
    loadPayments();
}
</script>

<?php
}

// Render the layout with payments content
renderAdminLayout($page_title, 'trust-payments', 'renderTrustPaymentsContent');
?>
