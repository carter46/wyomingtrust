<?php
// Expects: $faq_title, $faq_items (array of ['question' => '', 'answer' => '']), optional: $faq_id
$faq_id = $faq_id ?? 'faqAccordion';
$faq_title = $faq_title ?? 'Common questions.';
?>
<section class="py-section-padding-lg px-gutter bg-surface">
<div class="max-w-3xl mx-auto">
<div class="text-center mb-12">
<h2 class="font-headline-lg text-headline-lg text-primary"><?php echo escape_html($faq_title); ?></h2>
</div>
<div class="space-y-4" id="<?php echo escape_html($faq_id); ?>">
<?php foreach ($faq_items as $item): ?>
<details class="group bg-white rounded-xl border border-outline-variant/30 overflow-hidden">
<summary class="flex justify-between items-center p-6 cursor-pointer">
<span class="font-bold text-lg pr-4"><?php echo escape_html($item['question']); ?></span>
<span class="material-symbols-outlined transition-transform group-open:rotate-180 flex-shrink-0">expand_more</span>
</summary>
<div class="px-6 pb-6 text-on-surface-variant font-body-md"><?php echo $item['answer']; ?></div>
</details>
<?php endforeach; ?>
</div>
</div>
</section>
<script>
(function() {
    const accordion = document.getElementById(<?php echo json_encode($faq_id); ?>);
    if (!accordion) return;
    accordion.querySelectorAll('details').forEach((el) => {
        el.addEventListener('toggle', () => {
            if (el.open) {
                accordion.querySelectorAll('details').forEach((other) => {
                    if (other !== el) other.open = false;
                });
            }
        });
    });
})();
</script>
