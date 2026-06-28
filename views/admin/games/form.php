<div class="admin-panel" style="max-width:760px;">
    <div class="panel-header">
        <h5><i class="bi bi-<?= $game ? 'pencil-square' : 'plus-lg' ?> me-2 text-purple"></i>
            <?= $game ? 'Edit Game' : 'Tambah Game Baru' ?>
        </h5>
        <a href="<?= BASE_URL ?>/admin/games" class="btn-admin btn-admin-outline">
            <i class="bi bi-arrow-left me-1"></i>Kembali
        </a>
    </div>
    <div class="p-4">
        <form method="POST"
              action="<?= BASE_URL . ($game ? '/admin/games/update/' . $game['id'] : '/admin/games/store') ?>"
              enctype="multipart/form-data">
            <?= CsrfHelper::field() ?>

            <div class="form-row-2">
                <div class="admin-form-group">
                    <label class="admin-label">Nama Game *</label>
                    <input type="text" name="name" class="admin-input"
                           value="<?= SanitizeHelper::escape($game['name'] ?? '') ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Status</label>
                    <select name="status" class="admin-input">
                        <?php foreach (['regular'=>'Regular','featured'=>'Featured','new_release'=>'New Release'] as $val => $label) : ?>
                            <option value="<?= $val ?>" <?= ($game['status'] ?? '') === $val ? 'selected' : '' ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row-3">
                <div class="admin-form-group">
                    <label class="admin-label">Harga (Rp) *</label>
                    <input type="number" name="price" class="admin-input" min="0"
                           value="<?= (int)($game['price'] ?? 0) ?>" required>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Diskon (%)</label>
                    <input type="number" name="discount" class="admin-input" min="0" max="100"
                           value="<?= (int)($game['discount'] ?? 0) ?>">
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Rating (0-5)</label>
                    <input type="number" name="rating" class="admin-input" min="0" max="5" step="0.1"
                           value="<?= $game['rating'] ?? 0.0 ?>">
                </div>
            </div>

            <div class="form-row-2">
                <div class="admin-form-group">
                    <label class="admin-label">
                        Thumbnail (Card) <?= $game ? '<span class="text-muted">— kosongkan jika tidak diubah</span>' : '*' ?>
                    </label>
                    <?php if ($game && $game['thumbnail']) : ?>
                        <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['thumbnail']) ?>"
                             class="img-preview mb-2">
                    <?php endif; ?>
                    <input type="file" name="thumbnail" class="admin-input" accept=".jpg,.jpeg,.png,.webp"
                           <?= !$game ? 'required' : '' ?>>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">
                        Banner (Hero) <?= $game ? '<span class="text-muted">— opsional</span>' : '<span class="text-muted">opsional</span>' ?>
                    </label>
                    <?php if ($game && $game['banner']) : ?>
                        <img src="<?= BASE_URL ?>/assets/img/games/<?= SanitizeHelper::escape($game['banner']) ?>"
                             class="img-preview mb-2">
                    <?php endif; ?>
                    <input type="file" name="banner" class="admin-input" accept=".jpg,.jpeg,.png,.webp">
                </div>
            </div>

            <div class="admin-form-group">
                <label class="admin-label">Deskripsi</label>
                <textarea name="description" class="admin-input" rows="4"><?= SanitizeHelper::escape($game['description'] ?? '') ?></textarea>
            </div>

            <div class="form-row-2">
                <div class="admin-form-group">
                    <label class="admin-label">Genre</label>
                    <div class="checkbox-grid">
                        <?php foreach ($genres as $genre) : ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="genres[]" value="<?= (int)$genre['id'] ?>"
                                       <?= in_array($genre['id'], $selectedGenres) ? 'checked' : '' ?>>
                                <?= SanitizeHelper::escape($genre['name']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="admin-form-group">
                    <label class="admin-label">Platform</label>
                    <div class="checkbox-grid">
                        <?php foreach ($platforms as $platform) : ?>
                            <label class="checkbox-label">
                                <input type="checkbox" name="platforms[]" value="<?= (int)$platform['id'] ?>"
                                       <?= in_array($platform['id'], $selectedPlatforms) ? 'checked' : '' ?>>
                                <?= SanitizeHelper::escape($platform['name']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-3 mt-3">
                <button type="submit" class="btn-admin btn-admin-purple flex-fill py-2">
                    <i class="bi bi-floppy me-1"></i><?= $game ? 'Simpan Perubahan' : 'Tambah Game' ?>
                </button>
                <a href="<?= BASE_URL ?>/admin/games" class="btn-admin btn-admin-outline flex-fill py-2 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>
