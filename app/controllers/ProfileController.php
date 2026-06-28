<?php

class ProfileController extends Controller {

    public function __construct() {
        $this->requireLogin('Kamu harus login untuk mengakses halaman ini.', false);
    }

    /** GET /profile */
    public function index(): void {
        $user = $this->model('User')->findById(AuthHelper::id());
        if (!$user) { $this->redirect('/'); }

        $this->view('profile/index', [
            'pageTitle' => 'My Account | BarnOwl',
            'user'      => $user,
        ], ['profile.css']);
    }

    /** POST /profile/avatar — upload/ganti foto profil */
    public function updateAvatar(): void {
        $this->requirePost('/profile');

        $newFile = $this->uploadImage('avatar', 'avatars');
        if (!$newFile) { $this->redirect('/profile'); } // pesan error sudah di-set oleh uploadImage()

        $userId    = AuthHelper::id();
        $userModel = $this->model('User');
        $oldUser   = $userModel->findById($userId);

        $userModel->updateAvatar($userId, $newFile);

        // Hapus file avatar lama dari disk supaya tidak menumpuk file yatim.
        if (!empty($oldUser['avatar'])) {
            $oldPath = ROOT_DIR . '/public/assets/img/avatars/' . $oldUser['avatar'];
            if (is_file($oldPath)) @unlink($oldPath);
        }

        $_SESSION['avatar'] = $newFile;
        self::setToast('Foto profil berhasil diperbarui!', 'success');
        $this->redirect('/profile');
    }

    /** POST /profile/avatar/remove — kembalikan ke avatar default (inisial nama) */
    public function removeAvatar(): void {
        $this->requirePost('/profile');

        $userId    = AuthHelper::id();
        $userModel = $this->model('User');
        $user      = $userModel->findById($userId);

        if (!empty($user['avatar'])) {
            $path = ROOT_DIR . '/public/assets/img/avatars/' . $user['avatar'];
            if (is_file($path)) @unlink($path);
        }

        $userModel->updateAvatar($userId, null);
        $_SESSION['avatar'] = null;

        self::setToast('Foto profil dihapus, kembali ke avatar default.', 'success');
        $this->redirect('/profile');
    }

    /** POST /profile/update — ubah username & email (email wajib konfirmasi password) */
    public function update(): void {
        $this->requirePost('/profile');

        $userId    = AuthHelper::id();
        $username  = trim($_POST['username'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['current_password'] ?? '';
        $userModel = $this->model('User');
        $user      = $userModel->findById($userId);

        if (!$user) { $this->redirect('/'); }

        if (empty($username) || empty($email)) {
            self::setToast('Username dan Email wajib diisi!', 'warning');
            $this->redirect('/profile');
        }

        // Email termasuk data sensitif (dipakai buat reset password/notifikasi),
        // jadi setiap perubahan wajib konfirmasi password saat ini.
        $emailChanged = strcasecmp($email, $user['email']) !== 0;
        if ($emailChanged) {
            if (empty($password) || !password_verify($password, $user['password'])) {
                self::setToast('Password salah. Konfirmasi password diperlukan untuk mengganti email.', 'danger');
                $this->redirect('/profile');
            }

            if ($userModel->emailTakenByOther($email, $userId)) {
                self::setToast('Email sudah dipakai user lain.', 'warning');
                $this->redirect('/profile');
            }
        }

        if ($userModel->usernameTakenByOther($username, $userId)) {
            self::setToast('Username sudah dipakai user lain.', 'warning');
            $this->redirect('/profile');
        }

        $userModel->updateProfile($userId, $username, $email);
        $_SESSION['username'] = $username; // sinkronkan session supaya navbar langsung berubah

        self::setToast('Informasi akun berhasil diperbarui!', 'success');
        $this->redirect('/profile');
    }

    /** POST /profile/password — ganti password */
    public function updatePassword(): void {
        $this->requirePost('/profile');

        $userId      = AuthHelper::id();
        $current     = $_POST['current_password'] ?? '';
        $new         = $_POST['new_password'] ?? '';
        $confirm     = $_POST['confirm_password'] ?? '';
        $userModel   = $this->model('User');
        $user        = $userModel->findById($userId);

        if (!$user || !password_verify($current, $user['password'])) {
            self::setToast('Password saat ini salah.', 'danger');
            $this->redirect('/profile');
        }

        if (strlen($new) < 6) {
            self::setToast('Password baru minimal 6 karakter.', 'warning');
            $this->redirect('/profile');
        }

        if ($new !== $confirm) {
            self::setToast('Konfirmasi password baru tidak cocok.', 'warning');
            $this->redirect('/profile');
        }

        $userModel->updatePassword($userId, $new);
        self::setToast('Password berhasil diganti!', 'success');
        $this->redirect('/profile');
    }
}
