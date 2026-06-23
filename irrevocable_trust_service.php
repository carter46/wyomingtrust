<?php
$page_title = 'Irrevocable Trust - WyomingTrust';
include 'includes/header.php';

$hero_label = 'Maximum Protection';
$hero_title = 'Irrevocable Trust';
$hero_subtitle = 'Ultimate asset protection, tax benefits, and creditor shielding for your crypto wealth and long-term legacy.';
$hero_bullets = [
    'Maximum protection from creditors and lawsuits',
    'Significant estate and gift tax advantages',
    'Permanent asset shielding for beneficiaries',
];
$hero_cta_text = 'Create Your Trust Now';
$hero_cta_href = 'onboarding/onboarding.php';
$hero_secondary_text = 'Compare Trust Types';
$hero_secondary_href = 'compare_trust_types_page.php';
$hero_badge_value = '$599';
$hero_badge_label = 'Starting Price';
include 'includes/components/service-hero-split.php';
?>

<!-- Overview -->
<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
<div class="space-y-6">
<span class="inline-block px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider">Overview</span>
<h2 class="font-headline-lg text-headline-lg text-primary">What is an Irrevocable Trust?</h2>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
An irrevocable trust is a powerful legal structure where you permanently transfer ownership of your cryptocurrency assets into the trust. Once established, the trust terms generally cannot be modified or revoked without beneficiary consent, providing maximum asset protection.
</p>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
By removing assets from your personal estate, an irrevocable trust offers unparalleled protection from creditors, lawsuits, and estate taxes. Your crypto holdings are shielded in a separate legal entity, safeguarded for your beneficiaries' future.
</p>
<p class="font-body-md text-body-md text-on-surface-variant leading-relaxed">
Ideal for high-net-worth individuals, those facing litigation risks, or anyone seeking maximum tax efficiency for substantial crypto portfolios.
</p>
</div>
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-white/10 shadow-xl">
<h3 class="font-headline-md text-headline-md text-sky-accent mb-8">Key Features</h3>
<div class="space-y-6">
<?php
$features = [
    ['icon' => 'shield', 'title' => 'Asset Protection', 'desc' => 'Maximum protection from creditors and legal judgments'],
    ['icon' => 'percent', 'title' => 'Tax Benefits', 'desc' => 'Significant estate and gift tax advantages'],
    ['icon' => 'group', 'title' => 'Medicaid Planning', 'desc' => 'Protect assets while qualifying for benefits'],
    ['icon' => 'lock', 'title' => 'Permanent Protection', 'desc' => 'Once established, assets are permanently protected'],
];
foreach ($features as $f):
?>
<div class="flex gap-4">
<div class="w-12 h-12 shrink-0 bg-secondary rounded-xl flex items-center justify-center text-on-secondary">
<span class="material-symbols-outlined"><?php echo $f['icon']; ?></span>
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
<h2 class="font-headline-lg text-headline-lg text-primary mb-3">Benefits of an Irrevocable Trust</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">Why high-net-worth individuals choose irrevocable trusts</p>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php
$benefits = [
    ['icon' => 'security', 'title' => 'Creditor Protection', 'desc' => 'Assets are protected from creditors, lawsuits, and bankruptcy—they\'re no longer part of your personal estate.'],
    ['icon' => 'trending_down', 'title' => 'Estate Tax Reduction', 'desc' => 'Remove appreciating crypto from your taxable estate, potentially saving millions in estate taxes.'],
    ['icon' => 'medical_information', 'title' => 'Medicaid Eligibility', 'desc' => 'Properly structured trusts can help qualify for Medicaid while preserving wealth for beneficiaries.'],
    ['icon' => 'family_history', 'title' => 'Generation Planning', 'desc' => 'Create lasting wealth for multiple generations with precise distribution control.'],
    ['icon' => 'gavel', 'title' => 'Lawsuit Protection', 'desc' => 'Shield crypto from malpractice and personal injury claims—ideal for high-liability professions.'],
    ['icon' => 'volunteer_activism', 'title' => 'Charitable Giving', 'desc' => 'Combine asset protection with philanthropy through charitable remainder trusts.'],
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

<!-- Stats strip -->
<section class="py-section-padding-md px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
<div>
<div class="font-display-lg text-display-lg text-sky-accent mb-1">100%</div>
<p class="font-body-md text-body-md text-on-primary-container">Creditor shield when properly structured</p>
</div>
<div>
<div class="font-display-lg text-display-lg text-sky-accent mb-1">$0</div>
<p class="font-body-md text-body-md text-on-primary-container">Probate costs for trust-held assets</p>
</div>
<div>
<div class="font-display-lg text-display-lg text-sky-accent mb-1">24/7</div>
<p class="font-body-md text-body-md text-on-primary-container">Expert trust specialist support</p>
</div>
</div>
</section>

<?php
$cta_title = 'Ready for Maximum Protection?';
$cta_subtitle = 'Starting at $599 — includes legal consultation';
$cta_primary_text = 'Create Irrevocable Trust';
$cta_primary_href = 'onboarding/onboarding.php';
$cta_secondary_text = '';
include 'includes/components/cta-banner.php';
?>

<section class="py-section-padding-md px-gutter bg-surface border-t border-outline-variant/20">
<div class="max-w-container-max mx-auto text-center">
<div class="inline-flex items-center gap-3 bg-secondary-fixed text-on-secondary-fixed px-6 py-3 rounded-xl">
<span class="material-symbols-outlined text-secondary">call</span>
<span class="font-body-md text-body-md text-primary font-medium">Speak with a trust specialist: 1-800-Wyoming-TRUST</span>
</div>
</div>
</section>

<?php
$current_service = 'irrevocable';
include 'includes/components/service-explore.php';
?>

<?php include 'includes/footer.php'; ?>
