<?php

class OrderAdminController extends AdminBaseController {

    public function orders(): void {
        $this->adminView('admin/orders/index', [
            'pageTitle' => 'Riwayat Order | Admin',
            'orders'    => $this->model('Order')->getAll(),
        ], ['admin.css']);
    }

    public function approveOrder(int $id): void {
        $this->requirePost('/admin/orders');

        $ok = $this->model('Order')->approve($id);
        self::setToast($ok ? 'Order berhasil disetujui & game masuk Library!' : 'Gagal approve order.', $ok ? 'success' : 'danger');
        $this->redirect('/admin/orders');
    }

    public function exportOrders(): void {
        $orders = $this->model('Order')->exportCsv();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="orders_' . date('Ymd_His') . '.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['ID', 'Username', 'Email', 'Total', 'Status', 'Tanggal']);
        foreach ($orders as $o) {
            fputcsv($out, [$o['id'], $o['username'], $o['email'], $o['total'], $o['status'], $o['created_at']]);
        }
        fclose($out);
        exit;
    }
}
