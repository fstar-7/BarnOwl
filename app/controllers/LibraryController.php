<?php

class LibraryController extends Controller {

    public function index(): void {
        $this->requireLogin('Kamu harus login untuk mengakses Library.', false);

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
