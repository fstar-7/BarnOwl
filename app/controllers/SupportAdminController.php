<?php

class SupportAdminController extends AdminBaseController {

    public function support(): void {
        $this->adminView('admin/support/index', [
            'pageTitle' => 'Support Tickets | Admin',
            'tickets'   => $this->model('SupportTicket')->getAll(),
        ], ['admin.css']);
    }

    public function closeTicket(int $id): void {
        $this->requirePost('/admin/support');

        $this->model('SupportTicket')->close($id);
        self::setToast('Tiket ditandai selesai.', 'success');
        $this->redirect('/admin/support');
    }
}
