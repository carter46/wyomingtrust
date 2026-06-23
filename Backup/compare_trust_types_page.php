<?php
$page_title = 'Compare Trust Types | WyomingTrust';
include 'includes/header.php';
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<section class="bg-navy-900 py-12 sm:py-16 lg:py-20 relative overflow-hidden">
    <div class="absolute inset-0 opacity-5 pointer-events-none">
        <img alt="pattern" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD4V037pfPLp7dfFOnJJFwSFAn4tkEKj5epC_RhMw7AUd2U1FhQ5hQJsLTSjwpQx69Jq1NAkRvAAI-JlaruNpcCDLsrxN3n3qta6f6Emxyp75E9Afgj797R5kHXdqJJyAygd73uC7gE7dQfs6LiYSUvQO3Lwdo9PAuvwAc0rqNx0Fs_rcLGAwh3vLDQlkB99jLWCNp7ZKpXvFpJddtCSPqZVczSotNDWbh9J_l4aYO06qlIAKA2I1ioNTVRaDNdP3LMe8mH9fuhtXa1"/>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center gap-2 bg-primary/20 backdrop-blur-sm px-3 sm:px-4 py-1 sm:py-1.5 rounded-full mb-4 sm:mb-6 border border-primary/30">
                <span class="material-icons-outlined text-xs sm:text-sm text-primary">balance</span>
                <span class="text-[10px] sm:text-xs font-medium text-primary">Compare Trust Types</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 sm:mb-6 tracking-tight">Compare Trust Types</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 mb-6 sm:mb-8 lg:mb-10 max-w-2xl mx-auto font-medium px-2">Find the right trust for you and your family's future.</p>
            <a href="onboarding/onboarding.php" class="inline-block bg-primary text-navy-900 hover:opacity-90 px-6 sm:px-8 py-2.5 sm:py-3.5 rounded-xl font-bold text-sm sm:text-base transition-all shadow-xl shadow-primary/20 flex items-center justify-center gap-2 mx-auto w-auto max-w-xs">
                <span class="material-icons-outlined text-base sm:text-lg">rocket_launch</span>
                <span>Get Started</span>
            </a>
        </div>
    </div>
</section>
<section class="py-24 px-4 bg-white dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl md:text-4xl font-bold text-center mb-16 text-slate-900 dark:text-white">Trust Type Comparison</h2>
        <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <th class="py-6 px-8 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Feature</th>
                        <th class="py-6 px-8 text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white">Revocable</th>
                        <th class="py-6 px-8 text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white">Irrevocable</th>
                        <th class="py-6 px-8 text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white">Smart Contract</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-6 px-8 font-medium text-slate-700 dark:text-slate-300">Can be modified</td>
                        <td class="py-6 px-8">
                            <span class="material-icons-outlined text-emerald-500">check</span>
                        </td>
                        <td class="py-6 px-8">
                            <span class="material-icons-outlined text-rose-500">close</span>
                        </td>
                        <td class="py-6 px-8 text-slate-500">—</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-6 px-8 font-medium text-slate-700 dark:text-slate-300">Asset protection</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400">Moderate</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400 font-semibold">Maximum</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400 font-semibold text-primary">High</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-6 px-8 font-medium text-slate-700 dark:text-slate-300">Tax benefits</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400">Limited</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400 font-semibold">Significant</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400">Moderate</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-6 px-8 font-medium text-slate-700 dark:text-slate-300">Automation</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400">Manual</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400">Manual</td>
                        <td class="py-6 px-8 text-slate-600 dark:text-slate-400 font-semibold text-emerald-600">Automatic</td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/30 transition-colors">
                        <td class="py-6 px-8 font-medium text-slate-700 dark:text-slate-300">Starting price</td>
                        <td class="py-6 px-8 text-slate-900 dark:text-white font-bold">$299</td>
                        <td class="py-6 px-8 text-slate-900 dark:text-white font-bold">$599</td>
                        <td class="py-6 px-8 text-slate-900 dark:text-white font-bold">$499</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-12 text-center">
            <a href="onboarding/onboarding.php" class="inline-block bg-primary hover:bg-primary/90 text-white px-10 py-4 rounded-xl font-bold transition-all shadow-xl shadow-primary/20 transform hover:-translate-y-0.5">
                    Create Your Trust
                </a>
        </div>
    </div>
</section>
<section class="bg-primary/5 dark:bg-primary/10 py-20 px-4 border-y border-slate-100 dark:border-slate-800">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-6 text-slate-900 dark:text-white">Still Not Sure Which Is Right For You?</h2>
        <p class="text-lg text-slate-600 dark:text-slate-400 mb-10">Our legal experts are here to help you navigate the complexities of estate planning and choose the structure that best meets your needs.</p>
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <a href="contact_us.php" class="w-full sm:w-auto bg-primary text-white px-8 py-3.5 rounded-xl font-bold hover:bg-primary/90 transition-all">
                    Schedule a Free Consultation
                </a>
            <a href="learning_center_landing.php" class="w-full sm:w-auto bg-white dark:bg-slate-800 text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 px-8 py-3.5 rounded-xl font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                    View FAQ
                </a>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
