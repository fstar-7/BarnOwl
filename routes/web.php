<?php
// Panggil Router
$router = new Router();

// ==========================================
// DAFTAR URL WEB BARNOWL ADA DI SINI
// Format: $router->get('/nama-url', 'NamaController@namaFungsi');
// ==========================================

// Rute Halaman Utama
$router->get('/', 'HomeController@index');

// Contoh Rute Katalog Game (Hanya contoh, belum bisa diklik dulu)
$router->get('/games', 'GameController@index');

// Contoh Rute Detail Game dengan ID (Misal: /games/1)
$router->get('/games/:id', 'GameController@show');

// Tambahkan 3 baris ini di daftar rute kamu:
$router->post('/login', 'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout', 'AuthController@logout');