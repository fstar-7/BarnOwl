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

    public function view(string $view, array $data = [], array $extraCss = [], array $extraJs = []): void {

        // ── 1. Data global ──
        $data['currentRoute'] = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $data['extraCss']     = $extraCss;
        $data['extraJs']      = $extraJs;

        // Cart summary
        $data['cartSummary'] = ['items' => [], 'totalItems' => 0, 'subtotal' => 0];
        if (AuthHelper::isLoggedIn()) {
            $cartModel           = new Cart();
            $data['cartSummary'] = $cartModel->getCartSummary(AuthHelper::id());
        }

        // ── 2. Validasi view ──
        $viewFile = VIEWS_DIR . '/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Error: View '<b>{$view}</b>' tidak ditemukan.");
        }

        // ── 3. Render ──
        extract($data);

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/layouts/navbar.php';
        require_once VIEWS_DIR . '/layouts/auth.php';
        require_once VIEWS_DIR . '/layouts/toast.php';
        require_once $viewFile;
        require_once VIEWS_DIR . '/layouts/footer.php';
    }

    protected function redirect(string $path): void {
        header('Location: ' . BASE_URL . $path);
        exit;
    }
}
