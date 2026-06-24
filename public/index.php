<?php
// 1. NYALAKAN SESI UNTUK SELURUH WEB DI SINI
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 2. DEFINISIKAN DIREKTORI (Lebih rapi daripada pakai __DIR__ berulang kali)
define('ROOT_DIR', dirname(__DIR__));
define('APP_DIR', ROOT_DIR . '/app');
define('VIEWS_DIR', ROOT_DIR . '/views');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/BarnOwl/public');

// 3. AUTOLOADER (Robot Pemanggil Class)
spl_autoload_register(function ($class) {
    if (file_exists(ROOT_DIR . '/config/' . $class . '.php')) {
        require_once ROOT_DIR . '/config/' . $class . '.php';
    } elseif (file_exists(APP_DIR . '/core/' . $class . '.php')) {
        require_once APP_DIR . '/core/' . $class . '.php';
    } elseif (file_exists(APP_DIR . '/helpers/' . $class . '.php')) {
        require_once APP_DIR . '/helpers/' . $class . '.php';
    } elseif (file_exists(APP_DIR . '/models/' . $class . '.php')) {
        require_once APP_DIR . '/models/' . $class . '.php';
    } elseif (file_exists(APP_DIR . '/controllers/' . $class . '.php')) {
        require_once APP_DIR . '/controllers/' . $class . '.php';
    }
});

// 4. LOAD FILE RAHASIA (.env)
DotEnv::load(ROOT_DIR . '/.env');

// 5. SISTEM KEAMANAN ERROR (Menjawab kritik temanmu)
if (getenv('APP_ENV') === 'development') {
    // Mode pengembangan: Tampilkan semua error
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    // Mode online: Sembunyikan error dari hacker
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// 6. ROUTING
// Ambil URL yang diketik pengunjung (dari .htaccess)
$url = isset($_GET['url']) ? $_GET['url'] : '/';

// Panggil file daftar rute
require_once ROOT_DIR . '/routes/web.php';

// Jalankan Router!
$router->dispatch($url);