<?php

class AdminController extends Controller {

    // ── Helper upload gambar ──
    private function uploadImage(string $inputName, string $subDir = 'games'): ?string {
        if (empty($_FILES[$inputName]['name'])) return null;

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext     = strtolower(pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            self::setToast("Format gambar tidak valid! Gunakan JPG/PNG/WEBP.", 'danger');
            return null;
        }

        $uploadDir = ROOT_DIR . "/public/assets/img/{$subDir}/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

        $filename = time() . '_' . uniqid() . '.' . $ext;
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $filename);
        return $filename;
    }

    // ════════════════════════════════════
    //  DASHBOARD — Stat overview
    // ════════════════════════════════════
    public function index(): void {
        $this->requireAdmin();

        $gameModel    = $this->model('Game');
        $userModel    = $this->model('User');
        $orderModel   = $this->model('Order');
        $supportModel = $this->model('SupportTicket');

        $libraryStmt  = $this->model('Library');

        $data = [
            'pageTitle'    => 'Admin Dashboard | BarnOwl',
            'totalGames'   => $gameModel->getTotalCount(),
            'totalUsers'   => $userModel->getTotalCount(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'openTickets'  => $supportModel->getTotalOpen(),
            'recentOrders' => $orderModel->getAll(),
            'recentGames'  => $gameModel->getAll(),
        ];

        $this->adminView('admin/dashboard', $data, ['admin.css']);
    }

    // ════════════════════════════════════
    //  GAMES
    // ════════════════════════════════════
    public function games(): void {
        $this->requireAdmin();
        $games = $this->model('Game')->getAll();
        $this->adminView('admin/games/index', [
            'pageTitle' => 'Kelola Game | Admin',
            'games'     => $games,
        ], ['admin.css']);
    }

    public function createGame(): void {
        $this->requireAdmin();
        $this->adminView('admin/games/form', [
            'pageTitle' => 'Tambah Game | Admin',
            'game'      => null,
            'genres'    => $this->model('Genre')->getAll(),
            'platforms' => $this->model('Platform')->getAll(),
            'selectedGenres'    => [],
            'selectedPlatforms' => [],
        ], ['admin.css']);
    }

    public function storeGame(): void {
        $this->requireAdmin();
        $this->requirePost();

        $thumbnail = $this->uploadImage('thumbnail');
        $banner    = $this->uploadImage('banner');

        if (!$thumbnail) { $this->redirect('/admin/games/create'); }

        $gameModel = $this->model('Game');
        $gameId = $gameModel->create([
            'name'        => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'thumbnail'   => $thumbnail,
            'banner'      => $banner,
            'price'       => (int) ($_POST['price'] ?? 0),
            'discount'    => (int) ($_POST['discount'] ?? 0),
            'rating'      => min(5.0, max(0.0, (float) ($_POST['rating'] ?? 0))),
            'views'       => (int) ($_POST['views'] ?? 0),
            'status'      => $_POST['status'] ?? 'regular',
        ]);

        $gameModel->syncGenres($gameId, $_POST['genres'] ?? []);
        $gameModel->syncPlatforms($gameId, $_POST['platforms'] ?? []);

        self::setToast('Game berhasil ditambahkan!', 'success');
        $this->redirect('/admin/games');
    }

    public function editGame(int $id): void {
        $this->requireAdmin();
        $gameModel = $this->model('Game');
        $game = $gameModel->findById($id);
        if (!$game) { self::setToast('Game tidak ditemukan.', 'danger'); $this->redirect('/admin/games'); }

        $this->adminView('admin/games/form', [
            'pageTitle'         => 'Edit Game | Admin',
            'game'              => $game,
            'genres'            => $this->model('Genre')->getAll(),
            'platforms'         => $this->model('Platform')->getAll(),
            'selectedGenres'    => $gameModel->getGenreIds($id),
            'selectedPlatforms' => $gameModel->getPlatformIds($id),
        ], ['admin.css']);
    }

    public function updateGame(int $id): void {
        $this->requireAdmin();
        $this->requirePost();

        $gameModel = $this->model('Game');
        $game = $gameModel->findById($id);
        if (!$game) { self::setToast('Game tidak ditemukan.', 'danger'); $this->redirect('/admin/games'); }

        $thumbnail = $this->uploadImage('thumbnail') ?? $game['thumbnail'];
        $banner    = $this->uploadImage('banner')    ?? $game['banner'];

        $gameModel->update($id, [
            'name'        => trim($_POST['name'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'thumbnail'   => $thumbnail,
            'banner'      => $banner,
            'price'       => (int) ($_POST['price'] ?? 0),
            'discount'    => (int) ($_POST['discount'] ?? 0),
            'rating'      => min(5.0, max(0.0, (float) ($_POST['rating'] ?? 0))),
            'status'      => $_POST['status'] ?? 'regular',
        ]);

        $gameModel->syncGenres($id, $_POST['genres'] ?? []);
        $gameModel->syncPlatforms($id, $_POST['platforms'] ?? []);

        self::setToast('Game berhasil diperbarui!', 'success');
        $this->redirect('/admin/games');
    }

    public function deleteGame(int $id): void {
        $this->requireAdmin();
        $this->model('Game')->delete($id);
        self::setToast('Game berhasil dihapus.', 'success');
        $this->redirect('/admin/games');
    }

    // ════════════════════════════════════
    //  USERS
    // ════════════════════════════════════
    public function users(): void {
        $this->requireAdmin();
        $this->adminView('admin/users/index', [
            'pageTitle' => 'Kelola User | Admin',
            'users'     => $this->model('User')->getAll(),
        ], ['admin.css']);
    }

    public function deleteUser(int $id): void {
        $this->requireAdmin();
        if ($id === AuthHelper::id()) {
            self::setToast('Tidak dapat menghapus akun aktif.', 'warning');
            $this->redirect('/admin/users');
        }
        $this->model('User')->delete($id);
        self::setToast('User berhasil dihapus.', 'success');
        $this->redirect('/admin/users');
    }

    public function exportUsers(): void {
        $this->requireAdmin();
        $users = $this->model('User')->exportCsv();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Username', 'Email', 'Role', 'Terdaftar']);
        foreach ($users as $u) {
            fputcsv($out, [$u['id'], $u['username'], $u['email'], $u['role'], $u['created_at']]);
        }
        fclose($out);
        exit;
    }

    // ════════════════════════════════════
    //  ORDERS
    // ════════════════════════════════════
    public function orders(): void {
        $this->requireAdmin();
        $this->adminView('admin/orders/index', [
            'pageTitle' => 'Riwayat Order | Admin',
            'orders'    => $this->model('Order')->getAll(),
        ], ['admin.css']);
    }

    public function approveOrder(int $id): void {
        $this->requireAdmin();
        $ok = $this->model('Order')->approve($id);
        self::setToast($ok ? 'Order berhasil disetujui & game masuk Library!' : 'Gagal approve order.', $ok ? 'success' : 'danger');
        $this->redirect('/admin/orders');
    }

    public function exportOrders(): void {
        $this->requireAdmin();
        $orders = $this->model('Order')->exportCsv();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Username', 'Email', 'Total', 'Status', 'Tanggal']);
        foreach ($orders as $o) {
            fputcsv($out, [$o['id'], $o['username'], $o['email'], $o['total'], $o['status'], $o['created_at']]);
        }
        fclose($out);
        exit;
    }

    // ════════════════════════════════════
    //  SUPPORT TICKETS
    // ════════════════════════════════════
    public function support(): void {
        $this->requireAdmin();
        $this->adminView('admin/support/index', [
            'pageTitle' => 'Support Tickets | Admin',
            'tickets'   => $this->model('SupportTicket')->getAll(),
        ], ['admin.css']);
    }

    public function closeTicket(int $id): void {
        $this->requireAdmin();
        $this->model('SupportTicket')->close($id);
        self::setToast('Tiket ditandai selesai.', 'success');
        $this->redirect('/admin/support');
    }

    // ════════════════════════════════════
    //  CAROUSEL
    // ════════════════════════════════════
    public function carousel(): void {
        $this->requireAdmin();
        $this->adminView('admin/carousel/index', [
            'pageTitle' => 'Carousel | Admin',
            'slides'    => $this->model('Carousel')->getAll(),
        ], ['admin.css']);
    }

    public function createCarousel(): void {
        $this->requireAdmin();
        $this->adminView('admin/carousel/form', [
            'pageTitle' => 'Tambah Slide | Admin',
            'slide'     => null,
            'games'     => $this->model('Game')->getAll(),
        ], ['admin.css']);
    }

    public function storeCarousel(): void {
        $this->requireAdmin();
        $this->requirePost();

        $image = $this->uploadImage('image', 'carousel');
        if (!$image) { $this->redirect('/admin/carousel/create'); }

        $this->model('Carousel')->create([
            'title'       => trim($_POST['title'] ?? ''),
            'subtitle'    => trim($_POST['subtitle'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image'       => $image,
            'order'       => (int) ($_POST['order'] ?? 1),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
            'game_id'     => !empty($_POST['game_id']) ? (int) $_POST['game_id'] : null,
        ]);

        self::setToast('Slide berhasil ditambahkan!', 'success');
        $this->redirect('/admin/carousel');
    }

    public function editCarousel(int $id): void {
        $this->requireAdmin();
        $slide = $this->model('Carousel')->findById($id);
        if (!$slide) { self::setToast('Slide tidak ditemukan.', 'danger'); $this->redirect('/admin/carousel'); }

        $this->adminView('admin/carousel/form', [
            'pageTitle' => 'Edit Slide | Admin',
            'slide'     => $slide,
            'games'     => $this->model('Game')->getAll(),
        ], ['admin.css']);
    }

    public function updateCarousel(int $id): void {
        $this->requireAdmin();
        $this->requirePost();

        $model = $this->model('Carousel');
        $slide = $model->findById($id);
        if (!$slide) { self::setToast('Slide tidak ditemukan.', 'danger'); $this->redirect('/admin/carousel'); }

        $image = $this->uploadImage('image', 'carousel') ?? $slide['image'];

        $model->update($id, [
            'title'       => trim($_POST['title'] ?? ''),
            'subtitle'    => trim($_POST['subtitle'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image'       => $image,
            'order'       => (int) ($_POST['order'] ?? 1),
            'is_active'   => isset($_POST['is_active']) ? 1 : 0,
            'game_id'     => !empty($_POST['game_id']) ? (int) $_POST['game_id'] : null,
        ]);

        self::setToast('Slide berhasil diperbarui!', 'success');
        $this->redirect('/admin/carousel');
    }

    public function deleteCarousel(int $id): void {
        $this->requireAdmin();
        $this->model('Carousel')->delete($id);
        self::setToast('Slide berhasil dihapus.', 'success');
        $this->redirect('/admin/carousel');
    }

    public function toggleCarousel(int $id): void {
        $this->requireAdmin();
        $this->model('Carousel')->toggleActive($id);
        $this->redirect('/admin/carousel');
    }

    public function moveCarousel(int $id, string $direction): void {
        $this->requireAdmin();
        $this->model('Carousel')->moveOrder($id, $direction);
        $this->redirect('/admin/carousel');
    }
}
