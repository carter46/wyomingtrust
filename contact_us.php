<?php
$page_title = 'Contact Us | WyomingTrust';
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="relative overflow-hidden bg-primary py-section-padding-lg">
<div class="relative z-10 max-w-container-max mx-auto px-gutter text-center">
<h1 class="font-display-lg text-display-lg text-on-primary mb-6">How can we help?</h1>
<p class="font-body-lg text-body-lg text-sky-accent max-w-2xl mx-auto opacity-90">
                    Whether you're starting your legacy or managing an estate, our team and AI support are here to guide you every step of the way.
                </p>
</div>
</section>

<!-- Main Contact Grid -->
<section class="max-w-container-max mx-auto px-gutter -mt-16 relative z-20 pb-section-padding-lg">
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
<!-- Contact Form Column -->
<div class="lg:col-span-7 bg-surface-container-lowest rounded-xl p-8 md:p-12 shadow-xl border border-outline-variant/30">
<h2 class="font-headline-lg text-headline-lg text-primary mb-8">Send us a message</h2>
<form id="contactForm" action="#" class="space-y-6" method="POST">
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<div class="space-y-2">
<label class="font-label-md text-label-md text-on-surface-variant" for="first-name">First Name</label>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-secondary focus:ring-0 rounded-t-lg px-4 py-3 transition-colors" id="first-name" name="first-name" placeholder="Jane" type="text"/>
</div>
<div class="space-y-2">
<label class="font-label-md text-label-md text-on-surface-variant" for="last-name">Last Name</label>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-secondary focus:ring-0 rounded-t-lg px-4 py-3 transition-colors" id="last-name" name="last-name" placeholder="Doe" type="text"/>
</div>
</div>
<div class="space-y-2">
<label class="font-label-md text-label-md text-on-surface-variant" for="email">Email Address</label>
<input class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-secondary focus:ring-0 rounded-t-lg px-4 py-3 transition-colors" id="email" name="email" placeholder="jane@example.com" type="email"/>
</div>
<div class="space-y-2">
<label class="font-label-md text-label-md text-on-surface-variant" for="subject">Subject</label>
<select class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-secondary focus:ring-0 rounded-t-lg px-4 py-3 transition-colors" id="subject" name="subject">
<option>General Inquiry</option>
<option>Technical Support</option>
<option>Legal Question</option>
<option>Billing &amp; Pricing</option>
<option>Professional Partners</option>
</select>
</div>
<div class="space-y-2">
<label class="font-label-md text-label-md text-on-surface-variant" for="message">Message</label>
<textarea class="w-full bg-surface-container-low border-0 border-b-2 border-outline-variant focus:border-secondary focus:ring-0 rounded-t-lg px-4 py-3 transition-colors" id="message" name="message" placeholder="How can we assist you today?" rows="4"></textarea>
</div>
<button class="w-full bg-secondary text-on-secondary font-label-md text-label-md py-4 rounded-lg hover:shadow-lg transition-all flex items-center justify-center gap-2 group" type="submit">
                            Send Message
                            <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
</button>
</form>
</div>
<!-- Support Info Column -->
<div class="lg:col-span-5 space-y-6">
<div class="contact-card-hover bg-primary-container rounded-xl p-8 border border-on-primary-container/20">
<div class="flex items-start gap-4 mb-6">
<div class="bg-secondary p-3 rounded-full text-on-secondary">
<span class="material-symbols-outlined">smart_toy</span>
</div>
<div>
<h3 class="font-headline-md text-headline-md text-on-primary">Connect with AI Support</h3>
<p class="text-on-primary-container mt-2">Get instant answers to common questions about your estate plan 24/7.</p>
</div>
</div>
<a class="inline-flex items-center gap-2 text-sky-accent hover:underline font-label-md" href="compare_trust_types_page.php">
                            Compare Trust Types
                            <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
