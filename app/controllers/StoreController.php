<?php

class StoreController extends Controller {

    public function index(): void {
        // ── 1. Panggil semua Model ──
        $gameModel      = $this->model('Game');
        $genreModel     = $this->model('Genre');
        $platformModel  = $this->model('Platform');
        $wishlistModel  = $this->model('Wishlist');
        $bannerModel    = $this->model('BannerSale');
        $heroModel      = $this->model('StoreHero');

        // ── 2. Baca & validasi input filter dari URL ──
        $selectedGenres    = $this->parseIntArray($_GET['genres']    ?? []);
        $selectedPlatforms = $this->parseIntArray($_GET['platforms'] ?? []);

        // Shortcut genre dari halaman lain (contoh: klik kategori di home)
        if (!empty($_GET['genre_id'])) {
            $fromGenreId = (int) $_GET['genre_id'];
            if (!in_array($fromGenreId, $selectedGenres)) {
                $selectedGenres[] = $fromGenreId;
            }
        }

        $maxPriceLimit  = $gameModel->getMaxPrice();
        $selectedPrice  = isset($_GET['max_price']) ? (int) $_GET['max_price'] : $maxPriceLimit;
        $selectedSort   = in_array($_GET['sort'] ?? '', ['popular', 'latest', 'lowest_price'])
                          ? $_GET['sort']
                          : 'popular';

        $isPromo     = isset($_GET['shortcut']) && $_GET['shortcut'] === 'promo';
        $isTopRated  = isset($_GET['shortcut']) && $_GET['shortcut'] === 'top_rated';

        // ── 3. Pagination ──
        $perPage     = 8;
        $currentPage = max(1, (int) ($_GET['page'] ?? 1));
        $offset      = ($currentPage - 1) * $perPage;

        // ── 4. Ambil game dengan filter ──
        $result = $gameModel->getFiltered([
            'genre_ids'    => $selectedGenres,
            'platform_ids' => $selectedPlatforms,
            'max_price'    => $selectedPrice,
            'promo'        => $isPromo,
            'top_rated'    => $isTopRated,
            'sort'         => $selectedSort,
            'per_page'     => $perPage,
            'offset'       => $offset,
        ]);

        $games      = $result['items'];
        $totalGames = $result['total'];
        $totalPages = (int) ceil($totalGames / $perPage);

        // ── 5. Hitung harga final & badge di Controller ──
        foreach ($games as &$game) {
            $price    = (int) $game['price'];
            $discount = (int) ($game['discount'] ?? 0);

            $game['final_price'] = Game::calcFinalPrice($price, $discount);
            $game['badge_hot']   = (int) $game['views'] >= 300;
            $game['badge_top']   = (float) $game['rating'] >= 4.7;
            $game['badge_new']   = $game['status'] === 'new_release';
        }
        unset($game);

        // ── 6. Wishlist user (1 query, bukan N query) ──
        $wishlistedIds = [];
        if (AuthHelper::isLoggedIn()) {
            $wishlistedIds = $wishlistModel->getGameIdsByUser(AuthHelper::id());
        }

        // ── 7. Data sidebar & pendukung ──
        $genres      = $genreModel->getAll();
        $platforms   = $platformModel->getAll();
        $topSelling  = $gameModel->getTopSelling(5);
        $bannerSale  = $bannerModel->getActive();
        $storeHero   = $heroModel->getActive();

        // ── 8. Kirim ke View ──
        $data = [
            'pageTitle'         => 'Game Store | BarnOwl',
            'games'             => $games,
            'totalGames'        => $totalGames,
            'totalPages'        => $totalPages,
            'currentPage'       => $currentPage,
            'genres'            => $genres,
            'platforms'         => $platforms,
            'topSelling'        => $topSelling,
            'bannerSale'        => $bannerSale,
            'storeHero'         => $storeHero,
            'wishlistedIds'     => $wishlistedIds,
            'maxPriceLimit'     => $maxPriceLimit,
            'selectedGenres'    => $selectedGenres,
            'selectedPlatforms' => $selectedPlatforms,
            'selectedPrice'     => $selectedPrice,
            'selectedSort'      => $selectedSort,
            'isPromo'           => $isPromo,
            'isTopRated'        => $isTopRated,
        ];

        $this->view('store/index', $data, ['store.css'], ['store.js']);
    }

    // ── Helper: pastikan array hanya berisi integer ──
    private function parseIntArray(mixed $input): array {
        if (!is_array($input)) return [];
        return array_map('intval', array_filter($input, 'is_numeric'));
    }
}
