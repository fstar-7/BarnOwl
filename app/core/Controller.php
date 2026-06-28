<?php

class Controller {

    public function model(string $model): object {
        return new $model();
    }

    public static function setToast(string $message, string $type = 'success'): void {
        $_SESSION['toast'] = [
            'message' => $message,
            'type'    => $type,
        ];
    }

    // ── View biasa (public) ──
    public function view(string $view, array $data = [], array $extraCss = [], array $extraJs = []): void {
        $data['currentRoute'] = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $data['extraCss']     = $extraCss;
        $data['extraJs']      = $extraJs;

        $data['cartSummary'] = ['items' => [], 'totalItems' => 0, 'subtotal' => 0];
        if (AuthHelper::isLoggedIn()) {
            $cartModel           = new Cart();
            $data['cartSummary'] = $cartModel->getCartSummary(AuthHelper::id());
        }

        $viewFile = VIEWS_DIR . '/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Error: View '<b>{$view}</b>' tidak ditemukan.");
        }

        extract($data);
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/layouts/navbar.php';
        require_once VIEWS_DIR . '/layouts/auth.php';
        require_once VIEWS_DIR . '/layouts/toast.php';
        require_once $viewFile;
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    // ── View admin (pakai layout admin tersendiri) ──
    public function adminView(string $view, array $data = [], array $extraCss = [], array $extraJs = []): void {
        $data['currentRoute'] = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $data['extraCss']     = $extraCss;
        $data['extraJs']      = $extraJs;

        $viewFile = VIEWS_DIR . '/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Error: Admin view '<b>{$view}</b>' tidak ditemukan.");
        }

        extract($data);
        require_once VIEWS_DIR . '/admin/layouts/header.php';
        require_once VIEWS_DIR . '/layouts/toast.php';
        require_once $viewFile;
        require_once VIEWS_DIR . '/admin/layouts/footer.php';
    }

    protected function redirect(string $path): void {
        header('Location: ' . BASE_URL . $path);
        exit;
    }

    protected function redirectBack(): void {
        $referer = $_SERVER['HTTP_REFERER'] ?? (BASE_URL . '/');
        if (stripos($referer, BASE_URL) !== 0) {
            $referer = BASE_URL . '/';
        }
        header('Location: ' . $referer);
        exit;
    }

    protected function requireAdmin(): void {
        if (!AuthHelper::isLoggedIn() || !AuthHelper::isAdmin()) {
            self::setToast('Akses ditolak. Halaman ini hanya untuk Admin.', 'danger');
            $this->redirect('/');
        }
    }

    /**
     * Pastikan user sudah login, kalau belum tampilkan toast & redirect.
     * Dipakai untuk menggantikan pola "if (!AuthHelper::isLoggedIn()) {...}"
     * yang sebelumnya ditulis manual berulang kali di banyak Controller.
     *
     * @param string $message     Pesan toast yang ditampilkan.
     * @param bool   $back        true = redirect ke halaman asal (redirectBack),
     *                             false = redirect ke homepage.
     */
    protected function requireLogin(string $message = 'Kamu harus login terlebih dahulu.', bool $back = true): void {
        if (!AuthHelper::isLoggedIn()) {
            if ($message !== '') {
                self::setToast($message, 'warning');
            }
            $back ? $this->redirectBack() : $this->redirect('/');
        }
    }

    /**
     * Pastikan request adalah POST DAN token CSRF-nya valid.
     * Kalau salah satu gagal, user diarahkan ke $wrongMethodRedirect.
     *
     * PENTING: setiap <form method="POST"> di view WAJIB menyertakan
     * <?= CsrfHelper::field() ?> agar tidak selalu ditolak di sini.
     */
    protected function requirePost(string $wrongMethodRedirect = '/'): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect($wrongMethodRedirect);
        }

        if (!CsrfHelper::verify($_POST['csrf_token'] ?? null)) {
            self::setToast('Sesi form sudah kedaluwarsa. Silakan coba lagi.', 'danger');
            $this->redirect($wrongMethodRedirect);
        }
    }

    /**
     * Helper upload gambar generik (dipakai AdminBaseController & ProfileController).
     *
     * Validasi 2 lapis:
     *  1. Ekstensi file (whitelist) — cepat, untuk UX.
     *  2. Isi file asli lewat getimagesize()/MIME — supaya file yang sengaja
     *     diganti namanya (mis. shell.php diubah jadi shell.jpg) tetap ditolak.
     */
    protected function uploadImage(string $inputName, string $subDir = 'games'): ?string {
        if (empty($_FILES[$inputName]['name'])) return null;

        $allowedExt  = ['jpg', 'jpeg', 'png', 'webp'];
        $allowedMime = ['image/jpeg', 'image/png', 'image/webp'];

        $ext = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExt, true)) {
            self::setToast('Format gambar tidak valid! Gunakan JPG/PNG/WEBP.', 'danger');
            return null;
        }

        // Cek isi file asli, bukan cuma nama/ekstensinya.
        $info = @getimagesize($_FILES[$inputName]['tmp_name']);
        if (!$info || !in_array($info['mime'], $allowedMime, true)) {
            self::setToast('File yang diunggah bukan gambar yang valid.', 'danger');
            return null;
        }

        $uploadDir = ROOT_DIR . "/public/assets/img/{$subDir}/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $filename);
        return $filename;
    }
}
