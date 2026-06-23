<?php
// Expects: $hero_title, $hero_subtitle; optional: $hero_label, $hero_bullets (array),
// $hero_cta_text, $hero_cta_href, $hero_secondary_text, $hero_secondary_href,
// $hero_image, $hero_image_alt, $hero_badge_value, $hero_badge_label
$hero_label = $hero_label ?? null;
$hero_bullets = $hero_bullets ?? [];
$hero_cta_href = $hero_cta_href ?? 'onboarding/onboarding.php';
$hero_cta_text = $hero_cta_text ?? 'Get Started';
$hero_image = $hero_image ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBvRYp0dvstYxodtw784FyHjyvs3SYAMkiRfoYQHJgKA99SXuN6Mup5mFrMly1F7PUfIAqsnyfEMTuCU9ZHfpeFHTiL2DOPIyAV1O5lDrlj3kb3hjXo6DvEYoxjPzmYmpE2Qb3r2qbmMRIQ02IbSnE9Tdl6dMgXmm6RaHoDHEwEoAvKeKjDhxsyykiax7teX-H95wWD6BvttSZscWlBLdN45H_cxhvLCoIEd_P64e3_GyXhpcegsVOBCwjYoEFReykqxcsl56gvXOc';
$hero_image_alt = $hero_image_alt ?? 'WyomingTrust estate planning';
?>
<section class="relative overflow-hidden bg-primary py-section-padding-lg px-gutter">
<div class="absolute inset-0 opacity-[0.07] pointer-events-none" style="background-image: radial-gradient(circle at 20% 50%, #B6D6F2 0%, transparent 50%), radial-gradient(circle at 80% 20%, #115cb9 0%, transparent 40%);"></div>
<div class="max-w-container-max mx-auto grid lg:grid-cols-2 gap-12 lg:gap-16 items-center relative z-10">
<div class="max-w-xl">
<?php if ($hero_label): ?>
<span class="inline-block px-3 py-1 rounded-full bg-secondary-fixed text-on-secondary-fixed font-label-sm text-label-sm uppercase tracking-wider mb-4"><?php echo escape_html($hero_label); ?></span>
<?php endif; ?>
<h1 class="font-display-lg text-display-lg text-on-primary leading-tight mb-4"><?php echo escape_html($hero_title); ?></h1>
<p class="font-body-lg text-body-lg text-sky-accent mb-6"><?php echo $hero_subtitle; ?></p>
<?php if (!empty($hero_bullets)): ?>
<ul class="space-y-3 mb-8">
<?php foreach ($hero_bullets as $bullet): ?>
<li class="flex items-start gap-3 text-on-primary-container font-body-md">
<span class="material-symbols-outlined text-sky-accent flex-shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span><?php echo escape_html($bullet); ?></span>
</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<div class="flex flex-col sm:flex-row gap-4">
<a href="<?php echo escape_html($hero_cta_href); ?>" class="inline-flex items-center justify-center gap-2 bg-secondary text-on-secondary px-8 py-4 rounded-xl font-bold hover:opacity-90 transition-opacity shadow-lg shadow-secondary/20">
<?php echo escape_html($hero_cta_text); ?>
<span class="material-symbols-outlined">arrow_forward</span>
</a>
<?php if (!empty($hero_secondary_text) && !empty($hero_secondary_href)): ?>
<a href="<?php echo escape_html($hero_secondary_href); ?>" class="inline-flex items-center justify-center gap-2 border-2 border-sky-accent text-sky-accent px-8 py-4 rounded-xl font-bold hover:bg-sky-accent/10 transition-colors">
<?php echo escape_html($hero_secondary_text); ?>
</a>
<?php endif; ?>
</div>
</div>
<div class="relative">
<div class="rounded-2xl overflow-hidden shadow-2xl border-4 border-white/10 aspect-[4/3]">
<img class="w-full h-full object-cover" src="<?php echo escape_html($hero_image); ?>" alt="<?php echo escape_html($hero_image_alt); ?>"/>
</div>
<?php if (!empty($hero_badge_value)): ?>
<div class="absolute -bottom-5 -left-5 bg-primary-container text-on-primary p-5 rounded-2xl shadow-xl border-4 border-white/10 hidden sm:flex items-center gap-4">
<div class="bg-secondary p-3 rounded-full">
<span class="material-symbols-outlined text-on-secondary text-2xl" style="font-variation-settings: 'FILL' 1;">verified</span>
</div>
<div>
<div class="text-2xl font-black leading-none text-on-primary"><?php echo escape_html($hero_badge_value); ?></div>
<?php if (!empty($hero_badge_label)): ?>
<div class="text-xs font-medium uppercase tracking-widest text-sky-accent mt-1"><?php echo escape_html($hero_badge_label); ?></div>
<?php endif; ?>
</div>
</div>
<?php endif; ?>
</div>
</div>
</section>
