<?php
// Expects: $current_service — one of: crypto, irrevocable, revocable, smart_contract, llc
$services = [
    ['key' => 'crypto', 'href' => 'crypto_asset_trust_service.php', 'icon' => 'wallet', 'title' => 'Crypto Asset Trust', 'desc' => 'Blockchain-native security for digital wealth'],
    ['key' => 'irrevocable', 'href' => 'irrevocable_trust_service.php', 'icon' => 'lock', 'title' => 'Irrevocable Trust', 'desc' => 'Maximum asset protection and tax benefits'],
    ['key' => 'revocable', 'href' => 'revocable_living_trust_details.php', 'icon' => 'edit', 'title' => 'Revocable Living Trust', 'desc' => 'Flexible control with probate avoidance'],
    ['key' => 'smart_contract', 'href' => 'smart_contract_trust_service.php', 'icon' => 'link', 'title' => 'Smart Contract Trust', 'desc' => 'Automated execution on the blockchain'],
    ['key' => 'llc', 'href' => 'trust_llc.php', 'icon' => 'group', 'title' => 'Wyoming LLC', 'desc' => 'Business formation and asset protection'],
];
$current = $current_service ?? '';
?>
<section class="py-section-padding-lg px-gutter bg-primary text-on-primary">
<div class="max-w-container-max mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg text-on-primary mb-3">Explore Other Trust Services</h2>
<p class="font-body-md text-body-md text-on-primary-container max-w-2xl mx-auto">Find the right structure for your estate plan and digital assets.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
<?php foreach ($services as $svc): if ($svc['key'] === $current) continue; ?>
<a href="<?php echo escape_html($svc['href']); ?>" class="bg-primary-container p-6 rounded-2xl border border-white/10 hover:border-sky-accent transition-colors group flex flex-col h-full">
<?php echo wt_icon($svc['icon'], 'text-sky-accent text-3xl mb-4'); ?>
<h3 class="font-headline-md text-headline-md text-sky-accent mb-2 group-hover:underline"><?php echo escape_html($svc['title']); ?></h3>
<p class="font-body-md text-body-md text-on-primary-container flex-grow"><?php echo escape_html($svc['desc']); ?></p>
<span class="inline-flex items-center text-sky-accent font-label-md mt-4 group-hover:gap-2 transition-all">
Learn more <?php echo wt_icon('arrow-forward', 'text-[18px] ml-1'); ?>
</span>
</a>
<?php endforeach; ?>
</div>
<div class="text-center mt-10">
<a href="compare_trust_types_page.php" class="inline-flex items-center gap-2 text-sky-accent font-label-md font-bold hover:underline">
Compare all trust types
<?php echo wt_icon('info', 'text-[18px]'); ?>
</a>
</div>
</div>
</section>
