<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$userName = $_SESSION['user_name'] ?? 'User';
$trustIdParam = isset($_GET['trust_id']) ? (int) $_GET['trust_id'] : 0;
$coinKeyParam = isset($_GET['coin_key']) ? sanitize_text($_GET['coin_key']) : '';
$page_title = 'Deposit Crypto | WyomingTrust';
$active_nav = $trustIdParam > 0 ? 'trusts' : '';
$extra_styles = '.card-shadow { box-shadow: 0 4px 20px rgba(4, 22, 39, 0.05); }';
$extra_head = '<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>';

include __DIR__ . '/includes/layout.php';
?>

<section class="flex flex-wrap items-center justify-between gap-4 mb-6">
<div>
<?php if ($trustIdParam > 0 && $coinKeyParam !== ''): ?>
<a href="asset-detail.php?coin_key=<?php echo escape_html($coinKeyParam); ?>&trust_id=<?php echo $trustIdParam; ?>" class="inline-flex items-center gap-1 text-secondary font-label-md text-label-md hover:underline mb-3">
<?php echo wt_icon('arrow-back', 'w-4 h-4'); ?> Back to Asset
</a>
<?php endif; ?>
<h1 class="font-headline-lg text-headline-lg text-primary mb-1">Deposit Cryptocurrency</h1>
<p class="font-body-md text-body-md text-on-surface-variant">Send crypto to your trust deposit address</p>
</div>
</section>

<div class="bg-surface-container-low border border-outline-variant rounded-2xl p-4 sm:p-6 mb-6">
<div class="flex items-start gap-3">
<?php echo wt_icon('info', 'text-secondary flex-shrink-0'); ?>
<div class="text-sm text-on-surface">
<p class="font-semibold mb-2">Security Information:</p>
<ul class="list-disc pl-5 space-y-1 text-xs sm:text-sm text-on-surface-variant">
<li>Only send the selected cryptocurrency to the address shown</li>
<li>Deposit addresses are configured by WyomingTrust administrators</li>
<li>Transactions sent to the wrong network or coin may be unrecoverable</li>
<li>We do not store your private keys or seed phrases</li>
</ul>
</div>
</div>
</div>

<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant card-shadow p-6 sm:p-8">
<div id="assetSelector" class="flex items-center gap-3 p-4 border border-outline-variant rounded-xl cursor-pointer hover:bg-surface-container-low mb-6">
<img id="selectedAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<span id="selectedAssetName" class="font-bold text-on-surface">Select Asset</span>
<?php echo wt_icon('chevron-down', 'ml-auto text-on-surface-variant'); ?>
</div>
<div id="lockedAssetDisplay" class="hidden flex items-center gap-3 p-4 border border-outline-variant rounded-xl bg-surface-container-low mb-6">
<img id="lockedAssetLogo" src="" alt="" class="w-10 h-10 rounded-full hidden">
<div>
<p id="lockedAssetName" class="font-bold text-on-surface">--</p>
<p id="lockedAssetSymbol" class="text-xs text-on-surface-variant">--</p>
</div>
</div>

<div id="depositLoadingPanel" class="text-center py-12">
<div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-primary border-t-transparent mb-4"></div>
<p class="text-on-surface-variant text-sm">Loading deposit details...</p>
</div>

<div id="depositUnavailablePanel" class="hidden text-center py-10 px-4">
<div class="w-16 h-16 mx-auto mb-4 rounded-full bg-error-container/30 flex items-center justify-center">
<?php echo wt_icon('warning', 'w-8 h-8 text-error'); ?>
</div>
<h2 class="font-headline-md text-headline-md text-primary mb-2">Deposit Not Available</h2>
<p class="text-on-surface-variant text-sm max-w-md mx-auto mb-2">
Deposits for <strong id="unavailableCoinName" class="text-primary">this coin</strong> are not available at this moment.
</p>
<p class="text-on-surface-variant text-xs max-w-md mx-auto">
An administrator has not yet configured a deposit wallet address for this asset. Please check back later or contact support.
</p>
<?php if ($trustIdParam > 0 && $coinKeyParam !== ''): ?>
<a href="asset-detail.php?coin_key=<?php echo escape_html($coinKeyParam); ?>&trust_id=<?php echo $trustIdParam; ?>" class="inline-flex items-center gap-2 mt-6 text-secondary font-label-md font-bold hover:underline">
<?php echo wt_icon('arrow-back', 'w-4 h-4'); ?> Back to Asset
</a>
<?php endif; ?>
</div>

