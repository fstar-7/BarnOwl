<?php

class FormatHelper {
    
    // Fungsi statis untuk mengubah angka menjadi format Rupiah
    public static function rupiah($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
    
    // Nanti kamu bisa tambah fungsi lain di sini
    // Contoh: public static function tanggalIndo($tanggal) { ... }
}