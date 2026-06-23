<?php
$page_title = 'Smart Contract Trust - WyomingTrust';
include 'includes/header.php';

$hero_label = 'Fully Automated';
$hero_title = 'Smart Contract Trust';
$hero_subtitle = 'Automated, self-executing trusts powered by blockchain technology — no intermediaries, no delays, no disputes.';
$hero_bullets = [
    'Self-executing contracts when conditions are met',
    'Full transparency with on-chain audit trails',
    'Eliminate trustee fees and probate costs',
];
$hero_cta_text = 'Create Smart Contract Trust';
$hero_cta_href = 'onboarding/onboarding.php';
$hero_secondary_text = 'Compare Trust Types';
$hero_secondary_href = 'compare_trust_types_page.php';
$hero_badge_value = '$499';
$hero_badge_label = 'Starting Price';
$hero_image = 'https://lh3.googleusercontent.com/aida-public/AB1WRLsd2Y5kwnSOihFhXNRim1IXArn6wVbsZ1IAFPgjIn4xj-ClwpECLJkqzklWqjcd_ds-kFSN_YLfHnZxKlzf6hlQrIfQkFarMutwWSw-4o4yyHv5qhK8WRqFXPaf4FoIHlOP4aM0eqTMmg0Sn6JC9igCp4KvJV7hxRe22pEt4vwsuh8P_5bFigc6cVhXfwfpTRNF7f5SQN0j5lwktNO5MIot9m0hME2o6JIvXP90vNythi1cZr23SGxV7g0';
include 'includes/components/service-hero-split.php';
?>

<!-- Overview -->
<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
<div class="space-y-6">
<span class="inline-block px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider">Overview</span>
<h2 class="font-headline-lg text-headline-lg text-primary">What is a Smart Contract Trust?</h2>
<div class="space-y-4 font-body-md text-body-md text-on-surface-variant leading-relaxed">
<p>A smart contract trust uses blockchain technology to automate trust execution. Your wishes are encoded into self-executing smart contracts that automatically transfer assets to beneficiaries when predetermined conditions are met.</p>
<p>No lawyers, no executors, no delays. The smart contract monitors the blockchain and executes distributions exactly as programmed, with complete transparency and zero human intervention.</p>
<p>Perfect for tech-savvy individuals who want maximum automation, transparency, and cost-efficiency in their estate planning.</p>
</div>
<a href="onboarding/onboarding.php" class="inline-flex items-center gap-2 text-secondary font-label-md font-bold hover:underline">
Deploy your smart contract trust
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<div class="bg-primary-container p-8 md:p-10 rounded-2xl border border-white/10 shadow-xl">
<h3 class="font-headline-md text-headline-md text-sky-accent mb-8">How It Works</h3>
<div class="space-y-6">
<?php
$how = [
    ['num' => '1', 'title' => 'Define Conditions', 'desc' => 'Set triggers like death certificate, time delays, or milestones.'],
    ['num' => '2', 'title' => 'Deploy Contract', 'desc' => 'Smart contract is deployed to the blockchain permanently.'],
    ['num' => '3', 'title' => 'Auto-Execution', 'desc' => 'When conditions are met, assets transfer automatically.'],
];
foreach ($how as $h):
?>
<div class="flex gap-5">
<div class="flex-shrink-0 w-10 h-10 bg-secondary text-on-secondary rounded-xl flex items-center justify-center font-bold"><?php echo $h['num']; ?></div>
<div>
<h4 class="font-headline-md text-headline-md text-on-primary mb-1"><?php echo $h['title']; ?></h4>
<p class="font-body-md text-body-md text-on-primary-container"><?php echo $h['desc']; ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
</div>
</div>
</section>

