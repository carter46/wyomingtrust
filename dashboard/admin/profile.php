<?php
require_once __DIR__ . '/../../api/helpers.php';

// Check admin authentication
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

$page_title = 'Admin Profile';

// Include shared layout
require_once __DIR__ . '/includes/layout.php';

function renderProfileContent() {
?>

<div class="mb-6 sm:mb-8">
    <h1 class="text-2xl sm:text-3xl font-bold text-navy-900 dark:text-white mb-2">Admin Profile</h1>
    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-400">Manage your account settings and preferences</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
    <!-- Change Password Section -->
    <div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="text-xl font-bold text-navy-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-icons-outlined text-primary">lock</span>
            <span>Change Password</span>
        </h2>
        <form id="passwordForm" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Current Password *</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password" required minlength="8"
                           class="w-full px-4 py-2 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    <button type="button" onclick="togglePasswordVisibility('current_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
                        <span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">New Password *</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password" required minlength="8"
                           class="w-full px-4 py-2 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    <button type="button" onclick="togglePasswordVisibility('new_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
                        <span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
                    </button>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Minimum 8 characters</p>
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Confirm New Password *</label>
                <div class="relative">
                    <input type="password" name="confirm_password" id="confirm_password" required minlength="8"
                           class="w-full px-4 py-2 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    <button type="button" onclick="togglePasswordVisibility('confirm_password', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
                        <span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
                    </button>
                </div>
            </div>
            <button type="submit" class="w-full bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                Update Password
            </button>
        </form>
        <div id="passwordMessage" class="mt-4"></div>
    </div>

    <!-- Change Email Section -->
    <div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="text-xl font-bold text-navy-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-icons-outlined text-primary">email</span>
            <span>Change Email Address</span>
        </h2>
        <form id="emailForm" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Current Email</label>
                <input type="email" id="currentEmail" readonly
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-navy-900 text-slate-600 dark:text-slate-400 cursor-not-allowed">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">New Email Address *</label>
                <input type="email" name="new_email" required
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
            </div>
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Confirm Password *</label>
                <div class="relative">
                    <input type="password" name="confirm_password_email" id="confirm_password_email" required
                           class="w-full px-4 py-2 pr-12 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                    <button type="button" onclick="togglePasswordVisibility('confirm_password_email', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none" aria-label="Toggle password visibility">
                        <span class="material-icons-outlined text-lg toggle-password-icon">visibility_off</span>
                    </button>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Enter your password to confirm email change</p>
            </div>
            <button type="submit" class="w-full bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                Update Email
            </button>
        </form>
        <div id="emailMessage" class="mt-4"></div>
    </div>

    <!-- Site Logo Upload -->
    <div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="text-xl font-bold text-navy-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-icons-outlined text-primary">image</span>
            <span>Site Logo</span>
        </h2>
        <div id="logoPreview" class="mb-4">
            <!-- Logo preview will be shown here -->
        </div>
        <form id="logoForm" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Upload Logo</label>
                <input type="file" name="logo" accept="image/png,image/jpeg,image/jpg,image/svg+xml" 
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">PNG, JPG, or SVG. Max 2MB</p>
            </div>
            <button type="submit" class="w-full bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                Upload Logo
            </button>
        </form>
        <div id="logoMessage" class="mt-4"></div>
    </div>

    <!-- Site Favicon Upload -->
    <div class="bg-white dark:bg-navy-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
        <h2 class="text-xl font-bold text-navy-900 dark:text-white mb-4 flex items-center gap-2">
            <span class="material-icons-outlined text-primary">bookmark</span>
            <span>Site Favicon</span>
        </h2>
        <div id="faviconPreview" class="mb-4">
            <!-- Favicon preview will be shown here -->
        </div>
        <form id="faviconForm" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-navy-900 dark:text-white mb-2">Upload Favicon</label>
                <input type="file" name="favicon" accept="image/png,image/x-icon,image/svg+xml" 
                       class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-navy-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary">
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">PNG, ICO, or SVG. Max 500KB. Recommended: 32x32px</p>
            </div>
            <button type="submit" class="w-full bg-primary text-navy-900 px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                Upload Favicon
            </button>
        </form>
        <div id="faviconMessage" class="mt-4"></div>
    </div>
</div>

<script src="includes/modal.js"></script>
<script>
    // Load current admin data
    async function loadAdminData() {
        try {
            const response = await fetch('../../api/admin/profile.php');
            const data = await response.json();
            
            if (data.success) {
                const admin = data.admin;
                document.getElementById('currentEmail').value = admin.email || '';
                
                // Load logo preview
                if (admin.logo) {
                    document.getElementById('logoPreview').innerHTML = `
                        <img src="../../${admin.logo}" alt="Site Logo" class="max-h-24 max-w-48 object-contain border border-slate-200 dark:border-slate-600 rounded-lg p-2">
                    `;
                } else {
                    document.getElementById('logoPreview').innerHTML = '<p class="text-sm text-slate-500">No logo uploaded</p>';
                }
                
                // Load favicon preview
                if (admin.favicon) {
                    document.getElementById('faviconPreview').innerHTML = `
                        <img src="../../${admin.favicon}" alt="Site Favicon" class="h-16 w-16 object-contain border border-slate-200 dark:border-slate-600 rounded-lg p-2">
                    `;
                } else {
                    document.getElementById('faviconPreview').innerHTML = '<p class="text-sm text-slate-500">No favicon uploaded</p>';
                }
            }
        } catch (error) {
            console.error('Error loading admin data:', error);
        }
    }

    // Password form handler
    document.getElementById('passwordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageDiv = document.getElementById('passwordMessage');
        
        const currentPassword = formData.get('current_password');
        const newPassword = formData.get('new_password');
        const confirmPassword = formData.get('confirm_password');
        
        if (newPassword !== confirmPassword) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Passwords do not match</div>';
            return;
        }
        
        if (newPassword.length < 8) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Password must be at least 8 characters</div>';
            return;
        }
        
        try {
            const response = await fetch('../../api/admin/profile.php', {
                method: 'PATCH',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    action: 'change_password',
                    current_password: currentPassword,
                    new_password: newPassword
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                messageDiv.innerHTML = '<div class="bg-green-50 dark:bg-green-900/20 border border-green-400 rounded-lg p-3 text-green-700 dark:text-green-400 text-sm">Password updated successfully</div>';
                this.reset();
                showToast('Password updated successfully', 'success');
            } else {
                messageDiv.innerHTML = `<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">${escapeHtml(data.message || 'Failed to update password')}</div>`;
            }
        } catch (error) {
            console.error('Error updating password:', error);
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Error updating password. Please try again.</div>';
        }
    });

    // Email form handler
    document.getElementById('emailForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageDiv = document.getElementById('emailMessage');
        
        const newEmail = formData.get('new_email');
        const password = formData.get('confirm_password_email');
        
        if (!validateEmail(newEmail)) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Invalid email address</div>';
            return;
        }
        
        try {
            const response = await fetch('../../api/admin/profile.php', {
                method: 'PATCH',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({
                    action: 'change_email',
                    new_email: newEmail,
                    password: password
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                messageDiv.innerHTML = '<div class="bg-green-50 dark:bg-green-900/20 border border-green-400 rounded-lg p-3 text-green-700 dark:text-green-400 text-sm">Email updated successfully</div>';
                document.getElementById('currentEmail').value = newEmail;
                this.reset();
                showToast('Email updated successfully', 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                messageDiv.innerHTML = `<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">${escapeHtml(data.message || 'Failed to update email')}</div>`;
            }
        } catch (error) {
            console.error('Error updating email:', error);
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Error updating email. Please try again.</div>';
        }
    });

    // Logo form handler
    document.getElementById('logoForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageDiv = document.getElementById('logoMessage');
        
        if (!formData.get('logo') || formData.get('logo').size === 0) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Please select a file</div>';
            return;
        }
        
        if (formData.get('logo').size > 2 * 1024 * 1024) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">File size must be less than 2MB</div>';
            return;
        }
        
        try {
            const response = await fetch('../../api/admin/profile.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                messageDiv.innerHTML = '<div class="bg-green-50 dark:bg-green-900/20 border border-green-400 rounded-lg p-3 text-green-700 dark:text-green-400 text-sm">Logo uploaded successfully</div>';
                showToast('Logo uploaded successfully', 'success');
                loadAdminData();
                this.reset();
            } else {
                messageDiv.innerHTML = `<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">${escapeHtml(data.message || 'Failed to upload logo')}</div>`;
            }
        } catch (error) {
            console.error('Error uploading logo:', error);
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Error uploading logo. Please try again.</div>';
        }
    });

    // Favicon form handler
    document.getElementById('faviconForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const messageDiv = document.getElementById('faviconMessage');
        
        if (!formData.get('favicon') || formData.get('favicon').size === 0) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Please select a file</div>';
            return;
        }
        
        if (formData.get('favicon').size > 500 * 1024) {
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">File size must be less than 500KB</div>';
            return;
        }
        
        try {
            const response = await fetch('../../api/admin/profile.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                messageDiv.innerHTML = '<div class="bg-green-50 dark:bg-green-900/20 border border-green-400 rounded-lg p-3 text-green-700 dark:text-green-400 text-sm">Favicon uploaded successfully</div>';
                showToast('Favicon uploaded successfully', 'success');
                loadAdminData();
                this.reset();
            } else {
                messageDiv.innerHTML = `<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">${escapeHtml(data.message || 'Failed to upload favicon')}</div>`;
            }
        } catch (error) {
            console.error('Error uploading favicon:', error);
            messageDiv.innerHTML = '<div class="bg-red-50 dark:bg-red-900/20 border border-red-400 rounded-lg p-3 text-red-700 dark:text-red-400 text-sm">Error uploading favicon. Please try again.</div>';
        }
    });

    function escapeHtml(text) {
        if (typeof text !== 'string') return text;
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // Password visibility toggle function
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('.toggle-password-icon');
        
        if (input && icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        }
    }

    // Load admin data on page load
    loadAdminData();
</script>

<?php
}

// Render the layout with profile content
renderAdminLayout($page_title, 'profile', 'renderProfileContent');
?>
