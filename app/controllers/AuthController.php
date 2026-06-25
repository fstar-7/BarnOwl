<?php

class AuthController extends Controller {

    public function login(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }

        $username  = trim($_POST['username'] ?? '');
        $password  = $_POST['password'] ?? '';
        $userModel = $this->model('User');
        $user      = $userModel->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']  = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            self::setToast('Selamat datang kembali, ' . $user['username'] . '!', 'success');
            $this->redirect('/');
        } else {
            self::setToast('Username atau Password salah!', 'danger');
            $this->redirectBack();
        }
    }

    public function register(): void {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }

        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email']    ?? '');
        $password  = $_POST['password']      ?? '';
        $userModel = $this->model('User');

        if (empty($username) || empty($email) || empty($password)) {
            self::setToast('Semua field wajib diisi!', 'warning');
            $this->redirectBack();
        }

        if ($userModel->findByUsername($username)) {
            self::setToast('Username sudah terdaftar!', 'warning');
            $this->redirectBack();
        }

        if ($userModel->findByEmail($email)) {
            self::setToast('Email sudah digunakan!', 'warning');
            $this->redirectBack();
        }

        if ($userModel->register($username, $email, $password)) {
            self::setToast('Registrasi berhasil! Silakan Sign In.', 'success');
            $this->redirect('/');
        } else {
            self::setToast('Gagal mendaftar. Terjadi kesalahan sistem.', 'danger');
            $this->redirectBack();
        }
    }

    public function logout(): void {
        session_unset();
        session_destroy();
        session_start();
        self::setToast('Anda telah berhasil logout.', 'info');
        $this->redirect('/');
    }

    private function redirectBack(): void {
        $referer = $_SERVER['HTTP_REFERER'] ?? BASE_URL . '/';
        header('Location: ' . $referer);
        exit;
    }
}
