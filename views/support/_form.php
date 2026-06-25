<div class="card support-card p-4 shadow-lg">
    <h4 class="fw-bold mb-3 text-white"><i class="bi bi-envelope-paper me-2"></i> Kirim Tiket Bantuan</h4>
    <p class="small text-secondary mb-4">
        Jika pertanyaan Anda tidak terjawab di menu FAQ, silakan kirimkan pesan langsung
        kepada tim administrasi kami.
    </p>

    <form action="<?= BASE_URL ?>/support/submit" method="POST">

        <div class="mb-3">
            <label class="form-label small text-secondary">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control text-white"
                   placeholder="Masukkan nama Anda" maxlength="100" required>
        </div>

        <div class="mb-3">
            <label class="form-label small text-secondary">Alamat Email</label>
            <input type="email" name="email" class="form-control text-white"
                   placeholder="name@example.com"
                   value="<?= SanitizeHelper::escape($emailUser) ?>"
                   required>
        </div>

        <div class="mb-4">
            <label class="form-label small text-secondary">Detail Kendala / Pertanyaan</label>
            <textarea name="pesan" class="form-control text-white" rows="4" maxlength="2000"
                      placeholder="Jelaskan kendala yang Anda alami secara detail..." required></textarea>
        </div>

        <button type="submit" class="btn btn-purple w-100 py-2">
            <i class="bi bi-send-fill me-2"></i> Kirim Pesan
        </button>
    </form>
</div>
