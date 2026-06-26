<?php

$router = new Router();

// ── Halaman Utama ──
$router->get('/',      'HomeController@index');

// ── Store & Game ──
$router->get('/store',      'StoreController@index');
$router->get('/store/:id',  'StoreController@detail');

// ── Auth ──
$router->post('/login',    'AuthController@login');
$router->post('/register', 'AuthController@register');
$router->get('/logout',    'AuthController@logout');

// ── Library ──
$router->get('/library', 'LibraryController@index');

// ── Wishlist ──
$router->get('/wishlist',            'WishlistController@index');
$router->get('/wishlist/add/:id',    'WishlistController@add');
$router->get('/wishlist/remove/:id', 'WishlistController@remove');
$router->get('/wishlist/toggle/:id', 'WishlistController@toggle');

// ── Support ──
$router->get('/support',         'SupportController@index');
$router->post('/support/submit', 'SupportController@submit');

// ── Admin ──
$router->get('/admin',                        'AdminController@index');
$router->get('/admin/games',                  'AdminController@games');
$router->get('/admin/games/create',           'AdminController@createGame');
$router->post('/admin/games/store',           'AdminController@storeGame');
$router->get('/admin/games/edit/:id',         'AdminController@editGame');
$router->post('/admin/games/update/:id',      'AdminController@updateGame');
$router->get('/admin/games/delete/:id',       'AdminController@deleteGame');

$router->get('/admin/users',                  'AdminController@users');
$router->get('/admin/users/delete/:id',       'AdminController@deleteUser');
$router->get('/admin/users/export',           'AdminController@exportUsers');

$router->get('/admin/orders',                 'AdminController@orders');
$router->get('/admin/orders/approve/:id',     'AdminController@approveOrder');
$router->get('/admin/orders/export',          'AdminController@exportOrders');

$router->get('/admin/support',                'AdminController@support');
$router->get('/admin/support/close/:id',      'AdminController@closeTicket');

$router->get('/admin/carousel',               'AdminController@carousel');
$router->get('/admin/carousel/create',        'AdminController@createCarousel');
$router->post('/admin/carousel/store',        'AdminController@storeCarousel');
$router->get('/admin/carousel/edit/:id',      'AdminController@editCarousel');
$router->post('/admin/carousel/update/:id',   'AdminController@updateCarousel');
$router->get('/admin/carousel/delete/:id',    'AdminController@deleteCarousel');
$router->get('/admin/carousel/toggle/:id',    'AdminController@toggleCarousel');
$router->get('/admin/carousel/move/:id/:dir', 'AdminController@moveCarousel');
