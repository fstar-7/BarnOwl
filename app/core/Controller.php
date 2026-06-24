<?php

class Controller
{

    // Fungsi untuk memanggil model
    public function model($model)
    {
        return new $model();
    }

    //Toast
    public static function setToast($message, $type = 'success')
    {
        $_SESSION['toast'] = [
            'message' => $message,
            'type'    => $type  // 'success', 'danger', 'warning', 'info'
        ];
    }

    // Fungsi untuk memanggil view beserta layout-nya
    public function view($view, $data = [])
    {

        // ─── 1. GLOBAL DATA UNTUK NAVBAR ───
        $data['currentRoute'] = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

        $data['cartSummary'] = [
            'items' => [],
            'totalItems' => 0,
            'subtotal' => 0
        ];

        if (AuthHelper::isLoggedIn()) {
            $cartModel = new Cart();
            $data['cartSummary'] = $cartModel->getCartSummary(AuthHelper::id());
        }

        // ─── 2. PENGECEKAN VIEW (ERROR HANDLING) ───
        $viewFile = VIEWS_DIR . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            // Hentikan sistem dengan pesan yang aman jika file tidak ada
            die("Error System: View '<b>{$view}</b>' tidak ditemukan di direktori views.");
        }

        // ─── 3. RENDER TAMPILAN ───
        extract($data);

        // Panggil kerangka UI secara berurutan
        require_once VIEWS_DIR . '/layouts/header.php';
        require_once VIEWS_DIR . '/layouts/navbar.php';
        require_once VIEWS_DIR . '/layouts/toast.php';
        require_once $viewFile; // Memanggil view yang sudah dipastikan ada
        require_once VIEWS_DIR . '/layouts/footer.php';
    }
}
