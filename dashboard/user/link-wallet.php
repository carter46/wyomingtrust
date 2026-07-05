<?php
require_once __DIR__ . '/../../api/helpers.php';

require_user_page_auth('../../login.php');

$db = getDatabase();
$stmt = $db->prepare('SELECT wallet_link_use_modal, wallet_link_url FROM site_settings WHERE id = 1 LIMIT 1');
$stmt->execute();
$walletSettings = $stmt->fetch(PDO::FETCH_ASSOC);

$useModal = isset($walletSettings['wallet_link_use_modal']) ? (int)$walletSettings['wallet_link_use_modal'] : 1;
$walletLinkUrl = $walletSettings['wallet_link_url'] ?? '';

$userName = $_SESSION['user_name'] ?? 'User';
$page_title = 'Link Wallet | WyomingTrust';
$active_nav = '';

include __DIR__ . '/includes/layout.php';
?>

<section class="flex items-center justify-center py-8 md:py-12">
<div class="flex flex-col max-w-[520px] w-full">
<div class="bg-surface-container-lowest p-8 md:p-12 rounded-2xl shadow-sm border border-outline-variant">
<div class="flex flex-col items-center text-center space-y-6">
<div class="relative">
<div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center">
<?php echo wt_icon('link', 'text-primary text-4xl'); ?>
</div>
<div class="absolute -bottom-1 -right-1 w-8 h-8 bg-surface-container-lowest rounded-full border-4 border-surface flex items-center justify-center">
<?php echo wt_icon('lock', 'text-primary text-xs font-bold'); ?>
</div>
</div>
<div class="space-y-3">
<h2 class="font-headline-md text-headline-md text-primary leading-tight">Connect Your Wallet</h2>
<p class="font-body-md text-on-surface-variant max-w-[340px] mx-auto">
Securely connect your external wallet to access your funds and manage your digital legacy.
</p>
</div>
<button id="connectWalletBtn" onclick="openWalletModal()" class="w-full py-4 bg-primary text-on-primary text-lg font-bold rounded-lg hover:bg-primary/90 transition-all flex items-center justify-center gap-2 group">
<span class="truncate">Connect Wallet</span>
<?php echo wt_icon('arrow-forward', 'group-hover:translate-x-1 transition-transform'); ?>
</button>
<div class="pt-6 border-t border-outline-variant w-full flex flex-col gap-4">
<div class="flex items-center justify-center gap-2 text-xs text-on-surface-variant font-medium uppercase tracking-widest">
<?php echo wt_icon('shield', 'text-sm'); ?>
Non-custodial and secure
</div>
<div class="grid grid-cols-2 gap-4">
<div class="p-3 bg-surface-container-low rounded-lg text-left">
<p class="text-[10px] text-on-surface-variant font-bold uppercase">Supported</p>
<p class="text-lg font-bold text-primary">20+ Wallets</p>
</div>
<div class="p-3 bg-surface-container-low rounded-lg text-left">
<p class="text-[10px] text-on-surface-variant font-bold uppercase">Encryption</p>
<p class="text-lg font-bold text-primary">AES-256</p>
</div>
</div>
</div>
</div>
</div>
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="flex items-center gap-3 p-4 bg-surface-container-lowest/50 rounded-lg border border-dashed border-outline-variant">
<?php echo wt_icon('shield', 'text-primary text-xl'); ?>
<span class="text-xs font-semibold text-on-surface">Privacy First</span>
</div>
<div class="flex items-center gap-3 p-4 bg-surface-container-lowest/50 rounded-lg border border-dashed border-outline-variant">
<?php echo wt_icon('bolt', 'text-primary text-xl'); ?>
<span class="text-xs font-semibold text-on-surface">Fast Sync</span>
</div>
<div class="flex items-center gap-3 p-4 bg-surface-container-lowest/50 rounded-lg border border-dashed border-outline-variant">
<?php echo wt_icon('link', 'text-primary text-xl'); ?>
<span class="text-xs font-semibold text-on-surface">Multi-Chain</span>
</div>
</div>
</div>
</section>

