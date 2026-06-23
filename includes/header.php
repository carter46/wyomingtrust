<?php
require_once __DIR__ . '/../api/helpers.php';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$service_pages = [
    'crypto_asset_trust_service',
    'irrevocable_trust_service',
    'revocable_living_trust_details',
    'smart_contract_trust_service',
    'trust_llc',
    'compare_trust_types_page',
];
$is_service_page = in_array($current_page, $service_pages, true);
$nav_active = function ($page) use ($current_page) {
    return $current_page === $page ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-secondary transition-colors';
};
?>
<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo isset($page_title) ? escape_html($page_title) : 'WyomingTrust | Secure Your Digital Legacy'; ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "inverse-surface": "#2e3132",
                        "on-secondary": "#ffffff",
                        "on-background": "#191c1d",
                        "warm-cream": "#FEFDF3",
                        "on-secondary-container": "#003370",
                        "error": "#ba1a1a",
                        "on-primary-fixed": "#0b1d2d",
                        "primary-container": "#1a2b3c",
                        "secondary-fixed-dim": "#acc7ff",
                        "on-tertiary": "#ffffff",
                        "tertiary-fixed": "#d4e7db",
                        "background": "#f8f9fa",
                        "primary-fixed-dim": "#b7c8de",
                        "inverse-primary": "#b7c8de",
                        "tertiary-container": "#1d2d25",
                        "secondary-container": "#659dfe",
                        "surface-container-lowest": "#ffffff",
                        "secondary": "#115cb9",
                        "on-surface": "#191c1d",
                        "secondary-fixed": "#d7e2ff",
                        "on-error": "#ffffff",
                        "surface-container-low": "#f3f4f5",
                        "sky-accent": "#B6D6F2",
                        "deep-forest": "#2D4B3F",
                        "surface-variant": "#e1e3e4",
                        "plum-shadow": "#341B2F",
                        "error-container": "#ffdad6",
                        "surface-tint": "#4f6073",
                        "inverse-on-surface": "#f0f1f2",
                        "surface-container-highest": "#e1e3e4",
                        "outline-variant": "#c4c6cd",
                        "on-secondary-fixed-variant": "#004491",
                        "primary": "#041627",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#b8cbc0",
                        "surface": "#f8f9fa",
                        "on-primary": "#ffffff",
                        "on-tertiary-container": "#83958b",
                        "tertiary": "#081812",
                        "outline": "#74777d",
                        "surface-dim": "#d9dadb",
                        "on-secondary-fixed": "#001a40",
                        "surface-container-high": "#e7e8e9",
                        "on-primary-fixed-variant": "#38485a",
                        "on-tertiary-fixed": "#0f1f18",
                        "surface-container": "#edeeef",
                        "on-surface-variant": "#44474c",
                        "primary-fixed": "#d2e4fb",
                        "on-tertiary-fixed-variant": "#3a4a42",
                        "surface-bright": "#f8f9fa",
                        "on-primary-container": "#8192a7"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px"
                    },
                    maxWidth: {
                        "container-max": "1200px"
                    },
                    spacing: {
                        "container-max": "1200px",
                        "section-padding-md": "48px",
                        "margin-mobile": "16px",
                        "stack-gap": "16px",
                        "section-padding-lg": "80px",
                        "gutter": "24px"
                    },
                    fontFamily: {
                        "headline-lg-mobile": ["\"Source Serif 4\"", "serif"],
                        "headline-lg": ["\"Source Serif 4\"", "serif"],
                        "display-lg": ["\"Source Serif 4\"", "serif"],
                        "label-sm": ["DM Sans", "sans-serif"],
                        "label-md": ["DM Sans", "sans-serif"],
                        "body-md": ["DM Sans", "sans-serif"],
                        "headline-md": ["\"Source Serif 4\"", "serif"],
                        "body-lg": ["DM Sans", "sans-serif"]
                    },
                    fontSize: {
                        "headline-lg-mobile": ["28px", { lineHeight: "36px", fontWeight: "600" }],
                        "headline-lg": ["32px", { lineHeight: "40px", fontWeight: "600" }],
                        "display-lg": ["48px", { lineHeight: "56px", letterSpacing: "-0.02em", fontWeight: "700" }],
                        "label-sm": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "700" }],
                        "label-md": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "500" }],
                        "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "headline-md": ["24px", { lineHeight: "32px", fontWeight: "600" }],
                        "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }]
                    }
                }
            }
        };
    </script>
<style>
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        details > summary { list-style: none; }
        details > summary::-webkit-details-marker { display: none; }
    </style>
