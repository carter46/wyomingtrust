<?php
$page_title = 'Pricing - WyomingTrust';
include 'includes/header.php';

$hero_title = 'Choose Your Plan';
$hero_subtitle = 'Select the perfect plan for your trust management needs. All plans include secure asset protection and professional management.';
$hero_label = 'Pricing';
$hero_cta_text = '';
include 'includes/components/hero-primary.php';
?>

<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-container-max mx-auto">
<div id="loadingState" class="text-center py-12">
<div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-secondary border-t-transparent mb-4"></div>
<p class="font-body-md text-body-md text-on-surface-variant">Loading pricing plans...</p>
</div>

<div id="errorState" class="hidden text-center py-12">
<div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg inline-flex items-center gap-2 text-sm">
<span class="material-symbols-outlined">error</span>
Failed to load pricing plans. Please refresh the page.
</div>
</div>

<div id="pricingContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 hidden"></div>

<div id="defaultPlans" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mb-16 hidden">
<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-8 relative shadow-sm">
<div class="absolute -top-4 left-1/2 -translate-x-1/2">
<span class="bg-secondary text-on-secondary px-4 py-1 rounded-full text-xs font-bold uppercase">Most Popular</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2">Basic</h3>
<div class="mb-6">
<span class="font-display-lg text-display-lg text-primary">$299</span>
<span class="font-body-md text-body-md text-on-surface-variant">/year</span>
</div>
<ul class="space-y-4 mb-8">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">1 Revocable Trust</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">5 Beneficiaries</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Basic Documentation</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Email Support</span></li>
</ul>
<a href="onboarding/onboarding.php" class="block w-full bg-secondary text-on-secondary text-center py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">Get Started</a>
</div>

<div class="bg-surface-container-lowest rounded-2xl border-2 border-secondary p-8 relative shadow-sm lg:scale-105">
<div class="absolute -top-4 left-1/2 -translate-x-1/2">
<span class="bg-secondary text-on-secondary px-4 py-1 rounded-full text-xs font-bold uppercase">Best Value</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2">Professional</h3>
<div class="mb-6">
<span class="font-display-lg text-display-lg text-primary">$599</span>
<span class="font-body-md text-body-md text-on-surface-variant">/year</span>
</div>
<ul class="space-y-4 mb-8">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Unlimited Trusts</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Unlimited Beneficiaries</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Advanced Documentation</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Priority Support</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Multi-Signature Security</span></li>
</ul>
<a href="onboarding/onboarding.php" class="block w-full bg-secondary text-on-secondary text-center py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">Get Started</a>
</div>

<div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-8 relative shadow-sm">
<div class="absolute -top-4 left-1/2 -translate-x-1/2">
<span class="bg-primary text-on-primary px-4 py-1 rounded-full text-xs font-bold uppercase">Enterprise</span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-2">Enterprise</h3>
<div class="mb-6">
<span class="font-display-lg text-display-lg text-primary">$999</span>
<span class="font-body-md text-body-md text-on-surface-variant">/year</span>
</div>
<ul class="space-y-4 mb-8">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Everything in Professional</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Custom Legal Structure</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Dedicated Account Manager</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">24/7 Support</span></li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-secondary">check_circle</span><span class="font-body-md text-body-md text-on-surface">Advanced Security Features</span></li>
</ul>
<a href="onboarding/onboarding.php" class="block w-full bg-secondary text-on-secondary text-center py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">Get Started</a>
</div>
</div>

<div class="max-w-3xl mx-auto">
<h2 class="font-headline-lg text-headline-lg text-primary text-center mb-12">Frequently Asked Questions</h2>
<div class="space-y-4">
<details class="group bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-6">
<summary class="flex items-center justify-between cursor-pointer font-label-md text-primary list-none">
<span>Can I change my plan later?</span>
<span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
</summary>
<p class="mt-4 font-body-md text-body-md text-on-surface-variant">Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately, and we'll prorate any pricing differences.</p>
</details>
<details class="group bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-6">
<summary class="flex items-center justify-between cursor-pointer font-label-md text-primary list-none">
<span>Are there any hidden fees?</span>
<span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
</summary>
<p class="mt-4 font-body-md text-body-md text-on-surface-variant">No hidden fees. The price you see is the price you pay. All plans include secure trust management, documentation, and support.</p>
</details>
<details class="group bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-6">
<summary class="flex items-center justify-between cursor-pointer font-label-md text-primary list-none">
<span>What payment methods do you accept?</span>
<span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
</summary>
<p class="mt-4 font-body-md text-body-md text-on-surface-variant">We accept various payment methods including credit cards, PayPal, and cryptocurrency (Bitcoin, Ethereum, USDC).</p>
</details>
<details class="group bg-surface-container-lowest rounded-xl border border-outline-variant/30 p-6">
<summary class="flex items-center justify-between cursor-pointer font-label-md text-primary list-none">
<span>Is my data secure?</span>
<span class="material-symbols-outlined group-open:rotate-180 transition-transform">expand_more</span>
</summary>
<p class="mt-4 font-body-md text-body-md text-on-surface-variant">Absolutely. We use bank-grade encryption and multi-signature security to protect all your assets and personal information.</p>
</details>
</div>
</div>
</div>
</section>

