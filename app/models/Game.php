<?php

// Tambahkan "extends Model" agar Game mewarisi koneksi database
class Game extends Model {
    
    // Kita hapus __construct() beserta isinya!
    
    public function getAllGames() {
        // Variabel $this->db otomatis sudah tersedia dari Base Model
        $stmt = $this->db->query("SELECT * FROM games");
        return $stmt->fetchAll();
    }
}