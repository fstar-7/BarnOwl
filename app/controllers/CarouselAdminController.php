<?php

class CarouselAdminController extends AdminBaseController {

    public function carousel(): void {
        $this->adminView('admin/carousel/index', [
            'pageTitle' => 'Carousel | Admin',
            'slides'    => $this->model('Carousel')->getAll(),
        ], ['admin.css']);
    }

    public function createCarousel(): void {
        $this->adminView('admin/carousel/form', [
            'pageTitle' => 'Tambah Slide | Admin',
            'slide'     => null,
            'games'     => $this->model('Game')->getAll(),
        ], ['admin.css']);
    }

    public function storeCarousel(): void {
        $this->requirePost('/admin/carousel/create');

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
        $slide = $this->model('Carousel')->findById($id);
        if (!$slide) { self::setToast('Slide tidak ditemukan.', 'danger'); $this->redirect('/admin/carousel'); }

        $this->adminView('admin/carousel/form', [
            'pageTitle' => 'Edit Slide | Admin',
            'slide'     => $slide,
            'games'     => $this->model('Game')->getAll(),
        ], ['admin.css']);
    }

    public function updateCarousel(int $id): void {
        $this->requirePost('/admin/carousel');

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
        $this->requirePost('/admin/carousel');
        $this->model('Carousel')->delete($id);
        self::setToast('Slide berhasil dihapus.', 'success');
        $this->redirect('/admin/carousel');
    }

    public function toggleCarousel(int $id): void {
        $this->requirePost('/admin/carousel');
        $this->model('Carousel')->toggleActive($id);
        $this->redirect('/admin/carousel');
    }

    public function moveCarousel(int $id, string $direction): void {
        $this->requirePost('/admin/carousel');
        $this->model('Carousel')->moveOrder($id, $direction);
        $this->redirect('/admin/carousel');
    }
}
