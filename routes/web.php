<?php

$router = new Router();

// ── Halaman Utama ──
$router->get('/',      'HomeController@index');

// ── Store & Game ──
$router->get('/store',      'StoreController@index');
$router->get('/store/:id',  'StoreController@detail');

// ── Cart ──
$router->get('/cart/add/:id',    'CartController@add');
$router->get('/cart/remove/:id', 'CartController@remove');

// ── Checkout ──
$router->get('/checkout',                 'CheckoutController@index');
$router->post('/checkout/place',          'CheckoutController@place');
$router->get('/checkout/success/:id',     'CheckoutController@success');

// ── Auth ──
$router->post('/login',    'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout',    'AuthController@logout');

// ── Library ──
$router->get('/library', 'LibraryController@index');

// ── Profile / My Account ──
$router->get('/profile',                'ProfileController@index');
$router->post('/profile/avatar',        'ProfileController@updateAvatar');
$router->post('/profile/avatar/remove', 'ProfileController@removeAvatar');
$router->post('/profile/update',        'ProfileController@update');
$router->post('/profile/password',      'ProfileController@updatePassword');

// ── Wishlist ──
$router->get('/wishlist',            'WishlistController@index');
$router->get('/wishlist/add/:id',    'WishlistController@add');
$router->get('/wishlist/remove/:id', 'WishlistController@remove');
$router->get('/wishlist/toggle/:id', 'WishlistController@toggle');

// ── Support ──
$router->get('/support',         'SupportController@index');
$router->post('/support/submit', 'SupportController@submit');

// ── Admin: Dashboard ──
$router->get('/admin', 'AdminController@index');

// ── Admin: Games ──
// CATATAN: delete diubah dari GET -> POST (operasi destructive harus
// pakai method yang mengubah state, bukan GET, supaya tidak gampang
// dipicu lewat link/img/prefetch milik orang lain — lihat CSRF + form
// di views/admin/games/index.php & dashboard.php).
$router->get('/admin/games',                  'GameAdminController@games');
$router->get('/admin/games/create',           'GameAdminController@createGame');
$router->post('/admin/games/store',           'GameAdminController@storeGame');
$router->get('/admin/games/edit/:id',         'GameAdminController@editGame');
$router->post('/admin/games/update/:id',      'GameAdminController@updateGame');
$router->post('/admin/games/delete/:id',      'GameAdminController@deleteGame');

// ── Admin: Users ──
$router->get('/admin/users',                  'UserAdminController@users');
$router->post('/admin/users/delete/:id',      'UserAdminController@deleteUser');
$router->get('/admin/users/export',           'UserAdminController@exportUsers');

// ── Admin: Orders ──
$router->get('/admin/orders',                 'OrderAdminController@orders');
$router->post('/admin/orders/approve/:id',    'OrderAdminController@approveOrder');
$router->get('/admin/orders/export',          'OrderAdminController@exportOrders');

// ── Admin: Support ──
$router->get('/admin/support',                'SupportAdminController@support');
$router->post('/admin/support/close/:id',     'SupportAdminController@closeTicket');

// ── Admin: Carousel ──
$router->get('/admin/carousel',               'CarouselAdminController@carousel');
$router->get('/admin/carousel/create',        'CarouselAdminController@createCarousel');
$router->post('/admin/carousel/store',        'CarouselAdminController@storeCarousel');
$router->get('/admin/carousel/edit/:id',      'CarouselAdminController@editCarousel');
$router->post('/admin/carousel/update/:id',   'CarouselAdminController@updateCarousel');
$router->post('/admin/carousel/delete/:id',   'CarouselAdminController@deleteCarousel');
$router->post('/admin/carousel/toggle/:id',   'CarouselAdminController@toggleCarousel');
$router->post('/admin/carousel/move/:id/:dir', 'CarouselAdminController@moveCarousel');