<div id="depositAvailablePanel" class="hidden">
<div class="text-center p-6 sm:p-8 bg-surface-container-low rounded-xl">
<div id="qrCode" class="inline-block p-4 bg-surface-container-lowest rounded-xl mb-4 border border-outline-variant">
<canvas id="qrCodeCanvas" width="200" height="200" class="w-48 h-48"></canvas>
</div>
<p class="text-xs text-on-surface-variant mb-4">Scan this QR code to deposit crypto</p>
<div class="flex items-center gap-2 p-3 bg-surface-container-lowest rounded-xl border border-outline-variant max-w-xl mx-auto">
<input type="text" id="receiveAddress" readonly class="flex-1 bg-transparent text-xs sm:text-sm font-mono break-all text-on-surface min-w-0">
<button type="button" onclick="copyAddress()" class="shrink-0 px-4 py-2 bg-primary text-on-primary rounded-lg hover:bg-primary/90 text-xs font-semibold inline-flex items-center gap-1">
<?php echo wt_icon('share', 'w-4 h-4'); ?> Copy
</button>
</div>
<p class="text-xs text-on-surface-variant mt-3">Send only <span id="selectedAssetSymbol" class="font-semibold text-primary">--</span> to this address</p>
</div>

<div id="depositPendingNotice" class="hidden mt-8 p-4 rounded-xl border border-secondary/30 bg-secondary/10 text-sm text-on-surface">
<?php echo wt_icon('info', 'inline w-4 h-4 text-secondary mr-1'); ?>
<strong>Deposit pending review.</strong> You already submitted a payment for this asset. An administrator will verify it shortly.
</div>

<div id="depositConfirmSection" class="mt-8 pt-8 border-t border-outline-variant">
<h2 class="font-headline-md text-headline-md text-primary mb-2">Confirm Your Payment</h2>
<p class="text-sm text-on-surface-variant mb-6">After sending crypto to the address above, enter your transaction details below.</p>
<form id="depositConfirmForm" class="space-y-5 max-w-xl">
<div>
<label for="depositAmount" class="block text-sm font-semibold text-primary mb-2">Amount Deposited</label>
<input type="number" id="depositAmount" name="amount" min="0" step="any" required placeholder="0.00" class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface-container-low text-on-surface focus:outline-none focus:ring-2 focus:ring-secondary"/>
</div>
<div>
<label for="depositTxHash" class="block text-sm font-semibold text-primary mb-2">Transaction Hash (TX ID)</label>
<input type="text" id="depositTxHash" name="tx_hash" required placeholder="Paste your transaction hash" class="w-full px-4 py-3 rounded-xl border border-outline-variant bg-surface-container-low text-on-surface font-mono text-sm focus:outline-none focus:ring-2 focus:ring-secondary"/>
</div>
<div>
<label for="depositProof" class="block text-sm font-semibold text-primary mb-2">Payment Proof <span class="font-normal text-on-surface-variant">(optional)</span></label>
<input type="file" id="depositProof" name="proof" accept=".pdf,.jpg,.jpeg,.png,.webp" class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-secondary file:text-on-secondary file:font-semibold hover:file:opacity-90"/>
<p class="text-xs text-on-surface-variant mt-1">Upload a screenshot or receipt (PDF, JPG, PNG — max 10MB)</p>
</div>
<button type="submit" id="depositSubmitBtn" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-8 py-4 rounded-xl font-label-md font-bold hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
<?php echo wt_icon('check-circle', 'w-5 h-5'); ?> I Have Made This Payment
</button>
</form>
</div>
</div>
</div>

