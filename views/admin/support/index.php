<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-headset me-2 text-purple"></i>Support Tickets</h5>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>#</th><th>Nama</th><th>Email</th><th>Pesan</th><th>Status</th><th>Dikirim</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $i => $ticket) :
                    $badgeClass = $ticket['status'] === 'Open' ? 'badge-warning' : 'badge-muted';
                ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td class="fw-600"><?= SanitizeHelper::escape($ticket['nama']) ?></td>
                    <td class="text-blue text-sm"><?= SanitizeHelper::escape($ticket['email']) ?></td>
                    <td class="text-muted text-sm ticket-msg"><?= SanitizeHelper::escape($ticket['pesan']) ?></td>
                    <td><span class="admin-badge <?= $badgeClass ?>"><?= SanitizeHelper::escape($ticket['status']) ?></span></td>
                    <td class="text-muted text-sm"><?= date('d M Y', strtotime($ticket['created_at'])) ?></td>
                    <td>
                        <?php if ($ticket['status'] === 'Open') : ?>
                            <form action="<?= BASE_URL ?>/admin/support/close/<?= (int) $ticket['id'] ?>" method="POST" style="display:inline"
                                  onsubmit="return confirm('Tandai tiket ini sebagai selesai?')">
                                <?= CsrfHelper::field() ?>
                                <button type="submit" class="btn-revoke">
                                    <i class="bi bi-check2-circle me-1"></i>Tutup
                                </button>
                            </form>
                        <?php else : ?>
                            <span class="text-muted text-sm">— selesai —</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($tickets)) : ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada tiket.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
