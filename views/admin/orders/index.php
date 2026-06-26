<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-receipt me-2 text-purple"></i>Riwayat Order</h5>
        <a href="<?= BASE_URL ?>/admin/orders/export" class="btn-admin btn-admin-outline">
            <i class="bi bi-download me-1"></i>Export CSV
        </a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Tanggal</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) :
                    $badgeClass = match($order['status']) {
                        'paid','completed' => 'badge-success',
                        'pending'          => 'badge-warning',
                        default            => 'badge-muted',
                    };
                ?>
                <tr>
                    <td class="text-mono text-muted">#<?= (int) $order['id'] ?></td>
                    <td class="fw-600 text-blue">@<?= SanitizeHelper::escape($order['username']) ?></td>
                    <td class="fw-700 text-yellow"><?= FormatHelper::rupiah((int) $order['total']) ?></td>
                    <td><span class="admin-badge <?= $badgeClass ?>"><?= strtoupper($order['status']) ?></span></td>
                    <td class="text-muted text-sm"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                    <td>
                        <?php if ($order['status'] === 'pending') : ?>
                            <a href="<?= BASE_URL ?>/admin/orders/approve/<?= (int) $order['id'] ?>"
                               class="btn-icon btn-icon-success" title="Approve"
                               onclick="return confirm('Setujui order ini & masukkan game ke library user?')">
                                <i class="bi bi-check-circle"></i>
                            </a>
                        <?php else : ?>
                            <span class="text-muted text-sm">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)) : ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada order.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
