<style>
/* Enhanced Topbar */
.fi-topbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3) !important;
}
.fi-topbar .fi-topbar-item,
.fi-topbar .fi-topbar-item a {
    color: white !important;
}

/* Enhanced Sidebar */
.fi-sidebar {
    background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%) !important;
    transition: width 0.3s, min-width 0.3s;
}
.fi-sidebar.collapsed {
    width: 60px !important;
    min-width: 60px !important;
    overflow-x: hidden;
}
.fi-sidebar-nav-item > .fi-sidebar-nav-item-button {
    color: rgba(255, 255, 255, 0.8) !important;
    border-radius: 0.75rem;
    margin: 0.25rem 0.5rem;
    transition: all 0.2s ease;
}
.fi-sidebar-nav-item > .fi-sidebar-nav-item-button:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
}

/* Stats Card */
.fi-stats-card {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 1rem !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.fi-stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}
</style>

<!-- SIDEBAR TOGGLE BUTTON - you can place this anywhere visible, e.g., in your main admin panel header -->
<button id="sidebar-toggle" class="p-2 m-2 bg-white text-indigo-900 rounded shadow" style="position:fixed;top:16px;left:16px;z-index:1000;">
    <!-- Hamburger Icon SVG -->
    <svg width="24" height="24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>

<script>
// Wait for DOM content to be ready
document.addEventListener('DOMContentLoaded', function() {
    // Find Filament sidebar by class
    var sidebar = document.querySelector('.fi-sidebar');
    var btn = document.getElementById('sidebar-toggle');
    if (sidebar && btn) {
        btn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
});
</script>
