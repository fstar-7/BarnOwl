<?php

class DotEnv {
    // Fungsi untuk membaca isi file .env dan memasukkannya ke sistem memori PHP
    public static function load($path) {
        if (!file_exists($path)) {
            die("File .env tidak ditemukan! Sistem dihentikan demi keamanan.");
        }

        // Baca file baris per baris
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Lewati baris yang berupa komentar (diawali tanda #)
            if (strpos(trim($line), '#') === 0) continue;

            // Pecah berdasarkan tanda sama dengan (=)
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            // Masukkan ke variabel sistem PHP ($_ENV dan getenv)
            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }
}