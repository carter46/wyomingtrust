<?php
$page_title = 'Pricing - WyomingTrust';
include 'includes/header.php';
?>

<section class="py-12 sm:py-16 lg:py-24 bg-white dark:bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12 lg:mb-16">
            <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-navy-900 dark:text-navy-900 mb-3 sm:mb-4">Choose Your Plan</h1>
            <p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto text-sm sm:text-base lg:text-lg leading-relaxed px-4">
                Select the perfect plan for your trust management needs. All plans include secure asset protection and professional management.
            </p>
        </div>

        <!-- Loading State -->
        <div id="loadingState" class="text-center py-8 sm:py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 sm:h-12 sm:w-12 border-4 border-primary border-t-transparent mb-3 sm:mb-4"></div>
            <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">Loading pricing plans...</p>
        </div>

        <!-- Error State -->
        <div id="errorState" class="hidden text-center py-8 sm:py-12 px-4">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-400 text-red-700 dark:text-red-400 px-3 sm:px-4 py-2 sm:py-3 rounded-lg inline-block text-sm sm:text-base">
                <span class="material-icons-outlined mr-2 text-base sm:text-lg align-middle">error</span>
                Failed to load pricing plans. Please refresh the page.
            </div>
        </div>

        <!-- Pricing Plans Container -->
        <div id="pricingContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16 hidden">
            <!-- Plans will be dynamically inserted here -->
        </div>

        <!-- Default Plans (Fallback) -->
        <div id="defaultPlans" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 mb-12 sm:mb-16 hidden">
            <div class="bg-white dark:bg-navy-800 rounded-xl sm:rounded-2xl shadow-lg border-2 border-slate-200 dark:border-slate-700 p-6 sm:p-8 relative">
                <div class="absolute -top-3 sm:-top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-primary text-navy-900 px-3 sm:px-4 py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase">Most Popular</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-navy-900 dark:text-white mb-2">Basic</h3>
                <div class="mb-4 sm:mb-6">
                    <span class="text-3xl sm:text-4xl font-extrabold text-navy-900 dark:text-white">$299</span>
                    <span class="text-sm sm:text-base text-slate-600 dark:text-slate-400">/year</span>
                </div>
                <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">1 Revocable Trust</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">5 Beneficiaries</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Basic Documentation</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Email Support</span>
                    </li>
                </ul>
                <a href="onboarding/onboarding.php" class="block w-full bg-primary text-navy-900 text-center py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base hover:opacity-90 transition-opacity">
                    Get Started
                </a>
            </div>

            <div class="bg-white dark:bg-navy-800 rounded-xl sm:rounded-2xl shadow-lg border-2 border-primary dark:border-primary p-6 sm:p-8 relative sm:transform sm:scale-105">
                <div class="absolute -top-3 sm:-top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-primary text-navy-900 px-3 sm:px-4 py-1 rounded-full text-[10px] sm:text-xs font-bold uppercase">Best Value</span>
                </div>
                <h3 class="text-xl sm:text-2xl font-bold text-navy-900 dark:text-white mb-2">Professional</h3>
                <div class="mb-4 sm:mb-6">
                    <span class="text-3xl sm:text-4xl font-extrabold text-navy-900 dark:text-white">$599</span>
                    <span class="text-sm sm:text-base text-slate-600 dark:text-slate-400">/year</span>
                </div>
                <ul class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Unlimited Trusts</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Unlimited Beneficiaries</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Advanced Documentation</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Priority Support</span>
                    </li>
                    <li class="flex items-center gap-2 sm:gap-3">
                        <span class="material-icons-outlined text-primary text-base sm:text-lg flex-shrink-0">check_circle</span>
                        <span class="text-sm sm:text-base text-slate-700 dark:text-slate-300">Multi-Signature Security</span>
                    </li>
                </ul>
                <a href="onboarding/onboarding.php" class="block w-full bg-primary text-navy-900 text-center py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base hover:opacity-90 transition-opacity">
                    Get Started
                </a>
            </div>

            <div class="bg-white dark:bg-navy-800 rounded-2xl shadow-lg border-2 border-slate-200 dark:border-slate-700 p-8 relative">
                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                    <span class="bg-slate-600 text-white px-4 py-1 rounded-full text-xs font-bold uppercase">Enterprise</span>
                </div>
                <h3 class="text-2xl font-bold text-navy-900 dark:text-white mb-2">Enterprise</h3>
                <div class="mb-6">
                    <span class="text-4xl font-extrabold text-navy-900 dark:text-white">$999</span>
                    <span class="text-slate-600 dark:text-slate-400">/year</span>
                </div>
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">Everything in Professional</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">Custom Legal Structure</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">Dedicated Account Manager</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">24/7 Support</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">Advanced Security Features</span>
                    </li>
                </ul>
                <a href="onboarding/onboarding.php" class="block w-full bg-primary text-navy-900 text-center py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                    Get Started
                </a>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto mt-24">
            <h2 class="text-3xl font-bold text-center text-navy-900 dark:text-navy-900 mb-12">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <details class="group bg-slate-50 dark:bg-navy-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-navy-900 dark:text-white">
                        <span>Can I change my plan later?</span>
                        <span class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">
                        Yes, you can upgrade or downgrade your plan at any time. Changes take effect immediately, and we'll prorate any pricing differences.
                    </p>
                </details>
                <details class="group bg-slate-50 dark:bg-navy-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-navy-900 dark:text-white">
                        <span>Are there any hidden fees?</span>
                        <span class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">
                        No hidden fees. The price you see is the price you pay. All plans include secure trust management, documentation, and support.
                    </p>
                </details>
                <details class="group bg-slate-50 dark:bg-navy-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-navy-900 dark:text-white">
                        <span>What payment methods do you accept?</span>
                        <span class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">
                        We accept various payment methods including credit cards, PayPal, and cryptocurrency (Bitcoin, Ethereum, USDC).
                    </p>
                </details>
                <details class="group bg-slate-50 dark:bg-navy-800 rounded-lg border border-slate-200 dark:border-slate-700 p-6">
                    <summary class="flex items-center justify-between cursor-pointer font-semibold text-navy-900 dark:text-white">
                        <span>Is my data secure?</span>
                        <span class="material-icons-outlined group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <p class="mt-4 text-slate-600 dark:text-slate-400">
                        Absolutely. We use bank-grade encryption and multi-signature security to protect all your assets and personal information.
                    </p>
                </details>
            </div>
        </div>
    </div>
