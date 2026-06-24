<?php

class User extends Model {
    
    // Mencari user berdasarkan username (untuk Login)
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }

    // Mencari user berdasarkan email (untuk validasi Register)
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    // Menyimpan user baru ke database (Password otomatis di-hash/diacak)
    public function register($username, $email, $password) {
        // Enkripsi password menggunakan bcrypt (Standar Keamanan Tertinggi)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("INSERT INTO user (username, email, password, role) VALUES (:username, :email, :password, 'user')");
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword
        ]);
    }
}