<div id="assetModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
<div class="bg-surface-container-lowest rounded-2xl max-w-md w-full max-h-[80vh] overflow-y-auto border border-outline-variant">
<div class="p-6 border-b border-outline-variant flex items-center justify-between">
<h3 class="font-bold text-lg text-primary">Select Asset</h3>
<button type="button" onclick="closeAssetModal()" class="text-on-surface-variant hover:text-on-surface">
<?php echo wt_icon('close', 'w-5 h-5'); ?>
</button>
</div>
<div id="assetList" class="p-4"></div>
</div>
</div>

<?php include __DIR__ . '/includes/modal.php'; ?>

<script>
let userAssets = [];
let selectedAsset = null;
let adminAddresses = {};
let hasPendingDeposit = false;

const urlParams = new URLSearchParams(window.location.search);
const urlCoinKey = urlParams.get('coin_key');
const urlTrustId = <?php echo $trustIdParam; ?>;
const lockToSingleCoin = !!urlCoinKey;

function showPanel(panelId) {
    ['depositLoadingPanel', 'depositUnavailablePanel', 'depositAvailablePanel'].forEach((id) => {
        const el = document.getElementById(id);
        if (el) el.classList.toggle('hidden', id !== panelId);
    });
}

async function loadCoinFromCatalog(coinKey) {
    const response = await fetch('../../api/coins.php');
    const data = await response.json();
    if (!data.success || !data.coins) return null;
    return data.coins.find(c => c.coin_key === coinKey) || null;
}

function updateLockedAssetDisplay(asset) {
    if (!asset) return;
    const logo = document.getElementById('lockedAssetLogo');
    if (asset.logo) {
        logo.src = asset.logo;
        logo.classList.remove('hidden');
    }
    document.getElementById('lockedAssetName').textContent = asset.display_name || asset.symbol || asset.coin_key;
    document.getElementById('lockedAssetSymbol').textContent = asset.symbol || asset.coin_key;
}

async function loadAdminAddresses() {
    try {
        const response = await fetch('../../api/addresses.php');
        const data = await response.json();
        if (data.success && data.addressMap) {
            adminAddresses = data.addressMap;
        }
    } catch (error) {
        console.error('Error loading admin addresses:', error);
    }
}

async function loadAssets() {
    showPanel('depositLoadingPanel');
    await loadAdminAddresses();

    try {
        const response = await fetch('../../api/user/assets.php');
        const data = await response.json();
        if (!data.success || !data.assets) {
            showPanel('depositUnavailablePanel');
            return;
        }

        userAssets = data.assets;

        if (lockToSingleCoin) {
            let asset = userAssets.find(a => a.coin_key === urlCoinKey);
            if (!asset) {
                const coin = await loadCoinFromCatalog(urlCoinKey);
                if (coin) {
                    asset = {
                        coin_key: coin.coin_key,
                        display_name: coin.display_name,
                        symbol: coin.symbol,
                        logo: coin.logo,
                        balance: 0,
                    };
                }
            }
            document.getElementById('assetSelector').classList.add('hidden');
            document.getElementById('lockedAssetDisplay').classList.remove('hidden');
            if (asset) {
                selectedAsset = asset;
                updateLockedAssetDisplay(asset);
                updateSelectedAsset();
            } else {
                document.getElementById('lockedAssetName').textContent = 'Asset not found';
                document.getElementById('lockedAssetSymbol').textContent = urlCoinKey;
                showPanel('depositUnavailablePanel');
                document.getElementById('unavailableCoinName').textContent = urlCoinKey;
            }
            return;
        }

        if (urlCoinKey) {
            const asset = userAssets.find(a => a.coin_key === urlCoinKey);
            if (asset) selectedAsset = asset;
        }
        if (!selectedAsset && userAssets.length > 0) {
            selectedAsset = userAssets[0];
        }
        if (selectedAsset) {
            updateSelectedAsset();
        } else {
            showPanel('depositUnavailablePanel');
        }
        renderAssetModal();
    } catch (error) {
        console.error('Error loading assets:', error);
        showPanel('depositUnavailablePanel');
    }
}