</head>
<body class="bg-background text-on-background font-body-md">
<header class="fixed top-0 left-0 right-0 z-50 bg-surface shadow-sm h-20 flex items-center">
<div class="flex justify-between items-center w-full px-gutter max-w-container-max mx-auto h-20">
<a href="index.php" class="font-headline-md text-headline-md font-bold text-primary">WyomingTrust</a>
<nav class="hidden lg:flex gap-8 items-center font-label-md text-label-md">
<div class="relative group">
<a class="<?php echo $is_service_page ? 'text-secondary font-bold' : 'text-on-surface-variant hover:text-secondary'; ?> transition-colors cursor-pointer flex items-center gap-1" href="#">
Services
<span class="material-symbols-outlined text-[18px]">expand_more</span>
</a>
<div class="absolute top-full left-0 mt-2 w-64 bg-surface-container-lowest rounded-xl shadow-xl border border-outline-variant/30 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
<div class="py-2">
<a href="irrevocable_trust_service.php" class="block px-4 py-2 text-sm text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-colors">Irrevocable Trust</a>
<a href="revocable_living_trust_details.php" class="block px-4 py-2 text-sm text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-colors">Revocable Living Trust</a>
<a href="crypto_asset_trust_service.php" class="block px-4 py-2 text-sm text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-colors">Crypto Asset Trust</a>
<a href="smart_contract_trust_service.php" class="block px-4 py-2 text-sm text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-colors">Smart Contract Trust</a>
<a href="trust_llc.php" class="block px-4 py-2 text-sm text-on-surface-variant hover:text-secondary hover:bg-surface-container-low transition-colors">Wyoming LLC</a>
</div>
</div>
</div>
<a class="<?php echo $nav_active('about_us'); ?>" href="about_us.php">About</a>
<a class="<?php echo $nav_active('contact_us'); ?>" href="contact_us.php">Contact</a>
<a class="<?php echo $nav_active('pricing'); ?>" href="pricing.php">Pricing</a>
<?php if (isset($_SESSION['user_id'])): ?>
<a class="text-on-surface-variant hover:text-secondary transition-colors" href="dashboard/user/dashboard.php">Dashboard</a>
<?php else: ?>
<a class="text-on-surface-variant hover:text-secondary transition-colors <?php echo ($current_page === 'login') ? 'text-secondary font-bold' : ''; ?>" href="login.php">Log In</a>
<?php endif; ?>
<a class="bg-secondary text-on-secondary px-6 py-2.5 rounded-lg font-bold hover:opacity-90 transition-opacity flex items-center gap-2" href="onboarding/onboarding.php">
Get Started
<span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</nav>
<button id="mobileMenuBtn" type="button" class="lg:hidden text-primary p-2" onclick="toggleMobileMenu()" aria-label="Toggle menu">
<span class="material-symbols-outlined">menu</span>
</button>
</div>
<div id="mobileMenu" class="hidden lg:hidden fixed top-20 left-0 right-0 glass-card border-b border-outline-variant/30 shadow-lg max-h-[calc(100vh-5rem)] overflow-y-auto">
<div class="px-gutter py-4 max-w-container-max mx-auto flex flex-col gap-1">
<span class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-widest px-2 py-2">Services</span>
<a href="irrevocable_trust_service.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Irrevocable Trust</a>
<a href="revocable_living_trust_details.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Revocable Living Trust</a>
<a href="crypto_asset_trust_service.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Crypto Asset Trust</a>
<a href="smart_contract_trust_service.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Smart Contract Trust</a>
<a href="trust_llc.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Wyoming LLC</a>
<div class="border-t border-outline-variant/30 my-2"></div>
<a href="about_us.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">About</a>
<a href="contact_us.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Contact</a>
<a href="pricing.php" class="px-4 py-2 text-sm text-on-surface-variant hover:text-secondary rounded-lg hover:bg-surface-container-low transition-colors">Pricing</a>
<div class="border-t border-outline-variant/30 my-2 pt-2 flex flex-col gap-2">
<?php if (isset($_SESSION['user_id'])): ?>
<a href="dashboard/user/dashboard.php" class="text-center px-4 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md font-bold">Dashboard</a>
<?php else: ?>
<a href="login.php" class="text-center px-4 py-2.5 rounded-lg border-2 border-secondary text-secondary font-label-md font-bold">Log In</a>
<?php endif; ?>
<a href="onboarding/onboarding.php" class="text-center bg-secondary text-on-secondary px-4 py-2.5 rounded-lg font-bold">Get Started</a>
</div>
</div>
</div>
</header>
<script>
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const btn = document.getElementById('mobileMenuBtn');
    if (menu.classList.contains('hidden')) {
        menu.classList.remove('hidden');
        btn.innerHTML = '<span class="material-symbols-outlined">close</span>';
    } else {
        menu.classList.add('hidden');
        btn.innerHTML = '<span class="material-symbols-outlined">menu</span>';
    }
}
</script>
<main class="mt-20">
