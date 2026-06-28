<?php

/**
 * Parent class untuk semua Controller area /admin/*.
 *
 * Kenapa dibuat: sebelumnya setiap method di AdminController memanggil
 * $this->requireAdmin() secara manual satu-satu (23 kali). Karena SETIAP
 * halaman admin memang wajib admin, cukup taruh sekali di constructor —
 * otomatis berlaku untuk semua Controller turunan ini.
 */
abstract class AdminBaseController extends Controller {

    public function __construct() {
        $this->requireAdmin();
    }
}
