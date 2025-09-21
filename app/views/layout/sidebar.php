<?php
// Ambil nama controller dan action saat ini dari URL untuk menandai menu aktif
$controller_name = $_GET['controller'] ?? 'dashboard';
$action_name = $_GET['action'] ?? 'index';
?>
<div class="bg-dark border-right" id="sidebar-wrapper">
    <div class="sidebar-heading text-white">Point of Sale</div>
    <div class="list-group list-group-flush">

        <a href="index.php?controller=dashboard" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'dashboard') ? 'active' : '' ?>">
            <i class="fas fa-fw fa-tachometer-alt mr-2"></i>Dashboard
        </a>
        <a href="index.php?controller=sales&action=create" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'sales') ? 'active' : '' ?>">
            <i class="fas fa-fw fa-cash-register mr-2"></i>Transaksi Baru
        </a>
        
        <div class="sidebar-heading text-secondary pt-3">Master Data</div>
        <a href="index.php?controller=customer" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'customer') ? 'active' : '' ?>">
            <i class="fas fa-fw fa-users mr-2"></i>Data Customer
        </a>
        <a href="index.php?controller=item" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'item') ? 'active' : '' ?>">
            <i class="fas fa-fw fa-box mr-2"></i>Data Item
        </a>

        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
            <a href="index.php?controller=user" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'user') ? 'active' : '' ?>">
                <i class="fas fa-fw fa-user-shield mr-2"></i>Data Pengguna
            </a>
        <?php endif; ?>
        

        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
            <div class="sidebar-heading text-secondary pt-3">Laporan</div>
            <a href="#reportSubmenu" data-toggle="collapse" aria-expanded="<?= ($controller_name == 'report') ? 'true' : 'false' ?>" class="list-group-item list-group-item-action bg-dark text-white dropdown-toggle <?= ($controller_name == 'report') ? 'active' : '' ?>">
                <i class="fas fa-fw fa-chart-bar mr-2"></i>Laporan
            </a>
            <ul class="collapse list-unstyled <?= ($controller_name == 'report') ? 'show' : '' ?>" id="reportSubmenu">
                <li>
                    <a href="index.php?controller=report&action=sales" class="list-group-item list-group-item-action bg-secondary text-white pl-5">Laporan Penjualan</a>
                </li>
                <li>
                    <a href="index.php?controller=report&action=customers" class="list-group-item list-group-item-action bg-secondary text-white pl-5">Laporan Pelanggan</a>
                </li>
                <li>
                    <a href="index.php?controller=report&action=items" class="list-group-item list-group-item-action bg-secondary text-white pl-5">Laporan Stok Item</a>
                </li>
            </ul>
        <?php endif; ?>
        

        <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 1): ?>
            <div class="sidebar-heading text-secondary pt-3">Pengaturan</div>
            <a href="index.php?controller=identitas" class="list-group-item list-group-item-action bg-dark text-white <?= ($controller_name == 'identitas') ? 'active' : '' ?>">
                <i class="fas fa-fw fa-cogs mr-2"></i>Identitas Usaha
            </a>
        <?php endif; ?>

    </div>
</div>
<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle"><i class="fas fa-bars"></i></button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-user mr-2"></i><?= htmlspecialchars($_SESSION['username'] ?? 'Pengguna'); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-danger" href="index.php?controller=auth&action=logout">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid p-4">