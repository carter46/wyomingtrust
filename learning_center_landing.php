<?php
$page_title = 'Learning Center | WyomingTrust';
include 'includes/header.php';
?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#7C3AED", // Vibrant Purple from the screenshots
                        "background-light": "#FFFFFF",
                        "background-dark": "#0F172A",
                    },
                    fontFamily: {
                        display: ["Inter", "sans-serif"],
                    },
                    borderRadius: {
                        DEFAULT: "0.5rem",
                    },
                },
            },
        };
    </script>
<style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .hero-gradient {
            background: linear-gradient(135deg, #2563EB 0%, #0D9488 100%);
        }
    </style>
<section class="hero-gradient text-white py-24 sm:py-32 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 px-4 py-1.5 rounded-full mb-8">
            <span class="material-icons-outlined text-sm">school</span>
            <span class="text-xs font-semibold tracking-wider uppercase">Learning Center</span>
        </div>
        <h1 class="text-5xl sm:text-7xl font-extrabold tracking-tight mb-6">
                Learning Center
            </h1>
        <p class="text-xl sm:text-2xl text-blue-50/90 max-w-2xl mx-auto mb-12">
                Master crypto estate planning with our expert-led resources and comprehensive guides.
            </p>
        <div class="flex justify-center">
            <a href="onboarding/onboarding.php" class="bg-white text-primary hover:bg-blue-50 px-8 py-3.5 rounded-xl font-bold text-lg shadow-xl shadow-black/10 transition-all flex items-center gap-2 group">
                <span class="material-icons-outlined group-hover:translate-x-1 transition-transform">rocket_launch</span>
                    Get Started
                </a>
        </div>
    </div>
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-[600px] h-[600px] bg-white/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-[400px] h-[400px] bg-teal-400/10 rounded-full blur-3xl"></div>
</section>
<section class="py-24 bg-background-light dark:bg-background-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-5xl font-extrabold text-slate-900 dark:text-white mb-4">
                Educational Resources
            </h2>
        <p class="text-lg sm:text-xl text-slate-500 dark:text-slate-400 max-w-3xl mx-auto mb-16">
                Comprehensive guides and tutorials coming soon. Our experts are crafting the most detailed repository for blockchain estate planning.
            </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 animate-pulse">
                <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 rounded-lg mb-4"></div>
                <div class="h-6 bg-slate-200 dark:bg-slate-700 rounded-full w-3/4 mb-4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-full"></div>
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-5/6"></div>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 animate-pulse">
                <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 rounded-lg mb-4"></div>
                <div class="h-6 bg-slate-200 dark:bg-slate-700 rounded-full w-3/4 mb-4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-full"></div>
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-5/6"></div>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/50 p-8 rounded-2xl border border-slate-200 dark:border-slate-800 animate-pulse">
                <div class="w-12 h-12 bg-slate-200 dark:bg-slate-700 rounded-lg mb-4"></div>
                <div class="h-6 bg-slate-200 dark:bg-slate-700 rounded-full w-3/4 mb-4"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-full"></div>
                    <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded-full w-5/6"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include 'includes/footer.php'; ?>
