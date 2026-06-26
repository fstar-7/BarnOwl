<div class="admin-panel">
    <div class="panel-header">
        <h5><i class="bi bi-images me-2 text-purple"></i>Carousel Banner</h5>
        <a href="<?= BASE_URL ?>/admin/carousel/create" class="btn-admin btn-admin-purple">
            <i class="bi bi-plus-lg me-1"></i>Tambah Slide
        </a>
    </div>
    <div class="table-wrap">
        <table class="admin-table">
            <thead>
                <tr><th>Urutan</th><th>Preview</th><th>Judul</th><th>Subjudul</th><th>Game</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php foreach ($slides as $slide) : ?>
                <tr>
                    <td>
                        <div class="order-ctrl">
                            <a href="<?= BASE_URL ?>/admin/carousel/move/<?= (int) $slide['id'] ?>/up"
                               class="order-btn" title="Naik"><i class="bi bi-caret-up-fill"></i></a>
                            <span class="fw-700"><?= (int) $slide['order'] ?></span>
                            <a href="<?= BASE_URL ?>/admin/carousel/move/<?= (int) $slide['id'] ?>/down"
                               class="order-btn" title="Turun"><i class="bi bi-caret-down-fill"></i></a>
                        </div>
                    </td>
                    <td>
                        <img src="<?= BASE_URL ?>/assets/img/carousel/<?= SanitizeHelper::escape($slide['image']) ?>"
                             class="carousel-thumb" alt="">
                    </td>
                    <td class="fw-600"><?= SanitizeHelper::escape($slide['title']) ?></td>
                    <td class="text-muted text-sm"><?= SanitizeHelper::escape($slide['subtitle'] ?? '—') ?></td>
                    <td class="text-sm">
                        <?php if ($slide['game_name']) : ?>
                            <span class="text-purple-light"><?= SanitizeHelper::escape($slide['game_name']) ?></span>
                        <?php else : ?>
                            <span class="text-muted">— (ke store)</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/carousel/toggle/<?= (int) $slide['id'] ?>"
                           title="Toggle aktif">
                            <span class="admin-badge <?= $slide['is_active'] ? 'badge-success' : 'badge-muted' ?>">
                                <?= $slide['is_active'] ? 'AKTIF' : 'NONAKTIF' ?>
                            </span>
                        </a>
                    </td>
                    <td>
                        <a href="<?= BASE_URL ?>/admin/carousel/edit/<?= (int) $slide['id'] ?>"
                           class="btn-icon btn-icon-edit" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= BASE_URL ?>/admin/carousel/delete/<?= (int) $slide['id'] ?>"
                           class="btn-icon btn-icon-del ms-1" title="Hapus"
                           onclick="return confirm('Hapus slide ini?')">
                            <i class="bi bi-trash3"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($slides)) : ?>
                    <tr><td colspan="7" class="text-center text-muted py-5">Belum ada slide carousel.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
