<?php

class AvatarHelper {

    /** Palet warna untuk avatar fallback — konsisten dengan tema ungu BarnOwl. */
    private static array $colors = [
        '#8a4dff', '#06b6d4', '#f59e0b', '#ef4444',
        '#10b981', '#3b82f6', '#ec4899', '#84cc16',
    ];

    /**
     * Render avatar siap pakai (HTML <img> atau lingkaran inisial).
     *
     * @param string|null $avatarFile  Nama file di /assets/img/avatars/, atau null/kosong kalau belum ada.
     * @param string      $name        Username — dipakai untuk inisial & warna fallback.
     * @param string      $sizeClass   Class ukuran: 'avatar-sm' | 'avatar-md' | 'avatar-lg'.
     */
    public static function render(?string $avatarFile, string $name, string $sizeClass = 'avatar-md'): string {
        if (!empty($avatarFile)) {
            $src = BASE_URL . '/assets/img/avatars/' . SanitizeHelper::escape($avatarFile);
            return '<img src="' . $src . '" class="avatar-img ' . $sizeClass . '" alt="Avatar">';
        }

        $initials = self::initials($name);
        $color    = self::colorFor($name);

        return '<div class="avatar-fallback ' . $sizeClass . '" style="background:' . $color . '">'
             . SanitizeHelper::escape($initials)
             . '</div>';
    }

    /** Ambil 1-2 huruf inisial dari nama/username. */
    public static function initials(string $name): string {
        $name = trim($name);
        if ($name === '') return '?';

        $parts = preg_split('/\s+/', $name);
        if (count($parts) === 1) {
            // Username biasanya 1 kata -> ambil 2 huruf pertama (mis. "egi" -> "EG")
            return strtoupper(substr($parts[0], 0, 2));
        }
        // Kalau ada spasi (nama lengkap) -> huruf pertama + huruf terakhir kata
        return strtoupper(substr($parts[0], 0, 1) . substr($parts[count($parts) - 1], 0, 1));
    }

    /** Warna deterministik berdasarkan string — nama yang sama selalu dapat warna yang sama. */
    public static function colorFor(string $name): string {
        $sum = array_sum(array_map('ord', str_split($name)));
        return self::$colors[$sum % count(self::$colors)];
    }
}
