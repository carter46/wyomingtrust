<?php
// Expects: $cta_title; optional: $cta_subtitle, $cta_primary_href, $cta_primary_text, $cta_secondary_href, $cta_secondary_text
$cta_subtitle = $cta_subtitle ?? '';
$cta_primary_href = $cta_primary_href ?? 'onboarding/onboarding.php';
$cta_primary_text = $cta_primary_text ?? 'Create Your Trust';
$cta_secondary_href = $cta_secondary_href ?? 'onboarding/onboarding.php';
$cta_secondary_text = $cta_secondary_text ?? 'Create Your Will';
?>
<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-container-max mx-auto">
<div class="bg-secondary p-10 md:p-12 rounded-3xl text-center text-on-secondary shadow-xl relative overflow-hidden">
<div class="absolute top-0 right-0 p-8 opacity-10 pointer-events-none">
<span class="material-symbols-outlined text-[200px]">verified</span>
</div>
<div class="relative z-10 space-y-6">
<h2 class="font-display-lg text-display-lg"><?php echo escape_html($cta_title); ?></h2>
<?php if ($cta_subtitle): ?>
<p class="font-body-lg text-body-lg opacity-90 max-w-xl mx-auto"><?php echo escape_html($cta_subtitle); ?></p>
<?php endif; ?>
<div class="flex flex-col sm:flex-row justify-center gap-4 pt-2">
<a href="<?php echo escape_html($cta_primary_href); ?>" class="bg-white text-secondary px-10 py-4 rounded-xl font-label-md font-bold hover:bg-sky-accent transition-colors shadow-lg"><?php echo escape_html($cta_primary_text); ?></a>
<a href="<?php echo escape_html($cta_secondary_href); ?>" class="bg-primary text-on-primary px-10 py-4 rounded-xl font-label-md font-bold hover:opacity-90 transition-opacity"><?php echo escape_html($cta_secondary_text); ?></a>
</div>
</div>
</div>
</div>
</section>
