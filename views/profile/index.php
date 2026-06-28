<?php include __DIR__ . '/_header.php'; ?>

<main class="container mb-5 profile-main">
    <div class="row g-4">

        <!-- ── Kartu Avatar ── -->
        <div class="col-lg-4">
            <div class="profile-card text-center p-4">
                <?= AvatarHelper::render($user['avatar'], $user['username'], 'avatar-lg') ?>

                <h5 class="fw-bold mt-3 mb-0 text-white"><?= SanitizeHelper::escape($user['username']) ?></h5>
                <p class="text-secondary small mb-3"><?= SanitizeHelper::escape($user['email']) ?></p>

                <span class="profile-role-badge <?= $user['role'] === 'admin' ? 'role-admin' : 'role-user' ?>">
                    <i class="bi bi-<?= $user['role'] === 'admin' ? 'shield-lock-fill' : 'person-fill' ?> me-1"></i>
                    <?= $user['role'] === 'admin' ? 'Administrator' : 'Member' ?>
                </span>

                <p class="text-muted small mt-3 mb-4">
                    <i class="bi bi-calendar3 me-1"></i>
                    Bergabung sejak <?= date('d M Y', strtotime($user['created_at'])) ?>
                </p>

                <!-- Upload / ganti foto -->
                <form action="<?= BASE_URL ?>/profile/avatar" method="POST" enctype="multipart/form-data" class="mb-2" id="avatarForm">
                    <?= CsrfHelper::field() ?>
                    <label for="avatarInput" class="btn-profile-upload w-100 mb-0">
                        <i class="bi bi-camera-fill me-1"></i> Ganti Foto
                    </label>
                    <input type="file" id="avatarInput" name="avatar" accept=".jpg,.jpeg,.png,.webp" class="d-none"
                           onchange="document.getElementById('avatarForm').submit()">
                </form>

                <!-- Hapus foto -> balik ke avatar default (inisial) -->
                <?php if (!empty($user['avatar'])) : ?>
                    <form action="<?= BASE_URL ?>/profile/avatar/remove" method="POST"
                          onsubmit="return confirm('Hapus foto profil dan kembali ke avatar default?')">
                        <?= CsrfHelper::field() ?>
                        <button type="submit" class="btn-profile-remove w-100">
                            <i class="bi bi-trash3 me-1"></i> Hapus Foto
                        </button>
                    </form>
                <?php else : ?>
                    <p class="text-muted small mb-0 mt-2">
                        <i class="bi bi-info-circle me-1"></i> Belum ada foto, memakai avatar inisial otomatis.
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── Form Informasi & Password ── -->
        <div class="col-lg-8">

            <div class="profile-card p-4 mb-4">
                <h5 class="fw-bold text-white mb-3">
                    <i class="bi bi-person-vcard me-2 text-purple-primary"></i>Informasi Akun
                </h5>

                <form action="<?= BASE_URL ?>/profile/update" method="POST">
                    <?= CsrfHelper::field() ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="<?= SanitizeHelper::escape($user['username']) ?>" maxlength="50" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">Email</label>
                            <input type="email" name="email" id="emailInput" class="form-control"
                                   value="<?= SanitizeHelper::escape($user['email']) ?>" maxlength="100" required
                                   data-original="<?= SanitizeHelper::escape($user['email']) ?>"
                                   oninput="document.getElementById('emailPasswordHint').classList.toggle('d-none', this.value === this.dataset.original)">
                        </div>
                        <div class="col-12">
                            <label class="form-label small text-secondary">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" autocomplete="current-password">
                            <small id="emailPasswordHint" class="text-warning d-block mt-1 d-none">
                                <i class="bi bi-exclamation-triangle me-1"></i>Wajib diisi karena kamu mengubah email.
                            </small>
                            <small class="text-muted d-block mt-1">
                                Hanya diperlukan kalau kamu mengganti Email (untuk keamanan akun).
                            </small>
                        </div>
                    </div>
                    <button type="submit" class="btn-profile-save mt-4">
                        <i class="bi bi-check-circle me-1"></i> Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="profile-card p-4">
                <h5 class="fw-bold text-white mb-3">
                    <i class="bi bi-shield-lock me-2 text-purple-primary"></i>Ubah Password
                </h5>

                <form action="<?= BASE_URL ?>/profile/password" method="POST">
                    <?= CsrfHelper::field() ?>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small text-secondary">Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">Password Baru</label>
                            <input type="password" name="new_password" class="form-control" minlength="6" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-secondary">Konfirmasi Password Baru</label>
                            <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                        </div>
                    </div>
                    <button type="submit" class="btn-profile-save mt-4">
                        <i class="bi bi-key-fill me-1"></i> Ganti Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</main>
