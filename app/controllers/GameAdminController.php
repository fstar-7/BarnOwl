<?php

class GameAdminController extends AdminBaseController {

    public function games(): void {
        $games = $this->model('Game')->getAll();
        $this->adminView('admin/games/index', [
            'pageTitle' => 'Kelola Game | Admin',
            'games'     => $games,
        ], ['admin.css']);
    }

    public function createGame(): void {
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
        $this->requirePost('/admin/games/create');

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
        $this->requirePost('/admin/games');

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
        $this->requirePost('/admin/games');
        $this->model('Game')->delete($id);
        self::setToast('Game berhasil dihapus.', 'success');
        $this->redirect('/admin/games');
    }
}
