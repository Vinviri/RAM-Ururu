/**
 * RAM Ururu - Inventory Management System
 * Main JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    initSidebar();
    initDropdowns();
    initToasts();
});

/**
 * Sidebar toggle untuk mobile
 */
function initSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle = document.getElementById('sidebar-toggle');

    if (!sidebar || !toggle) return;

    toggle.addEventListener('click', function () {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
    });

    if (overlay) {
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            // Close sidebar on mobile
            if (sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
                document.body.style.overflow = '';
            }
            // Close any open modals
            document.querySelectorAll('.modal-overlay.show').forEach(m => {
                m.classList.remove('show');
            });
        }
    });
}

/**
 * Dropdown menu di sidebar
 */
function initDropdowns() {
    const toggles = document.querySelectorAll('.nav-toggle');

    toggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = this.closest('.nav-dropdown');

            document.querySelectorAll('.nav-dropdown').forEach(function (item) {
                if (item !== parent) {
                    item.classList.remove('open');
                }
            });

            parent.classList.toggle('open');
        });
    });
}

/**
 * Auto-dismiss toast notifications
 */
function initToasts() {
    document.querySelectorAll('.toast').forEach(function (toast) {
        setTimeout(function () {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(40px)';
            toast.style.transition = 'all 0.3s ease';
            setTimeout(function () {
                toast.style.display = 'none';
            }, 300);
        }, 4000);
    });
}