<?php if ($useModal): ?>
<div id="walletModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
<div class="bg-surface-container-lowest rounded-2xl shadow-2xl border border-outline-variant max-w-md w-full max-h-[90vh] overflow-y-auto">
<div class="p-6 border-b border-outline-variant flex items-center justify-between">
<h3 class="font-headline-md text-headline-md text-primary">Select Wallet</h3>
<button onclick="closeWalletModal()" class="p-2 hover:bg-surface-container-low rounded-lg transition-colors text-on-surface-variant">
<?php echo wt_icon('close', 'w-5 h-5'); ?>
</button>
</div>
<div class="p-6 space-y-3">
<div class="p-4 bg-warm-cream border border-outline-variant rounded-lg mb-4">
<p class="text-xs text-on-surface font-semibold mb-2">Security Notice:</p>
<ul class="text-xs text-on-surface-variant space-y-1 list-disc pl-4">
<li>Wallet data is encrypted using AES-256-CBC encryption</li>
<li>We never store your private keys or seed phrases</li>
<li>All wallet information is encrypted at rest</li>
</ul>
</div>
<div id="wallet-metamask" onclick="selectWallet('metamask')" class="flex items-center justify-between p-4 rounded-lg bg-primary/10 border-2 border-primary shadow-sm cursor-pointer hover:bg-primary/20 transition-colors">
<div class="flex items-center gap-3">
<div class="size-10 rounded-full bg-surface-container-lowest p-1 flex items-center justify-center">
<img class="size-full object-contain" alt="MetaMask logo" src="<?php echo escape_html(asset_url('Storage/images/metamask-logo.png')); ?>"/>
</div>
<div class="text-left">
<span class="text-primary font-semibold text-base block">MetaMask</span>
<span class="text-xs text-on-surface-variant">Browser Extension</span>
</div>
</div>
<span id="metamask-selected" class="bg-primary text-on-primary text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider hidden">Selected</span>
</div>
<div id="wallet-coinbase" onclick="selectWallet('coinbase')" class="flex items-center gap-3 p-4 rounded-lg border border-outline-variant cursor-pointer hover:bg-surface-container-low transition-colors">
<div class="size-10 rounded-full bg-surface-container-lowest p-1 flex items-center justify-center">
<?php echo wt_icon('wallet', 'text-secondary text-2xl'); ?>
</div>
<div class="text-left flex-1">
<span class="text-primary font-medium text-base block">Coinbase Wallet</span>
<span class="text-xs text-on-surface-variant">Mobile & Extension</span>
</div>
</div>
<div id="wallet-trust" onclick="selectWallet('trust')" class="flex items-center gap-3 p-4 rounded-lg border border-outline-variant cursor-pointer hover:bg-surface-container-low transition-colors">
<div class="size-10 rounded-full bg-surface-container-lowest p-1 flex items-center justify-center">
<?php echo wt_icon('shield', 'text-primary text-2xl'); ?>
</div>
<div class="text-left flex-1">
<span class="text-primary font-medium text-base block">Trust Wallet</span>
<span class="text-xs text-on-surface-variant">Mobile App</span>
</div>
</div>
<div id="wallet-walletconnect" onclick="selectWallet('walletconnect')" class="flex items-center gap-3 p-4 rounded-lg border border-outline-variant cursor-pointer hover:bg-surface-container-low transition-colors">
<div class="size-10 rounded-full bg-surface-container-lowest p-1 flex items-center justify-center">
<?php echo wt_icon('refresh', 'text-secondary text-2xl'); ?>
</div>
<div class="text-left flex-1">
<span class="text-primary font-medium text-base block">WalletConnect</span>
<span class="text-xs text-on-surface-variant">Universal Protocol</span>
</div>
</div>
</div>
<div class="p-6 border-t border-outline-variant">
<button id="connectBtn" onclick="linkWallet()" class="w-full py-3 bg-primary text-on-primary text-base font-bold rounded-lg hover:bg-primary/90 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
Connect
</button>
</div>
</div>
</div>
<?php endif; ?>