</a>
</div>
<div class="contact-card-hover bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/30">
<div class="flex items-start gap-4 mb-6">
<div class="bg-surface-container-high p-3 rounded-full text-secondary">
<span class="material-symbols-outlined">call</span>
</div>
<div>
<h3 class="font-headline-md text-headline-md text-primary">Call Support</h3>
<p class="text-on-surface-variant mt-2">Speak with our dedicated support team for complex inquiries.</p>
<p class="font-headline-md text-headline-md text-secondary mt-4 font-bold tracking-tight">1-800-Wyoming-TRUST</p>
</div>
</div>
<p class="text-label-sm text-on-surface-variant uppercase tracking-widest">Mon-Fri 9am-6pm EST</p>
</div>
<div class="contact-card-hover bg-surface-container-lowest rounded-xl p-8 border border-outline-variant/30">
<div class="flex items-start gap-4 mb-6">
<div class="bg-surface-container-high p-3 rounded-full text-secondary">
<span class="material-symbols-outlined">alternate_email</span>
</div>
<div>
<h3 class="font-headline-md text-headline-md text-primary">Email Support</h3>
<p class="text-on-surface-variant mt-2">Send us a detailed message and we'll respond within 24 hours.</p>
<p class="font-label-md text-secondary mt-4 font-bold">support@WyomingTrust.com</p>
</div>
</div>
</div>
</div>
</div>
</section>

<!-- Helpful Resources -->
<section class="bg-warm-cream py-section-padding-lg border-t border-outline-variant/20">
<div class="max-w-container-max mx-auto px-gutter text-center">
<span class="text-label-sm text-secondary font-bold uppercase tracking-[0.2em] mb-4 block">Resources</span>
<h2 class="font-headline-lg text-headline-lg text-primary mb-12">Explore our services</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
<a href="compare_trust_types_page.php" class="bg-surface rounded-xl p-6 shadow-sm border border-outline-variant/20 hover:border-secondary transition-colors group block">
<span class="material-symbols-outlined text-secondary mb-4 text-3xl">compare_arrows</span>
<h4 class="font-headline-md text-headline-md text-primary mb-2">Compare Trust Types</h4>
<p class="text-on-surface-variant mb-4">Side-by-side comparison of revocable, irrevocable, and smart contract trusts.</p>
<span class="text-secondary font-label-md flex items-center gap-1 group-hover:underline">
                            View Comparison <span class="material-symbols-outlined text-sm">chevron_right</span>
</span>
</a>
<a href="pricing.php" class="bg-surface rounded-xl p-6 shadow-sm border border-outline-variant/20 hover:border-secondary transition-colors group block">
<span class="material-symbols-outlined text-secondary mb-4 text-3xl">payments</span>
<h4 class="font-headline-md text-headline-md text-primary mb-2">Pricing</h4>
<p class="text-on-surface-variant mb-4">Transparent plans and starting prices for every trust type.</p>
<span class="text-secondary font-label-md flex items-center gap-1 group-hover:underline">
                            View Pricing <span class="material-symbols-outlined text-sm">chevron_right</span>
</span>
</a>
<a href="about_us.php" class="bg-surface rounded-xl p-6 shadow-sm border border-outline-variant/20 hover:border-secondary transition-colors group block">
<span class="material-symbols-outlined text-secondary mb-4 text-3xl">groups</span>
<h4 class="font-headline-md text-headline-md text-primary mb-2">About WyomingTrust</h4>
<p class="text-on-surface-variant mb-4">Learn about our mission and why families trust us with their estates.</p>
<span class="text-secondary font-label-md flex items-center gap-1 group-hover:underline">
                            About Us <span class="material-symbols-outlined text-sm">chevron_right</span>
</span>
</a>
</div>
</div>
</section>

<style>
.contact-card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.contact-card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px rgba(4, 22, 39, 0.08);
}
</style>

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Sending...';
    btn.classList.add('opacity-80');
    btn.disabled = true;

    setTimeout(() => {
        btn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Sent!';
        btn.classList.remove('bg-secondary', 'opacity-80');
        btn.classList.add('bg-green-600');

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('bg-green-600');
            btn.classList.add('bg-secondary');
            btn.disabled = false;
            this.reset();
        }, 2000);
    }, 1500);
});
</script>

<?php include 'includes/footer.php'; ?>
