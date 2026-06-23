<?php
$page_title = 'Compare Trust Types | WyomingTrust';
include 'includes/header.php';

$hero_label = 'Compare Trust Types';
$hero_title = 'Compare Trust Types';
$hero_subtitle = 'Find the right trust for you and your family\'s future.';
$hero_cta_text = 'Get Started';
$hero_cta_href = 'onboarding/onboarding.php';
include 'includes/components/hero-primary.php';
?>

<!-- Trust Type Comparison Cards -->
<section class="py-section-padding-lg px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto text-center mb-16">
<h2 class="font-headline-lg text-headline-lg mb-4">Trust Type Comparison</h2>
<p class="font-body-lg text-body-lg text-on-primary-container max-w-2xl mx-auto">Compare features, protection levels, and pricing across our trust offerings to find the best fit for your estate plan.</p>
</div>
<div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Revocable -->
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-white/10 hover:border-sky-accent transition-colors group flex flex-col">
<h3 class="font-headline-md text-headline-md mb-2 text-sky-accent">Revocable</h3>
<p class="font-body-md text-body-md mb-6 text-on-primary-container">Flexible estate planning you can update as life changes.</p>
<a class="inline-flex items-center text-sky-accent font-label-md mb-8 hover:underline" href="revocable_living_trust_details.php">
Learn More About Revocable Trusts
<span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Can be modified</span>
<span class="material-symbols-outlined text-sky-accent" style="font-variation-settings: 'FILL' 1;">check</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Asset protection</span>
<span class="font-label-md text-on-primary">Moderate</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Tax benefits</span>
<span class="font-label-md text-on-primary">Limited</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Automation</span>
<span class="font-label-md text-on-primary">Manual</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-primary-container text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-sky-accent">$299</span>
</li>
</ul>
<a class="block w-full text-center bg-secondary text-on-secondary py-4 rounded-xl font-bold hover:bg-secondary-container transition-colors" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
<!-- Irrevocable -->
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-sky-accent/50 hover:border-sky-accent transition-colors group flex flex-col relative">
<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-4 py-1 rounded-full font-label-sm text-label-sm uppercase tracking-wider">Maximum Protection</span>
<h3 class="font-headline-md text-headline-md mb-2 text-sky-accent mt-2">Irrevocable</h3>
<p class="font-body-md text-body-md mb-6 text-on-primary-container">Ultimate asset protection and significant tax advantages.</p>
<a class="inline-flex items-center text-sky-accent font-label-md mb-8 hover:underline" href="irrevocable_trust_service.php">
Learn More About Irrevocable Trusts
<span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Can be modified</span>
<span class="material-symbols-outlined text-error">close</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Asset protection</span>
<span class="font-label-md text-on-primary font-bold">Maximum</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Tax benefits</span>
<span class="font-label-md text-on-primary font-bold">Significant</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Automation</span>
<span class="font-label-md text-on-primary">Manual</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-primary-container text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-sky-accent">$599</span>
</li>
</ul>
<a class="block w-full text-center bg-secondary text-on-secondary py-4 rounded-xl font-bold hover:bg-secondary-container transition-colors" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
<!-- Smart Contract -->
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-white/10 hover:border-sky-accent transition-colors group flex flex-col">
<h3 class="font-headline-md text-headline-md mb-2 text-sky-accent">Smart Contract</h3>
<p class="font-body-md text-body-md mb-6 text-on-primary-container">Blockchain-native automation for digital asset transfers.</p>
<a class="inline-flex items-center text-sky-accent font-label-md mb-8 hover:underline" href="smart_contract_trust_service.php">
Learn More About Smart Contract Trusts
<span class="material-symbols-outlined ml-1 text-[18px]">arrow_forward</span>
</a>
<ul class="space-y-4 mb-8 flex-grow">
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Can be modified</span>
<span class="font-label-md text-on-primary-container">—</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Asset protection</span>
<span class="font-label-md text-on-primary font-bold text-sky-accent">High</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Tax benefits</span>
<span class="font-label-md text-on-primary">Moderate</span>
</li>
<li class="flex items-center justify-between gap-3 border-b border-white/10 pb-3">
<span class="text-on-primary-container text-sm">Automation</span>
<span class="font-label-md text-on-primary font-bold text-secondary-fixed">Automatic</span>
</li>
<li class="flex items-center justify-between gap-3">
<span class="text-on-primary-container text-sm">Starting price</span>
<span class="font-headline-md text-headline-md text-sky-accent">$499</span>
</li>
</ul>
<a class="block w-full text-center bg-sky-accent text-primary py-4 rounded-xl font-bold hover:bg-white transition-colors" href="onboarding/onboarding.php">Create Your Trust</a>
</div>
</div>
<div class="max-w-container-max mx-auto text-center mt-12">
<a href="onboarding/onboarding.php" class="inline-flex items-center justify-center gap-2 bg-secondary text-on-secondary px-10 py-4 rounded-xl font-bold hover:opacity-90 transition-opacity">
Create Your Trust
<span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</section>

<!-- Consultation CTA -->
<section class="py-section-padding-lg px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto text-center">
<h2 class="font-headline-lg text-headline-lg text-primary mb-6">Still Not Sure Which Is Right For You?</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-2xl mx-auto">Our legal experts are here to help you navigate the complexities of estate planning and choose the structure that best meets your needs.</p>
<div class="flex flex-col sm:flex-row items-center justify-center gap-4">
<a href="contact_us.php" class="w-full sm:w-auto bg-secondary text-on-secondary px-8 py-3.5 rounded-xl font-bold hover:opacity-90 transition-opacity">
Schedule a Free Consultation
</a>
<a href="learning_center_landing.php" class="w-full sm:w-auto bg-surface-container-lowest text-primary border border-outline-variant/30 px-8 py-3.5 rounded-xl font-bold hover:bg-surface-container-low transition-colors">
View FAQ
</a>
</div>
</div>
</section>

<?php include 'includes/footer.php'; ?>
