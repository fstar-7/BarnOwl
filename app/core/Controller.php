<?php

class Controller
{

    public function model($model)
    {
        return new $model();
    }

    public static function setToast($message, $type = 'success')
    {
        $_SESSION['toast'] = [
            'message' => $message,
            'type'    => $type
        ];
    }

    public function view($view, $data = [], $extraCss = [])
    {

        // ── 1. GLOBAL DATA ──
        $data['currentRoute'] = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';
        $data['extraCss']     = $extraCss;

        $data['cartSummary'] = ['items' => [], 'totalItems' => 0, 'subtotal' => 0];
        if (AuthHelper::isLoggedIn()) {
            $cartModel = new Cart();
            $data['cartSummary'] = $cartModel->getCartSummary(AuthHelper::id());
        }

        // ── 2. PENGECEKAN VIEW ──
        $viewFile = VIEWS_DIR . '/' . $view . '.php';
        if (!file_exists($viewFile)) {
            die("Error System: View '<b>{$view}</b>' tidak ditemukan.");
        }

        // ── 3. RENDER ──
        extract($data);

        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/layouts/navbar.php';
        require_once VIEWS_DIR . '/layouts/auth.php';
        require_once VIEWS_DIR . '/layouts/toast.php';
        require_once $viewFile;
        require_once VIEWS_DIR . '/layouts/footer.php';
    }
}
