<?php

class LibraryController extends Controller {

    public function index(): void {
        // ── Proteksi: wajib login ──
        if (!AuthHelper::isLoggedIn()) {
            self::setToast('Kamu harus login untuk mengakses Library.', 'warning');
            $this->redirect('/');
        }

        $libraryModel = $this->model('Library');
        $games        = $libraryModel->getByUser(AuthHelper::id());

        $data = [
            'pageTitle' => 'My Library | BarnOwl',
            'games'     => $games,
            'total'     => count($games),
        ];

        $this->view('library/index', $data, ['library.css'], ['library.js']);
    }
}
