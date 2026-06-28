<?php

class SupportController extends Controller {

    /**
     * GET /support
     * Menampilkan FAQ + form tiket bantuan. Email auto-fill jika user login.
     */
    public function index(): void {
        $emailUser = '';

        if (AuthHelper::isLoggedIn()) {
            $user      = $this->model('User')->findById(AuthHelper::id());
            $emailUser = $user['email'] ?? '';
        }

        $data = [
            'pageTitle' => 'Support Center | BarnOwl',
            'emailUser' => $emailUser,
        ];

        $this->view('support/index', $data, ['support.css']);
    }

    /**
     * POST /support/submit
     * Memvalidasi & menyimpan tiket bantuan, lalu redirect kembali ke /support
     * (Post/Redirect/Get) supaya form tidak ter-submit ulang saat halaman di-refresh.
     */
    public function submit(): void {
        $this->requirePost('/support');

        $nama  = trim(strip_tags($_POST['nama']  ?? ''));
        $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $pesan = trim(strip_tags($_POST['pesan'] ?? ''));

        // ── Validasi dasar ──
        if ($nama === '' || $email === '' || $pesan === '') {
            self::setToast('Semua kolom wajib diisi!', 'warning');
            $this->redirect('/support');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            self::setToast('Format email tidak valid.', 'danger');
            $this->redirect('/support');
        }

        if (strlen($nama) > 100) {
            self::setToast('Nama terlalu panjang (maksimal 100 karakter).', 'danger');
            $this->redirect('/support');
        }

        if (strlen($pesan) > 2000) {
            self::setToast('Pesan terlalu panjang (maksimal 2000 karakter).', 'danger');
            $this->redirect('/support');
        }

        // ── Simpan ke database ──
        $saved = $this->model('SupportTicket')->create([
            'user_id' => AuthHelper::isLoggedIn() ? AuthHelper::id() : null,
            'nama'    => $nama,
            'email'   => $email,
            'pesan'   => $pesan,
        ]);

        if ($saved) {
            self::setToast('Tiket bantuan berhasil dikirim! Tim kami akan segera merespons.', 'success');
        } else {
            self::setToast('Gagal mengirim tiket. Silakan coba lagi.', 'danger');
        }

        $this->redirect('/support');
    }
}
