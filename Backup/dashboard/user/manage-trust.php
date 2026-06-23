<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check user authentication
require_user_page_auth('../../login.php');

$trustId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$userId = (int) $_SESSION['user_id'];

$page_title = 'Manage Trust - WyomingTrust';

// If no trust id provided, show a trusts list page (this is the "My Trusts" page)
if ($trustId <= 0) {
    $page_title = 'My Trusts - WyomingTrust';
    $userName = $_SESSION['user_name'] ?? 'User';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#F59E0B",
                        "accent-orange": "#F59E0B",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111721",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    </head>
    <body class="bg-background-light dark:bg-background-dark font-display min-h-screen text-[#0e131b] dark:text-white">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
    <div class="layout-container flex h-full grow flex-col">
    <!-- TopNavBar -->
    <header class="flex items-center justify-between border-b border-solid border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
    <div class="flex items-center gap-4 sm:gap-6 lg:gap-8 flex-1 min-w-0">
    <div class="flex items-center gap-2 sm:gap-4 text-primary flex-shrink-0">
    <div class="size-6 sm:size-8">
    <svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
    <path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
    <path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
    </svg>
    </div>
    <h2 class="text-lg sm:text-xl font-black leading-tight tracking-tight">WyomingTrust</h2>
    </div>
    <label class="hidden sm:flex flex-col min-w-40 h-10 max-w-64">
    <div class="flex w-full flex-1 items-stretch rounded-lg h-full">
    <div class="text-[#4e6b97] flex border-none bg-slate-100 dark:bg-slate-800 items-center justify-center pl-4 rounded-l-lg" data-icon="search">
    <span class="material-symbols-outlined text-base sm:text-lg">search</span>
    </div>
    <input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e131b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-slate-100 dark:bg-slate-800 focus:border-none h-full placeholder:text-[#4e6b97] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal" placeholder="Search portfolio..." value=""/>
    </div>
    </label>
    </div>
    <div class="flex flex-1 justify-end gap-4 sm:gap-6 items-center">
    <div class="hidden sm:flex gap-2">
    <button class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
    <span class="material-symbols-outlined">notifications</span>
    </button>
    <button onclick="window.location.href='profile.php'" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
    <span class="material-symbols-outlined">settings</span>
    </button>
    </div>
    <div class="hidden sm:flex items-center gap-3 border-l pl-6 border-slate-200 dark:border-slate-700">
    <div class="text-right">
    <p class="text-xs font-semibold" id="userNameDisplay"><?php echo htmlspecialchars($userName); ?></p>
    <p class="text-[10px] text-slate-500">Premium Plan</p>
    </div>
    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" data-alt="User profile portrait"></div>
    </div>
    <button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="sm:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 ml-auto">
    <span class="material-symbols-outlined">menu</span>
    </button>
    <a href="../../api/logout.php" class="hidden sm:flex text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 px-2 sm:px-0">Logout</a>
    </div>
    </header>
    <!-- Mobile Navigation Menu -->
    <div id="mobileMenu" class="hidden sm:hidden pb-4 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
    <div class="flex flex-col gap-1 px-4 pt-4">
    <a href="dashboard.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">dashboard</span>
    <span>Dashboard</span>
    </a>
    <a href="assets.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">account_balance_wallet</span>
    <span>Assets</span>
    </a>
    <a href="transactions.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">history</span>
    <span>Transactions</span>
    </a>
    <a href="send.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">send</span>
    <span>Send</span>
    </a>
    <a href="receive.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">call_received</span>
    <span>Receive</span>
    </a>
    <a href="swap.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">swap_horiz</span>
    <span>Swap</span>
    </a>
    <a href="link-wallet.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">link</span>
    <span>Link Wallet</span>
    </a>
    <a href="manage-trust.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">account_balance</span>
    <span>Manage Trusts</span>
    </a>
    <a href="profile.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
    <span class="material-symbols-outlined">person</span>
    <span>Profile</span>
    </a>
    <a href="../../api/logout.php" class="px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center gap-3 border-t border-slate-200 dark:border-slate-700 mt-2 pt-4">
    <span class="material-symbols-outlined">logout</span>
    <span>Logout</span>
    </a>
    </div>
    </div>
    <main class="flex-1 flex flex-col items-center">
    <div class="layout-content-container flex flex-col max-w-[1200px] w-full px-4 py-8">
    <!-- PageHeading -->
    <div class="flex flex-wrap justify-between gap-3 p-3 sm:p-4">
    <div class="flex min-w-0 flex-col gap-1 flex-1">
    <p class="text-[#0e131b] dark:text-white text-2xl sm:text-3xl lg:text-4xl font-black leading-tight tracking-[-0.033em]">My Trusts</p>
    <p class="text-[#4e6b97] text-sm sm:text-base font-normal leading-normal">View and manage your trusts.</p>
    </div>
    <div class="flex gap-3 items-center">
    <a href="dashboard.php" class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 h-10 flex items-center">Dashboard</a>
    <a href="../../onboarding/onboarding.php" class="px-4 py-2 rounded-lg bg-primary text-white font-bold hover:opacity-90 h-10 flex items-center">Create New Trust</a>
    </div>
    </div>

    <div id="trustsList" class="space-y-4 px-4">
        <div class="text-center py-10 text-slate-500">Loading trusts...</div>
    </div>
    </div>
    </main>

    <!-- Custom Modal System -->
    <div id="customModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal()"></div>
            <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white dark:bg-slate-900 px-4 pt-5 pb-4 sm:p-6">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                            <span id="modalIcon" class="material-symbols-outlined text-primary text-xl">info</span>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                            <h3 id="modalTitle" class="text-lg leading-6 font-bold text-slate-900 dark:text-white"></h3>
                            <div class="mt-2">
                                <p id="modalMessage" class="text-sm text-slate-500 dark:text-slate-400"></p>
                                <div id="modalInput" class="hidden mt-4">
                                    <input type="text" id="modalInputField" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-slate-50 dark:bg-slate-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                    <button id="modalConfirmBtn" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"></button>
                    <button id="modalCancelBtn" type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 dark:border-slate-700 shadow-sm px-4 py-2 bg-white dark:bg-slate-700 text-base font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text ?? '';
        return div.innerHTML;
    }

    async function loadTrusts() {
        try {
            const res = await fetch('../../api/user/trusts.php');
            const data = await res.json();
            const container = document.getElementById('trustsList');
            if (!data.success || !data.trusts) {
                container.innerHTML = '<div class="text-center py-10 text-red-500">Failed to load trusts</div>';
                return;
            }
            if (data.trusts.length === 0) {
                container.innerHTML = '<div class="text-center py-10 text-slate-500">No trusts yet. <a class="text-primary font-semibold hover:underline" href="../../onboarding/onboarding.php">Create your first trust</a></div>';
                return;
            }
            container.innerHTML = data.trusts.map(t => {
                const trustName = t.trust_name || t.service_name || 'Untitled Trust';
                const serviceName = t.service_name || 'Trust';
                const status = (t.status || 'pending').toString();
                const createdAt = t.created_at ? new Date(t.created_at).toLocaleDateString() : '';
                const bens = Array.isArray(t.beneficiaries) ? t.beneficiaries.length : 
                            (Array.isArray(t.trust_data?.beneficiaries) ? t.trust_data.beneficiaries.length : 0);
                // Only show service name badge if trust name exists and is different from service name
                const showServiceBadge = t.trust_name && t.trust_name !== serviceName;
                return `
                    <div class="p-5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="text-xl font-black text-slate-900 dark:text-white">${escapeHtml(trustName)}</p>
                                    ${showServiceBadge ? `<span class="text-[10px] font-bold uppercase tracking-wider px-2 py-1 rounded bg-primary/10 text-primary">${escapeHtml(serviceName)}</span>` : ''}
                                </div>
                                <p class="text-xs text-slate-500 mt-1">Status: <strong>${escapeHtml(status)}</strong> · Beneficiaries: <strong>${bens}</strong> · Created: ${escapeHtml(createdAt)}</p>
                            </div>
                            <div class="flex gap-2">
                                <a href="manage-trust.php?id=${t.id}" class="px-4 py-2 rounded-lg bg-primary text-white font-bold hover:opacity-90 h-10 flex items-center">Edit</a>
                                <button onclick="deleteTrust(${t.id})" class="px-4 py-2 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 h-10 flex items-center">Delete</button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        } catch (e) {
            console.error(e);
            document.getElementById('trustsList').innerHTML = '<div class="text-center py-10 text-red-500">Error loading trusts</div>';
        }
    }

    async function deleteTrust(trustId) {
        try {
            const confirmed = await showConfirmModal(
                'Delete Trust',
                'Are you sure you want to permanently delete this trust? This action cannot be undone and all trust data will be permanently removed.',
                'Delete Trust',
                'Cancel',
                'danger'
            );
            if (!confirmed) return;
            
            const res = await fetch(`../../api/user/trusts.php?id=${trustId}`, {
                method: 'DELETE'
            });
            const data = await res.json();
            if (data.success) {
                await showAlertModal('Success', 'Trust deleted successfully', 'success');
                loadTrusts(); // Reload list
            } else {
                await showAlertModal('Error', data.message || 'Failed to delete trust', 'error');
            }
        } catch (e) {
            console.error(e);
            await showAlertModal('Error', 'Error deleting trust', 'error');
        }
    }
    
    // Custom Modal Functions for list view
    var modalResolve = null;
    var modalReject = null;

    function showConfirmModal(title, message, confirmText = 'Confirm', cancelText = 'Cancel', type = 'warning') {
        return new Promise((resolve, reject) => {
            modalResolve = resolve;
            modalReject = reject;
            const modal = document.getElementById('customModal');
            const icon = document.getElementById('modalIcon');
            const titleEl = document.getElementById('modalTitle');
            const messageEl = document.getElementById('modalMessage');
            const confirmBtn = document.getElementById('modalConfirmBtn');
            const cancelBtn = document.getElementById('modalCancelBtn');
            const inputDiv = document.getElementById('modalInput');
            
            inputDiv.classList.add('hidden');
            titleEl.textContent = title;
            messageEl.textContent = message;
            confirmBtn.textContent = confirmText;
            cancelBtn.textContent = cancelText;
            
            if (type === 'danger') {
                icon.textContent = 'warning';
                icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'material-symbols-outlined text-red-600 dark:text-red-400 text-xl';
                confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
            } else {
                icon.textContent = 'help';
                icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'material-symbols-outlined text-primary text-xl';
                confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
            }
            
            confirmBtn.onclick = () => {
                closeModal();
                resolve(true);
            };
            
            modal.classList.remove('hidden');
        });
    }

    function showAlertModal(title, message, type = 'info') {
        return new Promise((resolve) => {
            const modal = document.getElementById('customModal');
            const icon = document.getElementById('modalIcon');
            const titleEl = document.getElementById('modalTitle');
            const messageEl = document.getElementById('modalMessage');
            const confirmBtn = document.getElementById('modalConfirmBtn');
            const cancelBtn = document.getElementById('modalCancelBtn');
            const inputDiv = document.getElementById('modalInput');
            
            inputDiv.classList.add('hidden');
            cancelBtn.classList.add('hidden');
            titleEl.textContent = title;
            messageEl.textContent = message;
            confirmBtn.textContent = 'OK';
            
            if (type === 'success') {
                icon.textContent = 'check_circle';
                icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'material-symbols-outlined text-green-600 dark:text-green-400 text-xl';
            } else if (type === 'error') {
                icon.textContent = 'error';
                icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'material-symbols-outlined text-red-600 dark:text-red-400 text-xl';
            } else {
                icon.textContent = 'info';
                icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10';
                icon.className = 'material-symbols-outlined text-primary text-xl';
            }
            
            confirmBtn.onclick = () => {
                closeModal();
                resolve();
            };
            
            modal.classList.remove('hidden');
        });
    }

    function closeModal() {
        const modal = document.getElementById('customModal');
        const cancelBtn = document.getElementById('modalCancelBtn');
        modal.classList.add('hidden');
        cancelBtn.classList.remove('hidden');
        if (modalReject) {
            modalReject(false);
            modalReject = null;
        }
    }

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

    document.addEventListener('DOMContentLoaded', loadTrusts);
    </script>
    </div>
    </div>
    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title><?php echo htmlspecialchars($page_title); ?></title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#F59E0B",
                        "accent-orange": "#F59E0B",
                        "background-light": "#f6f7f8",
                        "background-dark": "#111721",
                    },
                    fontFamily: {
                        "display": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        @media print {
            header, .no-print, button, a {
                display: none !important;
            }
            body {
                background: white;
                color: black;
            }
            .bg-white, .bg-slate-900 {
                background: white !important;
                color: black !important;
            }
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark font-display min-h-screen text-[#0e131b] dark:text-white">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<!-- TopNavBar -->
<header class="flex items-center justify-between border-b border-solid border-[#d0d9e7] dark:border-slate-700 px-4 sm:px-6 lg:px-10 py-3 bg-white dark:bg-slate-900 sticky top-0 z-50">
<div class="flex items-center gap-4 sm:gap-6 lg:gap-8 flex-1 min-w-0">
<div class="flex items-center gap-2 sm:gap-4 text-primary flex-shrink-0">
<div class="size-6 sm:size-8">
<svg fill="none" viewbox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
<path d="M39.5563 34.1455V13.8546C39.5563 15.708 36.8773 17.3437 32.7927 18.3189C30.2914 18.916 27.263 19.2655 24 19.2655C20.737 19.2655 17.7086 18.916 15.2073 18.3189C11.1227 17.3437 8.44365 15.708 8.44365 13.8546V34.1455C8.44365 35.9988 11.1227 37.6346 15.2073 38.6098C17.7086 39.2069 20.737 39.5564 24 39.5564C27.263 39.5564 30.2914 39.2069 32.7927 38.6098C36.8773 37.6346 39.5563 35.9988 39.5563 34.1455Z" fill="currentColor"></path>
<path clip-rule="evenodd" d="M10.4485 13.8519C10.4749 13.9271 10.6203 14.246 11.379 14.7361C12.298 15.3298 13.7492 15.9145 15.6717 16.3735C18.0007 16.9296 20.8712 17.2655 24 17.2655C27.1288 17.2655 29.9993 16.9296 32.3283 16.3735C34.2508 15.9145 35.702 15.3298 36.621 14.7361C37.3796 14.246 37.5251 13.9271 37.5515 13.8519C37.5287 13.7876 37.4333 13.5973 37.0635 13.2931C36.5266 12.8516 35.6288 12.3647 34.343 11.9175C31.79 11.0295 28.1333 10.4437 24 10.4437C19.8667 10.4437 16.2099 11.0295 13.657 11.9175C12.3712 12.3647 11.4734 12.8516 10.9365 13.2931C10.5667 13.5973 10.4713 13.7876 10.4485 13.8519ZM37.5563 18.7877C36.3176 19.3925 34.8502 19.8839 33.2571 20.2642C30.5836 20.9025 27.3973 21.2655 24 21.2655C20.6027 21.2655 17.4164 20.9025 14.7429 20.2642C13.1498 19.8839 11.6824 19.3925 10.4436 18.7877V34.1275C10.4515 34.1545 10.5427 34.4867 11.379 35.027C12.298 35.6207 13.7492 36.2054 15.6717 36.6644C18.0007 37.2205 20.8712 37.5564 24 37.5564C27.1288 37.5564 29.9993 37.2205 32.3283 36.6644C34.2508 36.2054 35.702 35.6207 36.621 35.027C37.4573 34.4867 37.5485 34.1546 37.5563 34.1275V18.7877ZM41.5563 13.8546V34.1455C41.5563 36.1078 40.158 37.5042 38.7915 38.3869C37.3498 39.3182 35.4192 40.0389 33.2571 40.5551C30.5836 41.1934 27.3973 41.5564 24 41.5564C20.6027 41.5564 17.4164 41.1934 14.7429 40.5551C12.5808 40.0389 10.6502 39.3182 9.20848 38.3869C7.84205 37.5042 6.44365 36.1078 6.44365 34.1455L6.44365 13.8546C6.44365 12.2684 7.37223 11.0454 8.39581 10.2036C9.43325 9.3505 10.8137 8.67141 12.343 8.13948C15.4203 7.06909 19.5418 6.44366 24 6.44366C28.4582 6.44366 32.5797 7.06909 35.657 8.13948C37.1863 8.67141 38.5667 9.3505 39.6042 10.2036C40.6278 11.0454 41.5563 12.2684 41.5563 13.8546Z" fill="currentColor" fill-rule="evenodd"></path>
</svg>
</div>
<h2 class="text-lg sm:text-xl font-black leading-tight tracking-tight">WyomingTrust</h2>
</div>
<label class="hidden sm:flex flex-col min-w-40 h-10 max-w-64">
<div class="flex w-full flex-1 items-stretch rounded-lg h-full">
<div class="text-[#4e6b97] flex border-none bg-slate-100 dark:bg-slate-800 items-center justify-center pl-4 rounded-l-lg" data-icon="search">
<span class="material-symbols-outlined text-base sm:text-lg">search</span>
</div>
<input class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#0e131b] dark:text-white focus:outline-0 focus:ring-0 border-none bg-slate-100 dark:bg-slate-800 focus:border-none h-full placeholder:text-[#4e6b97] px-4 rounded-l-none border-l-0 pl-2 text-sm font-normal" placeholder="Search portfolio..." value=""/>
</div>
</label>
</div>
<div class="flex flex-1 justify-end gap-4 sm:gap-6 items-center">
<div class="hidden sm:flex gap-2">
<button class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
<span class="material-symbols-outlined">notifications</span>
</button>
<button onclick="window.location.href='profile.php'" class="flex items-center justify-center rounded-lg h-10 w-10 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700">
<span class="material-symbols-outlined">settings</span>
</button>
</div>
<div class="hidden sm:flex items-center gap-3 border-l pl-6 border-slate-200 dark:border-slate-700">
<div class="text-right">
<p class="text-xs font-semibold" id="userNameDisplay"><?php echo htmlspecialchars($userName); ?></p>
<p class="text-[10px] text-slate-500">Premium Plan</p>
</div>
<div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10 border-2 border-primary/20" data-alt="User profile portrait"></div>
</div>
<button id="mobileMenuBtn" onclick="toggleMobileMenu()" class="sm:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
<span class="material-symbols-outlined">menu</span>
</button>
<a href="../../api/logout.php" class="text-xs sm:text-sm text-red-600 dark:text-red-400 hover:text-red-700 px-2 sm:px-0">Logout</a>
</div>
</header>
<!-- Mobile Navigation Menu -->
<div id="mobileMenu" class="hidden sm:hidden pb-4 border-b border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
<div class="flex flex-col gap-1 px-4 pt-4">
<a href="dashboard.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">dashboard</span>
<span>Dashboard</span>
</a>
<a href="assets.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">account_balance_wallet</span>
<span>Assets</span>
</a>
<a href="transactions.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">history</span>
<span>Transactions</span>
</a>
<a href="send.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">send</span>
<span>Send</span>
</a>
<a href="receive.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">call_received</span>
<span>Receive</span>
</a>
<a href="swap.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">swap_horiz</span>
<span>Swap</span>
</a>
<a href="link-wallet.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">link</span>
<span>Link Wallet</span>
</a>
<a href="manage-trust.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">account_balance</span>
<span>Manage Trusts</span>
</a>
<a href="profile.php" class="px-4 py-3 text-sm hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors flex items-center gap-3">
<span class="material-symbols-outlined">person</span>
<span>Profile</span>
</a>
<a href="../../api/logout.php" class="px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors flex items-center gap-3 border-t border-slate-200 dark:border-slate-700 mt-2 pt-4">
<span class="material-symbols-outlined">logout</span>
<span>Logout</span>
</a>
</div>
</div>
<main class="flex-1 flex flex-col items-center">
<div class="layout-content-container flex flex-col max-w-[1200px] w-full px-4 py-8">
<!-- Page Heading -->
<div class="flex flex-wrap justify-between items-end gap-3 pb-6 border-b border-slate-200 dark:border-slate-700 mb-6">
<div class="flex flex-col gap-2">
<div class="flex items-center gap-2">
<span id="trustTypeBadge" class="bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded">Loading...</span>
</div>
<p id="trustName" class="text-slate-900 dark:text-white text-4xl font-black leading-tight tracking-[-0.033em]">Loading...</p>
<p id="trustId" class="text-slate-500 dark:text-slate-400 text-sm font-mono font-medium">ID: Loading...</p>
</div>
<div class="flex gap-2 items-center">
    <button onclick="window.location.href='../../onboarding/onboarding.php'" class="flex items-center justify-center rounded-lg h-10 px-4 bg-primary text-white text-sm font-bold gap-2 hover:opacity-90 transition-all">
        <span class="material-symbols-outlined text-sm">add</span>
        <span>Create New Trust</span>
    </button>
    <button onclick="window.location.href='manage-trust.php'" class="flex items-center justify-center rounded-lg h-10 px-4 bg-slate-700 dark:bg-slate-600 text-white text-sm font-bold gap-2 hover:bg-slate-600 dark:hover:bg-slate-500 transition-all">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        <span>Back to Trusts</span>
    </button>
</div>
</div>
<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
<div class="flex flex-col gap-2 rounded-xl p-5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Portfolio Assets</p>
<div class="flex items-baseline gap-2">
<p id="portfolioAssets" class="text-slate-900 dark:text-white text-2xl font-black">0/0</p>
<span class="text-xs text-slate-500 dark:text-slate-400">0% allocation</span>
</div>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Total Value</p>
<p id="totalValue" class="text-slate-900 dark:text-white text-2xl font-black tracking-tight">$0.00</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Beneficiaries</p>
<p id="beneficiaryCount" class="text-slate-900 dark:text-white text-2xl font-black">0</p>
</div>
<div class="flex flex-col gap-2 rounded-xl p-5 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
<p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">Status</p>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-amber-500 text-xl">gpp_maybe</span>
<p id="trustStatus" class="text-slate-900 dark:text-white text-lg font-bold">Loading...</p>
</div>
</div>
</div>
<!-- Quick Actions Row -->
<div class="flex items-center gap-4 mb-8 bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-700">
<p class="text-slate-900 dark:text-white text-sm font-bold mr-2">Quick Actions:</p>
<button onclick="exportTrustReport()" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold text-slate-900 dark:text-white hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined text-primary">ios_share</span>
Export Report
</button>
<button onclick="printTrustDetails()" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold text-slate-900 dark:text-white hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined text-primary">print</span>
Print Details
</button>
<button onclick="shareWithAdvisor()" class="flex items-center gap-2 px-3 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-semibold text-slate-900 dark:text-white hover:bg-primary/10 transition-colors">
<span class="material-symbols-outlined text-primary">diversity_3</span>
Share with Advisor
</button>
</div>
<!-- Trust Settings -->
<h2 class="text-slate-900 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] pb-4">Trust Settings</h2>
<div class="flex flex-col gap-3 mb-8">
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm">
<div class="flex flex-col gap-1">
<p class="text-slate-900 dark:text-white text-base font-bold">Edit Trust Name</p>
<p class="text-slate-500 dark:text-slate-400 text-sm">Modify the official title of this trust.</p>
</div>
<button onclick="editTrustName()" class="flex min-w-[120px] cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-all">
Edit Name
</button>
</div>
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-5 shadow-sm">
<div class="flex flex-col gap-1">
<p class="text-slate-900 dark:text-white text-base font-bold">Change Status</p>
<div class="flex items-center gap-2">
<span id="statusDot" class="size-2 bg-slate-400 rounded-full"></span>
<p class="text-slate-500 dark:text-slate-400 text-sm">Current Status: <span id="statusBadge" class="font-bold text-slate-700 dark:text-slate-200">Loading...</span></p>
</div>
</div>
<button onclick="changeStatus()" class="flex min-w-[120px] cursor-pointer items-center justify-center rounded-lg h-9 px-4 bg-slate-700 dark:bg-slate-600 text-white text-sm font-bold hover:bg-slate-600 dark:hover:bg-slate-500 transition-all">
Change Status
</button>
</div>
</div>
<!-- Manage Beneficiaries Section -->
<div class="flex justify-between items-center pb-4">
<h2 class="text-slate-900 dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]">Manage Beneficiaries</h2>
<div class="flex gap-3 items-center">
<button id="saveChangesBtn" onclick="saveBeneficiaries()" class="hidden px-4 py-2 rounded-lg bg-primary text-white text-sm font-bold hover:opacity-90">Save Changes</button>
<button onclick="addBeneficiary()" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
<span class="material-symbols-outlined text-sm">add_circle</span>
Add Beneficiary
</button>
</div>
</div>
<div id="beneficiariesContainer" class="flex flex-col gap-4 mb-4">
<div class="text-center py-10 text-[#9c7349]">Loading beneficiaries...</div>
</div>
<!-- Danger Zone -->
<div class="rounded-xl border-2 border-red-500/20 bg-red-50/30 dark:bg-red-950/10 p-6 mb-12">
<div class="flex items-center gap-3 mb-4">
<span class="material-symbols-outlined text-red-500">warning</span>
<h2 class="text-red-700 dark:text-red-500 text-lg font-bold">Danger Zone</h2>
</div>
<p class="text-red-600/70 dark:text-red-500/60 text-sm mb-6 max-w-2xl">Actions in this section are permanent and may require legal authorization. Proceed with extreme caution.</p>
<div class="flex flex-wrap gap-4">
<button onclick="suspendTrust()" class="px-6 py-2.5 rounded-lg bg-white dark:bg-slate-900 border border-red-200 dark:border-red-900/50 text-red-600 dark:text-red-400 text-sm font-bold hover:bg-red-600 hover:text-white transition-all shadow-sm">
Suspend Trust
</button>
<button onclick="archiveTrust()" class="px-6 py-2.5 rounded-lg bg-red-600 text-white text-sm font-bold hover:bg-red-700 transition-all shadow-md">
Delete Trust
</button>
</div>
</div>
<!-- Footer-like padding -->
<div class="h-20"></div>
</div>
</main>
</div>

<!-- Custom Modal System -->
<div id="customModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-black/50 transition-opacity" onclick="closeModal()"></div>
        <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <div class="bg-white dark:bg-slate-900 px-4 pt-5 pb-4 sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10">
                        <span id="modalIcon" class="material-symbols-outlined text-primary text-xl">info</span>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                        <h3 id="modalTitle" class="text-lg leading-6 font-bold text-slate-900 dark:text-white"></h3>
                        <div class="mt-2">
                            <p id="modalMessage" class="text-sm text-slate-500 dark:text-slate-400"></p>
                            <div id="modalInput" class="hidden mt-4">
                                <input type="text" id="modalInputField" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white" placeholder="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-3">
                <button id="modalConfirmBtn" type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm"></button>
                <button id="modalCancelBtn" type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 dark:border-slate-700 shadow-sm px-4 py-2 bg-white dark:bg-slate-700 text-base font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-600 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
const trustId = <?php echo $trustId; ?>;
let currentTrust = null;
let beneficiariesState = [];
let hasBeneficiaryChanges = false;
let originalBeneficiariesState = [];

// Custom Modal Functions
var modalResolve = null;
var modalReject = null;

function showConfirmModal(title, message, confirmText = 'Confirm', cancelText = 'Cancel', type = 'warning') {
    return new Promise((resolve, reject) => {
        modalResolve = resolve;
        modalReject = reject;
        const modal = document.getElementById('customModal');
        const icon = document.getElementById('modalIcon');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');
        
        inputDiv.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = confirmText;
        cancelBtn.textContent = cancelText;
        
        if (type === 'danger') {
            icon.textContent = 'warning';
            icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10';
            icon.className = 'material-symbols-outlined text-red-600 dark:text-red-400 text-xl';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-bold text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        } else {
            icon.textContent = 'help';
            icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10';
            icon.className = 'material-symbols-outlined text-primary text-xl';
            confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        }
        
        confirmBtn.onclick = () => {
            closeModal();
            resolve(true);
        };
        
        modal.classList.remove('hidden');
    });
}

function showAlertModal(title, message, type = 'info') {
    return new Promise((resolve) => {
        const modal = document.getElementById('customModal');
        const icon = document.getElementById('modalIcon');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');
        
        inputDiv.classList.add('hidden');
        cancelBtn.classList.add('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        confirmBtn.textContent = 'OK';
        
        if (type === 'success') {
            icon.textContent = 'check_circle';
            icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20 sm:mx-0 sm:h-10 sm:w-10';
            icon.className = 'material-symbols-outlined text-green-600 dark:text-green-400 text-xl';
        } else if (type === 'error') {
            icon.textContent = 'error';
            icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10';
            icon.className = 'material-symbols-outlined text-red-600 dark:text-red-400 text-xl';
        } else {
            icon.textContent = 'info';
            icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10';
            icon.className = 'material-symbols-outlined text-primary text-xl';
        }
        
        confirmBtn.onclick = () => {
            closeModal();
            resolve();
        };
        
        modal.classList.remove('hidden');
    });
}

function showInputModal(title, message, placeholder, confirmText = 'Confirm') {
    return new Promise((resolve, reject) => {
        modalResolve = resolve;
        modalReject = reject;
        const modal = document.getElementById('customModal');
        const icon = document.getElementById('modalIcon');
        const titleEl = document.getElementById('modalTitle');
        const messageEl = document.getElementById('modalMessage');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        const inputDiv = document.getElementById('modalInput');
        const inputField = document.getElementById('modalInputField');
        
        inputDiv.classList.remove('hidden');
        cancelBtn.classList.remove('hidden');
        titleEl.textContent = title;
        messageEl.textContent = message;
        inputField.placeholder = placeholder;
        inputField.value = '';
        confirmBtn.textContent = confirmText;
        
        icon.textContent = 'edit';
        icon.parentElement.className = 'mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary/10 sm:mx-0 sm:h-10 sm:w-10';
        icon.className = 'material-symbols-outlined text-primary text-xl';
        confirmBtn.className = 'w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-primary text-base font-bold text-white hover:bg-primary/90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm';
        
        const handleConfirm = () => {
            const value = inputField.value.trim();
            if (value) {
                closeModal();
                resolve(value);
            }
        };
        
        confirmBtn.onclick = handleConfirm;
        inputField.onkeypress = (e) => {
            if (e.key === 'Enter') handleConfirm();
        };
        
        inputField.focus();
        modal.classList.remove('hidden');
    });
}

function closeModal() {
    const modal = document.getElementById('customModal');
    const cancelBtn = document.getElementById('modalCancelBtn');
    modal.classList.add('hidden');
    cancelBtn.classList.remove('hidden');
    if (modalReject) {
        modalReject(false);
        modalReject = null;
    }
}

async function loadTrustData() {
    if (!trustId) {
        await showAlertModal('Error', 'Invalid trust ID', 'error');
        window.location.href = 'dashboard.php';
        return;
    }
    
    try {
        const response = await fetch(`../../api/user/trusts.php?id=${trustId}`);
        const data = await response.json();
        
        if (data.success && data.trust) {
            const trust = data.trust;
            currentTrust = trust;
            document.getElementById('trustName').textContent = trust.trust_name || 'Untitled Trust';
            document.getElementById('trustId').textContent = `ID: ${trust.id || 'N/A'}`;
            document.getElementById('trustTypeBadge').textContent = trust.trust_type || 'Standard';
            updateStatusUI(trust);
            
            // Load beneficiaries if available
            beneficiariesState = Array.isArray(trust.beneficiaries) ? trust.beneficiaries : [];
            originalBeneficiariesState = JSON.parse(JSON.stringify(beneficiariesState));
            hasBeneficiaryChanges = false;
            renderBeneficiaries(beneficiariesState);
            document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
            updateSaveButtonVisibility();
        } else {
            await showAlertModal('Error', 'Trust not found', 'error');
            window.location.href = 'dashboard.php';
        }
    } catch (error) {
        console.error('Error loading trust:', error);
        await showAlertModal('Error', 'Error loading trust data', 'error');
    }
}

function renderBeneficiaries(beneficiaries) {
    const container = document.getElementById('beneficiariesContainer');
    if (!beneficiaries || beneficiaries.length === 0) {
        container.innerHTML = '<div class="text-center py-10 text-slate-500 dark:text-slate-400">No beneficiaries added yet. Click "Add Beneficiary".</div>';
        return;
    }
    
    const html = `
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            ${beneficiaries.map((ben, idx) => `
                <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="size-10 rounded-full bg-primary/10 text-primary flex items-center justify-center font-bold flex-shrink-0">${escapeHtml((ben.name || 'B').charAt(0).toUpperCase())}</div>
                            <div class="min-w-0">
                                <p class="text-slate-900 dark:text-white font-black truncate">Beneficiary #${idx + 1}${ben.is_myself ? ' (Myself)' : ''}</p>
                                <p class="text-slate-500 dark:text-slate-400 text-xs truncate">${escapeHtml(ben.relationship || '')}${ben.email ? ' · ' + escapeHtml(ben.email) : ''}</p>
                            </div>
                        </div>
                        <button onclick="removeBeneficiary(${idx})" class="text-red-600 dark:text-red-400 text-xs font-bold hover:underline">Remove</button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Name</label>
                            <input value="${escapeHtml(ben.name || '')}" oninput="updateBeneficiary(${idx}, 'name', this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Relationship</label>
                            <input value="${escapeHtml(ben.relationship || '')}" oninput="updateBeneficiary(${idx}, 'relationship', this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Email</label>
                            <input value="${escapeHtml(ben.email || '')}" oninput="updateBeneficiary(${idx}, 'email', this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white"/>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Allocation %</label>
                            <input type="number" min="0" max="100" step="0.01" value="${ben.allocation ?? 0}" oninput="updateBeneficiary(${idx}, 'allocation', this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white"/>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Wallet Address (optional)</label>
                            <input value="${escapeHtml(ben.wallet_address || '')}" oninput="updateBeneficiary(${idx}, 'wallet_address', this.value)" class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white"/>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
        <div class="mt-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-4">
            <p class="text-sm font-bold text-slate-900 dark:text-white">Total Allocation: <span id="allocationTotal">0</span>%</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Must equal 100% before saving.</p>
        </div>
    `;
    container.innerHTML = html;
    updateAllocationTotal();
}

async function editTrustName() {
    const currentName = document.getElementById('trustName').textContent;
    try {
        const newName = await showInputModal('Edit Trust Name', 'Enter a new name for this trust:', currentName, 'Save');
        if (newName && newName.trim() !== currentName) {
            await updateTrustName(newName.trim());
        }
    } catch (e) {
        // User cancelled
    }
}

async function changeStatus() {
    const currentStatus = currentTrust?.status || 'active';
    const newStatus = currentStatus.toLowerCase() === 'active' ? 'inactive' : 'active';
    const confirmed = await showConfirmModal(
        'Change Trust Status',
        `Are you sure you want to change the trust status from "${currentStatus}" to "${newStatus}"?`,
        'Change Status',
        'Cancel'
    );
    if (confirmed) {
        await updateTrustStatus(newStatus);
    }
}

function addBeneficiary() {
    beneficiariesState.push({
        name: '',
        relationship: '',
        email: '',
        allocation: 0,
        wallet_address: '',
        is_myself: false
    });
    hasBeneficiaryChanges = true;
    renderBeneficiaries(beneficiariesState);
    document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
    updateSaveButtonVisibility();
}

async function suspendTrust() {
    const confirmed = await showConfirmModal(
        'Suspend Trust',
        'Are you sure you want to suspend this trust? The trust status will be changed to inactive. This action may be reversible.',
        'Suspend Trust',
        'Cancel',
        'warning'
    );
    if (confirmed) {
        await updateTrustStatus('inactive');
    }
}

async function archiveTrust() {
    const confirmed = await showConfirmModal(
        'Delete Trust',
        'Are you sure you want to permanently delete this trust? This action cannot be undone and all trust data will be permanently removed.',
        'Delete Trust',
        'Cancel',
        'danger'
    );
    if (confirmed) {
        try {
            const res = await fetch(`../../api/user/trusts.php?id=${trustId}`, {
                method: 'DELETE'
            });
            const data = await res.json();
            if (data.success) {
                await showAlertModal('Success', 'Trust deleted successfully', 'success');
                window.location.href = 'dashboard.php';
            } else {
                await showAlertModal('Error', data.message || 'Failed to delete trust', 'error');
            }
        } catch (e) {
            console.error(e);
            await showAlertModal('Error', 'Error deleting trust', 'error');
        }
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function updateBeneficiary(index, field, value) {
    if (!beneficiariesState[index]) return;
    if (field === 'allocation') {
        beneficiariesState[index][field] = parseFloat(value) || 0;
    } else {
        beneficiariesState[index][field] = value;
    }
    hasBeneficiaryChanges = true;
    updateAllocationTotal();
    updateSaveButtonVisibility();
}

function updateSaveButtonVisibility() {
    const saveBtn = document.getElementById('saveChangesBtn');
    if (saveBtn) {
        if (hasBeneficiaryChanges) {
            saveBtn.classList.remove('hidden');
        } else {
            saveBtn.classList.add('hidden');
        }
    }
}

function removeBeneficiary(index) {
    beneficiariesState.splice(index, 1);
    hasBeneficiaryChanges = true;
    renderBeneficiaries(beneficiariesState);
    document.getElementById('beneficiaryCount').textContent = beneficiariesState.length || 0;
    updateSaveButtonVisibility();
}

function updateAllocationTotal() {
    const total = beneficiariesState.reduce((sum, b) => sum + (parseFloat(b.allocation) || 0), 0);
    const el = document.getElementById('allocationTotal');
    if (el) el.textContent = total.toFixed(2);
}

async function saveBeneficiaries() {
    const total = beneficiariesState.reduce((sum, b) => sum + (parseFloat(b.allocation) || 0), 0);
    if (Math.abs(total - 100) > 0.01) {
        await showAlertModal('Validation Error', `Total allocation must equal 100%. Current total: ${total.toFixed(2)}%`, 'error');
        return;
    }
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, beneficiaries: beneficiariesState })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            beneficiariesState = Array.isArray(data.trust.beneficiaries) ? data.trust.beneficiaries : beneficiariesState;
            originalBeneficiariesState = JSON.parse(JSON.stringify(beneficiariesState));
            hasBeneficiaryChanges = false;
            renderBeneficiaries(beneficiariesState);
            updateSaveButtonVisibility();
            await showAlertModal('Success', 'Beneficiaries saved successfully.', 'success');
        } else {
            await showAlertModal('Error', data.message || 'Failed to save beneficiaries', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error saving beneficiaries', 'error');
    }
}

async function updateTrustName(newName) {
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, trust_name: newName })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            document.getElementById('trustName').textContent = data.trust.trust_name || newName;
            currentTrust.trust_name = data.trust.trust_name || newName;
            await showAlertModal('Success', 'Trust name updated successfully.', 'success');
        } else {
            await showAlertModal('Error', data.message || 'Failed to update trust name', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error updating trust name', 'error');
    }
}

function updateStatusUI(trust) {
    const statusRaw = (trust?.status || 'active').toString().toLowerCase();
    const paymentStatusRaw = (trust?.payment_status || '').toString().toLowerCase();

    const trustStatusEl = document.getElementById('trustStatus');
    const badgeEl = document.getElementById('statusBadge');
    const dotEl = document.getElementById('statusDot');

    if (!trustStatusEl || !badgeEl || !dotEl) return;

    let label = statusRaw;
    let badgeClass = 'font-bold';
    let dotClass = 'size-2 rounded-full';

    // If payment was rejected, surface it clearly even if status didn't change elsewhere
    if (paymentStatusRaw === 'rejected') {
        label = 'payment rejected';
        badgeClass += ' text-red-600 dark:text-red-400';
        dotClass += ' bg-red-500';
    } else if (statusRaw === 'pending') {
        label = 'pending';
        badgeClass += ' text-amber-600 dark:text-amber-400';
        dotClass += ' bg-amber-500 animate-pulse';
    } else if (statusRaw === 'active') {
        label = 'active';
        badgeClass += ' text-green-600 dark:text-green-400';
        dotClass += ' bg-green-500';
    } else if (statusRaw === 'inactive') {
        label = 'inactive';
        badgeClass += ' text-slate-600 dark:text-slate-300';
        dotClass += ' bg-slate-400';
    } else if (statusRaw === 'suspended') {
        label = 'suspended';
        badgeClass += ' text-red-600 dark:text-red-400';
        dotClass += ' bg-red-500';
    } else {
        label = statusRaw;
        badgeClass += ' text-slate-700 dark:text-slate-200';
        dotClass += ' bg-slate-400';
    }

    const pretty = label.replace(/_/g, ' ').replace(/\b\w/g, (c) => c.toUpperCase());
    trustStatusEl.textContent = pretty;
    badgeEl.textContent = pretty;
    badgeEl.className = badgeClass;
    dotEl.className = dotClass;
}

async function updateTrustStatus(newStatus) {
    try {
        const res = await fetch('../../api/user/trusts.php', {
            method: 'PATCH',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id: trustId, status: newStatus })
        });
        const data = await res.json();
        if (data.success && data.trust) {
            currentTrust = data.trust;
            updateStatusUI(currentTrust);
            await showAlertModal('Success', `Trust status updated to ${newStatus}.`, 'success');
            // Reload trust data to refresh UI
            await loadTrustData();
        } else {
            await showAlertModal('Error', data.message || 'Failed to update trust status', 'error');
        }
    } catch (e) {
        console.error(e);
        await showAlertModal('Error', 'Error updating trust status', 'error');
    }
}

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

// Quick Action Functions
function exportTrustReport() {
    if (!currentTrust) {
        showAlertModal('Error', 'Trust data not loaded yet', 'error');
        return;
    }
    
    // Generate CSV report
    const csv = [
        ['Trust Report', ''],
        ['Trust Name', currentTrust.trust_name || 'Untitled Trust'],
        ['Trust Type', currentTrust.trust_type || 'Standard'],
        ['Status', currentTrust.status || 'Active'],
        ['Created', currentTrust.created_at ? new Date(currentTrust.created_at).toLocaleDateString() : 'N/A'],
        [''],
        ['Beneficiaries', ''],
        ['Name', 'Relationship', 'Email', 'Allocation %', 'Wallet Address']
    ];
    
    if (Array.isArray(currentTrust.beneficiaries)) {
        currentTrust.beneficiaries.forEach(ben => {
            csv.push([
                ben.name || '',
                ben.relationship || '',
                ben.email || '',
                ben.allocation || 0,
                ben.wallet_address || ''
            ]);
        });
    }
    
    const csvContent = csv.map(row => row.map(cell => `"${cell}"`).join(',')).join('\n');
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', `trust-report-${currentTrust.id}-${new Date().toISOString().split('T')[0]}.csv`);
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function printTrustDetails() {
    window.print();
}

async function shareWithAdvisor() {
    if (!currentTrust) {
        await showAlertModal('Error', 'Trust data not loaded yet', 'error');
        return;
    }
    
    try {
        const email = await showInputModal(
            'Share with Advisor',
            'Enter the email address of your advisor:',
            'advisor@example.com',
            'Send'
        );
        
        if (email && email.includes('@')) {
            // In a real implementation, this would send an email via API
            // For now, we'll use mailto link
            const subject = encodeURIComponent(`Trust Details: ${currentTrust.trust_name || 'Untitled Trust'}`);
            const body = encodeURIComponent(`Please review the details of my trust.\n\nTrust ID: ${currentTrust.id}\nTrust Name: ${currentTrust.trust_name || 'Untitled Trust'}\nStatus: ${currentTrust.status || 'Active'}`);
            window.location.href = `mailto:${email}?subject=${subject}&body=${body}`;
            await showAlertModal('Success', `Share link prepared for ${email}. Your email client should open.`, 'success');
        } else if (email) {
            await showAlertModal('Error', 'Please enter a valid email address', 'error');
        }
    } catch (e) {
        // User cancelled
    }
}

// Load trust data on page load
document.addEventListener('DOMContentLoaded', loadTrustData);
</script>
</div>
</div>
</body>
</html>