function updateSelectedAsset() {
    if (!selectedAsset) return;
    const logoEl = document.getElementById('selectedAssetLogo');
    if (logoEl) {
        logoEl.src = selectedAsset.logo || '';
        logoEl.classList.toggle('hidden', !selectedAsset.logo);
    }
    const nameEl = document.getElementById('selectedAssetName');
    if (nameEl) nameEl.textContent = selectedAsset.display_name || selectedAsset.symbol;
    document.getElementById('selectedAssetSymbol').textContent = selectedAsset.symbol || selectedAsset.coin_key || '';
    renderDepositState();
}

function renderDepositState() {
    if (!selectedAsset) {
        showPanel('depositUnavailablePanel');
        return;
    }

    const address = (adminAddresses[selectedAsset.coin_key] || '').trim();
    if (!address) {
        document.getElementById('unavailableCoinName').textContent =
            selectedAsset.display_name || selectedAsset.symbol || selectedAsset.coin_key;
        showPanel('depositUnavailablePanel');
        return;
    }

    showPanel('depositAvailablePanel');
    document.getElementById('receiveAddress').value = address;
    generateQRCode(address);
    checkPendingDeposit();
}

async function checkPendingDeposit() {
    const notice = document.getElementById('depositPendingNotice');
    const formSection = document.getElementById('depositConfirmSection');
    const submitBtn = document.getElementById('depositSubmitBtn');
    if (!selectedAsset || !notice || !formSection) return;

    try {
        const params = new URLSearchParams({ coin_key: selectedAsset.coin_key });
        if (urlTrustId > 0) params.set('trust_id', String(urlTrustId));
        const res = await fetch(`../../api/user/deposit-submissions.php?${params.toString()}`, { credentials: 'same-origin' });
        const data = await res.json();
        const pending = data.success && Array.isArray(data.submissions)
            ? data.submissions.find(s => s.status === 'pending')
            : null;
        hasPendingDeposit = !!pending;
        notice.classList.toggle('hidden', !hasPendingDeposit);
        formSection.classList.toggle('hidden', hasPendingDeposit);
        if (submitBtn) submitBtn.disabled = hasPendingDeposit;
    } catch (e) {
        console.error('Error checking pending deposit:', e);
    }
}

function closeModal() {
    const modal = document.getElementById('customModal');
    if (modal) modal.classList.add('hidden');
}

function showAlertModal(title, message, type = 'info') {
    return new Promise((resolve) => {
        const modal = document.getElementById('customModal');
        const iconWrap = document.getElementById('modalIcon').parentElement;
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        document.getElementById('modalInput').classList.add('hidden');
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
        confirmBtn.onclick = () => { closeModal(); resolve(true); };
        modal.classList.remove('hidden');
    });
}

