<div class="admin-panel" style="max-width:680px;">
    <div class="panel-header">
        <h5><i class="bi bi-<?= $slide ? 'pencil-square' : 'images' ?> me-2 text-purple"></i>
            <?= $slide ? 'Edit Slide' : 'Tambah Slide Carousel' ?>
        </h5>
        <a href="<?= BASE_URL ?>/admin/carousel" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="p-4">
        <form method="POST"
              action="<?= BASE_URL . ($slide ? '/admin/carousel/update/' . $slide['id'] : '/admin/carousel/store') ?>"
              enctype="multipart/form-data">

            <div class="admin-form-group">
                <label class="admin-label">
                    Gambar Slide <?= $slide ? '<span class="text-muted">— kosongkan jika tidak diubah</span>' : '*' ?>
                </label>
                <?php if ($slide && $slide['image']) : ?>
                    <img src="<?= BASE_URL ?>/assets/img/carousel/<?= SanitizeHelper::escape($slide['image']) ?>"
                         class="img-preview mb-2" id="imgPreview">
                <?php else : ?>
                    <div class="img-preview-placeholder mb-2" id="imgPreviewPlaceholder">
                        <i class="bi bi-image"></i>
                    </div>
                <?php endif; ?>
                <input type="file" name="image" class="admin-input" accept=".jpg,.jpeg,.png,.webp"
                       <?= !$slide ? 'required' : '' ?>
                       onchange="previewImage(this)">
                <div class="text-muted text-sm mt-1">Rekomendasi: 1920×600px. Format JPG/PNG/WEBP.</div>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Judul Slide *</label>
                <input type="text" name="title" class="admin-input"
                       value="<?= SanitizeHelper::escape($slide['title'] ?? '') ?>"
                       placeholder="Contoh: CYBER HORIZON" required>
            </div>

            <div class="form-row-2">
                <div class="admin-form-group">
                    <label class="admin-label">Subjudul <span class="text-muted">(opsional)</span></label>
                    <input type="text" name="subtitle" class="admin-input"
                           value="<?= SanitizeHelper::escape($slide['subtitle'] ?? '') ?>"
                           placeholder="NOW AVAILABLE">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Nomor Urutan</label>
                    <input type="number" name="order" class="admin-input" min="1"
                           value="<?= (int) ($slide['order'] ?? 1) ?>">
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Deskripsi <span class="text-muted">(opsional)</span></label>
                <textarea name="description" class="admin-input" rows="2"
                          placeholder="Teks singkat di bawah judul..."><?= SanitizeHelper::escape($slide['description'] ?? '') ?></textarea>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Link ke Game <span class="text-muted">(kosongkan → arahkan ke store)</span></label>
                <select name="game_id" class="admin-input">
                    <option value="">— Arahkan ke halaman Store —</option>
                    <?php foreach ($games as $game) : ?>
                        <option value="<?= (int) $game['id'] ?>"
                                <?= ($slide['game_id'] ?? null) == $game['id'] ? 'selected' : '' ?>>
                            <?= SanitizeHelper::escape($game['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="admin-form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" <?= ($slide['is_active'] ?? 1) ? 'checked' : '' ?>>
                    Slide aktif (tampil di carousel)
                </label>
            </div>

            <div class="d-flex gap-3 mt-3">
                <button type="submit" class="btn-admin btn-admin-purple flex-fill py-2">
                    <i class="bi bi-floppy me-1"></i><?= $slide ? 'Simpan Perubahan' : 'Tambah Slide' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/carousel" class="btn-admin btn-admin-outline flex-fill py-2 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
