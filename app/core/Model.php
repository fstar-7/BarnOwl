<?php

class Model {
    // Gunakan 'protected' agar variabel ini bisa diakses oleh class anaknya (Game, Cart, dll)
    protected $db;

    public function __construct() {
        // Cukup panggil koneksi database SATU KALI saja di sini
        $this->db = Database::connect();
    }
}