</section>

<script>
// Fetch pricing plans from API
async function loadPricingPlans() {
    const loadingState = document.getElementById('loadingState');
    const errorState = document.getElementById('errorState');
    const pricingContainer = document.getElementById('pricingContainer');
    const defaultPlans = document.getElementById('defaultPlans');

    try {
        const response = await fetch('api/pricing.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            }
        });

        const data = await response.json();

        if (data.success && data.plans && data.plans.length > 0) {
            // Hide loading state
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            
            // Show pricing container
            pricingContainer.classList.remove('hidden');
            defaultPlans.classList.add('hidden');

            // Render pricing plans
            renderPricingPlans(data.plans);
        } else {
            // Show default plans if no plans returned
            loadingState.classList.add('hidden');
            errorState.classList.add('hidden');
            defaultPlans.classList.remove('hidden');
            pricingContainer.classList.add('hidden');
        }
    } catch (error) {
        console.error('Failed to load pricing plans:', error);
        
        // Show error state
        loadingState.classList.add('hidden');
        pricingContainer.classList.add('hidden');
        errorState.classList.remove('hidden');
        
        // Fallback to default plans
        defaultPlans.classList.remove('hidden');
    }
}

// Render pricing plans
function renderPricingPlans(plans) {
    const container = document.getElementById('pricingContainer');
    container.innerHTML = '';

    plans.forEach((plan, index) => {
        const features = Array.isArray(plan.features) ? plan.features : [];
        
        // Determine badge and highlight for middle plan
        let badgeText = '';
        let badgeColor = 'bg-slate-600';
        let borderClass = 'border-2 border-slate-200 dark:border-slate-700';
        let scaleClass = '';
        
        if (index === 1 && plans.length === 3) {
            badgeText = 'Best Value';
            badgeColor = 'bg-primary';
            borderClass = 'border-2 border-primary';
            scaleClass = 'transform scale-105';
        } else if (index === 0 && plans.length === 3) {
            badgeText = 'Most Popular';
            badgeColor = 'bg-primary';
        } else if (index === plans.length - 1) {
            badgeText = 'Enterprise';
        }

        const planCard = document.createElement('div');
        planCard.className = `bg-white dark:bg-navy-800 rounded-2xl shadow-lg ${borderClass} p-8 relative ${scaleClass}`;
        
        planCard.innerHTML = `
            ${badgeText ? `<div class="absolute -top-4 left-1/2 transform -translate-x-1/2">
                <span class="${badgeColor} ${badgeColor === 'bg-primary' ? 'text-navy-900' : 'text-white'} px-4 py-1 rounded-full text-xs font-bold uppercase">${badgeText}</span>
            </div>` : ''}
            <h3 class="text-2xl font-bold text-navy-900 dark:text-white mb-2">${escapeHtml(plan.plan_name)}</h3>
            <div class="mb-6">
                ${plan.is_free ? 
                    '<span class="text-4xl font-extrabold text-navy-900 dark:text-white">Free</span>' :
                    `<span class="text-4xl font-extrabold text-navy-900 dark:text-white">$${parseFloat(plan.price).toFixed(2)}</span><span class="text-slate-600 dark:text-slate-400">/year</span>`
                }
            </div>
            <ul class="space-y-4 mb-8">
                ${features.map(feature => `
                    <li class="flex items-center gap-3">
                        <span class="material-icons-outlined text-primary">check_circle</span>
                        <span class="text-slate-700 dark:text-slate-300">${escapeHtml(feature)}</span>
                    </li>
                `).join('')}
            </ul>
            <a href="onboarding/onboarding.php" class="block w-full bg-primary text-navy-900 text-center py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                Get Started
            </a>
        `;
        
        container.appendChild(planCard);
    });
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Load pricing plans on page load
loadPricingPlans();
</script>

<?php include 'includes/footer.php'; ?>
