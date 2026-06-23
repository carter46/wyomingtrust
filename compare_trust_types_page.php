<?php
$page_title = 'Compare Trust Types | WyomingTrust';
include 'includes/header.php';

$hero_label = 'Compare Trust Types';
$hero_title = 'Find the Right Trust for Your Family';
$hero_subtitle = 'Compare features, protection levels, and pricing across our trust offerings to choose the best fit for your estate plan.';
$hero_bullets = [
    'Side-by-side comparison of revocable, irrevocable, and smart contract trusts',
    'Transparent starting prices for every trust type',
    'Expert support to help you decide',
];
$hero_cta_text = 'Get Started';
$hero_cta_href = 'onboarding/onboarding.php';
$hero_secondary_text = 'View Pricing';
$hero_secondary_href = 'pricing.php';
$hero_badge_value = '4';
$hero_badge_label = 'Trust Types';
include 'includes/components/service-hero-split.php';
?>

<section class="py-section-padding-lg px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg text-primary mb-3">Trust Type Comparison</h2>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">Each structure serves a different goal — flexibility, maximum protection, or blockchain automation.</p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Revocable -->
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col overflow-hidden">
<div class="bg-primary p-6">
<h3 class="font-headline-md text-headline-md text-sky-accent">Revocable</h3>
<p class="font-body-md text-body-md text-on-primary-container mt-2">Flexible estate planning you can update as life changes.</p>
</div>
<div class="p-6 md:p-8 flex flex-col flex-grow">
<a class="inline-flex items-center text-secondary font-label-md mb-6 hover:underline" href="revocable_living_trust_details.php">
Learn more <span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Can be modified</span>
<span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">check</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Asset protection</span>
<span class="font-label-md text-primary font-bold">Moderate</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Tax benefits</span>
<span class="font-label-md text-primary">Limited</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Automation</span>
<span class="font-label-md text-primary">Manual</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-surface-variant text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-secondary">$299</span>
</li>
</ul>
<a class="block w-full text-center bg-secondary text-on-secondary py-3.5 rounded-xl font-bold hover:opacity-90 transition-opacity" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
</div>
<!-- Irrevocable -->
<div class="bg-surface-container-lowest rounded-2xl border-2 border-secondary shadow-lg flex flex-col overflow-hidden relative">
<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-4 py-1 rounded-full font-label-sm text-label-sm uppercase tracking-wider z-10">Maximum Protection</span>
<div class="bg-primary p-6 pt-8">
<h3 class="font-headline-md text-headline-md text-sky-accent">Irrevocable</h3>
<p class="font-body-md text-body-md text-on-primary-container mt-2">Ultimate asset protection and significant tax advantages.</p>
</div>
<div class="p-6 md:p-8 flex flex-col flex-grow">
<a class="inline-flex items-center text-secondary font-label-md mb-6 hover:underline" href="irrevocable_trust_service.php">
Learn more <span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Can be modified</span>
<span class="material-symbols-outlined text-error">close</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Asset protection</span>
<span class="font-label-md text-primary font-bold">Maximum</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Tax benefits</span>
<span class="font-label-md text-primary font-bold">Significant</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Automation</span>
<span class="font-label-md text-primary">Manual</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-surface-variant text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-secondary">$599</span>
</li>
</ul>
<a class="block w-full text-center bg-secondary text-on-secondary py-3.5 rounded-xl font-bold hover:opacity-90 transition-opacity" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
</div>
<!-- Smart Contract -->
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm flex flex-col overflow-hidden">
<div class="bg-primary p-6">
<h3 class="font-headline-md text-headline-md text-sky-accent">Smart Contract</h3>
<p class="font-body-md text-body-md text-on-primary-container mt-2">Blockchain-native automation for digital asset transfers.</p>
</div>
<div class="p-6 md:p-8 flex flex-col flex-grow">
<a class="inline-flex items-center text-secondary font-label-md mb-6 hover:underline" href="smart_contract_trust_service.php">
Learn more <span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Can be modified</span>
<span class="font-label-md text-on-surface-variant">—</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Asset protection</span>
<span class="font-label-md text-primary font-bold">High</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Tax benefits</span>
<span class="font-label-md text-primary">Moderate</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-outline-variant/30 pb-3">
<span class="text-on-surface-variant text-sm">Automation</span>
<span class="font-label-md text-secondary font-bold">Automatic</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-surface-variant text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-secondary">$499</span>
</li>
</ul>
<a class="block w-full text-center bg-secondary text-on-secondary py-3.5 rounded-xl font-bold hover:opacity-90 transition-opacity" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
</div>
</div>
</div>
</section>

<!-- Also explore -->
<section class="py-section-padding-md px-gutter bg-surface border-y border-outline-variant/30">
<div class="max-w-container-max mx-auto grid md:grid-cols-2 gap-6">
<a href="crypto_asset_trust_service.php" class="flex items-center gap-4 p-6 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 hover:border-secondary transition-colors group">
<div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-on-secondary shrink-0">
<span class="material-symbols-outlined">currency_bitcoin</span>
</div>
<div>
<h3 class="font-headline-md text-headline-md text-primary group-hover:text-secondary transition-colors">Crypto Asset Trust</h3>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Specialized protection for digital assets</p>
</div>
</a>
<a href="trust_llc.php" class="flex items-center gap-4 p-6 bg-surface-container-lowest rounded-2xl border border-outline-variant/30 hover:border-secondary transition-colors group">
<div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-on-secondary shrink-0">
<span class="material-symbols-outlined">business</span>
</div>
<div>
<h3 class="font-headline-md text-headline-md text-primary group-hover:text-secondary transition-colors">Wyoming LLC</h3>
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Business formation and asset protection</p>
</div>
</a>
</div>
</section>

<section class="py-section-padding-lg px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto text-center">
<h2 class="font-headline-lg text-headline-lg mb-4">Still Not Sure Which Is Right For You?</h2>
<p class="font-body-lg text-body-lg text-on-primary-container mb-10 max-w-2xl mx-auto">Our team can walk you through the options and help you choose the structure that fits your goals.</p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
<a href="contact_us.php" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-secondary text-on-secondary px-8 py-4 rounded-xl font-bold hover:opacity-90 transition-opacity">
Schedule a Free Consultation
<span class="material-symbols-outlined">arrow_forward</span>
</a>
<a href="pricing.php" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 border-2 border-sky-accent text-sky-accent px-8 py-4 rounded-xl font-bold hover:bg-sky-accent/10 transition-colors">
View Pricing
</a>
</div>
</div>
</section>

<?php include 'includes/footer.php'; ?>
