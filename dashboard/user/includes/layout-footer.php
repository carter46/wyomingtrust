<?php
$mobileNavClass = function ($key) use ($active_nav) {
    if (($active_nav ?? '') === $key) {
        return 'flex items-center gap-4 px-4 py-3 rounded-lg bg-primary text-on-primary';
    }
    return 'flex items-center gap-4 px-4 py-3 rounded-lg hover:bg-surface-container';
};
?>
</div>
</main>
</div>
<div class="fixed inset-0 z-[60] pointer-events-none opacity-0 transition-opacity duration-300 md:hidden" id="mobile-nav">
<div class="absolute inset-0 bg-primary/20 backdrop-blur-sm" onclick="toggleMobileNav()"></div>
<div class="absolute inset-y-0 left-0 w-72 bg-surface-container-lowest shadow-2xl flex flex-col p-6 -translate-x-full transition-transform duration-300">
<div class="flex items-center justify-between mb-8">
<span class="font-headline-md text-headline-md font-bold text-primary">WyomingTrust</span>
<button type="button" class="p-2 hover:bg-surface-container rounded-full" onclick="toggleMobileNav()" aria-label="Close menu">
<span class="material-symbols-outlined">close</span>
</button>
</div>
<nav class="flex-1 space-y-2 overflow-y-auto">
<a class="<?php echo $mobileNavClass('assets'); ?>" href="assets.php"><span class="material-symbols-outlined">account_balance_wallet</span>Assets</a>
<a class="<?php echo $mobileNavClass('transactions'); ?>" href="transactions.php"><span class="material-symbols-outlined">receipt_long</span>Transactions</a>
<a class="<?php echo $mobileNavClass('send'); ?>" href="send.php"><span class="material-symbols-outlined">send</span>Send</a>
<a class="<?php echo $mobileNavClass('receive'); ?>" href="receive.php"><span class="material-symbols-outlined">call_received</span>Receive</a>
<a class="<?php echo $mobileNavClass('swap'); ?>" href="swap.php"><span class="material-symbols-outlined">swap_horiz</span>Swap</a>
<a class="<?php echo $mobileNavClass('link-wallet'); ?>" href="link-wallet.php"><span class="material-symbols-outlined">link</span>Link Wallet</a>
<a class="<?php echo $mobileNavClass('trusts'); ?>" href="manage-trust.php"><span class="material-symbols-outlined">gavel</span>Trusts</a>
<a class="<?php echo $mobileNavClass('profile'); ?>" href="profile.php"><span class="material-symbols-outlined">person</span>Profile</a>
<a class="flex items-center gap-4 px-4 py-3 rounded-lg text-error hover:bg-error-container/20" href="../../api/logout.php"><span class="material-symbols-outlined">logout</span>Logout</a>
</nav>
</div>
</div>
<script>
function toggleMobileNav() {
    const nav = document.getElementById('mobile-nav');
    const panel = nav.querySelector('div:last-child');
    if (nav.classList.contains('opacity-0')) {
        nav.classList.replace('opacity-0', 'opacity-100');
        nav.classList.replace('pointer-events-none', 'pointer-events-auto');
        panel.classList.replace('-translate-x-full', 'translate-x-0');
    } else {
        nav.classList.replace('opacity-100', 'opacity-0');
        nav.classList.replace('pointer-events-auto', 'pointer-events-none');
        panel.classList.replace('translate-x-0', '-translate-x-full');
    }
}
</script>
