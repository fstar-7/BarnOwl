<?php

class CartController extends Controller {

    /**
     * GET /cart/add/:id
     * Menambahkan satu game ke keranjang, lalu kembali ke halaman asal.
     */
    public function add($id): void {
        $gameId = (int) $id;

        $this->requireLogin('Kamu harus login terlebih dahulu untuk berbelanja.');

        $userId       = AuthHelper::id();
        $gameModel    = $this->model('Game');
        $libraryModel = $this->model('Library');

        if (!$gameModel->exists($gameId)) {
            self::setToast('Game tidak ditemukan.', 'danger');
            $this->redirectBack();
        }

        // Tidak perlu dibeli ulang kalau sudah ada di Library.
        if ($libraryModel->owns($userId, $gameId)) {
            self::setToast('Game ini sudah ada di Library-mu.', 'info');
            $this->redirectBack();
        }

        try {
            $this->model('Cart')->add($userId, $gameId);
            self::setToast('Game berhasil ditambahkan ke keranjang.', 'success');
        } catch (PDOException $e) {
            self::setToast('Gagal menambahkan ke keranjang. Silakan coba lagi.', 'danger');
        }

        $this->redirectBack();
    }

    /**
     * GET /cart/remove/:id
     * :id di sini adalah ID baris cart (cart_id), bukan game_id —
     * sesuai dengan link yang dipakai di offcanvas keranjang (navbar).
     */
    public function remove($id): void {
        $cartId = (int) $id;

        $this->requireLogin();

        $this->model('Cart')->remove($cartId, AuthHelper::id());

        self::setToast('Game dihapus dari keranjang.', 'success');
        $this->redirectBack();
    }
}
