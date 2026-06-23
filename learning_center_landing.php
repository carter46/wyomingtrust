<?php
$page_title = 'Learning Center | WyomingTrust';
include 'includes/header.php';

$hero_label = 'Learning Center';
$hero_title = 'Learning Center';
$hero_subtitle = 'Master crypto estate planning with our expert-led resources and comprehensive guides.';
$hero_cta_text = 'Get Started';
$hero_cta_href = 'onboarding/onboarding.php';
include 'includes/components/hero-primary.php';
?>

<section class="py-section-padding-lg px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto text-center mb-16">
<h2 class="font-headline-lg text-headline-lg text-primary mb-4">Educational Resources</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-3xl mx-auto">
Comprehensive guides and tutorials coming soon. Our experts are crafting the most detailed repository for blockchain estate planning.
</p>
</div>

<div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
<div class="bg-white rounded-2xl border border-outline-variant/30 p-8 shadow-sm">
<div class="bg-secondary-fixed w-12 h-12 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-secondary text-2xl">account_balance</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-3">Trust Fundamentals</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Learn the basics of revocable and irrevocable trusts for digital asset protection.</p>
</div>

<div class="bg-white rounded-2xl border border-outline-variant/30 p-8 shadow-sm">
<div class="bg-secondary-fixed w-12 h-12 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-secondary text-2xl">currency_bitcoin</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-3">Crypto Estate Planning</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Guides on securing Bitcoin, Ethereum, NFTs, and wallet inheritance strategies.</p>
</div>

<div class="bg-white rounded-2xl border border-outline-variant/30 p-8 shadow-sm">
<div class="bg-secondary-fixed w-12 h-12 rounded-xl flex items-center justify-center mb-6">
<span class="material-symbols-outlined text-secondary text-2xl">gavel</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-3">Wyoming Trust Law</h3>
<p class="font-body-md text-body-md text-on-surface-variant">Understand Wyoming's favorable trust statutes and LLC structures for asset protection.</p>
</div>
</div>
</section>

<section class="py-section-padding-md px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
<a href="compare_trust_types_page.php" class="bg-primary-container rounded-2xl p-6 border border-white/10 hover:border-sky-accent transition-colors group">
<span class="material-symbols-outlined text-sky-accent text-3xl mb-4 block">compare</span>
<h3 class="font-headline-md text-headline-md text-sky-accent mb-2">Compare Trust Types</h3>
<p class="font-body-md text-body-md text-on-primary-container">Find the right trust structure for your estate plan.</p>
</a>
<a href="revocable_living_trust_details.php" class="bg-primary-container rounded-2xl p-6 border border-white/10 hover:border-sky-accent transition-colors group">
<span class="material-symbols-outlined text-sky-accent text-3xl mb-4 block">description</span>
<h3 class="font-headline-md text-headline-md text-sky-accent mb-2">Revocable Living Trust</h3>
<p class="font-body-md text-body-md text-on-primary-container">Flexible estate planning you can update as life changes.</p>
</a>
<a href="crypto_asset_trust_service.php" class="bg-primary-container rounded-2xl p-6 border border-white/10 hover:border-sky-accent transition-colors group">
<span class="material-symbols-outlined text-sky-accent text-3xl mb-4 block">token</span>
<h3 class="font-headline-md text-headline-md text-sky-accent mb-2">Crypto Asset Trust</h3>
<p class="font-body-md text-body-md text-on-primary-container">Blockchain-native security for your digital wealth.</p>
</a>
</div>
</section>

<?php
$cta_title = 'Ready to secure your digital legacy?';
$cta_subtitle = 'Start your trust setup with guided onboarding.';
$cta_primary_text = 'Get Started';
$cta_primary_href = 'onboarding/onboarding.php';
$cta_secondary_text = '';
include 'includes/components/cta-banner.php';
?>

<?php include 'includes/footer.php'; ?>