<section class="py-section-padding-md px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto text-center">
<h2 class="font-headline-lg text-headline-lg text-primary mb-4">Ready to protect your digital legacy?</h2>
<p class="font-body-md text-body-md text-on-surface-variant mb-8 max-w-2xl mx-auto">Start your trust setup today with guided onboarding and expert support.</p>
<a href="onboarding/onboarding.php" class="inline-flex items-center gap-2 bg-secondary text-on-secondary px-8 py-4 rounded-lg font-bold hover:opacity-90 transition-opacity">
Get Started
<span class="material-symbols-outlined">arrow_forward</span>
</a>
</div>
</section>

<script>
async function loadPricingPlans() {
    const loadingState = document.getElementById('loadingState');
    const errorState = document.getElementById('errorState');
    const pricingContainer = document.getElementById('pricingContainer');
    const defaultPlans = document.getElementById('defaultPlans');

    try {
        const response = await fetch('api/pricing.php', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        });
        const data = await response.json();

        if (data.success && data.plans && data.plans.length > 0) {
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            pricingContainer.classList.remove('hidden');
            defaultPlans.classList.add('hidden');
            renderPricingPlans(data.plans);
        } else {
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            defaultPlans.classList.remove('hidden');
            pricingContainer.classList.add('hidden');
        }
    } catch (error) {
        console.error('Failed to load pricing plans:', error);
        loadingState.classList.add('hidden');
        pricingContainer.classList.add('hidden');
        errorState.classList.remove('hidden');
        defaultPlans.classList.remove('hidden');
    }
}

function renderPricingPlans(plans) {
    const container = document.getElementById('pricingContainer');
    container.innerHTML = '';

    plans.forEach((plan, index) => {
        const features = Array.isArray(plan.features) ? plan.features : [];
        let badgeText = '';
        let badgeClass = 'bg-primary text-on-primary';
        let borderClass = 'border border-outline-variant/30';
        let scaleClass = '';

        if (index === 1 && plans.length === 3) {
            badgeText = 'Best Value';
            badgeClass = 'bg-secondary text-on-secondary';
            borderClass = 'border-2 border-secondary';
            scaleClass = 'lg:scale-105';
        } else if (index === 0 && plans.length === 3) {
            badgeText = 'Most Popular';
            badgeClass = 'bg-secondary text-on-secondary';
        } else if (index === plans.length - 1) {
            badgeText = 'Enterprise';
        }

        const planCard = document.createElement('div');
        planCard.className = `bg-surface-container-lowest rounded-2xl ${borderClass} p-8 relative shadow-sm ${scaleClass}`;
        planCard.innerHTML = `
            ${badgeText ? `<div class="absolute -top-4 left-1/2 -translate-x-1/2"><span class="${badgeClass} px-4 py-1 rounded-full text-xs font-bold uppercase">${badgeText}</span></div>` : ''}
            <h3 class="font-headline-md text-headline-md text-primary mb-2">${escapeHtml(plan.plan_name)}</h3>
            <div class="mb-6">
                ${plan.is_free ?
                    '<span class="font-display-lg text-display-lg text-primary">Free</span>' :
                    `<span class="font-display-lg text-display-lg text-primary">$${parseFloat(plan.price).toFixed(2)}</span><span class="font-body-md text-body-md text-on-surface-variant">/year</span>`
                }
            </div>
            <ul class="space-y-4 mb-8">
                ${features.map(feature => `
                    <li class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-secondary">check_circle</span>
                        <span class="font-body-md text-body-md text-on-surface">${escapeHtml(feature)}</span>
                    </li>
                `).join('')}
            </ul>
            <a href="onboarding/onboarding.php" class="block w-full bg-secondary text-on-secondary text-center py-3 rounded-lg font-bold hover:opacity-90 transition-opacity">Get Started</a>
        `;
        container.appendChild(planCard);
    });
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

loadPricingPlans();
</script>

<?php include 'includes/footer.php'; ?>
