<?php

class UserAdminController extends AdminBaseController {

    public function users(): void {
        $this->adminView('admin/users/index', [
            'pageTitle' => 'Kelola User | Admin',
            'users'     => $this->model('User')->getAll(),
        ], ['admin.css']);
    }

    public function deleteUser(int $id): void {
        $this->requirePost('/admin/users');

        if ($id === AuthHelper::id()) {
            self::setToast('Tidak dapat menghapus akun aktif.', 'warning');
            $this->redirect('/admin/users');
        }
        $this->model('User')->delete($id);
        self::setToast('User berhasil dihapus.', 'success');
        $this->redirect('/admin/users');
    }

    public function exportUsers(): void {
        $users = $this->model('User')->exportCsv();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="users_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Username', 'Email', 'Role', 'Terdaftar']);
        foreach ($users as $u) {
            fputcsv($out, [$u['id'], $u['username'], $u['email'], $u['role'], $u['created_at']]);
        }
        fclose($out);
        exit;
    }
}
