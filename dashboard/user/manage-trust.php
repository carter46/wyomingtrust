<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$trustId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$userName = $_SESSION['user_name'] ?? 'User';

if ($trustId <= 0) {
    $page_title = 'My Trusts | WyomingTrust';
    $active_nav = 'trusts';
    include __DIR__ . '/includes/layout.php';
    ?>

<section class="flex flex-wrap justify-between items-end gap-4">
<div>
<h1 class="font-headline-lg text-headline-lg text-primary mb-2">My Trusts</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">View and manage your trusts.</p>
</div>
<a href="../../onboarding/onboarding.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-primary text-on-primary font-bold hover:bg-primary/90 h-10 transition-colors">
<?php echo wt_icon('add', 'text-sm'); ?>
Create New Trust
</a>
</section>

<section>
<div id="trustsList" class="space-y-4">
<div class="text-center py-10 text-on-surface-variant">Loading trusts...</div>
</div>
</section>

<?php include __DIR__ . '/includes/modal.php'; ?>

<script>
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text ?? '';
    return div.innerHTML;
}

async function loadTrusts() {
    try {
        const res = await fetch('../../api/user/trusts.php');
        const data = await res.json();
        const container = document.getElementById('trustsList');
        if (!data.success || !data.trusts) {
            container.innerHTML = '<div class="text-center py-10 text-error">Failed to load trusts</div>';
            return;
        }
        if (data.trusts.length === 0) {
            container.innerHTML = '<div class="text-center py-10 text-on-surface-variant">No trusts yet. <a class="text-secondary font-semibold hover:underline" href="../../onboarding/onboarding.php">Create your first trust</a></div>';
            return;
        }
        container.innerHTML = data.trusts.map(t => {
            const trustName = t.trust_name || t.service_name || 'Untitled Trust';
            const serviceName = t.service_name || 'Trust';
            const status = (t.status || 'pending').toString();
            const createdAt = t.created_at ? new Date(t.created_at).toLocaleDateString() : '';
            const bens = Array.isArray(t.beneficiaries) ? t.beneficiaries.length :
                        (Array.isArray(t.trust_data?.beneficiaries) ? t.trust_data.beneficiaries.length : 0);
            const showServiceBadge = t.trust_name && t.trust_name !== serviceName;
            return `
                <div class="p-5 bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-xl font-black text-primary">${escapeHtml(trustName)}</p>
                                ${showServiceBadge ? `<span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-secondary/10 text-secondary">${escapeHtml(serviceName)}</span>` : ''}
                            </div>
                            <p class="text-xs text-on-surface-variant mt-1">Status: <strong>${escapeHtml(status)}</strong> · Beneficiaries: <strong>${bens}</strong> · Created: ${escapeHtml(createdAt)}</p>
                        </div>
                        <div class="flex gap-2">
                            <a href="manage-trust.php?id=${t.id}" class="px-4 py-2 rounded-lg bg-primary text-on-primary font-bold hover:bg-primary/90 h-10 flex items-center">Edit</a>
                            <button onclick="deleteTrust(${t.id})" class="px-4 py-2 rounded-lg bg-error text-on-primary font-bold hover:bg-error/90 h-10 flex items-center">Delete</button>
                        </div>
                    </div>
                </div>
            `;
        }).join('');
    } catch (e) {
        console.error(e);
        document.getElementById('trustsList').innerHTML = '<div class="text-center py-10 text-error">Error loading trusts</div>';
    }
}

async function deleteTrust(trustId) {
    try {
        const confirmed = await showConfirmModal(
            'Delete Trust',
            'Are you sure you want to permanently delete this trust? This action cannot be undone and all trust data will be permanently removed.',
            'Delete Trust',
            'Cancel',
            'danger'
        );
        if (!confirmed) return;

        const res = await fetch(`../../api/user/trusts.php?id=${trustId}`, {
            method: 'DELETE'
        });
        const data = await res.json();
        if (data.success) {
            await showAlertModal('Success', 'Trust deleted successfully', 'success');
            loadTrusts();
        } else {
            await showAlertModal('Error', data.message || 'Failed to delete trust', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error deleting trust', 'error');
    }
}

var modalResolve = null;
var modalReject = null;

function showConfirmModal(title, message, confirmText = 'Confirm', cancelText = 'Cancel', type = 'warning') {
    return new Promise((resolve, reject) => {
        modalResolve = resolve;
        modalReject = reject;
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');

        inputDiv.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;

        if (type === 'danger') {
            setModalIcon('warning', 'text-error text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-container sm:mx-0 sm:h-10 sm:w-10';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-error text-base font-bold text-on-primary hover:bg-error/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        } else {
            setModalIcon('help', 'text-secondary text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary/10 sm:mx-0 sm:h-10 sm:w-10';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-on-primary hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        }

        confirmBtn.onclick = () => {
            closeModal();
            resolve(true);
        };

        modal.classList.remove('hidden');
    });
}

function showAlertModal(title, message, type = 'info') {
    return new Promise((resolve) => {
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');

        inputDiv.classList.add('hidden');
        cancelBtn.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = 'OK';

        if (type === 'success') {
            setModalIcon('check-circle', 'text-deep-forest text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-deep-forest/10 sm:mx-0 sm:h-10 sm:w-10';
        } else if (type === 'error') {
            setModalIcon('error', 'text-error text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-container sm:mx-0 sm:h-10 sm:w-10';
        } else {
            setModalIcon('info', 'text-secondary text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary/10 sm:mx-0 sm:h-10 sm:w-10';
        }

        confirmBtn.onclick = () => {
            closeModal();
            resolve();
        };

        modal.classList.remove('hidden');
    });
}

function closeModal() {
    const modal = document.getElementById('customModal');
    const cancelBtn = document.getElementById('modalCancelBtn');
    modal.classList.add('hidden');
    cancelBtn.classList.remove('hidden');
    if (modalReject) {
        modalReject(false);
        modalReject = null;
    }
}

document.addEventListener('DOMContentLoaded', loadTrusts);
</script>

<?php
    include __DIR__ . '/includes/layout-footer.php';
    exit;
}

$page_title = 'Manage Trust | WyomingTrust';
$active_nav = 'trusts';
$extra_styles = '@media print { aside, header, .no-print { display: none !important; } body { background: white; color: black; } }';
include __DIR__ . '/includes/layout.php';
?>

<section class="flex flex-wrap justify-between items-end gap-4 pb-6 border-b border-outline-variant mb-6">
<div class="flex flex-col gap-2">
<div class="flex items-center gap-2">
<span id="trustTypeBadge" class="bg-secondary/10 text-secondary text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded">Loading...</span>
</div>
<p id="trustName" class="font-headline-lg text-headline-lg text-primary leading-tight">Loading...</p>
<p id="trustId" class="text-on-surface-variant text-sm font-mono font-medium">ID: Loading...</p>
</div>
<div class="flex gap-2 items-center no-print">
<button onclick="window.location.href='../../onboarding/onboarding.php'" class="flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-on-primary text-sm font-bold gap-2 hover:bg-primary/90 transition-all">
<?php echo wt_icon('add', 'text-sm'); ?>
<span>Create New Trust</span>
</button>
<button onclick="window.location.href='manage-trust.php'" class="flex items-center justify-center rounded-lg h-10 px-4 bg-primary-container text-on-primary text-sm font-bold gap-2 hover:bg-primary transition-all">
<?php echo wt_icon('arrow-back', 'text-sm'); ?>
<span>Back to Trusts</span>
</button>
</div>
</section>

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
<div class="flex flex-col gap-2 rounded-xl p-5 border border-outline-variant bg-surface-container-lowest shadow-sm">
<p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Portfolio Assets</p>
<div class="flex items-baseline gap-2">
<p id="portfolioAssets" class="text-primary text-2xl font-black">0/0</p>
<span class="text-xs text-on-surface-variant">0% allocation</span>
</div>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-outline-variant bg-surface-container-lowest shadow-sm">
<p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Total Value</p>
<p id="totalValue" class="text-primary text-2xl font-black tracking-tight">$0.00</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-outline-variant bg-surface-container-lowest shadow-sm">
<p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Beneficiaries</p>
<p id="beneficiaryCount" class="text-primary text-2xl font-black">0</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-outline-variant bg-surface-container-lowest shadow-sm">
<p class="text-on-surface-variant text-xs font-bold uppercase tracking-wider">Status</p>
<div class="flex items-center gap-2">
<?php echo wt_icon('shield', 'text-secondary text-xl'); ?>
<p id="trustStatus" class="text-primary text-lg font-bold">Loading...</p>
</div>
</div>
</section>

<section class="flex items-center gap-4 mb-8 bg-surface-container-low p-4 rounded-xl border border-outline-variant no-print">
<p class="text-primary text-sm font-bold mr-2">Quick Actions:</p>
<button onclick="exportTrustReport()" class="flex items-center gap-2 px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm font-semibold text-primary hover:bg-secondary/10 transition-colors">
<?php echo wt_icon('share', 'text-secondary'); ?>
Export Report
</button>
<button onclick="printTrustDetails()" class="flex items-center gap-2 px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm font-semibold text-primary hover:bg-secondary/10 transition-colors">
<?php echo wt_icon('print', 'text-secondary'); ?>
Print Details
</button>
<button onclick="shareWithAdvisor()" class="flex items-center gap-2 px-3 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg text-sm font-semibold text-primary hover:bg-secondary/10 transition-colors">
<?php echo wt_icon('group', 'text-secondary'); ?>
Share with Advisor
</button>
</section>

<section class="mb-8">
<h2 class="font-headline-md text-headline-md text-primary pb-4">Trust Settings</h2>
<div class="flex flex-col gap-3">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
<div class="flex flex-col gap-1">
<p class="text-primary text-base font-bold">Edit Trust Name</p>
<p class="text-on-surface-variant text-sm">Modify the official title of this trust.</p>
</div>
<button onclick="editTrustName()" class="flex min-w-[120px] cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-primary text-on-primary text-sm font-bold hover:bg-primary/90 transition-all">
Edit Name
</button>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">
<div class="flex flex-col gap-1">
<p class="text-primary text-base font-bold">Change Status</p>
<div class="flex items-center gap-2">
<span id="statusDot" class="size-2 bg-outline-variant rounded-full"></span>
<p class="text-on-surface-variant text-sm">Current Status: <span id="statusBadge" class="font-bold text-on-surface">Loading...</span></p>
</div>
</div>
<button onclick="changeStatus()" class="flex min-w-[120px] cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-primary-container text-on-primary text-sm font-bold hover:bg-primary transition-all">
Change Status
</button>
</div>
</div>
</section>

<section class="mb-4">
<div class="flex justify-between items-center pb-4">
<h2 class="font-headline-md text-headline-md text-primary">Manage Beneficiaries</h2>
<div class="flex gap-3 items-center">
<button id="saveChangesBtn" onclick="saveBeneficiaries()" class="hidden px-4 py-2 rounded-lg bg-primary text-on-primary text-sm font-bold hover:bg-primary/90">Save Changes</button>
<button onclick="addBeneficiary()" class="text-secondary text-sm font-bold hover:underline flex items-center gap-1">
<?php echo wt_icon('add-circle', 'text-sm'); ?>
Add Beneficiary
</button>
</div>
</div>
<div id="beneficiariesContainer" class="flex flex-col gap-4 mb-4">
<div class="text-center py-10 text-on-surface-variant">Loading beneficiaries...</div>
</div>
</section>

<section class="rounded-xl border-2 border-error/20 bg-error-container/30 p-6 mb-12 no-print">
<div class="flex items-center gap-3 mb-4">
<?php echo wt_icon('warning', 'text-error'); ?>
<h2 class="text-error text-lg font-bold">Danger Zone</h2>
</div>
<p class="text-error/70 text-sm mb-6 max-w-2xl">Actions in this section are permanent and may require legal authorization. Proceed with extreme caution.</p>
<div class="flex flex-wrap gap-4">
<button onclick="suspendTrust()" class="px-6 py-2.5 rounded-lg bg-surface-container-lowest border border-error/20 text-error text-sm font-bold hover:bg-error hover:text-on-primary transition-all shadow-sm">
Suspend Trust
</button>
<button onclick="archiveTrust()" class="px-6 py-2.5 rounded-lg bg-error text-on-primary text-sm font-bold hover:bg-error/90 transition-all shadow-md">
Delete Trust
</button>
</div>
</section>

<?php include __DIR__ . '/includes/modal.php'; ?>

<script>
const trustId = <?php echo $trustId; ?>;
let currentTrust = null;
let beneficiariesState = [];
let hasBeneficiaryChanges = false;
let originalBeneficiariesState = [];

var modalResolve = null;
var modalReject = null;

function showConfirmModal(title, message, confirmText = 'Confirm', cancelText = 'Cancel', type = 'warning') {
    return new Promise((resolve, reject) => {
        modalResolve = resolve;
        modalReject = reject;
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');

        inputDiv.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;

        if (type === 'danger') {
            setModalIcon('warning', 'text-error text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-container sm:mx-0 sm:h-10 sm:w-10';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-error text-base font-bold text-on-primary hover:bg-error/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        } else {
            setModalIcon('help', 'text-secondary text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary/10 sm:mx-0 sm:h-10 sm:w-10';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-on-primary hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        }

        confirmBtn.onclick = () => {
            closeModal();
            resolve(true);
        };

        modal.classList.remove('hidden');
    });
}

function showAlertModal(title, message, type = 'info') {
    return new Promise((resolve) => {
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');

        inputDiv.classList.add('hidden');
        cancelBtn.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = 'OK';

        if (type === 'success') {
            setModalIcon('check-circle', 'text-deep-forest text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-deep-forest/10 sm:mx-0 sm:h-10 sm:w-10';
        } else if (type === 'error') {
            setModalIcon('error', 'text-error text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-error-container sm:mx-0 sm:h-10 sm:w-10';
        } else {
            setModalIcon('info', 'text-secondary text-xl');
            iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary/10 sm:mx-0 sm:h-10 sm:w-10';
        }

        confirmBtn.onclick = () => {
            closeModal();
            resolve();
        };

        modal.classList.remove('hidden');
    });
}

function showInputModal(title, message, placeholder, confirmText = 'Confirm') {
    return new Promise((resolve, reject) => {
        modalResolve = resolve;
        modalReject = reject;
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');
        const inputField = document.getElementById('modalInputField');

        inputDiv.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        inputField.placeholder = placeholder;
        inputField.value = '';
        confirmBtn.textContent = confirmText;

        setModalIcon('edit', 'text-secondary text-xl');
        iconWrap.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-secondary/10 sm:mx-0 sm:h-10 sm:w-10';
        confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-on-primary hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';

        const handleConfirm = () => {
            const value = inputField.value.trim();
            if (value) {
                closeModal();
                resolve(value);
            }
        };

        confirmBtn.onclick = handleConfirm;
        inputField.onkeypress = (e) => {
            if (e.key === 'Enter') handleConfirm();
        };

        inputField.focus();
        modal.classList.remove('hidden');
    });
}

function closeModal() {
    const modal = document.getElementById('customModal');
    const cancelBtn = document.getElementById('modalCancelBtn');
    modal.classList.add('hidden');
    cancelBtn.classList.remove('hidden');
    if (modalReject) {
        modalReject(false);
        modalReject = null;
    }
}

async function loadTrustData() {
    if (!trustId) {
        await showAlertModal('Error', 'Invalid trust ID', 'error');
        window.location.href = 'dashboard.php';
        return;
    }

    try {
        const response = await fetch(`../../api/user/trusts.php?id=${trustId}`);
        const data = await response.json();

        if (data.success && data.trust) {
            const trust = data.trust;
            currentTrust = trust;
            document.getElementById('trustName').textContent = trust.trust_name || 'Untitled Trust';
            document.getElementById('trustId').textContent = `ID: ${trust.id || 'N/A'}`;
            document.getElementById('trustTypeBadge').textContent = trust.trust_type || 'Standard';
            updateStatusUI(trust);

            beneficiariesState = Array.isArray(trust.beneficiaries) ? trust.beneficiaries : [];
            originalBeneficiariesState = JSON.parse(JSON.stringify(beneficiariesState));
            hasBeneficiaryChanges = false;
            renderBeneficiaries(beneficiariesState);
            document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
            updateSaveButtonVisibility();
        } else {
            await showAlertModal('Error', 'Trust not found', 'error');
            window.location.href = 'dashboard.php';
        }
    } catch (error) {
        console.error('Error loading trust:', error);
        await showAlertModal('Error', 'Error loading trust data', 'error');
    }
}

function renderBeneficiaries(beneficiaries) {
    const container = document.getElementById('beneficiariesContainer');
    if (!beneficiaries || beneficiaries.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-on-surface-variant">No beneficiaries added yet. Click "Add Beneficiary".</div>';
        return;
    }

    const html = `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            ${beneficiaries.map((ben, idx) => `
                <div class="p-5 rounded-xl border border-outline-variant bg-surface-container-lowest shadow-sm">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="size-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center font-bold flex-shrink-0">${escapeHtml((ben.name || 'B').charAt(0).toUpperCase())}</div>
                            <div class="min-w-0">
                                <p class="text-primary font-black truncate">Beneficiary #${idx + 1}${ben.is_myself ? ' (Myself)' : ''}</p>
                                <p class="text-on-surface-variant text-xs truncate">${escapeHtml(ben.relationship || '')}${ben.email ? ' · ' + escapeHtml(ben.email) : ''}</p>
                            </div>
                        </div>
                        <button onclick="removeBeneficiary(${idx})" class="text-error text-xs font-bold hover:underline">Remove</button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Name</label>
                            <input value="${escapeHtml(ben.name || '')}" oninput="updateBeneficiary(${idx}, 'name', this.value)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Relationship</label>
                            <input value="${escapeHtml(ben.relationship || '')}" oninput="updateBeneficiary(${idx}, 'relationship', this.value)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Email</label>
                            <input value="${escapeHtml(ben.email || '')}" oninput="updateBeneficiary(${idx}, 'email', this.value)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Allocation %</label>
                            <input type="number" min="0" max="100" step="0.01" value="${ben.allocation ?? 0}" oninput="updateBeneficiary(${idx}, 'allocation', this.value)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface"/>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant mb-1">Wallet Address (optional)</label>
                            <input value="${escapeHtml(ben.wallet_address || '')}" oninput="updateBeneficiary(${idx}, 'wallet_address', this.value)" class="w-full px-3 py-2 rounded-lg border border-outline-variant bg-surface-container-low text-on-surface"/>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
        <div class="mt-4 rounded-xl border border-outline-variant bg-surface-container-lowest p-4">
            <p class="text-sm font-bold text-primary">Total Allocation: <span id="allocationTotal">0</span>%</p>
            <p class="text-xs text-on-surface-variant mt-1">Must equal 100% before saving.</p>
        </div>
    `;
    container.innerHTML = html;
    updateAllocationTotal();
}

async function editTrustName() {
    const currentName = document.getElementById('trustName').textContent;
    try {
        const newName = await showInputModal('Edit Trust Name', 'Enter a new name for this trust:', currentName, 'Save');
        if (newName && newName.trim() !== currentName) {
            await updateTrustName(newName.trim());
        }
    } catch (e) {
        // User cancelled
    }
}

async function changeStatus() {
    const currentStatus = currentTrust?.status || 'active';
    const newStatus = currentStatus.toLowerCase() === 'active' ? 'inactive' : 'active';
    const confirmed = await showConfirmModal(
        'Change Trust Status',
        `Are you sure you want to change the trust status from "${currentStatus}" to "${newStatus}"?`,
        'Change Status',
        'Cancel'
    );
    if (confirmed) {
        await updateTrustStatus(newStatus);
    }
}

function addBeneficiary() {
    beneficiariesState.push({
        name: '',
        relationship: '',
        email: '',
        allocation: 0,
        wallet_address: '',
        is_myself: false
    });
    hasBeneficiaryChanges = true;
    renderBeneficiaries(beneficiariesState);
    document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
    updateSaveButtonVisibility();
}

async function suspendTrust() {
    const confirmed = await showConfirmModal(
        'Suspend Trust',
        'Are you sure you want to suspend this trust? The trust status will be changed to inactive. This action may be reversible.',
        'Suspend Trust',
        'Cancel',
        'warning'
    );
    if (confirmed) {
        await updateTrustStatus('inactive');
    }
}

async function archiveTrust() {
    const confirmed = await showConfirmModal(
        'Delete Trust',
        'Are you sure you want to permanently delete this trust? This action cannot be undone and all trust data will be permanently removed.',
        'Delete Trust',
        'Cancel',
        'danger'
    );
    if (confirmed) {
        try {
            const res = await fetch(`../../api/user/trusts.php?id=${trustId}`, {
                method: 'DELETE'
            });
            const data = await res.json();
            if (data.success) {
                await showAlertModal('Success', 'Trust deleted successfully', 'success');
                window.location.href = 'dashboard.php';
            } else {
                await showAlertModal('Error', data.message || 'Failed to delete trust', 'error');
            }
        } catch (e) {
            console.error(e);
            await showAlertModal('Error', 'Error deleting trust', 'error');
        }
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function updateBeneficiary(index, field, value) {
    if (!beneficiariesState[index]) return;
    if (field === 'allocation') {
        beneficiariesState[index][field] = parseFloat(value) || 0;
    } else {
        beneficiariesState[index][field] = value;
    }
    hasBeneficiaryChanges = true;
    updateAllocationTotal();
    updateSaveButtonVisibility();
}

function updateSaveButtonVisibility() {
    const saveBtn = document.getElementById('saveChangesBtn');
    if (saveBtn) {
        if (hasBeneficiaryChanges) {
            saveBtn.classList.remove('hidden');
        } else {
            saveBtn.classList.add('hidden');
        }
    }
}

function removeBeneficiary(index) {
    beneficiariesState.splice(index, 1);
    hasBeneficiaryChanges = true;
    renderBeneficiaries(beneficiariesState);
    document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
    updateSaveButtonVisibility();
}

function updateAllocationTotal() {
    const total = beneficiariesState.reduce((sum, b) => sum + (parseFloat(b.allocation) || 0), 0);
    const el = document.getElementById('allocationTotal');
    if (el) el.textContent = total.toFixed(2);
}

async function saveBeneficiaries() {
    const total = beneficiariesState.reduce((sum, b) => sum + (parseFloat(b.allocation) || 0), 0);
    if (Math.abs(total - 100) > 0.01) {
        await showAlertModal('Validation Error', `Total allocation must equal 100%. Current total: ${total.toFixed(2)}%`, 'error');
        return;
    }
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, beneficiaries: beneficiariesState })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            beneficiariesState = Array.isArray(data.trust.beneficiaries) ? data.trust.beneficiaries : beneficiariesState;
            originalBeneficiariesState = JSON.parse(JSON.stringify(beneficiariesState));
            hasBeneficiaryChanges = false;
            renderBeneficiaries(beneficiariesState);
            updateSaveButtonVisibility();
            await showAlertModal('Success', 'Beneficiaries saved successfully.', 'success');
        } else {
            await showAlertModal('Error', data.message || 'Failed to save beneficiaries', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error saving beneficiaries', 'error');
    }
}

async function updateTrustName(newName) {
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, trust_name: newName })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            document.getElementById('trustName').textContent = data.trust.trust_name || newName;
            currentTrust.trust_name = data.trust.trust_name || newName;
            await showAlertModal('Success', 'Trust name updated successfully.', 'success');
        } else {
            await showAlertModal('Error', data.message || 'Failed to update trust name', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error updating trust name', 'error');
    }
}

function updateStatusUI(trust) {
    const statusRaw = (trust?.status || 'active').toString().toLowerCase();
    const paymentStatusRaw = (trust?.payment_status || '').toString().toLowerCase();

    const trustStatusEl = document.getElementById('trustStatus');
    const badgeEl = document.getElementById('statusBadge');
    const dotEl = document.getElementById('statusDot');

    if (!trustStatusEl || !badgeEl || !dotEl) return;

    let label = statusRaw;
    let badgeClass = 'font-bold';
    let dotClass = 'size-2 rounded-full';

    if (paymentStatusRaw === 'rejected') {
        label = 'payment rejected';
        badgeClass += ' text-error';
        dotClass += ' bg-error';
    } else if (statusRaw === 'pending') {
        label = 'pending';
        badgeClass += ' text-secondary';
        dotClass += ' bg-secondary animate-pulse';
    } else if (statusRaw === 'active') {
        label = 'active';
        badgeClass += ' text-deep-forest';
        dotClass += ' bg-deep-forest';
    } else if (statusRaw === 'inactive') {
        label = 'inactive';
        badgeClass += ' text-on-surface-variant';
        dotClass += ' bg-outline-variant';
    } else if (statusRaw === 'suspended') {
        label = 'suspended';
        badgeClass += ' text-error';
        dotClass += ' bg-error';
    } else {
        label = statusRaw;
        badgeClass += ' text-on-surface';
        dotClass += ' bg-outline-variant';
    }

    const pretty = label.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    trustStatusEl.textContent = pretty;
    badgeEl.textContent = pretty;
    badgeEl.className = badgeClass;
    dotEl.className = dotClass;
}

async function updateTrustStatus(newStatus) {
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, status: newStatus })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            currentTrust = data.trust;
            updateStatusUI(currentTrust);
            await showAlertModal('Success', `Trust status updated to ${newStatus}.`, 'success');
            await loadTrustData();
        } else {
            await showAlertModal('Error', data.message || 'Failed to update trust status', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error updating trust status', 'error');
    }
}

function exportTrustReport() {
    if (!currentTrust) {
        showAlertModal('Error', 'Trust data not loaded yet', 'error');
        return;
    }

    const csv = [
        ['Trust Report', ''],
        ['Trust Name', currentTrust.trust_name || 'Untitled Trust'],
        ['Trust Type', currentTrust.trust_type || 'Standard'],
        ['Status', currentTrust.status || 'Active'],
        ['Created', currentTrust.created_at ? new Date(currentTrust.created_at).toLocaleDateString() : 'N/A'],
        [''],
        ['Beneficiaries', ''],
        ['Name', 'Relationship', 'Email', 'Allocation %', 'Wallet Address']
    ];

    if (Array.isArray(currentTrust.beneficiaries)) {
        currentTrust.beneficiaries.forEach(ben => {
            csv.push([
                ben.name || '',
                ben.relationship || '',
                ben.email || '',
                ben.allocation || 0,
                ben.wallet_address || ''
            ]);
        });
    }

    const csvContent = csv.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `trust-report-${currentTrust.id}-${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function printTrustDetails() {
    window.print();
}

async function shareWithAdvisor() {
    if (!currentTrust) {
        await showAlertModal('Error', 'Trust data not loaded yet', 'error');
        return;
    }

    try {
        const email = await showInputModal(
            'Share with Advisor',
            'Enter the email address of your advisor:',
            'advisor@example.com',
            'Send'
        );

        if (email && email.includes('@')) {
            const subject = encodeURIComponent(`Trust Details: ${currentTrust.trust_name || 'Untitled Trust'}`);
            const body = encodeURIComponent(`Please review the details of my trust.\n\nTrust ID: ${currentTrust.id}\nTrust Name: ${currentTrust.trust_name || 'Untitled Trust'}\nStatus: ${currentTrust.status || 'Active'}`);
            window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
            await showAlertModal('Success', `Share link prepared for ${email}. Your email client should open.`, 'success');
        } else if (email) {
            await showAlertModal('Error', 'Please enter a valid email address', 'error');
        }
    } catch (e) {
        // User cancelled
    }
}

document.addEventListener('DOMContentLoaded', loadTrustData);
</script>

<?php include __DIR__ . '/includes/layout-footer.php'; ?>
