<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Site Settings';

// Include shared layout
require_once __DIR__ . '/includes/layout.php';

function renderSettingsContent() {
?>

<!-- Settings Section -->
<section class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 sm:p-6 mb-6 sm:mb-8">
    <h2 class="text-xl sm:text-2xl font-bold text-navy-900 dark:text-white mb-4 sm:mb-6 flex items-center gap-2">
        <span class="material-icons-outlined text-primary text-lg sm:text-xl">settings</span>
        <span>Site Settings</span>
    </h2>

    <div class="space-y-4 sm:space-y-6">
        <!-- Email Verification Toggle -->
        <div class="border-b border-slate-200 dark:border-slate-700 pb-4 sm:pb-6">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 sm:gap-4">
                <div class="flex-1 min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-navy-900 dark:text-white mb-2">Email Verification</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-1">
                        Require users to verify their email address during registration before they can access their dashboard.
                    </p>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-slate-500">
                        When enabled, users will receive a verification email after registration and must click the verification link before logging in.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 self-start sm:self-center">
                    <input 
                        type="checkbox" 
                        id="emailVerificationToggle" 
                        class="sr-only peer"
                        onchange="toggleEmailVerification(this.checked)"
                    >
                    <div class="w-12 h-6 sm:w-14 sm:h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 sm:after:h-6 sm:after:w-6 after:transition-all dark:border-slate-600 peer-checked:bg-primary"></div>
                </label>
            </div>
            <div id="emailVerificationStatus" class="mt-3 sm:mt-4 text-xs sm:text-sm text-slate-600 dark:text-slate-400"></div>
        </div>

        <!-- Site Name -->
        <div class="border-b border-slate-200 dark:border-slate-700 pb-4 sm:pb-6">
            <label class="block text-xs sm:text-sm font-semibold text-navy-900 dark:text-white mb-2">Site Name</label>
            <input 
                type="text" 
                id="siteName" 
                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="WyomingTrust"
            >
        </div>

        <!-- Tagline -->
        <div class="border-b border-slate-200 dark:border-slate-700 pb-4 sm:pb-6">
            <label class="block text-xs sm:text-sm font-semibold text-navy-900 dark:text-white mb-2">Tagline</label>
            <input 
                type="text" 
                id="tagline" 
                class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary"
                placeholder="Secure Your Digital Legacy"
            >
        </div>

        <!-- Wallet Link Settings -->
        <div>
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 sm:gap-4 mb-4">
                <div class="flex-1 min-w-0">
                    <h3 class="text-base sm:text-lg font-semibold text-navy-900 dark:text-white mb-2">Wallet Link Modal</h3>
                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-1">
                        When enabled, clicking "Connect Wallet" shows a modal with wallet options. When disabled, it redirects to a custom URL.
                    </p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer flex-shrink-0 self-start sm:self-center">
                    <input 
                        type="checkbox" 
                        id="walletLinkUseModalToggle" 
                        class="sr-only peer"
                        onchange="toggleWalletLinkModal(this.checked)"
                    >
                    <div class="w-12 h-6 sm:w-14 sm:h-7 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/30 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 sm:after:h-6 sm:after:w-6 after:transition-all dark:border-slate-600 peer-checked:bg-primary"></div>
                </label>
            </div>
            <div id="walletLinkUrlContainer" class="hidden">
                <label class="block text-xs sm:text-sm font-semibold text-navy-900 dark:text-white mb-2">Wallet Link URL</label>
                <input 
                    type="url" 
                    id="walletLinkUrl" 
                    class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary"
                    placeholder="https://example.com/wallet-connect"
                >
                <p class="text-xs text-slate-500 dark:text-slate-500 mt-1">
                    Enter the URL where users will be redirected when they click "Connect Wallet"
                </p>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end pt-3 sm:pt-4">
            <button 
                onclick="saveGeneralSettings()"
                class="bg-primary text-navy-900 px-4 sm:px-6 py-2 sm:py-2.5 rounded-lg font-semibold text-sm sm:text-base hover:opacity-90 transition-opacity w-full sm:w-auto"
            >
                Save General Settings
            </button>
        </div>
    </div>
</section>

<script src="includes/modal.js"></script>
<script>
    // Load current settings
    async function loadSettings() {
        try {
            const response = await fetch('../../api/admin/settings.php', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            });

            const data = await response.json();
            
            if (data.success && data.settings) {
                const settings = data.settings;
                
                // Set email verification toggle
                const toggle = document.getElementById('emailVerificationToggle');
                if (toggle) {
                    toggle.checked = (settings.require_email_verification == 1);
                    updateEmailVerificationStatus(settings.require_email_verification == 1);
                }
                
                // Set site name and tagline
                if (document.getElementById('siteName')) {
                    document.getElementById('siteName').value = settings.site_name || '';
                }
                if (document.getElementById('tagline')) {
                    document.getElementById('tagline').value = settings.tagline || '';
                }
                
                // Set wallet link settings
                const walletModalToggle = document.getElementById('walletLinkUseModalToggle');
                const walletUrlContainer = document.getElementById('walletLinkUrlContainer');
                const walletUrlInput = document.getElementById('walletLinkUrl');
                
                if (walletModalToggle) {
                    const useModal = (settings.wallet_link_use_modal == 1);
                    walletModalToggle.checked = useModal;
                    toggleWalletLinkModal(useModal, false); // false = don't save yet
                }
                
                if (walletUrlInput && settings.wallet_link_url) {
                    walletUrlInput.value = settings.wallet_link_url || '';
                }
            }
        } catch (error) {
            console.error('Failed to load settings:', error);
            showToast('Failed to load settings', 'error');
        }
    }

    // Toggle email verification
    async function toggleEmailVerification(enabled) {
        try {
            const response = await fetch('../../api/admin/settings.php', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    require_email_verification: enabled ? 1 : 0
                })
            });

            const data = await response.json();
            
            if (data.success) {
                updateEmailVerificationStatus(enabled);
                showToast(
                    enabled 
                        ? 'Email verification enabled. New users must verify their email before accessing the dashboard.' 
                        : 'Email verification disabled. New users can access the dashboard immediately after registration.',
                    'success'
                );
            } else {
                // Revert toggle on error
                document.getElementById('emailVerificationToggle').checked = !enabled;
                showToast(data.message || 'Failed to update email verification setting', 'error');
            }
        } catch (error) {
            console.error('Failed to toggle email verification:', error);
            // Revert toggle on error
            document.getElementById('emailVerificationToggle').checked = !enabled;
            showToast('Failed to update email verification setting', 'error');
        }
    }

    function updateEmailVerificationStatus(enabled) {
        const statusDiv = document.getElementById('emailVerificationStatus');
        if (statusDiv) {
            if (enabled) {
                statusDiv.innerHTML = `
                    <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                        <span class="material-icons-outlined text-sm">check_circle</span>
                        <span class="font-medium">Email verification is currently <strong>ENABLED</strong></span>
                    </div>
                `;
            } else {
                statusDiv.innerHTML = `
                    <div class="flex items-center gap-2 text-amber-600 dark:text-amber-400">
                        <span class="material-icons-outlined text-sm">warning</span>
                        <span class="font-medium">Email verification is currently <strong>DISABLED</strong></span>
                    </div>
                `;
            }
        }
    }

    // Toggle wallet link modal
    function toggleWalletLinkModal(enabled, saveImmediately = true) {
        const walletUrlContainer = document.getElementById('walletLinkUrlContainer');
        const walletUrlInput = document.getElementById('walletLinkUrl');
        
        if (enabled) {
            walletUrlContainer.classList.add('hidden');
            if (walletUrlInput) {
                walletUrlInput.disabled = true;
            }
        } else {
            walletUrlContainer.classList.remove('hidden');
            if (walletUrlInput) {
                walletUrlInput.disabled = false;
            }
        }
        
        if (saveImmediately) {
            saveWalletLinkSettings();
        }
    }
    
    // Save wallet link settings
    async function saveWalletLinkSettings() {
        const walletModalToggle = document.getElementById('walletLinkUseModalToggle');
        const walletUrlInput = document.getElementById('walletLinkUrl');
        
        const useModal = walletModalToggle ? walletModalToggle.checked : true;
        const walletUrl = walletUrlInput ? walletUrlInput.value : '';
        
        try {
            const response = await fetch('../../api/admin/settings.php', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    wallet_link_use_modal: useModal ? 1 : 0,
                    wallet_link_url: walletUrl
                })
            });

            const data = await response.json();
            
            if (data.success) {
                showToast('Wallet link settings saved successfully', 'success');
            } else {
                showToast(data.message || 'Failed to save wallet link settings', 'error');
            }
        } catch (error) {
            console.error('Failed to save wallet link settings:', error);
            showToast('Failed to save wallet link settings', 'error');
        }
    }

    // Save general settings
    async function saveGeneralSettings() {
        const siteName = document.getElementById('siteName').value;
        const tagline = document.getElementById('tagline').value;
        
        // Also save wallet link settings
        const walletModalToggle = document.getElementById('walletLinkUseModalToggle');
        const walletUrlInput = document.getElementById('walletLinkUrl');
        const useModal = walletModalToggle ? walletModalToggle.checked : true;
        const walletUrl = walletUrlInput ? walletUrlInput.value : '';

        try {
            const response = await fetch('../../api/admin/settings.php', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    site_name: siteName,
                    tagline: tagline,
                    wallet_link_use_modal: useModal ? 1 : 0,
                    wallet_link_url: walletUrl
                })
            });

            const data = await response.json();
            
            if (data.success) {
                showToast('General settings saved successfully', 'success');
            } else {
                showToast(data.message || 'Failed to save settings', 'error');
            }
        } catch (error) {
            console.error('Failed to save settings:', error);
            showToast('Failed to save settings', 'error');
        }
    }

    // Load settings on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', loadSettings);
    } else {
        loadSettings();
    }
</script>

<?php
}

// Render the layout with settings content
renderAdminLayout($page_title, 'settings', 'renderSettingsContent');
?>
