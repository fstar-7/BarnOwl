<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-controller me-2 text-purple"></i>Daftar Game</h5>
        <a href="<?= BASE_URL ?>/admin/games/create" class="btn-admin btn-admin-purple">
            <i class="bi bi-plus-lg me-1"></i>Tambah Game
        </a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>#</th><th>Cover</th><th>Nama Game</th><th>Harga</th><th>Diskon</th><th>Harga Final</th><th>Rating</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($games as $i => $game) :
                    $finalPrice = Game::calcFinalPrice((int)$game['price'], (int)($game['discount']??0));
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
                    <td>
                        <div class="fw-600"><?= SanitizeHelper::escape($game['name']) ?></div>
                        <div class="text-muted text-sm"><?= number_format((int)$game['views'],0,',','.') ?> views · ★ <?= $game['rating'] ?></div>
                    </td>
                    <td class="text-muted line-through"><?= FormatHelper::rupiah((int)$game['price']) ?></td>
                    <td>
                        <?php if ($game['discount'] > 0) : ?>
                            <span class="admin-badge badge-danger">-<?= $game['discount'] ?>%</span>
                        <?php else : ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                    <td class="fw-700 text-green"><?= FormatHelper::rupiah($finalPrice) ?></td>
                    <td class="text-yellow">★ <?= $game['rating'] ?></td>
                    <td><span class="admin-badge <?= $badgeClass ?>"><?= SanitizeHelper::escape($game['status']) ?></span></td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/games/edit/<?= (int)$game['id'] ?>" class="btn-icon btn-icon-edit" title="Edit"><i class="bi bi-pencil"></i></a>
                        <a href="<?= BASE_URL ?>/admin/games/delete/<?= (int)$game['id'] ?>" class="btn-icon btn-icon-del ms-1"
                           title="Hapus" onclick="return confirm('Hapus game ini?')"><i class="bi bi-trash3"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($games)) : ?>
                    <tr><td colspan="9" class="text-center text-muted py-5">Belum ada game.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
