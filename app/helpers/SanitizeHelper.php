<?php

class SanitizeHelper {
    
    /**
     * Mengamankan teks dari serangan XSS (HTML Injection)
     * @param string $string Teks mentah dari database atau input
     * @return string Teks yang sudah aman dibaca oleh browser
     */
    public static function escape($string) {
        // Jika data kosong atau bukan teks, kembalikan apa adanya
        if (empty($string) && !is_numeric($string)) {
            return '';
        }
        
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}