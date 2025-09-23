<button
    id="sidebar-toggle"
    style="position:absolute; top:1rem; left:-0.1rem; z-index:1000; background:#fff; color:#1e3a8a; border-radius:0.75rem; box-shadow:0 2px 8px rgba(0,0,0,0.15); border:none; padding:0.5rem 0.75rem;"
>
    <!-- Hamburger icon -->
    <svg width="24" height="24" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var sidebar = document.querySelector('.fi-sidebar');
    var toggleBtn = document.getElementById('sidebar-toggle');
    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
        });
    }
});
</script>