<!-- Features -->
<section class="py-section-padding-lg px-gutter bg-warm-cream">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg text-primary mb-3">Smart Contract Features</h2>
<p class="font-body-md text-body-md text-on-surface-variant">The future of automated estate planning</p>
</div>
<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php
$features = [
    ['icon' => 'bolt', 'title' => 'Instant Execution', 'desc' => 'No waiting for probate or executor decisions. Transfers happen immediately when conditions are met.'],
    ['icon' => 'visibility', 'title' => 'Full Transparency', 'desc' => 'All transactions recorded on the blockchain—completely transparent and auditable.'],
    ['icon' => 'lock', 'title' => 'Immutable', 'desc' => 'Once deployed, the contract cannot be altered, ensuring your wishes are honored without dispute.'],
    ['icon' => 'payments', 'title' => 'Cost-Effective', 'desc' => 'Eliminate ongoing trustee fees, executor commissions, and expensive probate costs.'],
    ['icon' => 'settings_suggest', 'title' => 'Complex Logic', 'desc' => 'Sophisticated distribution rules based on multiple conditions, time frames, and triggers.'],
    ['icon' => 'language', 'title' => 'Global Access', 'desc' => 'Beneficiaries anywhere in the world receive their inheritance automatically.'],
];
foreach ($features as $f):
?>
<div class="bg-surface-container-lowest p-8 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-md hover:border-secondary/30 transition-all">
<div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center text-on-secondary mb-5">
<span class="material-symbols-outlined"><?php echo $f['icon']; ?></span>
</div>
<h4 class="font-headline-md text-headline-md text-primary mb-3"><?php echo $f['title']; ?></h4>
<p class="font-body-md text-body-md text-on-surface-variant"><?php echo $f['desc']; ?></p>
</div>
<?php endforeach; ?>
</div>
</div>
</section>

<!-- Highlight -->
<section class="py-section-padding-lg px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-12 items-center">
<div>
<h2 class="font-headline-lg text-headline-lg mb-4">Code Your Legacy.<br/><span class="text-sky-accent">Execute Automatically.</span></h2>
<p class="font-body-lg text-body-lg text-on-primary-container mb-6">Smart contract trusts remove human error and delay from estate distribution. Your beneficiaries receive exactly what you intended, when you intended — enforced by immutable blockchain code.</p>
<ul class="space-y-3">
<?php foreach (['No executor fees or delays', 'On-chain proof of every transaction', 'Works across borders and jurisdictions', 'Integrates with major blockchains'] as $item): ?>
<li class="flex items-center gap-3 text-on-primary-container font-body-md">
<span class="material-symbols-outlined text-sky-accent" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<?php echo $item; ?>
</li>
<?php endforeach; ?>
</ul>
</div>
<div class="bg-primary-container p-8 rounded-2xl border border-white/10">
<div class="font-mono text-sm text-sky-accent/80 space-y-2 p-4 bg-primary rounded-xl border border-white/5">
<div><span class="text-on-primary-container">contract</span> <span class="text-sky-accent">WyomingTrust</span> {</div>
<div class="pl-4"><span class="text-on-primary-container">function</span> <span class="text-sky-accent">distribute</span>() {</div>
<div class="pl-8 text-on-primary-container">// Auto-execute on trigger</div>
<div class="pl-8 text-on-primary-container">transfer(beneficiary, amount);</div>
<div class="pl-4">}</div>
<div>}</div>
</div>
<p class="font-body-md text-body-md text-on-primary-container mt-4 text-center">Simplified illustration — your trust is legally structured and blockchain-enforced.</p>
</div>
</div>
</section>

<?php
$cta_title = 'The Future of Estate Planning';
$cta_subtitle = 'Smart contract trust starting at $499';
$cta_primary_text = 'Deploy Your Smart Contract';
$cta_primary_href = 'onboarding/onboarding.php';
$cta_secondary_text = '';
include 'includes/components/cta-banner.php';

$current_service = 'smart_contract';
include 'includes/components/service-explore.php';
?>

<?php include 'includes/footer.php'; ?>
