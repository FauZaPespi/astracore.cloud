<?php
session_start();
if (isset($_GET['tab'])) {
    $currentTab = $_GET['tab'];
} else {
    $currentTab = 'devices-list';
}
?>

<aside class="sidebar">
    <div class="sidebar-header">
        <a href="/astracore" style="text-decoration: none;"><span class="sidebar-logo">AstraCore</span></a>
    </div>
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <li class="nav-item">
                <a href="dashboard/?tab=devices-list" class="nav-link <?= ($currentTab == 'devices-list') ? 'active' : '' ?>">
                    <i class="bi bi-list-ul"></i>
                    <span>Device list</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="dashboard/?tab=modules-list" class="nav-link <?= ($currentTab == 'modules-list') ? 'active' : '' ?>">
                    <i class="bi bi-puzzle"></i>
                    <span>Module list</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="dashboard/?tab=devices-add" class="nav-link <?= ($currentTab == 'devices-add') ? 'active' : '' ?>">
                    <i class="bi bi-plus-circle"></i>
                    <span>Add Device</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="dashboard/?tab=settings" class="nav-link <?= ($currentTab == 'settings') ? 'active' : '' ?>">
                    <i class="bi bi-gear"></i>
                    <span>Settings</span>
                </a>
            </li>
            <?php
            if ($_SESSION["role"] == "admin")
            {?>
                <li class="nav-item">
                <a href="dashboard/?tab=admin" class="nav-link <?= ($currentTab == 'admin') ? 'active' : '' ?>">
                    <i class="bi bi-shield"></i>
                    <span>Admin</span>
                </a>
            </li>
            <?php } ?>
            <li class="nav-item nav-logout">
                <a href="dashboard/?action=logout" class="nav-link logout-link">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>