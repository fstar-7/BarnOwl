<?php

class Database {
    // Variabel untuk menyimpan koneksi agar tidak dibuka berulang-ulang (Singleton)
    private static $pdo = null;

    public static function connect() {
        if (self::$pdo === null) {
            
            // ─── MENGAMBIL DATA RAHASIA DARI .ENV ───
            // Tidak ada lagi tulisan 'root' atau nama database yang hardcode di sini!
            $host   = getenv('DB_HOST');
            $user   = getenv('DB_USER');
            $pass   = getenv('DB_PASS');
            $dbname = getenv('DB_NAME');

            try {
                // Merakit Data Source Name (DSN)
                $dsn = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8mb4";
                
                // Opsi keamanan & efisiensi PDO
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lempar error jika gagal
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Ambil data dalam bentuk Array Associative
                    PDO::ATTR_EMULATE_PREPARES   => false,                  // Matikan emulasi untuk keamanan ekstra
                ];
                
                // Membuka koneksi sesungguhnya
                self::$pdo = new PDO($dsn, $user, $pass, $options);
                
            } catch (PDOException $e) {
                // PERINGATAN KEAMANAN: 
                // Jangan pernah melakukan echo $e->getMessage() di server asli!
                // Cukup tampilkan pesan umum agar struktur folder/database tidak bocor.
                die("Database Connection Error. Please check your configuration.");
            }
        }
        
        return self::$pdo;
    }
}