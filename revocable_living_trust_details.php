<?php
$page_title = 'Revocable Living Trust - WyomingTrust';
include 'includes/header.php';

$hero_label = 'Most Popular Choice';
$hero_title = 'Revocable Living Trust';
$hero_subtitle = 'Maintain full control of your crypto assets while ensuring smooth transfer to beneficiaries — no probate required.';
$hero_bullets = [
    'Modify or revoke anytime during your lifetime',
    'Assets transfer immediately to beneficiaries',
    'Complete privacy — trusts are not public record',
];
$hero_cta_text = 'Create Your Trust Now';
$hero_cta_href = 'onboarding/onboarding.php';
$hero_secondary_text = 'Compare Trust Types';
$hero_secondary_href = 'compare_trust_types_page.php';
$hero_badge_value = '$299';
$hero_badge_label = 'Starting Price';
include 'includes/components/service-hero-split.php';
?>

<!-- Overview -->
<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
<div class="space-y-6">
<span class="inline-block px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider">Overview</span>
<h2 class="font-headline-lg text-headline-lg text-primary">What is a Revocable Trust?</h2>
<div class="space-y-4 font-body-md text-body-md text-on-surface-variant leading-relaxed">
<p>A revocable living trust is a legal entity you create during your lifetime to hold and manage your cryptocurrency assets. As the grantor, you maintain complete control and can modify or dissolve the trust at any time while you're alive and competent.</p>
<p>Unlike a will, a revocable trust allows your crypto assets to pass directly to beneficiaries without probate, saving time, money, and maintaining privacy. You serve as the trustee during your lifetime.</p>
<p>When you pass away or become incapacitated, your chosen successor trustee takes over, executing your wishes exactly as specified in the trust document.</p>
</div>
</div>
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-white/10 shadow-xl">
<h3 class="font-headline-md text-headline-md text-sky-accent mb-8">Key Features</h3>
<div class="space-y-5">
<?php
$features = [
    ['title' => 'Full Control', 'desc' => 'Modify, amend, or revoke anytime during your lifetime'],
    ['title' => 'Avoid Probate', 'desc' => 'Assets transfer immediately to beneficiaries'],
    ['title' => 'Privacy', 'desc' => 'Unlike wills, trusts remain private and not public record'],
    ['title' => 'Incapacity Planning', 'desc' => 'Successor trustee manages assets if you\'re unable to'],
];
foreach ($features as $f):
?>
<div class="flex gap-4">
<div class="flex-shrink-0 w-8 h-8 bg-secondary rounded-full flex items-center justify-center text-on-secondary">
<span class="material-symbols-outlined text-sm" style="font-variation-settings: 'FILL' 1;">check</span>
</div>
<div>
<h4 class="font-headline-md text-headline-md text-on-primary"><?php echo $f['title']; ?></h4>
<p class="font-body-md text-body-md text-on-primary-container"><?php echo $f['desc']; ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</section>

<!-- Benefits -->
<section class="py-section-padding-lg px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg text-primary mb-3">Benefits of a Revocable Trust</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Why thousands choose revocable trusts for their crypto assets</p>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php
$benefits = [
    ['icon' => 'gavel', 'title' => 'Avoid Probate Court', 'desc' => 'Bypass probate entirely, saving beneficiaries months of legal proceedings and thousands in court fees.'],
    ['icon' => 'group', 'title' => 'Maintain Privacy', 'desc' => 'Trusts remain completely private. Your crypto holdings and beneficiaries stay confidential.'],
    ['icon' => 'tune', 'title' => 'Maximum Flexibility', 'desc' => 'Change beneficiaries, update allocations, or modify terms anytime as life changes.'],
    ['icon' => 'monitor_heart', 'title' => 'Incapacity Protection', 'desc' => 'Successor trustee seamlessly takes over without court intervention if you\'re unable to manage assets.'],
    ['icon' => 'bolt', 'title' => 'Immediate Transfer', 'desc' => 'Beneficiaries receive crypto assets immediately upon your passing—no waiting for probate.'],
    ['icon' => 'verified_user', 'title' => 'Harder to Contest', 'desc' => 'Trusts are more difficult to challenge than wills, better protecting your wishes.'],
];
foreach ($benefits as $b):
?>
<div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-md hover:border-secondary/30 transition-all">
<div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-on-secondary mb-5">
<span class="material-symbols-outlined"><?php echo $b['icon']; ?></span>
</div>
<h3 class="font-headline-md text-headline-md text-primary mb-3"><?php echo $b['title']; ?></h3>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed"><?php echo $b['desc']; ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- How It Works -->
<section class="py-section-padding-lg px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg mb-3">How It Works</h2>
<p class="font-body-md text-body-md text-on-primary-container">Create your revocable trust in four simple steps</p>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
<?php
$steps = [
    ['num' => '1', 'title' => 'Setup Trust Details', 'desc' => 'Name your trust, appoint yourself as trustee, and designate a successor trustee.'],
    ['num' => '2', 'title' => 'Add Crypto Assets', 'desc' => 'Transfer Bitcoin, Ethereum, and other cryptocurrencies via secure integration.'],
    ['num' => '3', 'title' => 'Name Beneficiaries', 'desc' => 'Specify who receives what, when, and under what conditions.'],
    ['num' => '4', 'title' => 'Sign & Activate', 'desc' => 'Digital signature deploys your trust, making it legally binding.'],
];
foreach ($steps as $step):
?>
<div class="bg-primary-container p-6 rounded-2xl border border-white/10 text-center">
<div class="w-12 h-12 bg-secondary text-on-secondary rounded-xl flex items-center justify-center text-lg font-bold mx-auto mb-4"><?php echo $step['num']; ?></div>
<h3 class="font-headline-md text-headline-md text-sky-accent mb-2"><?php echo $step['title']; ?></h3>
<p class="font-body-md text-body-md text-on-primary-container text-sm"><?php echo $step['desc']; ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<?php
$cta_title = 'Ready to Create Your Revocable Trust?';
$cta_subtitle = 'Starting at $299 — complete setup in under 15 minutes';
$cta_primary_text = 'Get Started Now';
$cta_primary_href = 'onboarding/onboarding.php';
$cta_secondary_text = '';
include 'includes/components/cta-banner.php';
?>

<section class="py-section-padding-md px-gutter bg-surface">
<div class="max-w-container-max mx-auto">
<div class="flex flex-wrap justify-center gap-6 md:gap-10">
<span class="flex items-center gap-2 font-body-md text-on-surface-variant"><span class="material-symbols-outlined text-secondary">security</span> Blockchain secured</span>
<span class="flex items-center gap-2 font-body-md text-on-surface-variant"><span class="material-symbols-outlined text-secondary">verified</span> Legally compliant</span>
<span class="flex items-center gap-2 font-body-md text-on-surface-variant"><span class="material-symbols-outlined text-secondary">credit_card_off</span> No credit card required</span>
</div>
</div>
</section>

<?php
$current_service = 'revocable';
include 'includes/components/service-explore.php';
?>

<?php include 'includes/footer.php'; ?>
