<?php

class HomeController extends Controller {

    public function index(): void {
        // ── 1. Panggil semua Model yang dibutuhkan ──
        $gameModel     = $this->model('Game');
        $carouselModel = $this->model('Carousel');
        $genreModel    = $this->model('Genre');
        $wishlistModel = $this->model('Wishlist');

        // ── 2. Ambil data dari database ──
        $featuredGames = $gameModel->getFeatured(4);
        $newReleases   = $gameModel->getNewRelease(3);
        $carousels     = $carouselModel->getActive();
        $genres        = $genreModel->getWithGameCount(6);

        // ── 3. Ambil wishlist user sekaligus (1 query, bukan N query) ──
        // Ini mencegah N+1 Query Problem — query wishlist tidak diulang
        // di dalam setiap loop game card.
        $wishlistedIds = [];
        if (AuthHelper::isLoggedIn()) {
            $wishlistedIds = $wishlistModel->getGameIdsByUser(AuthHelper::id());
        }

        // ── 4. Hitung harga final di Controller, bukan di View ──
        foreach ($featuredGames as &$game) {
            $game['final_price'] = Game::calcFinalPrice(
                (int) $game['price'],
                (int) ($game['discount'] ?? 0)
            );
        }
        unset($game);

        // ── 5. Pisah New Release: 1 besar + sisanya kecil ──
        $bigRelease    = $newReleases[0] ?? null;
        $smallReleases = array_slice($newReleases, 1);

        // ── 6. Kirim semua data ke View ──
        $data = [
            'pageTitle'     => 'BarnOwl - Premium Game Store',
            'carousels'     => $carousels,
            'featuredGames' => $featuredGames,
            'bigRelease'    => $bigRelease,
            'smallReleases' => $smallReleases,
            'genres'        => $genres,
            'wishlistedIds' => $wishlistedIds,
        ];

        $this->view('home/index', $data, ['home.css']);
    }
}
