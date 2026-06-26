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

    protected function requirePost(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }
    }
}
