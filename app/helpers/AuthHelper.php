<?php

class AuthHelper {
    
    // Cek apakah user sudah login
    public static function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Ambil ID user yang sedang login
    public static function id() {
        return $_SESSION['user_id'] ?? null;
    }

    // Cek apakah user adalah Admin
    public static function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    // Ambil username (untuk ditampilkan di navbar)
    public static function username() {
        return $_SESSION['username'] ?? 'Guest';
    }
}