async function submitDepositConfirmation(event) {
    event.preventDefault();
    if (!selectedAsset || hasPendingDeposit) return;

    const amount = parseFloat(document.getElementById('depositAmount').value);
    const txHash = document.getElementById('depositTxHash').value.trim();
    const proofFile = document.getElementById('depositProof').files[0];
    const address = document.getElementById('receiveAddress').value.trim();

    if (!amount || amount <= 0) {
        await showAlertModal('Invalid Amount', 'Please enter the amount you deposited.', 'error');
        return;
    }
    if (!txHash) {
        await showAlertModal('Transaction Hash Required', 'Please enter your transaction hash (TX ID).', 'error');
        return;
    }

    const submitBtn = document.getElementById('depositSubmitBtn');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
    }

    try {
        const sessionRes = await fetch('../../api/session.php', { credentials: 'same-origin' });
        const sessionData = await sessionRes.json();
        const csrfToken = sessionData.csrf_token || '';

        const formData = new FormData();
        formData.append('coin_key', selectedAsset.coin_key);
        formData.append('amount', String(amount));
        formData.append('tx_hash', txHash);
        formData.append('deposit_address', address);
        formData.append('csrf_token', csrfToken);
        if (urlTrustId > 0) formData.append('trust_id', String(urlTrustId));
        if (proofFile) formData.append('proof', proofFile);

        const res = await fetch('../../api/user/deposit-submissions.php', {
            method: 'POST',
            headers: { 'X-CSRF-Token': csrfToken },
            credentials: 'same-origin',
            body: formData,
        });
        const data = await res.json();

        if (data.success) {
            document.getElementById('depositConfirmForm').reset();
            await showAlertModal('Deposit Submitted', data.message || 'Your deposit has been submitted for admin review.', 'success');
            await checkPendingDeposit();
        } else {
            await showAlertModal('Submission Failed', data.message || 'Could not submit deposit.', 'error');
        }
    } catch (error) {
        console.error('Deposit submission error:', error);
        await showAlertModal('Error', 'An error occurred while submitting your deposit.', 'error');
    } finally {
        if (submitBtn) {
            submitBtn.disabled = hasPendingDeposit;
            submitBtn.textContent = 'I Have Made This Payment';
        }
    }
}

function drawQRPlaceholder(canvas, line1, line2) {
    const ctx = canvas.getContext('2d');
    canvas.width = 200;
    canvas.height = 200;
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, 200, 200);
    ctx.fillStyle = '#041627';
    ctx.font = '13px Arial';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    ctx.fillText(line1, 100, 90);
    if (line2) ctx.fillText(line2, 100, 110);
}

function generateQRCode(address) {
    const canvas = document.getElementById('qrCodeCanvas');
    if (!canvas || !address) return;

    if (typeof QRCode === 'undefined' || typeof QRCode.toCanvas !== 'function') {
        drawQRPlaceholder(canvas, 'QR code unavailable', 'copy address instead');
        return;
    }

    QRCode.toCanvas(canvas, address, {
        width: 200,
        margin: 1,
        color: { dark: '#041627', light: '#FFFFFF' }
    }, (err) => {
        if (err) {
            console.error('Error generating QR code:', err);
            drawQRPlaceholder(canvas, 'QR code unavailable', 'copy address instead');
        }
    });
}

function renderAssetModal() {
    const list = document.getElementById('assetList');
    if (!list) return;
    list.innerHTML = userAssets.map(asset => `
        <div onclick="selectAsset('${asset.coin_key}')" class="flex items-center gap-3 p-3 rounded-lg hover:bg-surface-container-low cursor-pointer">
            <img src="${asset.logo || ''}" alt="${asset.display_name}" class="w-10 h-10 rounded-full" onerror="this.style.display='none'">
            <div class="flex-1">
                <p class="font-semibold text-on-surface">${asset.display_name}</p>
                <p class="text-xs text-on-surface-variant">${asset.symbol}</p>
            </div>
        </div>
    `).join('');
}

document.getElementById('assetSelector')?.addEventListener('click', () => {
    if (lockToSingleCoin) return;
    const modal = document.getElementById('assetModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
});

function selectAsset(coinKey) {
    selectedAsset = userAssets.find(a => a.coin_key === coinKey);
    if (selectedAsset) {
        updateSelectedAsset();
        closeAssetModal();
    }
}

function closeAssetModal() {
    const modal = document.getElementById('assetModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

async function copyAddress() {
    const address = document.getElementById('receiveAddress').value;
    if (!address) return;
    try {
        await navigator.clipboard.writeText(address);
        alert('Address copied to clipboard!');
    } catch (err) {
        alert('Unable to copy address. Please copy manually.');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadAssets();
    document.getElementById('depositConfirmForm')?.addEventListener('submit', submitDepositConfirmation);
});
</script>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
