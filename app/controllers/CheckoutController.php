<?php

class CheckoutController extends Controller {

    /**
     * GET /checkout
     * Menampilkan ringkasan keranjang & form konfirmasi pesanan.
     */
    public function index(): void {
        $this->requireLogin('Kamu harus login terlebih dahulu untuk checkout.', false);

        $cartModel = $this->model('Cart');
        $summary   = $cartModel->getCartSummary(AuthHelper::id());

        if ($summary['totalItems'] === 0) {
            self::setToast('Keranjangmu masih kosong. Yuk pilih game dulu!', 'info');
            $this->redirect('/store');
        }

        $data = [
            'pageTitle' => 'Checkout | BarnOwl',
            'items'     => $summary['items'],
            'subtotal'  => $summary['subtotal'],
        ];

        $this->view('checkout/index', $data, ['checkout.css']);
    }

    /**
     * POST /checkout/place
     * Membuat order dari isi keranjang, mengosongkan keranjang,
     * dan mengarahkan user ke halaman konfirmasi pesanan.
     */
    public function place(): void {
        $this->requirePost();
        $this->requireLogin('Kamu harus login terlebih dahulu untuk checkout.', false);

        $userId    = AuthHelper::id();
        $cartModel = $this->model('Cart');
        $summary   = $cartModel->getCartSummary($userId);

        if ($summary['totalItems'] === 0) {
            self::setToast('Keranjangmu masih kosong.', 'warning');
            $this->redirect('/store');
        }

        $orderModel = $this->model('Order');

        try {
            $orderId = $orderModel->createFromCart($userId, $summary['items']);
            $cartModel->clear($userId);
        } catch (PDOException $e) {
            self::setToast('Gagal membuat pesanan. Silakan coba lagi.', 'danger');
            $this->redirect('/checkout');
        }

        // Order Rp 0 (semua game free-to-play) bisa langsung disetujui
        // otomatis — tidak perlu menunggu konfirmasi admin.
        if ($summary['subtotal'] === 0) {
            $orderModel->approve($orderId);
            self::setToast('Game gratis berhasil ditambahkan ke Library!', 'success');
            $this->redirect('/library');
        }

        self::setToast('Pesanan berhasil dibuat! Menunggu konfirmasi admin.', 'success');
        $this->redirect('/checkout/success/' . $orderId);
    }

    /**
     * GET /checkout/success/:id
     * Halaman konfirmasi setelah pesanan dibuat.
     */
    public function success($id): void {
        $this->requireLogin('', false);

        $orderId    = (int) $id;
        $orderModel = $this->model('Order');
        $order      = $orderModel->findById($orderId);

        // Pastikan order ini memang milik user yang sedang login.
        if (!$order || (int) $order['user_id'] !== AuthHelper::id()) {
            self::setToast('Pesanan tidak ditemukan.', 'danger');
            $this->redirect('/');
        }

        $items = $orderModel->getItems($orderId);

        // Hitung harga final per item — logika bisnis tetap di Controller.
        foreach ($items as &$item) {
            $item['final_price'] = Game::calcFinalPrice(
                (int) $item['price_at_buy'],
                (int) ($item['discount_at_buy'] ?? 0)
            );
        }
        unset($item);

        $data = [
            'pageTitle' => 'Pesanan Berhasil | BarnOwl',
            'order'     => $order,
            'items'     => $items,
        ];

        $this->view('checkout/success', $data, ['checkout.css']);
    }
}