<script>
const wallets = {
    'metamask': { name: 'MetaMask', iconUrl: <?php echo json_encode(asset_url('Storage/images/metamask-logo.png')); ?> },
    'coinbase': { name: 'Coinbase Wallet', icon: 'account_balance_wallet', color: 'secondary' },
    'trust': { name: 'Trust Wallet', icon: 'shield_with_heart', color: 'primary' },
    'walletconnect': { name: 'WalletConnect', icon: 'sync', color: 'secondary' }
};

let selectedWallet = 'metamask';

function openWalletModal() {
    <?php if ($useModal): ?>
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.classList.remove('hidden');
        selectWallet('metamask');
    }
    <?php else: ?>
    window.location.href = '<?php echo htmlspecialchars($walletLinkUrl ?: '#', ENT_QUOTES, 'UTF-8'); ?>';
    <?php endif; ?>
}

function closeWalletModal() {
    <?php if ($useModal): ?>
    const modal = document.getElementById('walletModal');
    if (modal) {
        modal.classList.add('hidden');
    }
    <?php endif; ?>
}

function selectWallet(walletId) {
    selectedWallet = walletId;
    
    ['metamask', 'coinbase', 'trust', 'walletconnect'].forEach(id => {
        const walletEl = document.getElementById('wallet-' + id);
        const selectedBadge = document.getElementById(id + '-selected');
        if (walletEl) {
            walletEl.className = 'flex items-center gap-3 p-4 rounded-lg border border-outline-variant cursor-pointer hover:bg-surface-container-low transition-colors';
        }
        if (selectedBadge) {
            selectedBadge.classList.add('hidden');
        }
    });
    
    const selectedEl = document.getElementById('wallet-' + walletId);
    const selectedBadge = document.getElementById(walletId + '-selected');
    if (selectedEl) {
        selectedEl.className = 'flex items-center justify-between p-4 rounded-lg bg-primary/10 border-2 border-primary shadow-sm cursor-pointer hover:bg-primary/20 transition-colors';
    }
    if (selectedBadge) {
        selectedBadge.classList.remove('hidden');
    }
}

async function linkWallet() {
    const wallet = wallets[selectedWallet];
    const connectBtn = document.getElementById('connectBtn');
    
    if (connectBtn) {
        connectBtn.disabled = true;
        connectBtn.textContent = 'Connecting...';
    }
    
    try {
        const tokenResponse = await fetch('../../api/session.php');
        const tokenData = await tokenResponse.json();
        const csrfToken = tokenData.csrf_token || null;
        
        const response = await fetch('../../api/user/wallets.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-Token': csrfToken || ''
            },
            body: JSON.stringify({
                wallet_type: selectedWallet,
                wallet_name: wallet.name,
                wallet_data: { connected: true, timestamp: new Date().toISOString() },
                csrf_token: csrfToken
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Wallet linked successfully!');
            window.location.href = 'dashboard.php';
        } else {
            alert('Failed to link wallet: ' + (data.message || 'Unknown error'));
            if (connectBtn) {
                connectBtn.disabled = false;
                connectBtn.textContent = 'Connect';
            }
        }
    } catch (error) {
        console.error('Error linking wallet:', error);
        alert('An error occurred while linking wallet. Please try again.');
        if (connectBtn) {
            connectBtn.disabled = false;
            connectBtn.textContent = 'Connect';
        }
    }
}

<?php if ($useModal): ?>
document.addEventListener('click', function(event) {
    const modal = document.getElementById('walletModal');
    if (modal && event.target === modal) {
        closeWalletModal();
    }
});
<?php endif; ?>
</script>
<?php include __DIR__ . '/includes/layout-footer.php'; ?>
