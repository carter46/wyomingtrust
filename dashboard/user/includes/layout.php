<?php
/**
 * User dashboard shell — Heritage Modern layout.
 * Expects: $page_title, $userName; optional: $active_nav (assets|transactions|send|receive|swap|link-wallet|trusts|profile)
 */
$active_nav = $active_nav ?? '';
$userName = $userName ?? ($_SESSION['user_name'] ?? 'User');
$userInitials = 'WT';
$nameParts = preg_split('/\s+/', trim($userName));
if (count($nameParts) >= 2) {
    $userInitials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[count($nameParts) - 1], 0, 1));
} elseif ($userName !== '') {
    $userInitials = strtoupper(substr($userName, 0, 2));
}

$navClass = function ($key) use ($active_nav) {
    if ($active_nav === $key) {
        return 'flex items-center gap-3 px-4 py-3 rounded-lg sidebar-active transition-all duration-200';
    }
    return 'flex items-center gap-3 px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all';
};
$navIconFill = function ($key) use ($active_nav) {
    return $active_nav === $key ? " style=\"font-variation-settings: 'FILL' 1;\"" : '';
};
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo escape_html($page_title ?? 'WyomingTrust Dashboard'); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
tailwind.config = {
    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "surface-container": "#edeeef",
                "deep-forest": "#2D4B3F",
                "primary": "#041627",
                "on-primary": "#ffffff",
                "sky-accent": "#B6D6F2",
                "secondary": "#115cb9",
                "surface": "#f8f9fa",
                "on-surface-variant": "#44474c",
                "on-secondary": "#ffffff",
                "warm-cream": "#FEFDF3",
                "outline-variant": "#c4c6cd",
                "outline": "#74777d",
                "on-surface": "#191c1d",
                "surface-container-low": "#f3f4f5",
                "surface-container-lowest": "#ffffff",
                "secondary-container": "#659dfe",
                "on-secondary-container": "#003370",
                "primary-container": "#1a2b3c",
                "on-primary-container": "#8192a7",
                "error": "#ba1a1a",
                "error-container": "#ffdad6",
            },
            borderRadius: { DEFAULT: "0.25rem", lg: "0.5rem", xl: "0.75rem", full: "9999px" },
            spacing: {
                "container-max": "1200px",
                "gutter": "24px",
                "section-padding-md": "48px",
                "section-padding-lg": "80px",
                "stack-gap": "16px",
            },
            maxWidth: { "container-max": "1200px" },
            fontFamily: {
                "body-md": ["DM Sans", "sans-serif"],
                "label-sm": ["DM Sans", "sans-serif"],
                "label-md": ["DM Sans", "sans-serif"],
                "headline-lg": ["\"Source Serif 4\"", "serif"],
                "headline-md": ["\"Source Serif 4\"", "serif"],
                "body-lg": ["DM Sans", "sans-serif"],
                "display-lg": ["\"Source Serif 4\"", "serif"],
            },
            fontSize: {
                "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                "label-sm": ["12px", { lineHeight: "16px", letterSpacing: "0.05em", fontWeight: "700" }],
                "label-md": ["14px", { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "500" }],
                "headline-lg": ["32px", { lineHeight: "40px", fontWeight: "600" }],
                "headline-md": ["24px", { lineHeight: "32px", fontWeight: "600" }],
                "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
            },
        },
    },
};
</script>
<style>
.sidebar-active { background-color: #041627; color: #ffffff; box-shadow: 0 10px 15px -3px rgba(4, 22, 39, 0.1); }
.glass-effect { backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.85); }
.card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(4, 22, 39, 0.1), 0 10px 10px -5px rgba(4, 22, 39, 0.04);
}
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
    -webkit-font-smoothing: antialiased;
    font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
}
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: #d9dadb; border-radius: 10px; }
</style>
</head>
<body class="bg-surface font-body-md text-on-surface antialiased overflow-x-hidden">
<div class="flex min-h-screen">
<aside class="hidden md:flex flex-col w-72 fixed h-full bg-surface-container-lowest border-r border-outline-variant z-50">
<div class="p-gutter h-20 flex items-center gap-2.5">
<span class="flex-shrink-0 w-9 h-9 rounded-lg bg-[#16a34a] flex items-center justify-center shadow-sm" aria-hidden="true">
<svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M12 2.25L4.5 5.75V11.25C4.5 16.04 7.73 20.36 12 21.75C16.27 20.36 19.5 16.04 19.5 11.25V5.75L12 2.25Z" fill="white"/>
<path d="M9.75 12.25L11.1 13.85L14.55 10.1" stroke="#16a34a" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
</span>
<a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight">WyomingTrust</a>
</div>
<nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
<a class="<?php echo $navClass('assets'); ?>" href="assets.php">
<span class="material-symbols-outlined"<?php echo $navIconFill('assets'); ?>>account_balance_wallet</span>
<span class="font-label-md text-label-md">Assets</span>
</a>
<a class="<?php echo $navClass('transactions'); ?>" href="transactions.php">
<span class="material-symbols-outlined">receipt_long</span>
<span class="font-label-md text-label-md">Transactions</span>
</a>
<a class="<?php echo $navClass('send'); ?>" href="send.php">
<span class="material-symbols-outlined">send</span>
<span class="font-label-md text-label-md">Send</span>
</a>
<a class="<?php echo $navClass('receive'); ?>" href="receive.php">
<span class="material-symbols-outlined">call_received</span>
<span class="font-label-md text-label-md">Receive</span>
</a>
<a class="<?php echo $navClass('swap'); ?>" href="swap.php">
<span class="material-symbols-outlined">swap_horiz</span>
<span class="font-label-md text-label-md">Swap</span>
</a>
<div class="pt-6 pb-2 px-4">
<span class="font-label-sm text-label-sm uppercase tracking-widest text-outline">Estate Tools</span>
</div>
<a class="<?php echo $navClass('link-wallet'); ?>" href="link-wallet.php">
<span class="material-symbols-outlined">link</span>
<span class="font-label-md text-label-md">Link Wallet</span>
</a>
<a class="<?php echo $navClass('trusts'); ?>" href="manage-trust.php">
<span class="material-symbols-outlined">gavel</span>
<span class="font-label-md text-label-md">Trusts</span>
</a>
<a class="<?php echo $navClass('profile'); ?>" href="profile.php">
<span class="material-symbols-outlined">person</span>
<span class="font-label-md text-label-md">Profile</span>
</a>
</nav>
<div class="p-6 border-t border-outline-variant">
<div class="flex items-center gap-4 mb-4">
<div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-on-secondary-container font-bold text-sm"><?php echo escape_html($userInitials); ?></div>
<div>
<p class="font-label-md text-label-md font-bold"><?php echo escape_html($userName); ?></p>
<p class="text-xs text-secondary">Member</p>
</div>
</div>
<a href="../../api/logout.php" class="flex items-center gap-2 w-full px-4 py-2 text-error font-label-md text-label-md hover:bg-error-container/20 rounded-lg transition-colors">
<span class="material-symbols-outlined text-sm">logout</span>
Logout
</a>
</div>
</aside>
<main class="flex-1 md:ml-72 min-h-screen flex flex-col">
<header class="h-20 glass-effect sticky top-0 z-40 flex items-center justify-between px-gutter md:px-12 border-b border-outline-variant/30">
<div class="flex items-center flex-1 max-w-xl">
<button type="button" class="md:hidden mr-4 p-2 hover:bg-surface-container rounded-full" onclick="toggleMobileNav()" aria-label="Open menu">
<span class="material-symbols-outlined">menu</span>
</button>
<div class="relative w-full max-w-md hidden sm:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-xl">search</span>
<input class="w-full pl-11 pr-4 py-2 bg-surface-container-low border-none rounded-full focus:ring-2 focus:ring-secondary/50 font-body-md text-sm" placeholder="Search assets, trusts, or transactions..." type="search"/>
</div>
</div>
<div class="flex items-center gap-2 md:gap-6">
<button type="button" class="relative p-2 text-on-surface-variant hover:bg-surface-container rounded-full transition-colors" aria-label="Notifications">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
</button>
<button type="button" onclick="window.location.href='profile.php'" class="p-2 text-on-surface-variant hover:bg-surface-container rounded-full transition-colors" aria-label="Settings">
<span class="material-symbols-outlined">settings</span>
</button>
<div class="h-8 w-px bg-outline-variant hidden md:block"></div>
<div class="hidden md:flex items-center gap-3 bg-surface-container px-4 py-1.5 rounded-full">
<span class="font-label-md text-label-md font-medium">Member</span>
<div class="w-6 h-6 rounded-full bg-secondary text-on-secondary flex items-center justify-center">
<span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">star</span>
</div>
</div>
</div>
</header>
<div class="p-gutter md:p-12 space-y-10 max-w-container-max mx-auto w-full flex-1">
