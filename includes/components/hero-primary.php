<?php
// Expects: $hero_title, $hero_subtitle; optional: $hero_label, $hero_cta_href, $hero_cta_text, $hero_secondary_href, $hero_secondary_text
$hero_label = $hero_label ?? null;
$hero_cta_href = $hero_cta_href ?? 'onboarding/onboarding.php';
$hero_cta_text = $hero_cta_text ?? 'Get Started';
?>
<section class="relative overflow-hidden bg-primary py-section-padding-lg px-gutter">
<div class="max-w-container-max mx-auto text-center relative z-10">
<?php if ($hero_label): ?>
<span class="inline-block px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider mb-6"><?php echo escape_html($hero_label); ?></span>
<?php endif; ?>
<h1 class="font-display-lg text-display-lg text-on-primary mb-6 max-w-4xl mx-auto"><?php echo escape_html($hero_title); ?></h1>
<p class="font-body-lg text-body-lg text-sky-accent max-w-2xl mx-auto opacity-90 mb-8"><?php echo $hero_subtitle; ?></p>
<?php if (!empty($hero_cta_text)): ?>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a class="bg-secondary text-on-secondary px-8 py-4 rounded-lg font-bold inline-flex items-center justify-center gap-2 hover:opacity-90 transition-opacity" href="<?php echo escape_html($hero_cta_href); ?>">
<?php echo escape_html($hero_cta_text); ?>
<span class="material-symbols-outlined">arrow_forward</span>
</a>
<?php if (!empty($hero_secondary_text) && !empty($hero_secondary_href)): ?>
<a class="border-2 border-sky-accent text-sky-accent px-8 py-4 rounded-lg font-bold inline-flex items-center justify-center hover:bg-sky-accent/10 transition-all" href="<?php echo escape_html($hero_secondary_href); ?>">
<?php echo escape_html($hero_secondary_text); ?>
</a>
<?php endif; ?>
</div>
<?php endif; ?>
</div>
</section>
