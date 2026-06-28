<?php

class CsrfHelper {

    /**
     * Ambil token CSRF untuk session saat ini.
     * Token dibuat sekali per session dan dipakai ulang di semua form
     * (bukan per-request) — supaya user yang membuka beberapa tab/form
     * sekaligus tidak tiba-tiba tokennya invalid.
     */
    public static function token(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Cetak <input type="hidden"> siap pakai di dalam <form>.
     * Dipakai supaya tidak perlu menulis ulang HTML token di banyak view.
     */
    public static function field(): string {
        return '<input type="hidden" name="csrf_token" value="' . self::token() . '">';
    }

    /**
     * Verifikasi token yang dikirim dari form dengan token di session.
     * Pakai hash_equals() supaya tahan terhadap timing attack.
     */
    public static function verify(?string $token): bool {
        if (empty($_SESSION['csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $token);
    }
}
