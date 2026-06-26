<!-- Stat Cards -->
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(138,77,255,.12);">
            <i class="bi bi-controller" style="color:#c4b5fd;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Game</div>
            <div class="stat-value" style="color:#c4b5fd;"><?= (int) $totalGames ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(59,130,246,.12);">
            <i class="bi bi-people" style="color:#93c5fd;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total User</div>
            <div class="stat-value" style="color:#93c5fd;"><?= (int) $totalUsers ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(234,179,8,.10);">
            <i class="bi bi-cash-stack" style="color:#fde047;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Total Revenue</div>
            <div class="stat-value" style="color:#fde047;font-size:1.1rem;"><?= FormatHelper::rupiah($totalRevenue) ?></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:rgba(239,68,68,.10);">
            <i class="bi bi-headset" style="color:#fca5a5;"></i>
        </div>
        <div class="stat-info">
            <div class="stat-label">Tiket Terbuka</div>
            <div class="stat-value" style="color:#fca5a5;"><?= (int) $openTickets ?></div>
        </div>
    </div>
</div>

<!-- Recent Orders -->
<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-receipt me-2 text-purple"></i>Order Terbaru</h5>
        <div class="d-flex gap-2">
            <a href="<?= BASE_URL ?>/admin/orders/export" class="btn-admin btn-admin-outline">
                <i class="bi bi-download me-1"></i>Export CSV
            </a>
            <a href="<?= BASE_URL ?>/admin/orders" class="btn-admin btn-admin-purple">
                Lihat Semua
            </a>
        </div>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($recentOrders, 0, 5) as $order) :
                    $badgeClass = match($order['status']) {
                        'paid', 'completed' => 'badge-success',
                        'pending'           => 'badge-warning',
                        default             => 'badge-muted',
                    };
                ?>
                <tr>
                    <td class="text-mono text-muted">#<?= (int) $order['id'] ?></td>
                    <td class="fw-600 text-blue">@<?= SanitizeHelper::escape($order['username']) ?></td>
                    <td class="fw-700 text-yellow"><?= FormatHelper::rupiah((int) $order['total']) ?></td>
                    <td><span class="admin-badge <?= $badgeClass ?>"><?= strtoupper($order['status']) ?></span></td>
                    <td class="text-muted text-sm"><?= date('d M Y', strtotime($order['created_at'])) ?></td>
                    <td>
                        <?php if ($order['status'] === 'pending') : ?>
                            <a href="<?= BASE_URL ?>/admin/orders/approve/<?= (int) $order['id'] ?>"
                               class="btn-icon btn-icon-success" title="Approve"
                               onclick="return confirm('Setujui order ini?')">
                                <i class="bi bi-check-circle"></i>
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Games -->
<div class="admin-panel mt-4">
    <div class="panel-header">
        <h5><i class="bi bi-controller me-2 text-purple"></i>Game Terbaru</h5>
        <a href="<?= BASE_URL ?>/admin/games/create" class="btn-admin btn-admin-purple">
            <i class="bi bi-plus-lg me-1"></i>Tambah Game
        </a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>#</th><th>Cover</th><th>Nama Game</th><th>Harga</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($recentGames, 0, 5) as $i => $game) :
                    $badgeClass = match($game['status']) {
                        'featured'    => 'badge-purple',
                        'new_release' => 'badge-success',
                        default       => 'badge-muted',
                    };
                ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td>
                        <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['thumbnail']) ?>"
                             class="game-thumb" alt="">
                    </td>
                    <td class="fw-600"><?= SanitizeHelper::escape($game['name']) ?></td>
                    <td><?= FormatHelper::rupiah((int) $game['price']) ?></td>
                    <td><span class="admin-badge <?= $badgeClass ?>"><?= SanitizeHelper::escape($game['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/games/edit/<?= (int) $game['id'] ?>" class="btn-icon btn-icon-edit"><i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>/admin/games/delete/<?= (int) $game['id'] ?>" class="btn-icon btn-icon-del ms-1"
                           onclick="return confirm('Hapus game ini?')"><i class="bi bi-trash3"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
