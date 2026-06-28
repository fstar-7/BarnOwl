<?php

class WishlistController extends Controller {

    /**
     * GET /wishlist
     * Menampilkan seluruh game yang ada di wishlist user yang sedang login.
     */
    public function index(): void {
        $this->requireLogin('Kamu harus login terlebih dahulu untuk mengakses Wishlist.', false);

        $wishlistModel = $this->model('Wishlist');
        $games         = $wishlistModel->getByUser(AuthHelper::id());

        // Hitung harga final setelah diskon — logika bisnis tetap di Model/Controller, bukan View.
        foreach ($games as &$game) {
            $price    = (int) $game['price'];
            $discount = (int) ($game['discount'] ?? 0);

            $game['final_price'] = Game::calcFinalPrice($price, $discount);
        }
        unset($game);

        $data = [
            'pageTitle' => 'My Wishlist | BarnOwl',
            'games'     => $games,
            'total'     => count($games),
        ];

        $this->view('wishlist/index', $data, ['wishlist.css']);
    }

    /**
     * GET /wishlist/add/:id
     * Menambahkan satu game ke wishlist, lalu kembali ke halaman asal.
     */
    public function add($id): void {
        $gameId = (int) $id;

        $this->requireLogin('Kamu harus login untuk menambah ke Wishlist.');

        $userId       = AuthHelper::id();
        $gameModel    = $this->model('Game');
        $libraryModel = $this->model('Library');

        if (!$gameModel->exists($gameId)) {
            self::setToast('Game tidak ditemukan.', 'danger');
            $this->redirectBack();
        }

        // Tidak perlu wishlist game yang sudah dimiliki di Library.
        if ($libraryModel->owns($userId, $gameId)) {
            self::setToast('Game ini sudah ada di Library-mu.', 'info');
            $this->redirectBack();
        }

        try {
            $this->model('Wishlist')->add($userId, $gameId);
            self::setToast('Game berhasil ditambahkan ke Wishlist.', 'success');
        } catch (PDOException $e) {
            self::setToast('Gagal menambah ke Wishlist. Silakan coba lagi.', 'danger');
        }

        $this->redirectBack();
    }

    /**
     * GET /wishlist/remove/:id
     * Menghapus satu game dari wishlist, lalu kembali ke halaman asal.
     */
    public function remove($id): void {
        $gameId = (int) $id;

        $this->requireLogin();

        $this->model('Wishlist')->remove(AuthHelper::id(), $gameId);

        self::setToast('Game dihapus dari Wishlist.', 'success');
        $this->redirectBack();
    }

    /**
     * GET /wishlist/toggle/:id
     * Dipakai pada ikon bookmark di Home/Store: tambah jika belum ada,
     * hapus jika sudah ada — dalam satu link yang sama.
     */
    public function toggle($id): void {
        $gameId = (int) $id;

        $this->requireLogin('Kamu harus login untuk menggunakan Wishlist.');

        $userId       = AuthHelper::id();
        $gameModel    = $this->model('Game');
        $libraryModel = $this->model('Library');

        if (!$gameModel->exists($gameId)) {
            self::setToast('Game tidak ditemukan.', 'danger');
            $this->redirectBack();
        }

        if ($libraryModel->owns($userId, $gameId)) {
            self::setToast('Game ini sudah ada di Library-mu.', 'info');
            $this->redirectBack();
        }

        try {
            $result  = $this->model('Wishlist')->toggle($userId, $gameId);
            $message = $result === 'added'
                ? 'Game ditambahkan ke Wishlist.'
                : 'Game dihapus dari Wishlist.';

            self::setToast($message, 'success');
        } catch (PDOException $e) {
            self::setToast('Terjadi kesalahan. Silakan coba lagi.', 'danger');
        }

        $this->redirectBack();
    }
}
