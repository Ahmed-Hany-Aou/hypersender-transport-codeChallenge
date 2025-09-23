<style>
/* Transportation Management Custom Styles */
.fi-topbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    box-shadow: 0 4px 20px rgba(102, 126, 234, 0.3) !important;
    border-bottom: none !important;
}

.fi-topbar .fi-topbar-item,
.fi-topbar .fi-topbar-item a,
.fi-topbar .fi-topbar-item button {
    color: white !important;
    font-weight: 500 !important;
}

.fi-sidebar {
    background: linear-gradient(180deg, #1e40af 0%, #1e3a8a 100%) !important;
    border-right: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.fi-sidebar-nav-item > .fi-sidebar-nav-item-button {
    color: rgba(255, 255, 255, 0.8) !important;
    border-radius: 0.75rem !important;
    margin: 0.25rem 0.5rem !important;
    transition: all 0.2s ease !important;
}

.fi-sidebar-nav-item > .fi-sidebar-nav-item-button:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: white !important;
    transform: translateX(4px) !important;
}

.fi-sidebar-nav-item-active > .fi-sidebar-nav-item-button {
    background-color: rgba(255, 255, 255, 0.15) !important;
    color: white !important;
    font-weight: 600 !important;
}

.fi-stats-card {
    background: rgba(255, 255, 255, 0.95) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    border-radius: 1rem !important;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1) !important;
    transition: transform 0.2s ease, box-shadow 0.2s ease !important;
}

.fi-stats-card:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15) !important;
}

.fi-stats-card .fi-stats-card-value {
    font-size: 2.5rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
}

.fi-stats-card .fi-stats-card-description {
    color: #6b7280 !important;
    font-weight: 500 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.05em !important;
}

/* Form styling */
.fi-input, .fi-select-input {
    border-radius: 0.75rem !important;
    border: 1.5px solid #d1d5db !important;
    transition: all 0.2s ease !important;
}

.fi-input:focus, .fi-select-input:focus {
    border-color: #667eea !important;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
}

.fi-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    border-radius: 0.75rem !important;
    font-weight: 600 !important;
    transition: all 0.2s ease !important;
}

.fi-btn-primary:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3) !important;
}
</style>