<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-people me-2 text-purple"></i>Manajemen User</h5>
        <a href="<?= BASE_URL ?>/admin/users/export" class="btn-admin btn-admin-outline">
            <i class="bi bi-download me-1"></i>Export CSV
        </a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>#</th><th>User</th><th>Email</th><th>Role</th><th>Terdaftar</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($users as $i => $user) : ?>
                <tr>
                    <td class="text-muted"><?= $i + 1 ?></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="user-avatar"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                            <span class="fw-600">@<?= SanitizeHelper::escape($user['username']) ?></span>
                        </div>
                    </td>
                    <td class="text-blue text-sm"><?= SanitizeHelper::escape($user['email']) ?></td>
                    <td>
                        <span class="admin-badge <?= $user['role'] === 'admin' ? 'badge-danger' : 'badge-success' ?>">
                            <?= strtoupper($user['role']) ?>
                        </span>
                    </td>
                    <td class="text-muted text-sm"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                    <td>
                        <?php if ($user['id'] !== AuthHelper::id()) : ?>
                            <a href="<?= BASE_URL ?>/admin/users/delete/<?= (int)$user['id'] ?>"
                               class="btn-icon btn-icon-del"
                               onclick="return confirm('Hapus user @<?= SanitizeHelper::escape($user['username']) ?>?')">
                                <i class="bi bi-person-x"></i>
                            </a>
                        <?php else : ?>
                            <span class="text-muted text-sm">— akun aktif —</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($users)) : ?>
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada user.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
