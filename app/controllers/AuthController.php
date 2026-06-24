<?php

class AuthController extends Controller {
    
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $userModel = $this->model('User');
            $user = $userModel->findByUsername($username);

            // Cek apakah user ada DAN passwordnya cocok (di-verify dengan hash di DB)
            if ($user && password_verify($password, $user['password'])) {
                // Set Session Login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect kembali ke halaman utama
                header('Location: ' . BASE_URL . '/');
                exit;
            } else {
                // Jika gagal (Nanti kita bisa ganti dengan sistem Toast)
                echo "<script>alert('Username atau Password salah!'); window.history.back();</script>";
                exit;
            }
        }
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $userModel = $this->model('User');

            // 1. Validasi: Pastikan Username dan Email belum dipakai
            if ($userModel->findByUsername($username)) {
                echo "<script>alert('Username sudah terdaftar!'); window.history.back();</script>";
                exit;
            }
            if ($userModel->findByEmail($email)) {
                echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
                exit;
            }

            // 2. Eksekusi Pendaftaran
            if ($userModel->register($username, $email, $password)) {
                echo "<script>alert('Registrasi berhasil! Silakan Login.'); window.location.href='" . BASE_URL . "/';</script>";
                exit;
            } else {
                echo "<script>alert('Gagal mendaftar. Terjadi kesalahan sistem.'); window.history.back();</script>";
                exit;
            }
        }
    }

    public function logout() {
        // Hapus semua data sesi
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/');
        exit;
    }
}