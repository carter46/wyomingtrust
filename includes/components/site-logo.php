<?php
// Optional: $logo_class for wrapper, $logo_text_class for wordmark
$logo_class = $logo_class ?? 'flex items-center gap-2.5';
$logo_text_class = $logo_text_class ?? 'font-headline-md text-headline-md font-bold text-primary';
$logo_href = $logo_href ?? asset_url('index.php');
?>
<a href="<?php echo escape_html($logo_href); ?>" class="<?php echo escape_html($logo_class); ?>">
<span class="flex-shrink-0 w-9 h-9 rounded-lg bg-[#16a34a] flex items-center justify-center shadow-sm" aria-hidden="true">
<svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2.25L4.5 5.75V11.25C4.5 16.04 7.73 20.36 12 21.75C16.27 20.36 19.5 16.04 19.5 11.25V5.75L12 2.25Z" fill="white"/>
<path d="M9.75 12.25L11.1 13.85L14.55 10.1" stroke="#16a34a" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
<span class="<?php echo escape_html($logo_text_class); ?>">WyomingTrust</span>
</a>
