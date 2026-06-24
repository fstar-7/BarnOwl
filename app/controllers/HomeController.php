<?php

class HomeController extends Controller
{

    public function index()
    {
        // 1. Panggil model 'Game'
        $gameModel = $this->model('Game');

        // 2. Ambil data dari database menggunakan fungsi yang ada di Model
        $games = $gameModel->getAllGames();

        $data = [
            'pageTitle' => 'BarnOwl - Game Store',
            'mainMessage' => 'Available Games:',
            'games' => $games
        ];

        // 4. Kirim ke tampilan
        $this->view('home/index', $data);
    }
}
