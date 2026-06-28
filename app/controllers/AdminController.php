<?php

/**
 * Sebelumnya class ini (341 baris) menangani Dashboard + Games + Users +
 * Orders + Support + Carousel sekaligus — melanggar Single Responsibility
 * Principle. Sekarang dipecah per resource:
 *
 *   AdminController          -> dashboard saja (file ini)
 *   GameAdminController      -> CRUD game
 *   UserAdminController      -> kelola user
 *   OrderAdminController     -> kelola order
 *   SupportAdminController   -> kelola tiket support
 *   CarouselAdminController  -> kelola carousel
 *
 * Semua extends AdminBaseController, yang otomatis menjalankan
 * requireAdmin() di constructor — tidak perlu ditulis manual lagi.
 */
class AdminController extends AdminBaseController {

    // ════════════════════════════════════
    //  DASHBOARD — Stat overview
    // ════════════════════════════════════
    public function index(): void {
        $gameModel    = $this->model('Game');
        $userModel    = $this->model('User');
        $orderModel   = $this->model('Order');
        $supportModel = $this->model('SupportTicket');

        $data = [
            'pageTitle'    => 'Admin Dashboard | BarnOwl',
            'totalGames'   => $gameModel->getTotalCount(),
            'totalUsers'   => $userModel->getTotalCount(),
            'totalRevenue' => $orderModel->getTotalRevenue(),
            'openTickets'  => $supportModel->getTotalOpen(),
            'recentOrders' => $orderModel->getAll(),
            'recentGames'  => $gameModel->getAll(),
        ];

        $this->adminView('admin/dashboard', $data, ['admin.css']);
    }
}
