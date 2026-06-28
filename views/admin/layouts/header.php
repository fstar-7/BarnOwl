<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? SanitizeHelper::escape($pageTitle) : 'Admin | BarnOwl' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
    <?php foreach ($extraCss as $css) : ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/<?= SanitizeHelper::escape($css) ?>">
    <?php endforeach; ?>
</head>
<body>

<div class="admin-wrapper">

    <!-- ── SIDEBAR ── -->
    <aside class="admin-sidebar">
        <a href="<?= BASE_URL ?>/admin" class="sidebar-brand">
            <span class="logo-badge logo-badge-sm">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logo">
            </span>
            <span>Barn Owl</span>
        </a>

        <nav class="sidebar-nav">
            <div class="sidebar-section">Manajemen</div>

            <?php
            $navItems = [
                ['icon' => 'bi-speedometer2', 'label' => 'Dashboard',       'route' => '/admin'],
                ['icon' => 'bi-controller',   'label' => 'Kelola Game',      'route' => '/admin/games'],
                ['icon' => 'bi-people',       'label' => 'Kelola User',      'route' => '/admin/users'],
                ['icon' => 'bi-receipt',      'label' => 'Riwayat Order',    'route' => '/admin/orders'],
                ['icon' => 'bi-headset',      'label' => 'Support Tickets',  'route' => '/admin/support'],
                ['icon' => 'bi-images',       'label' => 'Carousel Banner',  'route' => '/admin/carousel'],
            ];
            foreach ($navItems as $item) :
                $isActive = str_starts_with('/' . $currentRoute, $item['route'])
                            && ($item['route'] === '/admin' ? $currentRoute === 'admin' : true);
            ?>
                <a href="<?= BASE_URL . $item['route'] ?>"
                   class="sidebar-link <?= $isActive ? 'active' : '' ?>">
                    <i class="bi <?= $item['icon'] ?>"></i>
                    <?= $item['label'] ?>
                </a>
            <?php endforeach; ?>

            <div class="sidebar-section mt-3">Navigasi</div>
            <a href="<?= BASE_URL ?>/" class="sidebar-link">
                <i class="bi bi-arrow-left-circle"></i> Kembali ke Toko
            </a>
            <a href="<?= BASE_URL ?>/logout" class="sidebar-link sidebar-link-danger"
               onclick="return confirm('Yakin ingin logout?')">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>

        <div class="sidebar-footer">
            <i class="bi bi-shield-lock me-1"></i>
            Admin Panel · Barn Owl
        </div>
    </aside>

    <!-- ── MAIN ── -->
    <div class="admin-main">

        <!-- Topbar -->
        <header class="admin-topbar">
            <span class="topbar-title">
                <i class="bi bi-speedometer2 me-2"></i>
                <?= isset($pageTitle) ? SanitizeHelper::escape(explode(' | ', $pageTitle)[0]) : 'Dashboard' ?>
            </span>
            <div class="topbar-user">
                <?= AvatarHelper::render(AuthHelper::avatar(), AuthHelper::username(), 'avatar-sm topbar-avatar') ?>
                <div>
                    <div class="topbar-name"><?= SanitizeHelper::escape(AuthHelper::username()) ?></div>
                    <div class="topbar-role">Administrator</div>
                </div>
            </div>
        </header>

        <div class="admin-content">
