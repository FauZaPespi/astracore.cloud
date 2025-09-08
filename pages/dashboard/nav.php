<?php
if (isset($_GET['tab'])) {
    $currentTab = $_GET['tab'];
} else {
    $currentTab = 'devices-list';
}
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <span class="sidebar-logo">AstraCore</span>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="?tab=devices-list" class="nav-link <?= ($currentTab == 'devices-list') ? 'active' : '' ?>">
                    <i class="bi bi-list-ul"></i>
                    <span>Device list</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?tab=modules-list" class="nav-link <?= ($currentTab == 'modules-list') ? 'active' : '' ?>">
                    <i class="bi bi-puzzle"></i>
                    <span>Module list</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?tab=devices-add" class="nav-link <?= ($currentTab == 'devices-add') ? 'active' : '' ?>">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add Device</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?tab=devices-remove" class="nav-link <?= ($currentTab == 'devices-remove') ? 'active' : '' ?>">
                    <i class="bi bi-dash-circle"></i>
                    <span>Remove Device</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="?tab=settings" class="nav-link <?= ($currentTab == 'settings') ? 'active' : '' ?>">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <li class="nav-item nav-logout">
                <a href="?action=logout" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>